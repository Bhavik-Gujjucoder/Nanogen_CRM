<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class ProductCategoryController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = 'Product Category';
        // $data['category'] = ProductCategory::where('is_parent', 1)->orWhereHas('children')->get();
        $data['category'] = ProductCategory::where('is_parent', 1)->get()->all();
        // dd($data['category']->pluck('category_name')->toArray());

        if ($request->ajax()) {
            $data = ProductCategory::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $edit_btn = '<a href="javascript:void(0)" class="dropdown-item edit-btn"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"><i class="ti ti-edit text-warning"></i> Edit</a>';

                    $delete_btn = '<a href="javascript:void(0)" class="dropdown-item deleteCategory"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"> <i class="ti ti-trash text-danger"></i> ' . __('Delete') . '</a><form action="' . route('product_category.destroy', $row->id) . '" method="post" class="delete-form" id="delete-form-' . $row->id . '" >'
                        . csrf_field() . method_field('DELETE') . '</form>';

                    $action_btn = '<div class="dropdown table-action">
                                             <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                             <div class="dropdown-menu dropdown-menu-right">';


                    Auth::user()->can('manage users') ? $action_btn .= $edit_btn : '';
                    Auth::user()->can('manage users') ? $action_btn .= $delete_btn : '';

                    return $action_btn . ' </div></div>';
                })

                ->editColumn('parent_category_id', function ($category) {
                    return $category->parent->category_name ?? '-'; //Get user roles
                })

                ->editColumn('status', function ($category) {
                    return $category->statusBadge(); //Get user roles
                })

                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.productcategory.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate(['category_name' => 'required|unique:product_categories,category_name,NULL,id,deleted_at,NULL']);
        $is_parent = 1;
        if ($request->parent_category_id > 0) {
            $is_parent = 0;
        }
        ProductCategory::create([
            'parent_category_id' => $request->parent_category_id,
            'category_name' => $request->category_name,
            'status' => $request->status,
            'is_parent' =>  $is_parent
        ]);

        return redirect()->route('product_category.index')->with('success', 'Product Category created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $product_category)
    {
        return response()->json($product_category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $product_category)
    {
        $request->validate(['category_name' => 'required|unique:product_categories,category_name,' . $product_category->id .',id,deleted_at,NULL']);
        $is_parent = 1;
        if ($request->parent_category_id > 0) {
            $is_parent = 0;
        }
        $product_category->update([
            'parent_category_id' => $request->parent_category_id,
            'category_name' => $request->category_name,
            'status' => $request->status,
            'is_parent' =>  $is_parent
        ]);
        return response()->json(['success' => true, 'message' => 'Category updated successfully']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $product_category)
    {
        $product_category->delete();
        return redirect()->route('product_category.index')->with('success', 'Category deleted successfully.');
    }
}
