<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\OrderManagement;
use App\Models\SalesPersonDetail;
use App\Models\DistributorsDealers;
use App\Models\OrderManagementProduct;
use App\Models\Target;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    protected $order_management, $dealer_distributor, $sales_person_detail, $product, $target;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        OrderManagement $order_management,
        DistributorsDealers $dealer_distributor,
        SalesPersonDetail $sales_person_detail,
        Product $product,
        Target $target
    ) {
        $this->middleware('auth');
        $this->order_management = $order_management;
        $this->dealer_distributor = $dealer_distributor;
        $this->sales_person_detail = $sales_person_detail;
        $this->product = $product;
        $this->target = $target;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['page_title'] = 'Super Admin Dashboard';
        return view('superadmin.dashboard', $data);
    }

    public function staff_index()
    {
        $data['page_title']         = 'Staff Dashboard';
        $data['total_distributor']  = $this->dealer_distributor->where('user_type', 1)->count();
        $data['total_dealer']       = $this->dealer_distributor->where('user_type', 2)->count();
        $data['total_sales_person'] = $this->sales_person_detail->whereNull('deleted_at')->count();
        $data['total_product']      = $this->product->where('status', 1)->count();
        $data['total_order']        = $this->order_management->count();
        $data['order_grand_total']  = $this->order_management->sum('grand_total');
        $data['latest_orders']      = $this->order_management->latest()->take(5)->get();
        $data['latest_dealers']     = $this->dealer_distributor->where('user_type', 2)->latest()->take(5)->get();
        $data['latest_distributor'] = $this->dealer_distributor->where('user_type', 1)->latest()->take(5)->get();
        return view('staff.dashboard', $data);
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
        $login_user = Auth::user()->id;
        $data['page_title']        = 'Sales Dashboard';
        $data['total_order']       = $this->order_management->where('salesman_id', $login_user)->count();
        $data['order_grand_total'] = $this->order_management->where('salesman_id', $login_user)->sum('grand_total');
        $data['latest_orders']     = $this->order_management->where('salesman_id', $login_user)->latest()->take(5)->get();
        $data['total_target']      = $this->target->where('salesman_id', $login_user)->count();
        $data['latest_target']     = $this->target->where('salesman_id', $login_user)->latest()->take(5)->get();

        $data['current_target']    = $this->target->with('target_grade')->where('salesman_id', $login_user)
            ->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->get(); 

        $cTargets = [];
        foreach ($data['current_target'] as $key => $target) { 
            $grades = [];
            foreach ($target->target_grade as $target_grade) { 
                $gradeId = $target_grade->grade_id;

                $totalAmount = OrderManagementProduct::whereHas('order', function ($q) use ($login_user,$target) {
                    $q->where('salesman_id', $login_user)
                    ->whereBetween('order_date', [$target->start_date, $target->end_date]);
                })  
                ->whereHas('product', function ($q) use ($gradeId) {
                    $q->where('grade_id', $gradeId); 
                })  
                ->sum('total'); // Replace with calculation if needed: ->selectRaw('SUM(price * quantity)') if not a single 'amount'
                $grades[] = [
                    'grade_id' => $target_grade->grade->name,
                    'percentage' => $totalAmount,
                    'percentage_value' => $target_grade->percentage_value,
                    'achieved_percentage' => round(($target_grade->percentage_value > 0 ? ($totalAmount / $target_grade->percentage_value) * 100 : 0), 2)
                   

                ];

            }
            $cTargets[] = [
                'target_id' => $target->subject,//$target->id,
                'grades'    => $grades,
                'start_date' => $target->start_date->format('d M Y'),
                'end_date'=> $target->end_date->format('d M Y')
            ];
        }
        $data['current_target_graph'] = $cTargets;
        // dd($data['current_target_graph']);

        // dd($cTargets);
        // $data['target_grade_graph']    = DB::table('grade_management')
        //     ->join('target_grades', 'grade_management.id', '=', 'target_grades.grade_id')
        //     ->join('targets', 'target_grades.target_id', '=', 'targets.id')
        //     ->where('targets.salesman_id', $loggedInSalesmanId)

        //     // Join products through order_management_products
        //     ->leftJoin('products', 'grade_management.id', '=', 'products.grade_id')
        //     ->leftJoin('order_management_products', 'products.id', '=', 'order_management_products.product_id')
        //     ->leftJoin('order_management', function ($join) {
        //         $join->on('order_management.id', '=', 'order_management_products.order_id');
        //     })
        //     ->where(function ($query) use ($loggedInSalesmanId) {
        //         $query->whereNull('order_management.salesman_id')
        //               ->orWhere('order_management.salesman_id', $loggedInSalesmanId);
        //     })
        //     ->select('grade_management.name as grade_name', 
        //              DB::raw('COALESCE(COUNT(DISTINCT order_management.id), 0) as order_count')) // Ensure 0 count for no orders
        //     ->groupBy('grade_management.id', 'grade_management.name')
        //     ->get();

        // Total order counts for each targeted grade
        // $results = DB::table('grade_management')
        // ->join('target_grades', 'grade_management.id', '=', 'target_grades.grade_id')
        // ->join('targets', 'target_grades.target_id', '=', 'targets.id')
        // ->where('targets.salesman_id', $salespersonId)
        // ->leftJoin('order_management_products', 'grade_management.id', '=', 'order_management_products.grade_id')
        // ->leftJoin('order_management', function ($join) {
        //     $join->on('order_management.id', '=', 'order_management_products.order_id');
        // })
        // ->where(function ($query) use ($salespersonId) {
        //     $query->whereNull('order_management.salesman_id')
        //           ->orWhere('order_management.salesman_id', $salespersonId);
        // })
        // ->select('grade_management.name as grade_name', DB::raw('COUNT(DISTINCT order_management.id) as order_count'))
        // ->groupBy('grade_management.id', 'grade_management.name')
        // ->get();
        // dd(  $results); 
        return view('sales.dashboard', $data);
    }

    public function my_profile(Request $request)
    {
        $user = Auth::user();
        // dd($user);
        if ($user->hasrole('admin') || $user->hasrole('staff')) {
            return redirect()->route('users.edit', $user->id);
        }
        if ($user->hasrole('sales')) {
            $sale_person_id = SalesPersonDetail::where('user_id', $user->id)->first()->id;
            return redirect()->route('sales_person.edit', $sale_person_id);
        }
    }
}
