<?php

namespace App\Http\Controllers;

use App\Models\SalesPosition;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class SalesPositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['page_title'] = 'Sales Position';
        
        if ($request->ajax()) {
            $data['sales_positions'] = SalesPosition::get();
            // ->when($request->show_parent == 'false',function($query){ 
            //     $query->where('is_parent','!=', 1); 
            // });
            return DataTables::of($data['sales_positions'])
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<label class="checkboxs">
                            <input type="checkbox" class="checkbox-item sales_position_checkbox" data-id="' . $row->id . '">
                            <span class="checkmarks"></span>
                        </label>';
                })
                ->addColumn('action', function ($row) {
                    $edit_btn = '<a href="javascript:void(0)" class="dropdown-item edit-btn"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"><i class="ti ti-edit text-warning"></i> Edit</a>';

                    $delete_btn = '<a href="javascript:void(0)" class="dropdown-item deleteSalesPosition"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"> <i class="ti ti-trash text-danger"></i> ' . __('Delete') . '</a><form action="' . route('sales_position.destroy', $row->id) . '" method="post" class="delete-form" id="delete-sales-position-form-' . $row->id . '" >'
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
        return view('admin.sales_position.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:sales_positions,name,NULL,id'
        ], [
            'name.required' => 'The name field is required.',
        ]);

        SalesPosition::create([
            'name'   => $request->name,
            'status' => $request->status,
        ]);

        return response()->json(['success' => true, 'message' => 'Position created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function edit(SalesPosition $sales_position)
    {
        return response()->json($sales_position);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesPosition $sales_position)
    {
        $request->validate([
            'name' => 'required|unique:sales_positions,name,' . $sales_position->id . ',id'
        ], [
            'name.required' => 'The name field is required.',
        ]);

        $sales_position->update([
            'name'   => $request->name,
            'status' => $request->status,
        ]);
        return response()->json(['success' => true, 'message' => 'Position updated successfully']);
    }
    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(SalesPosition $salesPosition)
    // {
    //     //
    // }

    public function destroy(SalesPosition $sales_position)
    {
        $sales_position->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Position deleted successfully']);
        }
        return redirect()->route('sales_position.index')->with('success', 'Position deleted successfully.');
    }


    
    /*****  Bulk delete method  *****/
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if (!empty($ids)) {
            SalesPosition::whereIn('id', $ids)->delete();
            return response()->json(['message' => 'Position deleted successfully!']);
        }
        return response()->json(['message' => 'No records selected!'], 400);
    }






}
