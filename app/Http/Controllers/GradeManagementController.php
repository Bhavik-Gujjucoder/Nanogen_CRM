<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\GradeManagement;
use Illuminate\Support\Facades\Auth;

class GradeManagementController extends Controller
{
    /**
     * Display a listing of the resource.
    */
    public function index(Request $request)
    {
        $data['page_title'] = 'Grade management';

        if ($request->ajax()) {
            $data = GradeManagement::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // $show_btn = '<a href="' . route('users.show', $row->id) . '"
                    // class="btn btn-outline-info btn-sm"><i class="bi bi-eye-fill"></i> ' . __('Show') . '</a>';

                    $edit_btn = '<a href="javascript:void(0)" class="dropdown-item edit-btn"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"><i class="ti ti-edit text-warning"></i> Edit</a>';

                    // $delete_btn = '&nbsp;<form action="' . route('users.destroy', $row->id) . '" method="post">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-outline-danger btn-sm"
                    // onclick="return confirm(`' . __('Do you want to delete this admin?') . '`);"><i class="bi bi-trash-fill"></i> ' . __('Delete') . '</button></form>';

                    $delete_btn = '<a href="javascript:void(0)" class="dropdown-item deleteGrade"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"> <i class="ti ti-trash text-danger"></i> ' . __('Delete') . '</a><form action="' . route('grade.destroy', $row->id) . '" method="post" class="delete-form" id="delete-form-'. $row->id.'" >'
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

                ->editColumn('status', function ($product) {
                    return $product->statusBadge(); // Get user roles
                })

                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.grade.index', $data);
    }

    /**
     * Store a newly created resource in storage.
    */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:grade_management,name']);
        GradeManagement::create([
            'name' => $request->name,
            'status' => $request->status
        ]);

        return redirect()->route('product_category.index')->with('success', 'Product category created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
    */
    public function edit(GradeManagement $grade)
    {
        return response()->json($grade);
    }

     /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GradeManagement $grade)

    {
        $request->validate(['name' => 'required|unique:grade_management,name,' . $grade->id]);
        $grade->update([
            'name' => $request->name,
            'status' => $request->status
        ]);
        return response()->json(['success' => true, 'message' => 'Grade updated successfully']);

        // return redirect()->route('grade.index')->with('success', 'Grade updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GradeManagement $grade)
    {
        $grade->delete();
        return redirect()->route('grade.index')->with('success', 'Grade deleted successfully.');
    }

}
