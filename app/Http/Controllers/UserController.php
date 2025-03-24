<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['page_title'] = 'Users';
        if ($request->ajax()) {
            $data = User::role(['admin', 'staff']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $show_btn = '<a href="' . route('users.show', $row->id) . '"
                    class="btn btn-outline-info btn-sm"><i class="bi bi-eye-fill"></i> ' . __('Show') . '</a>';

                    $edit_btn = '<a href="'.route('users.edit',$row->id).'" class="dropdown-item"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"><i class="ti ti-edit text-warning"></i> Edit</a>';

                    // $delete_btn = '&nbsp;<form action="' . route('users.destroy', $row->id) . '" method="post">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-outline-danger btn-sm"
                    // onclick="return confirm(`' . __('Do you want to delete this admin?') . '`);"><i class="bi bi-trash-fill"></i> ' . __('Delete') . '</button></form>';

                    $delete_btn = '<a href="javascript:void(0)" class="dropdown-item deleteUser"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"> <i class="ti ti-trash text-danger"></i> ' . __('Delete') . '</a><form action="' . route('users.destroy', $row->id) . '" method="post" class="delete-form" id="delete-form-'. $row->id.'" >'
                        . csrf_field() . method_field('DELETE') . '</form>';


                    $action_btn = '<div class="dropdown table-action">
                                             <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                             <div class="dropdown-menu dropdown-menu-right">';
                    // Check if logged-in user is ID 1
                    // // Show edit button for all users
                    Auth::user()->can('manage users') ? $action_btn .= $edit_btn : '';
                    // // Show delete button if the user is not ID 1
                    Auth::user()->can('manage users') ? $action_btn .= $delete_btn : '';

                    return $action_btn . ' </div></div>';
                })
                ->addColumn('role', function ($user) {
                    return $user->roles->pluck('name')->implode(', '); // Get user roles
                })
                ->editColumn('status', function ($user) {
                    return $user->statusBadge(); // Get user roles
                })
                ->editColumn('updated_at', function ($user) {
                    return  Carbon::parse($user->updated_at)->diffForHumans(); // Get user roles
                })
                ->editColumn('created_at', function ($user) {
                    return  $user->created_at->format('d M Y, h:i A'); // Get user roles
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('users.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['page_title'] = 'Create User';
        $data['roles'] = Role::where('name', '!=', 'superadmin')->pluck('name', 'id'); // Get all roles
        return view('users.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => [
                'required',
                Rule::exists('roles', 'id')->whereNot('name', 'superadmin') // Exclude superadmin
            ],
            'phone_no' => 'required|digits_between:10,11|unique:users,phone_no',
            'password' => 'required|min:6|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image validation
            'status' => 'required|in:active,inactive'
        ], [
            'role.exists' => 'Invalid role selected.',
            'password.confirmed' => 'Password and Confirm Password must match.'
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_no' => $request->phone_no,
            'password' => Hash::make($request->password),
            'status' => $request->status,
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('profile_pictures', $filename, 'public'); // Save to storage/app/public/profile_pictures
            $user->profile_picture = $filename;
        }

        $user->save();
        // Assign role
        $user->assignRole(Role::find($request->role)->name);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $data['page_title'] = 'Edit User';
        $data['user'] = $user;
        $data['roles'] = Role::where('name', '!=', 'superadmin')->pluck('name', 'id'); // Get all roles
        return view('users.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_no' => 'required|numeric|digits_between:10,11|unique:users,phone_no,' . $user->id,
            'role' => 'required|exists:roles,name',
            'password' => 'nullable|min:6|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:0,1',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_no' => $request->phone_no,
            'status' => $request->status,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture) {
                Storage::disk('public')->delete('profile_pictures/' . $user->profile_picture);
            }

            // Upload new profile picture
            $file = $request->file('profile_picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('profile_pictures', $filename, 'public'); // Save in storage/app/public/profile_pictures

            // Save new filename in database
            $user->profile_picture = $filename;
        }

        $user->save();

        $user->syncRoles([$request->role]); // Update role

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
