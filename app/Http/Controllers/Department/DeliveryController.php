<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use DB;
use App\Unit;

class DeliveryController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('department');
    }
    
    public function deliveryList()
    {
        $u_id = Auth::user()->u_id;
        
        $orders =  DB::table('orders')
                       ->join('material', 'orders.material_id', '=', 'material.m_id')
                       ->join('user','orders.u_id_customer','=','user.u_id')
                        ->where('orders.o_status','=','7')
                        ->where('orders.u_id_taylor','=',$u_id)
                        ->orderBy('delivery_date', 'asc')
                        ->get();
        
        return view('department/delivery_list',compact('orders'));
    }
    
    public function updateDelivery($o_id)
    {
       
       $orders =  DB::table('orders')
                       ->join('material', 'orders.material_id', '=', 'material.m_id')
                        ->where('orders.o_id','=',$o_id)
                        ->get();
             
       $specs = DB::table('spec')
                     ->leftJoin('body', 'spec.b_id','=','body.b_id')
                     ->leftJoin('sleeve', 'spec.sl_id', '=', 'sleeve.sl_id')
                     ->leftJoin('neck', 'spec.n_id','=','neck.n_id')
                     ->where('spec.o_id','=',$o_id)
                     ->get();
             
       $units = Unit::all();
             
       //dd($orders);
       return view('department/job_delivery',compact('orders','specs','units'));  
    }
    
    public function completeDelivery(Request $request) {
        
        $data = $request->all();
        
        if($data['process']=="deliver")
        {

           DB::table('unit')
                 ->where('un_id', '=', $data['un_id'])
                 ->update(array(                   
                     'un_status'=>'4',
                     'updated_at'=>DB::raw('now()')));
           
          return back()->with('success','Order updated');           
        }          
        if($data['process']=="complete")
        {
           DB::table('orders')
                 ->where('o_id', '=', $data['o_id'])
                 ->update(array('o_status'=>'9','updated_at' => DB::raw('now()')));
           
           return Redirect::route('department.delivery');           
        }  
    }
}
