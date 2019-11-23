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
        $u_id = Auth::user()->u_id;
        
        $department = Auth::user()->u_type;
        
        if($department==3)
        {      
            $orders =  DB::table('orders')
                        ->join('material', 'orders.material_id', '=', 'material.m_id')
                        ->where('orders.u_id_designer','=',$u_id)
                        ->whereIn('orders.o_status', [0,10])
                        ->orderBy('delivery_date', 'asc')
                        ->get();
           // dd($orders);            

            return view('department/department_orderlist',compact('orders'))->with('department',$department);
        }
        elseif($department==5)
        {
            $orders =  DB::table('orders')
                       ->join('material', 'orders.material_id', '=', 'material.m_id')
                        ->where('orders.o_status','=','3')
                        ->orderBy('delivery_date', 'asc')
                        ->get();
            //dd($orders);
            return view('department/department_orderlist',compact('orders'))->with('department',$department);          
        }
        elseif($department==4)
        {
            $orders =  DB::table('orders')
                       ->join('material', 'orders.material_id', '=', 'material.m_id')
                        ->where('orders.o_status','=','5')
                        ->orderBy('delivery_date', 'asc')
                        ->get();
            //dd($orders);
            return view('department/department_orderlist',compact('orders'))->with('department',$department);             
        }
    }
    
    public function customerHome() 
    {
        return \View::make('customer/neworder');
    }
    
    public static function getMockup($o_id){
        
       $design =  DB::table('design')
                        ->where('o_id','=',$o_id)
                        ->where('d_type','=',1)
                        ->get();
       
       foreach ($design as $mock)
       {
           $url = $mock->d_url;
           $show = '<img class="" src="{{url("orders/mockup/'.$url.')}}" width="200" height="200">';
       }
 
       return $url;
    }
}
