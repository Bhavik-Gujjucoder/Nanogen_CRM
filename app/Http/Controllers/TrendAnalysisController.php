<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CityManagement;
use App\Models\OrderManagement;
use App\Models\OrderManagementProduct;
use App\Models\DistributorsDealers;
use App\Models\Target;
use Carbon\Carbon;


use Illuminate\Support\Facades\DB;

class TrendAnalysisController extends Controller
{

    protected $order_management, $order_management_product, $dealer_distributor, $product, $target, $city;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        OrderManagement $order_management,
        DistributorsDealers $dealer_distributor,
        Product $product,
        Target $target,
        CityManagement $city,
        OrderManagementProduct $order_management_product
    ) {
        $this->middleware('auth');
        $this->order_management = $order_management;
        $this->dealer_distributor = $dealer_distributor;
        $this->product = $product;
        $this->order_management_product = $order_management_product;
        $this->target = $target;
        $this->city = $city;
    }

    /**
     * Display a listing of the resource.
     */
    public function product_report(Request $request)
    {
        $product_data       = $request->all();
        $data['page_title'] = 'Trend Analysis';
        $data['products']   = $this->product->where('status', 1)->get();
        $data['citys']      = $this->city->where('status', 1)->get();
        $product_id         = isset($product_data['product_id']) ? $product_data['product_id'] : null;
        $city_id            = isset($product_data['city_id']) ? $product_data['city_id'] : null;
        $from_date          = isset($product_data['start_date']) ? Carbon::createFromFormat('d-m-Y', $product_data['start_date'])->format('Y-m-d')  : null;
        $to_date            = isset($product_data['end_date']) ? Carbon::createFromFormat('d-m-Y', $product_data['end_date'])->format('Y-m-d') : null;

        // $order_product = $this->order_management_product->where('product_id', $product_id);
        // $data['number_of_orders'] = $order_product->distinct('order_id')->count('order_id');
        // $data['revenue'] = $order_product->sum('total');

        $query = OrderManagementProduct::selectRaw('COUNT(DISTINCT order_id) as number_of_orders, SUM(total) as revenue,SUM(qty) as gqty')
            ->join('order_management', 'order_management_products.order_id', '=', 'order_management.id')
            ->where('product_id', $product_id)
            ->when($city_id, function ($q) use ($city_id) {
                $q->whereHas('order.distributors_dealers', function ($q2) use ($city_id) {
                    $q2->where('city_id', $city_id);
                });
            })
            ->when($from_date, fn($q) => $q->whereDate('order_management.order_date', '>=', $from_date))
            ->when($to_date, fn($q) => $q->whereDate('order_management.order_date', '<=', $to_date))
            ->first();

        $query2 = OrderManagementProduct::query()
            ->when($city_id, function ($q) use ($city_id) {
                $q->whereHas('order.distributors_dealers', function ($q2) use ($city_id) {
                    $q2->where('city_id', $city_id);
                });
            })
            ->when($from_date, fn($q) => $q->whereDate('order_management.order_date', '>=', $from_date))
            ->when($to_date, fn($q) => $q->whereDate('order_management.order_date', '<=', $to_date))
            ->join('order_management', 'order_management_products.order_id', '=', 'order_management.id')
            ->select(
                'order_management_products.packing_size_id',
                'variation_options.value as packing_size_name',
                'variation_options.unit as packing_size_unit',
                DB::raw('SUM(order_management_products.qty) as total_qty'),
                // DB::raw('COUNT(DISTINCT order_id) as number_of_orders')
                
            )
            ->join('variation_options', 'order_management_products.packing_size_id', '=', 'variation_options.id')
            ->where('order_management_products.product_id', $product_id)
            ->groupBy('order_management_products.packing_size_id', 'variation_options.value', 'variation_options.unit')
            ->get();


        $data['number_of_orders'] = $query->number_of_orders;
        $data['revenue']          = $query->revenue;
        $data['variation_qty']    = $query2;
        $data['city_id']          = $city_id;

        // ->when($city_id, function ($query) use ($city_id) {
        //     return $query->whereHas('distributors_dealers', function ($q) use ($city_id) {
        //         $q->where('city_id', $city_id);
        //     });
        // })
        // ->when($from_date, function ($query) use ($from_date) {
        //     return $query->whereDate('created_at', '>=', $from_date);
        // })
        // ->when($to_date, function ($query) use ($to_date) {
        //     return $query->whereDate('created_at', '<=', $to_date);
        // })
        // ->selectRaw('SUM(grand_total) as total_sales, city_management.city_name')
        // ->join('distributors_dealers', 'distributors_dealers.id', '=', 'order_management.dd_id')
        // ->join('city_management', 'city_management.id', '=', 'distributors_dealers.city_id')
        // ->groupBy('city_management.city_name')
        // ->get();

        return view('admin.trend_analysis.product_report', $data);
    }
}
