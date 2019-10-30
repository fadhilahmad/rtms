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
        return view('home');
    }
    
    public function adminHome()
    {
        return \View::make('admin/manage_customer');
    }
    
    public function departmentHome() 
    {
        return \View::make('department/department_orderlist');
    }
    
    public function customerHome() 
    {
        return \View::make('customer/neworder');
    }
}
