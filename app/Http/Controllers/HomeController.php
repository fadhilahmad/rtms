<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $u_id = Auth::id();
        
        $orders =  DB::table('orders')
                    ->where('u_id_designer','=',$u_id)
                    ->where('o_status','=','0')
                    ->get();

        return view('department/department_orderlist',compact('orders'));
    }
    
    public function customerHome() 
    {
        return \View::make('customer/neworder');
    }
}
