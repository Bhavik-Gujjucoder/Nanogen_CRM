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
use Illuminate\Support\Facades\Mail;
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
            $data = User::role(['admin', 'staff', 'reporting manager']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<label class="checkboxs">
                            <input type="checkbox" class="checkbox-item user_checkbox" data-id="' . $row->id . '">
                            <span class="checkmarks"></span>
                        </label>';
                })
                ->addColumn('action', function ($row) {
                    $show_btn = '<a href="' . route('users.show', $row->id) . '"
                    class="btn btn-outline-info btn-sm"><i class="bi bi-eye-fill"></i> ' . __('Show') . '</a>';

                    $edit_btn = '<a href="' . route('users.edit', $row->id) . '" class="dropdown-item"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"><i class="ti ti-edit text-warning"></i> Edit</a>';

                    // $delete_btn = '&nbsp;<form action="' . route('users.destroy', $row->id) . '" method="post">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-outline-danger btn-sm"
                    // onclick="return confirm(`' . __('Do you want to delete this admin?') . '`);"><i class="bi bi-trash-fill"></i> ' . __('Delete') . '</button></form>';

                    $delete_btn = '<a href="javascript:void(0)" class="dropdown-item deleteUser"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"> <i class="ti ti-trash text-danger"></i> ' . __('Delete') . '</a><form action="' . route('users.destroy', $row->id) . '" method="post" class="delete-form" id="delete-form-' . $row->id . '" >'
                        . csrf_field() . method_field('DELETE') . '</form>';

                    $action_btn = '<div class="dropdown table-action">
                                             <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                             <div class="dropdown-menu dropdown-menu-right">';
                    // Auth::user()->can('manage users') ? $action_btn .= $edit_btn : '';
                    // Auth::user()->can('manage users') ? $action_btn .= $delete_btn : '';
                    $action_btn .= $edit_btn;
                    $action_btn .= $delete_btn;
                    return $action_btn . ' </div></div>';
                })
                ->editColumn('name', function ($row) {
                    $profilePic = isset($row->profile_picture)
                        ? asset('storage/profile_pictures/' . $row->profile_picture)
                        : asset('images/default-user.png');

                    return '
                        <a href="' . $profilePic . '" target="_blank" class="avatar avatar-sm border rounded p-1 me-2">
                            <img src="' . $profilePic . '" alt="User Image">
                        </a>' . $row->name;
                })
                ->addColumn('role', function ($user) {
                    return $user->roles->pluck('name')->implode(', ');
                })
                ->filterColumn('role', function ($query, $keyword) {
                    $query->whereHas('roles', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
                })
                ->editColumn('status', function ($user) {
                    return $user->statusBadge();
                })
                // ->editColumn('updated_at', function ($user) {
                //     return  Carbon::parse($user->updated_at)->diffForHumans();
                // })
                ->editColumn('created_at', function ($user) {
                    return  $user->created_at->format('d M Y, h:i A');
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at, '%d %b %Y, %h:%i %p') like ?", ["%{$keyword}%"]);
                })
                ->rawColumns(['action', 'status', 'checkbox', 'name'])
                ->make(true);
        }
        return view('users.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['page_title'] = 'Add Users';
        // $data['roles']   = Role::where('name', '!=', 'super admin')->pluck('name', 'id'); // Get all roles
        $data['roles']      = Role::whereNotIn('name', ['super admin', 'sales'])->pluck('name', 'id');

        return view('users.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image validation
            'name'     => 'required|string|max:255|unique:users,name,NULL,id,deleted_at,NULL',
            'email'    => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
            'role'     => [
                'required',
                Rule::exists('roles', 'id')->whereNot('name', 'super admin') // Exclude super admin
            ],
            'phone_no' => 'required|digits_between:10,11|unique:users,phone_no,NULL,id,deleted_at,NULL',
            'password' => 'required|min:6|confirmed',
            'status'   => 'required|in:1,0'
        ], [
            'profile_picture.image' => 'The profile picture must be an image.',
            'profile_picture.mimes' => 'The profile picture must be a file of type: JPG, JPEG, PNG, or GIF.',
            'profile_picture.max'   => 'The profile picture may not be greater than 2MB.',
            'role.exists'           => 'Invalid role selected.',
            'password.confirmed'    => 'Password and Confirm Password must match.'
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone_no' => $request->phone_no,
            'password' => Hash::make($request->password),
            'status'   => $request->status,
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $file     = $request->file('profile_picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('profile_pictures', $filename, 'public'); // Save to storage/app/public/profile_pictures
            $user->profile_picture = $filename;
        }

        $user->save();
        // Assign role
        $user->assignRole(Role::find($request->role)->name);

        // **** EMAIL ****  
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = $request->password;
        Mail::send('email.user_email.create', ['data' => $data], fn($message) => $message->to($user->email)->subject('User Account Created'));

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $data['page_title'] = 'Edit User';
        $data['user']       = $user;
        // $data['roles']   = Role::where('name', '!=', 'super admin')->pluck('name', 'id'); // Get all roles
        $data['roles']      = Role::whereNotIn('name', ['super admin', 'sales'])->pluck('name', 'id');
        return view('users.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image validation
            'name'            => 'required|string|max:255|unique:users,name,' . $user->id . ',id,deleted_at,NULL',
            'email'           => 'required|email|unique:users,email,' . $user->id . ',id,deleted_at,NULL',
            'phone_no'        => 'required|numeric|digits_between:10,11|unique:users,phone_no,' . $user->id . ',id,deleted_at,NULL',
            'role'            => 'required|exists:roles,name',
            'password'        => ['nullable', 'string', 'min:6', 'confirmed'],
            'status'          => 'required|in:0,1',
        ], [
            'password.confirmed' => 'Password and Confirm Password must match.',
        ]);

        $user->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone_no' => $request->phone_no,
            'status'   => $request->status,
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
            $file     = $request->file('profile_picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('profile_pictures', $filename, 'public'); // Save in storage/app/public/profile_pictures

            // Save new filename in database
            $user->profile_picture = $filename;
        }
        $user->save();
        $user->syncRoles([$request->role]); // Update role
        // **** EMAIL ****  
        if ($user->status === "0") {
            $data = [];
            $data['name'] = $user->name;
            Mail::send('email.user_email.deactive_email', ['data' => $data], fn($message) => $message->to($user->email)->subject('Account Deactivated'));
        } else {
            $data = [];
            $data['name'] = $request->name;
            Mail::send('email.user_email.active_email', ['data' => $data], fn($message) => $message->to($user->email)->subject('Account Activated'));
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user = User::findOrFail($user->id);
        if ($user->profile_picture) {
            Storage::disk('public')->delete('profile_pictures/' . $user->profile_picture);
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if (!empty($ids) && is_array($ids)) {
            $users = User::whereIn('id', $ids)->get();

            foreach ($users as $u) {
                if ($u->profile_picture) {
                    Storage::disk('public')->delete('profile_pictures/' . $u->profile_picture);
                }
                $u->delete();
            }
            return response()->json(['message' => 'Selected users deleted successfully!']);
        }
        return response()->json(['message' => 'No records selected!'], 400);
    }
}
