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
        
        return view('admin/delivery_schedule',compact('orders'));
    }
}
