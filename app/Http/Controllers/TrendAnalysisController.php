<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CityManagement;
use App\Models\OrderManagement;
use App\Models\OrderManagementProduct;
use App\Models\DistributorsDealers;
use App\Models\Target;

class TrendAnalysisController extends Controller
{

    protected $order_management, $dealer_distributor, $product, $target;
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
        $product_data        = $request->all();
        $data['page_title']  = 'Trend Analysis';
        $data['products']    = $this->product->where('status', 1)->get();
        $data['citys']       = $this->city->where('status', 1)->get();
        $product_id          = isset($product_data['product_id']) ? $product_data['product_id'] : null;
        $city_id             = isset($product_data['city_id']) ? $product_data['city_id'] : null;
        $from_date           = isset($product_data['start_date']) ? $product_data['start_date'] : null;
        $to_date             = isset($product_data['end_date']) ? $product_data['end_date'] : null;   
        
        // dump ($product_id);
        $data['number_of_orders'] = $this->order_management_product->where('product_id', $product_id)->distinct('order_id')->count('order_id');
        // dd ($number_of_orders);
          
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
