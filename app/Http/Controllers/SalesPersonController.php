<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\CityManagement;
use App\Models\StateManagement;
use Yajra\DataTables\DataTables;
use App\Models\SalesPersonDetail;
use Illuminate\Support\Facades\DB;
use App\Models\SalesPersonPosition;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\SalesPersonDepartment;
use Illuminate\Support\Facades\Storage;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class SalesPersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['page_title'] = 'Sales Person';

        if ($request->ajax()) {
            $data = SalesPersonDetail::with('user');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<label class="checkboxs">
                            <input type="checkbox" class="checkbox-item sales_person_checkbox" data-id="' . $row->id . '">
                            <span class="checkmarks"></span>
                        </label>';
                })
                ->addColumn('action', function ($row) {
                    $edit_btn = '<a href="' . route('sales_person.edit', $row->id) . '" class="dropdown-item"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"><i class="ti ti-edit text-warning"></i> Edit</a>';

                    $delete_btn = '<a href="javascript:void(0)" class="dropdown-item deleteSalesPerson"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"> <i class="ti ti-trash text-danger"></i> ' . __('Delete') . '</a><form action="' . route('sales_person.destroy', $row->id) . '" method="post" class="delete-form" id="delete-form-' . $row->id . '" >'
                        . csrf_field() . method_field('DELETE') . '</form>';

                    $action_btn = '<div class="dropdown table-action">
                                             <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                             <div class="dropdown-menu dropdown-menu-right">';

                    Auth::user()->can('manage users') ? $action_btn .= $edit_btn : '';
                    Auth::user()->can('manage users') ? $action_btn .= $delete_btn : '';

                    return $action_btn . ' </div></div>';
                })

                ->editColumn('first_name', function ($row) {
                    $user = $row->user;
                    $profilePic = $user && !empty($user->profile_picture)
                        ? asset("storage/profile_pictures/" . $user->profile_picture)
                        : asset("images/default-user.png");

                    $name = $row->first_name . ' ' . $row->last_name;

                    if ($user) {
                        return '<a href="' . $profilePic . '" target="_blank" class="avatar avatar-sm border rounded p-1 me-2">
                                    <img class="" src="' . $profilePic . '" alt="User Image">
                                </a>' . $name;
                    }

                    return $name;
                })
                ->editColumn('user.phone_no', function ($row) {
                    return $row->user ? $row->user->phone_no : '-';
                })
                ->editColumn('user.email', function ($row) {
                    return $row->user ? $row->user->email : '-';
                })

                ->rawColumns(['checkbox', 'action', 'first_name'])
                ->make(true);
        }

        return view('admin.sales_person.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['page_title'] = 'Basic Information';
        $data['reporting_managers'] = User::role(['reporting manager'])->get();
        $data['departments'] = SalesPersonDepartment::where('status', 1)->get()->all();
        $data['positions'] = SalesPersonPosition::where('status', 1)->get()->all();
        $data['states'] = StateManagement::where('status', 1)->get()->all();
        $data['cities'] = CityManagement::where('status', 1)->get()->all();
        $data['countries'] = Country::where('status', 1)->get()->all();

        $latest_employee_id = SalesPersonDetail::withTrashed()->max(DB::raw("CAST(SUBSTRING(employee_id, 3) AS UNSIGNED)"));
        $nextId = $latest_employee_id ? $latest_employee_id + 1 : 1;
        $data['employeeId'] = 'ES' . str_pad($nextId, max(6, strlen($nextId)), '0', STR_PAD_LEFT);

        return view('admin.sales_person.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'first_name'           => 'required|string|max:255|unique:sales_person_details,first_name,NULL,id,deleted_at,NULL',
            'last_name'            => 'required|string|max:255|unique:sales_person_details,last_name,NULL,id,deleted_at,NULL',
            'email'                => 'required|email|max:255|unique:users,email,NULL,id,deleted_at,NULL',
            'phone_number'         => 'required|numeric|digits_between:10,15|unique:users,phone_no,NULL,id,deleted_at,NULL',
            'password'             => 'required|string|min:6|confirmed', // use password_confirmation field too
            // 'employee_id'          => 'required|string|max:255|unique:sales_person_details,employee_id,NULL,id,deleted_at,NULL',
            'department_id'        => 'required|exists:sales_person_department,id',
            'position_id'          => 'required|exists:sales_person_position,id',
            'reporting_manager_id' => 'required', // allow null if optional
            'date'                 => 'required|date_format:d-m-Y|before:today',
            'street_address'       => 'required|string|max:255',
            'city_id'              => 'required|exists:city_management,id',
            'state_id'             => 'required|exists:state_management,id',
            'postal_code'          => 'required|string|max:10',
            'country_id'           => 'required|exists:countries,id',
        ]);
        DB::beginTransaction();
        try {

            $user = new User();

            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('profile_pictures', $filename, 'public'); // Save to storage/app/public/profile_pictures
                $user->profile_picture = $filename;
            }

            $user->name      = $request->first_name . ' ' . $request->last_name;
            $user->email     = $request->email;
            $user->phone_no  = $request->phone_number;
            $user->password  = Hash::make($request->password);
            $user->save();

            /* Store into sales_person_details table */
            $salesDetail = new SalesPersonDetail();
            $salesDetail->first_name           = $request->first_name;
            $salesDetail->last_name            = $request->last_name;
            $salesDetail->user_id              = $user->id;
            $salesDetail->employee_id          = $request->employee_id;
            $salesDetail->department_id        = $request->department_id;
            $salesDetail->position_id          = $request->position_id;
            $salesDetail->reporting_manager_id = $request->reporting_manager_id;
            $salesDetail->date                 = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
            $salesDetail->street_address       = $request->street_address;
            $salesDetail->city_id              = $request->city_id;
            $salesDetail->state_id             = $request->state_id;
            $salesDetail->postal_code          = $request->postal_code;
            $salesDetail->country_id           = $request->country_id;
            $salesDetail->save();

            DB::commit();
            return redirect()->route('sales_person.index')->with('success', 'Sales person created successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['page_title']         = 'Edit Basic Information';
        $data['detail']             = SalesPersonDetail::findOrFail($id);
        $data['reporting_managers'] = User::role(['reporting manager'])->get();
        $data['departments']        = SalesPersonDepartment::where('status', 1)->get()->all();
        $data['positions']          = SalesPersonPosition::where('status', 1)->get()->all();
        $data['states']             = StateManagement::where('status', 1)->get()->all();
        $data['cities']             = CityManagement::where('status', 1)->get()->all();
        $data['countries']          = Country::where('status', 1)->get()->all();
        return view('admin.sales_person.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        $salesDetail = SalesPersonDetail::findOrFail($id);
        $user = User::where('id', $salesDetail->user_id)->first();
        $request->validate([
            'profile_picture'      => 'nullable|image|mimes:jpeg,jpg,png,gif|max:800',
            'first_name'           => 'required|string|max:255',
            'last_name'            => 'required|string|max:255',
            'email'                => 'required|email|max:255|unique:users,email,' . $user->id . ',id,deleted_at,NULL',
            'phone_number'         => 'required|numeric|digits_between:10,15|unique:users,phone_no,' . $user->id . ',id,deleted_at,NULL',
            'password'             => 'nullable|string|min:6|confirmed', // use password_confirmation field too
            'department_id'        => 'required|exists:sales_person_department,id',
            'position_id'          => 'required|exists:sales_person_position,id',
            'reporting_manager_id' => 'required', // allow null if optional
            'date'                 => 'required|date_format:d-m-Y|before:today',
            'street_address'       => 'required|string|max:255',
            'city_id'              => 'required|exists:city_management,id',
            'state_id'             => 'required|exists:state_management,id',
            'postal_code'          => 'required|string|max:10',
            'country_id'           => 'required|exists:countries,id',
        ]);

        DB::beginTransaction();
        try {

            $user->update([
                'name'     => $request->first_name . ' ' . $request->last_name,
                'email'    => $request->email,
                'phone_no' => $request->phone_number,
            ]);

            if ($request->filled('password')) {
                $user->update(['password' => Hash::make($request->password)]);
            }

            if ($request->hasFile('profile_picture')) {
                if ($user->profile_picture) {   /* Delete old profile picture if exists */
                    Storage::disk('public')->delete('profile_pictures/' . $user->profile_picture);
                }
                /* Upload new profile picture */
                $file = $request->file('profile_picture');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('profile_pictures', $filename, 'public'); /* Save in storage/app/public/profile_pictures */
                $user->profile_picture = $filename; /* Save new filename in database */
            }

            $user->save();
            $salesDetail->first_name           = $request->first_name;
            $salesDetail->last_name            = $request->last_name;
            $salesDetail->department_id        = $request->department_id;
            $salesDetail->position_id          = $request->position_id;
            $salesDetail->reporting_manager_id = $request->reporting_manager_id;
            $salesDetail->date                 = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
            $salesDetail->street_address       = $request->street_address;
            $salesDetail->city_id              = $request->city_id;
            $salesDetail->state_id             = $request->state_id;
            $salesDetail->postal_code          = $request->postal_code;
            $salesDetail->country_id           = $request->country_id;
            $salesDetail->save();

            DB::commit();
            return redirect()->route('sales_person.index')->with('success', 'Sales person updated successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $detail = SalesPersonDetail::findOrFail($id);
        $user = User::where('id', $detail->user_id)->first();

        // dd($detail,$user);

        if ($user->profile_picture) {
            Storage::disk('public')->delete('profile_pictures/' . $user->profile_picture);
        }
        $user->delete();
        $detail->delete();

        return redirect()->route('sales_person.index')->with('success', 'Sales person deleted successfully.');
    }



    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        if (!empty($ids) && is_array($ids)) {

            $details = SalesPersonDetail::whereIn('id', $ids)->get()->all();
            foreach ($details as $key => $detail) {
                $user = User::where('id', $detail->user_id)->first();
                if ($user->profile_picture) {
                    Storage::disk('public')->delete('profile_pictures/' . $user->profile_picture);
                }
                $user->delete();
                $detail->delete();
            }

            return response()->json(['message' => 'Selected users deleted successfully!']);
        }

        return response()->json(['message' => 'No records selected!'], 400);
    }
}
