<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\OrderManagement;
use App\Models\SalesPersonDetail;
use App\Models\DistributorsDealers;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $order_management,$dealer_distributor,$sales_person_detail,$product;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(OrderManagement $order_management, DistributorsDealers $dealer_distributor, SalesPersonDetail $sales_person_detail,Product $product)
    {
        $this->middleware('auth');
        $this->order_management = $order_management;
        $this->dealer_distributor = $dealer_distributor;
        $this->sales_person_detail = $sales_person_detail;
        $this->product = $product;
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
        $data['total_distributor']  = $this->dealer_distributor->where('user_type', 1)->count();
        $data['total_dealer']       = $this->dealer_distributor->where('user_type', 2)->count();
        $data['total_sales_person'] = $this->sales_person_detail->whereNull('deleted_at')->count(); 
        $data['total_product']      = $this->product->where('status', 1)->count();
        $data['total_order']        = $this->order_management->count();                  
        $data['order_grand_total']  = $this->order_management->sum('grand_total');       
        $data['latest_orders']      = $this->order_management->latest()->take(5)->get(); 
        $data['latest_dealers']     = $this->dealer_distributor->where('user_type', 2)->latest()->take(5)->get();
        $data['latest_distributor'] = $this->dealer_distributor->where('user_type', 1)->latest()->take(5)->get();
        return view('staff.dashboard',$data);
    }

    public function admin_index()
    {
        $data['page_title']         = 'Admin Dashboard';
        $data['total_distributor']  = $this->dealer_distributor->where('user_type', 1)->count();
        $data['total_dealer']       = $this->dealer_distributor->where('user_type', 2)->count();
        $data['total_sales_person'] = $this->sales_person_detail->whereNull('deleted_at')->count(); 
        $data['total_product']      = $this->product->where('status', 1)->count();
        $data['total_order']        = $this->order_management->count();                  
        $data['order_grand_total']  = $this->order_management->sum('grand_total');       
        $data['latest_orders']      = $this->order_management->latest()->take(5)->get(); 
        $data['latest_dealers']     = $this->dealer_distributor->where('user_type', 2)->latest()->take(5)->get();
        $data['latest_distributor'] = $this->dealer_distributor->where('user_type', 1)->latest()->take(5)->get();
        return view('admin.dashboard', $data);
    }

    public function sales_index()
    {
        $data['page_title'] = 'Sales Dashboard';
        return view('sales.dashboard', $data);
    }

    public function my_profile(Request $request)
    {
        $user = Auth::user();  
        // dd($user);
        if($user->hasrole('admin') || $user->hasrole('staff')){
            return redirect()->route('users.edit', $user->id);
        }
        if($user->hasrole('sales')){
            $sale_person_id = SalesPersonDetail::where('user_id', $user->id)->first()->id;
            return redirect()->route('sales_person.edit', $sale_person_id);
        }

    }
}
