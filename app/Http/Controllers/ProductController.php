<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Variation;
use Illuminate\Http\Request;
use App\Models\GradeManagement;
use App\Models\ProductVariation;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
                    $trend_analysis_btn = '<a href="' . route('trend_analysis.product_report',['product_id' => $row->id]) . '" class="dropdown-item" data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"><i class="ti ti-chart-bar text-cool"></i>Trend Analysis</a>';

                    $edit_btn = '<a href="' . route('product.edit', $row->id) . '" class="dropdown-item"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"><i class="ti ti-edit text-warning"></i> Edit</a>';

                    $delete_btn = '<a href="javascript:void(0)" class="dropdown-item deleteVariation"  data-id="' . $row->id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"> <i class="ti ti-trash text-danger"></i> ' . __('Delete') . '</a><form action="' . route('product.destroy', $row->id) . '" method="post" class="delete-form" id="delete-form-' . $row->id . '" >'
                        . csrf_field() . method_field('DELETE') . '</form>';

                    $action_btn = '<div class="dropdown table-action">
                                             <a href="#" class="action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                             <div class="dropdown-menu dropdown-menu-right">';

                    // Auth::user()->can('manage users') ? $action_btn .= $edit_btn : '';
                    // Auth::user()->can('manage users') ? $action_btn .= $delete_btn : '';
                    
                    Auth::user()->can('Trend Analysis') ? $action_btn .= $trend_analysis_btn : '';
                    // $action_btn .= $trend_analysis_btn; 
                    $action_btn .= $edit_btn;
                    $action_btn .= $delete_btn;

                    return $action_btn . ' </div></div>';
                })
                ->editColumn('product_name', function ($product) {
                    $productImage = !empty($product->product_image)
                        ? asset("storage/product_images/" . $product->product_image)
                        : asset("images/default-user.png"); // Change path if your default image is elsewhere

                    $imageTag = '<a href="' . $productImage . '" target="_blank" class="avatar avatar-sm border rounded p-1 me-2">
                                    <img class="" src="' . $productImage . '" alt="Product Image">
                                </a>';

                    return $imageTag . ' ' . $product->product_name;
                })
                ->editColumn('category_id', function ($product) {
                    return $product->category ? $product->category->category_name : '-';
                })
                ->editColumn('grade_id', function ($product) {
                    return $product->grade ? $product->grade->name : '-';
                })
                 ->editColumn('gst', function ($product) {
                    return $product->gst ? $product->gst : '-';
                })
                ->editColumn('status', function ($product) {
                    return $product->statusBadge();
                })
                ->filterColumn('category_id', function ($query, $keyword) {
                    $query->whereHas('category', function ($q) use ($keyword) {
                        $q->where('category_name', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('grade_id', function ($query, $keyword) {
                    $query->whereHas('grade', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
                })
                ->rawColumns(['checkbox', 'product_name', 'action', 'status']) //'value',
                ->make(true);
        }

        return view('admin.product.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['page_title'] = 'Create Product';
        $data['variations'] = Variation::where('status', 1)->get()->all();
        $data['category']   = Category::where('status', 1)->get()->all();
        $data['grads']      = GradeManagement::where('status', 1)->get()->all();
        return view('admin.product.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = Product::create($request->only(['product_name', 'category_id', 'grade_id', 'status', 'gst']));
        if ($request->hasFile('product_image')) {
            $file     = $request->file('product_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('product_images', $filename, 'public');
            /** Save to storage/app/public/product_images **/
            $product->product_image = $filename;
        }
        $product->save();

        if ($request->has(['dealer_price', 'distributor_price', 'variation_id', 'variation_option_id'])) {
            $dealer_prices       = $request->input('dealer_price');
            $distributor_price   = $request->input('distributor_price');
            $variation_id        = $request->input('variation_id');
            $variation_option_id = $request->input('variation_option_id');

            foreach ($dealer_prices as $key => $dealer_price) {
                ProductVariation::create([
                    'product_id'          => $product->id,
                    'dealer_price'        => $dealer_price,
                    'distributor_price'   => $distributor_price[$key],
                    'variation_id'        => $variation_id[$key],
                    'variation_option_id' => $variation_option_id[$key],
                ]);
            }
        }
        return redirect()->route('product.index')->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $data = [
            'page_title' => 'Edit Product',
            'product'    => $product,
            'variations' => Variation::where('status', 1)->get()->all(),
            'category'   => Category::where('status', 1)->get()->all(),
            'grads'      => GradeManagement::where('status', 1)->get()->all(),
        ];
        return view('admin.product.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->only(['product_name', 'category_id', 'grade_id', 'status', 'gst']));

        if ($request->hasFile('product_image')) {
            if ($product->product_image) {
                Storage::disk('public')->delete('product_images/' . $product->product_image);
            }

            $file     = $request->file('product_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('product_images', $filename, 'public');
            /** Save to storage/app/public/product_images **/
            $product->product_image = $filename;
            $product->save();
        }

        if ($request->has(['dealer_price', 'distributor_price', 'variation_id', 'variation_option_id'])) {
            ProductVariation::where('product_id', $id)->delete();

            $dealer_prices        = $request->input('dealer_price');
            $distributor_prices   = $request->input('distributor_price');
            $variation_ids        = $request->input('variation_id');
            $variation_option_ids = $request->input('variation_option_id');

            foreach ($dealer_prices as $key => $dealer_price) {
                ProductVariation::create([
                    'product_id'          => $product->id,
                    'dealer_price'        => $dealer_price,
                    'distributor_price'   => $distributor_prices[$key],
                    'variation_id'        => $variation_ids[$key],
                    'variation_option_id' => $variation_option_ids[$key],
                ]);
            }
        }
        return redirect()->route('product.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        ProductVariation::where('product_id', $id)->delete();
        if ($product->product_image) {
            Storage::disk('public')->delete('product_images/' . $product->product_image);
        }
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Variation deleted successfully!');
    }


    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if (!empty($ids)) {
            $products = Product::whereIn('id', $ids)->get();
            ProductVariation::whereIn('product_id', $ids)->delete();

            foreach ($products as $product) {
                if ($product->product_image) {
                    Storage::disk('public')->delete('product_images/' . $product->product_image);
                }
                $product->delete();
            }
            return response()->json(['message' => 'Selected products deleted successfully!']);
        }
        return response()->json(['message' => 'No records selected!'], 400);
    }


    public function get_product_variation(Request $request)
    {
        if (!empty($request->product_id)) {
            $product_variation = ProductVariation::with('variation_option_value')->where('product_id', $request->product_id)->get();
            return response()->json([
                'product_variation' => $product_variation,
                'success' => true,
                'message' => 'Selected products cache successfully!'
            ]);
        }
        return response()->json(['message' => 'No records selected!'], 400);
    }

    public function get_product_variation_price(Request $request)
    {
        if ($request->variation_option_id) {
            $product = ProductVariation::with('variation_option_value')
                ->where('product_id', $request->product_id)
                ->where('variation_option_id', $request->variation_option_id)
                ->first();

            return response()->json([
                'product' => $product,
                'success' => true,
                'message' => 'Selected products deleted successfully!'
            ]);
        }
        return response()->json(['message' => 'No records selected!'], 400);
    }
}
