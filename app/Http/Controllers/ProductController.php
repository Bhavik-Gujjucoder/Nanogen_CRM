<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Variation;
use Illuminate\Http\Request;
use App\Models\GradeManagement;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['page_title'] = 'Product Catalogue';

        if ($request->ajax()) {
            $data = Product::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<label class="checkboxs">
                            <input type="checkbox" class="checkbox-item product_checkbox" data-id="' . $row->id . '">
                            <span class="checkmarks"></span>
                        </label>';
                })
                ->addColumn('action', function ($row) {
                    $edit_btn = '<a href="' . route('product.edit', $row->id) . '" class="dropdown-item"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"><i class="ti ti-edit text-warning"></i> Edit</a>';

                    $delete_btn = '<a href="javascript:void(0)" class="dropdown-item deleteVariation"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"> <i class="ti ti-trash text-danger"></i> ' . __('Delete') . '</a><form action="' . route('product.destroy', $row->id) . '" method="post" class="delete-form" id="delete-form-' . $row->id . '" >'
                        . csrf_field() . method_field('DELETE') . '</form>';

                    $action_btn = '<div class="dropdown table-action">
                                             <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                             <div class="dropdown-menu dropdown-menu-right">';

                    Auth::user()->can('manage users') ? $action_btn .= $edit_btn : '';
                    Auth::user()->can('manage users') ? $action_btn .= $delete_btn : '';

                    return $action_btn . ' </div></div>';
                })

                ->editColumn('product_name', function ($product) {
                    return '<a href="'. asset("storage/product_images/".$product->product_image) .'" target="_blank" class="avatar avatar-sm border rounded p-1 me-2">
                                             <img class="" src="'. asset("storage/product_images/".$product->product_image) .'" alt="User Image"></a>  '.$product->product_name;
                })
                ->editColumn('category_id', function ($product) {
                    return $product->category ? $product->category->category_name : '-';
                })
                ->editColumn('grade_id', function ($product) {
                    return $product->grade ? $product->grade->name : '-';
                })

                // ->filterColumn('value', function ($query, $keyword) {
                //     $query->whereHas('variant_options', function ($q) use ($keyword) {
                //         $q->where('value', 'LIKE', "%{$keyword}%");
                //     });
                // })

                ->editColumn('status', function ($product) {
                    return $product->statusBadge();
                })

                ->rawColumns(['checkbox','product_name', 'action', 'status']) //'value',
                ->make(true);
        }

        return view('admin.product.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['page_title'] = 'Create Product Catalogue';
        $data['variations'] = Variation::where('status',1)->get()->all();
        $data['category'] = Category::where('status',1)->get()->all();
        $data['grads'] = GradeManagement::where('status',1)->get()->all();

        return view('admin.product.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $product_name  =  $request->product_name;
        $category_id   =  $request->category_id;
        $grade_id      =  $request->grade_id;
        $status        =  $request->status;


        if ($product_name || $category_id || $grade_id  || $status) {
            $product =  Product::create([
                'product_name' => $product_name,
                'category_id' => $category_id,
                'grade_id' => $grade_id,
                'status' => $request->status,
            ]);
        }
        if ($request->hasFile('product_image')) {
            $file = $request->file('product_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('product_images', $filename, 'public'); // Save to storage/app/public/product_images
            $product->product_image = $filename;
        }

        $product->save();
        return redirect()->route('product.index')->with('success', 'Product created successfully.');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
