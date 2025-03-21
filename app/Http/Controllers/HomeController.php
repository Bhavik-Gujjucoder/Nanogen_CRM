<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('admin.dashboard',$data);
    }
    public function sales_index()
    {
        $data['page_title'] = 'Sales Dashboard';
        return view('sales.dashboard',$data);
    }
}
