<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = 'Product Category';
        // $data['category'] = Category::where('is_parent', 1)->orWhereHas('children')->get();
        $data['category'] = Category::where('is_parent', 1)->where('status', 1)->get()->all();

        if ($request->ajax()) {
            // dd($request->show_parent);
            $data = Category::when($request->show_parent == 'true', function ($query) {
                $query->where('is_parent', 1);
            })
                ->when($request->show_parent == 'false', function ($query) {
                    $query->where('is_parent', '!=', 1);
                });
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<label class="checkboxs">
                            <input type="checkbox" class="checkbox-item category_checkbox" data-id="' . $row->id . '">
                            <span class="checkmarks"></span>
                        </label>';
                })
                ->addColumn('action', function ($row) {

                    $edit_btn = '<a href="javascript:void(0)" class="dropdown-item edit-btn"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"><i class="ti ti-edit text-warning"></i> Edit</a>';

                    $delete_btn = '<a href="javascript:void(0)" class="dropdown-item deleteCategory"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"> <i class="ti ti-trash text-danger"></i> ' . __('Delete') . '</a><form action="' . route('category.destroy', $row->id) . '" method="post" class="delete-form" id="delete-category-form-' . $row->id . '" >'
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
                ->editColumn('parent_category_id', function ($category) {
                    return $category->parent->category_name ?? '-'; //Get user roles
                })
                ->filterColumn('parent_category_id', function ($query, $keyword) {
                    $query->whereHas('parent', function ($query) use ($keyword) {
                        $query->where('category_name', 'like', "%$keyword%");
                    });
                })
                ->editColumn('status', function ($category) {
                    return $category->statusBadge(); //Get user roles
                })
                ->rawColumns(['checkbox', 'action', 'status'])
                ->make(true);
        }
        return view('admin.category.index', $data);
    }

    public function store(Request $request)
    {
        $categoriesCount = Category::whereNotNull('parent_category_id')->count(); // or however you get category count
        // dd($request->all());
        $request->validate([

            'parent_category_id' => [
                function ($attribute, $value, $fail) use ($categoriesCount) {
                    if ($categoriesCount > 1 && empty($value)) {
                        $fail('The ' . $attribute . ' field is required when more than one category exists.');
                    }
                },
            ],
            // 'parent_category_id' => 'required',
            'category_name' => 'required|unique:categories,category_name,NULL,id,deleted_at,NULL'
        ], [
            'parent_category_id.required' => 'The parent category field is required.',
        ]);
        $is_parent = 1;
        if ($request->parent_category_id > 0) {
            $is_parent = 0;
        }
        Category::create([
            'parent_category_id' => $request->parent_category_id,
            'category_name' => $request->category_name,
            'status'        => $request->status,
            'is_parent'     => $is_parent
        ]);

        return response()->json(['success' => true, 'message' => 'Category created successfully']);
        // return redirect()->route('category.index')->with('message', 'Product Category created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'parent_category_id' => 'required',
            'category_name' => 'required|unique:categories,category_name,' . $category->id . ',id,deleted_at,NULL'
        ], [
            'parent_category_id.required' => 'The parent category field is required.',
        ]);
        $is_parent = 1;
        if ($request->parent_category_id > 0) {
            $is_parent = 0;
        }
        $category->update([
            'parent_category_id' => $request->parent_category_id,
            'category_name' => $request->category_name,
            'status'    => $request->status,
            'is_parent' =>  $is_parent
        ]);
        return response()->json(['success' => true, 'message' => 'Category updated successfully']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Category deleted successfully']);
        }
        return redirect()->route('category.index')->with('success', 'Category deleted successfully.');
    }


    /*****  Bulk delete method  *****/
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if (!empty($ids)) {
            Category::whereIn('id', $ids)->delete();
            return response()->json(['message' => 'Selected categories deleted successfully!']);
        }
        return response()->json(['message' => 'No records selected!'], 400);
    }
}
