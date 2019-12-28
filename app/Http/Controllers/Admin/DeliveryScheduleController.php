<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class DeliveryScheduleController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function viewSchedule()
    {
        $today = date("Y-m-d");
        
        $orders = DB::table('orders')
                    ->where('o_status','<>',9)
                    ->where('active','=',1)
                    ->whereDate('delivery_date','>=',$today)
                    ->get();
        
        $total = DB::table('orders')
                    ->selectRaw('*, sum(quantity_total) as sum')
                    ->where('o_status','<>',9)
                    ->where('active','=',1)
                    ->whereDate('delivery_date','>=',$today)
                    ->groupBy('delivery_date')
//                    ->sum('quantity_total');
                    ->get();
        
       // dd($total);
        $lates = DB::table('orders')
                    ->where('o_status','<>',9)
                    ->where('active','=',1)
                    ->whereDate('delivery_date','<',$today)
                    ->get();
        
        $tot_lates = DB::table('orders')
                    ->selectRaw('*, sum(quantity_total) as sum')
                    ->where('o_status','<>',9)
                    ->where('active','=',1)
                    ->whereDate('delivery_date','<',$today)
                    ->groupBy('delivery_date')
//                    ->sum('quantity_total');
                    ->get();
        
        return view('admin/delivery_schedule',compact('orders','total','lates','tot_lates'));
    }
}
