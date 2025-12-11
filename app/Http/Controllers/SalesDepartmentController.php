<?php

namespace App\Http\Controllers;

use App\Models\SalesDepartment;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class SalesDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['page_title'] = 'Sales Department';

        if ($request->ajax()) {
            $data['sales_departments'] = SalesDepartment::get();
            // ->when($request->show_parent == 'false',function($query){ 
            //     $query->where('is_parent','!=', 1); 
            // });
            return DataTables::of($data['sales_departments'])
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<label class="checkboxs">
                            <input type="checkbox" class="checkbox-item sales_department_checkbox" data-id="' . $row->id . '">
                            <span class="checkmarks"></span>
                        </label>';
                })
                ->addColumn('action', function ($row) {
                    $edit_btn = '<a href="javascript:void(0)" class="dropdown-item edit-btn"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"><i class="ti ti-edit text-warning"></i> Edit</a>';

                    $delete_btn = '<a href="javascript:void(0)" class="dropdown-item deleteSalesDepartment"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"> <i class="ti ti-trash text-danger"></i> ' . __('Delete') . '</a><form action="' . route('sales_department.destroy', $row->id) . '" method="post" class="delete-form" id="delete-sales-department-form-' . $row->id . '" >'
                        . csrf_field() . method_field('DELETE') . '</form>';

                    $action_btn = '<div class="dropdown table-action">
                                             <a href="#" class="action-icon" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                             <div class="dropdown-menu dropdown-menu-right">';

                    // Auth::user()->can('manage users') ? $action_btn .= $edit_btn : '';
                    // Auth::user()->can('manage users') ? $action_btn .= $delete_btn : '';
                    $action_btn .= $edit_btn;
                    $action_btn .= $delete_btn;

                    return $action_btn . ' </div></div>';
                })
                ->editColumn('status', function ($row) {
                    return $row->statusBadge();
                })
                ->rawColumns(['checkbox', 'action', 'status'])
                ->make(true);
        }
        return view('admin.sales_department.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:sales_departments,name,NULL,id'
        ], [
            'name.required' => 'The name field is required.',
        ]);

        SalesDepartment::create([
            'name'   => $request->name,
            'status' => $request->status,
        ]);

        return response()->json(['success' => true, 'message' => 'Department created successfully']);
    }
    /**
     * Display the specified resource.
     */
    public function edit(SalesDepartment $sales_department)
    {
        return response()->json($sales_department);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesDepartment $sales_department)
    {
        $request->validate([
            'name' => 'required|unique:sales_departments,name,' . $sales_department->id . ',id'
        ], [
            'name.required' => 'The name field is required.',
        ]);

        $sales_department->update([
            'name'   => $request->name,
            'status' => $request->status,
        ]);
        return response()->json(['success' => true, 'message' => 'Department updated successfully']);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesDepartment $sales_department)
    {
        $sales_department->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Department deleted successfully']);
        }
        return redirect()->route('sales_department.index')->with('success', 'Department deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if (!empty($ids)) {
            SalesDepartment::whereIn('id', $ids)->delete();
            return response()->json(['message' => 'Department deleted successfully!']);
        }
        return response()->json(['message' => 'No records selected!'], 400);
    }
}
