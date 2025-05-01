<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\OrderManagement;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CityManagement;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class AreaWiseSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['page_title'] = 'Area wise sales';

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
        $data['page_title'] = 'Areawise Sales';
        $data['city_id'] = $city_id;
        $data['city_name'] = CityManagement::where('id', $city_id)->first()->city_name ?? '';
        $data['products'] = Product::where('status', 1)->get();
        $data['categories'] = Category::where('status', 1)->get();
        // $data['records'] = OrderManagement::where('sales_person_id');
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
                ->editColumn('order_date', function ($row) {
                    // return $row->order_date->format('d-m-Y');
                    return Carbon::parse($row->order_date)->format('d M Y');
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

                ->editColumn('status', function ($row) {
                    return $row->statusBadge();
                })
                // ->filterColumn('order_status', function ($query, $keyword) {
                //     $statuses = ['pending' => 1, 'processing' => 2, 'shipping' => 3, 'delivered' => 4, 'inactive' => 0];
                //     // Find the matching status key (case-insensitive)
                //     foreach ($statuses as $label => $value) {
                //         if (stripos($label, $keyword) != false) {
                //             return $query->where('status', $value);
                //         }
                //     }
                //     // If not matched, prevent any result
                //     return $query->whereRaw('0 = 1');
                // })
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



                // ->editColumn('city_name', function ($row) {
                //     return $row->sales_person_detail->city->city_name ?? '-'; //Get user roles
                // })
                // ->editColumn('amount', function ($row) {
                //     return $row->grand_total; //Get user roles
                // })
                // ->filterColumn('city_name', function($query, $keyword) {
                //             $query->where('city_name', 'like', "%$keyword%");
                // })
                ->rawColumns(['status', 'product_qty'])
                ->make(true);
        }

        return view('admin.area_wise_sales.show', $data);
    }
}
