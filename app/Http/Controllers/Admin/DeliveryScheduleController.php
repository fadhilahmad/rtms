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
        $orders = DB::table('orders')
                    ->where('o_status','<>',9)
                    ->get();
        
        $total = DB::table('orders')
                    ->selectRaw('*, sum(quantity_total) as sum')
                    ->where('o_status','<>',9)
                    ->groupBy('delivery_date')
//                    ->sum('quantity_total');
                    ->get();
        
       // dd($total);
        
        return view('admin/delivery_schedule',compact('orders','total'));
    }
}
