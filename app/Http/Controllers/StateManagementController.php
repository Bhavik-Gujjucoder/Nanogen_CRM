<?php

namespace App\Http\Controllers;

use App\Models\CityManagement;
use Illuminate\Http\Request;
use App\Models\StateManagement;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class StateManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['page_title'] = 'State Management';

        if ($request->ajax()) {
            $data = StateManagement::withCount('cities');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<label class="checkboxs">
                            <input type="checkbox" class="checkbox-item state_checkbox" data-id="' . $row->id . '">
                            <span class="checkmarks"></span>
                        </label>';
                })
                ->addColumn('action', function ($row) {
                    $edit_btn = '<a href="javascript:void(0)" class="dropdown-item edit-btn"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"><i class="ti ti-edit text-warning"></i>Edit</a>';

                    $delete_btn = '<a href="javascript:void(0)" class="dropdown-item deleteState"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"> <i class="ti ti-trash text-danger"></i> ' . __('Delete') . '</a><form action="' . route('state.destroy', $row->id) . '" method="post" class="delete-form" id="delete-form-'. $row->id.'" >'
                        . csrf_field() . method_field('DELETE') . '</form>';

                    $action_btn = '<div class="dropdown table-action">
                                             <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                             <div class="dropdown-menu dropdown-menu-right">';
                    Auth::user()->can('manage users') ? $action_btn .= $edit_btn : '';
                    Auth::user()->can('manage users') ? $action_btn .= $delete_btn : '';
                    return $action_btn . ' </div></div>';
                })

                ->addColumn('cities_count', function ($row) {
                    return $row->cities_count;   /*withCount('cities') => cities_count */
                })
                ->orderColumn('cities_count', function ($query, $order) {
                    $query->orderBy('cities_count', $order);
                })

                ->editColumn('status', function ($row) {
                    return $row->statusBadge(); // Get user roles
                })

                ->rawColumns(['action', 'status','checkbox','number_of_state_city'])
                ->make(true);
        }
        return view('admin.state.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate(['state_name' => 'required|unique:state_management,state_name,NULL,id,deleted_at,NULL']);
        StateManagement::create([
            'state_name' => $request->state_name,
            'status'     => $request->status
        ]);
        return response()->json(['success' => true, 'message' => 'State created successfully']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StateManagement $state)
    {
        return response()->json($state);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StateManagement $state)
    {
        $request->validate(['state_name' => 'required|unique:state_management,state_name,' . $state->id. ',id,deleted_at,NULL']);
        $state->update([
            'state_name' => $request->state_name,
            'status' => $request->status
        ]);
        
        return response()->json(['success' => true, 'message' => 'State updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StateManagement $state)
    {
        $cities = CityManagement::where('state_id',$state->id)->delete();
        $state->delete();
        return redirect()->route('state.index')->with('success', 'State deleted successfully.');
    }


    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        if (!empty($ids)) {
            CityManagement::whereIn('state_id',$ids)->delete();
            StateManagement::whereIn('id', $ids)->delete();
            return response()->json(['message' => 'Selected states deleted successfully!']);
        }

        return response()->json(['message' => 'No records selected!'], 400);
    }
}
