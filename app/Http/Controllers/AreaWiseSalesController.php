<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\CityManagement;
use App\Models\OrderManagement;
use Yajra\DataTables\DataTables;
use App\Models\SalesPersonDetail;
use Illuminate\Support\Facades\DB;
use App\Models\DistributorsDealers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AreaWiseSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['page_title'] = 'Area-wise Sales';
        if ($request->ajax()) {
            $data = OrderManagement::query()
                // ->join('sales_person_details', 'sales_person_details.user_id', '=', 'order_management.salesman_id')
                // ->join('city_management', 'city_management.id', '=', 'sales_person_details.city_id')
                ->join('distributors_dealers', 'distributors_dealers.id', '=', 'order_management.dd_id')
                ->join('city_management', 'city_management.id', '=', 'distributors_dealers.city_id')
                ->select(
                    'city_management.city_name as city_name',
                    'city_management.id as city_id',
                    DB::raw('SUM(order_management.grand_total) as amount')
                )
                ->groupBy('city_management.city_name', 'city_management.id');
            // ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $view_detail = '<a href="' . route('area_wise_sales.show', $row->city_id) . '" class="dropdown-item edit-btn" data-id="' . $row->city_id . '"
                    class="btn btn-outline-warning btn-sm edit-btn"><i class="ti ti-info-circle text-green"></i> View Detail</a>';

                    $action_btn = '<div class="dropdown table-action">
                                    <a href="#" class="action-icon" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right">';


                    Auth::user()->can('manage orders') ? $action_btn .= $view_detail : '';

                    return $action_btn . ' </div></div>';
                })
                ->filterColumn('city_name', function ($query, $keyword) {
                    $query->where('city_name', 'like', "%$keyword%");
                })
                ->rawColumns(['checkbox', 'action'])
                ->make(true);
        }

        return view('admin.area_wise_sales.index', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $city_id)
    {
        $data['page_title'] = 'Area-wise Sales';
        $data['city_id']    = $city_id;
        $data['city_name']  = CityManagement::where('id', $city_id)->first()->city_name ?? '';
        $data['products']   = Product::where('status', 1)->get();
        $data['categories'] = Category::where('status', 1)->get();

        if ($request->ajax()) {
            // $data = OrderManagement::with('sales_person_detail')
            // ->whereHas('sales_person_detail', function($q) use ($city_id) {
            //     $q->where('city_id', $city_id);
            // });
            $data = OrderManagement::with('distributors_dealers')->with('products.product.category')
                ->whereHas('distributors_dealers', function ($q) use ($city_id) {
                    $q->where('city_id', $city_id);
                })
                // Filter by product_id & category_id
                ->when($request->product_id, function ($query) use ($request) {
                    $query->whereHas('products.product', function ($q) use ($request) {
                        $q->where('products.id', $request->product_id);
                    });
                })
                ->when($request->category_id, function ($query) use ($request) {
                    $query->whereHas('products.product.category', function ($q) use ($request) {
                        $q->where('categories.id', $request->category_id);
                    });
                });

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('unique_order_id', function ($row) {
                    $order_id = $row->unique_order_id;
                    return '<a href="' . route('area_wise_sales.order_show', $row->id) . '" class="show-btn open-popup-model"  data-id="' . $row->id . '">
                                <i class="ti ti-eye #1ecbe2"></i>  ' . $order_id . '</a>';

                    // '. route('order_management.edit', $row->id) .'

                })
                ->editColumn('dd_id', function ($row) {
                    if ($row->distributors_dealers) {
                        $type = $row->distributors_dealers->user_type == 1 ? '(Distributor)' : ($row->distributors_dealers->user_type == 2 ? '(Dealer)' : '');
                        return $row->distributors_dealers->applicant_name . ' ' . $type;
                    }
                    return '-';
                })
                ->editColumn('salesman_id', function ($row) {
                    if ($row->sales_person_detail) {
                        return $row->sales_person_detail->first_name . ' ' . $row->sales_person_detail->last_name;
                    }
                    return '-';
                })
                ->addColumn('product_qty', function ($row) {
                    return $row->products->map(function ($orderProduct) {
                        return $orderProduct->product->product_name . ' (' . $orderProduct->qty . ')';
                    })->implode('<br> ');
                })
                ->editColumn('order_date', function ($row) {
                    return Carbon::parse($row->order_date)->format('d M Y');
                })
                ->editColumn('status', function ($row) {
                    return $row->statusBadge();
                })
                ->filterColumn('dd_id', function ($query, $keyword) {
                    $query->whereHas('distributors_dealers', function ($q) use ($keyword) {
                        $q->where('applicant_name', 'like', "%{$keyword}%")
                            ->orWhereRaw("CASE 
                              WHEN user_type = 1 THEN 'Distributor'
                              WHEN user_type = 2 THEN 'Dealer'
                              ELSE ''
                          END LIKE ?", ["%{$keyword}%"]);
                    });
                })
                ->filterColumn('salesman_id', function ($query, $keyword) {
                    $query->whereHas('sales_person_detail', function ($q) use ($keyword) {
                        // $q->where('first_name', 'like', "%{$keyword}%");
                        $q->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$keyword}%"]);
                    });
                })
                ->filterColumn('order_date', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(order_date, '%d-%m-%Y') LIKE ?", ["%{$keyword}%"]);
                })
                ->rawColumns(['unique_order_id', 'status', 'product_qty'])
                ->make(true);
        }

        return view('admin.area_wise_sales.show', $data);
    }


    public function order_show($id)
    {
        try {
            $data['order'] = OrderManagement::findOrFail($id);
           
            $html = view('admin.area_wise_sales.order_show', $data)->render(); // Assuming your modal HTML is in order.modal view.
    
            return response()->json([
                'html' => $html,  // Return the modal HTML as a string
            ]);
        } catch (\Throwable $th) {
            dd($th);
            return response()->json(['error' => 'Something went wrong!'], 500); 
            // return redirect()->back()->with('error', 'Something is wrong!!');
        }
    }
}
