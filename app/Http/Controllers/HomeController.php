<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\OrderManagement;
use App\Models\SalesPersonDetail;
use App\Models\DistributorsDealers;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['page_title'] = 'Super Admin Dashboard';
        return view('superadmin.dashboard',$data);
    }
    public function staff_index()
    {
        $data['page_title'] = 'Staff Dashboard';
        return view('staff.dashboard',$data);
    }
    public function admin_index()
    {
        $data['page_title'] = 'Admin Dashboard';
        $dealer_distributor = DistributorsDealers::get();
        $data['total_distributor'] = $dealer_distributor->where('user_type', 1)->count();
        $data['total_dealer'] = $dealer_distributor->where('user_type', 2)->count();
        $data['total_sales_person'] = SalesPersonDetail::where('deleted_at',NULL)->count(); 
        $data['total_product'] = Product::where('status', 1)->count();
        $order = OrderManagement::get(); 
        $data['total_order'] = $order->count();
        $data['order_grand_total'] = $order->sum('grand_total');

        return view('admin.dashboard',$data);
    }
    public function sales_index()
    {
        $data['page_title'] = 'Sales Dashboard';
        return view('sales.dashboard',$data);
    }
}
