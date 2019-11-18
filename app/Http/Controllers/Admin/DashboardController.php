<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('admin');
    }
        
    public function showDashboard()
    {
        $end_user = DB::table('user')
                    ->where('u_type','=',7)
                    ->where('u_status','=',1)
                    ->count();
        
        $agent = DB::table('user')
                    ->whereIn('u_type',['6','8','9'])
                    ->where('u_status','=',1)
                    ->count();
        
        $application = DB::table('user')
                    ->whereIn('u_type',['6','7','8','9'])
                    ->where('u_status','=',2)
                    ->count();
        
        $orders = DB::table('orders')
                    ->count('o_id');
        
        $invoice = DB::table('invoice')
                    ->where('i_status','=',1)
                    ->count('i_id');
        
        $payment = DB::table('orders')
                    ->where('balance','=',0)
                    ->count('o_id');
        
        $income = DB::table('receipt')
                    ->where('re_status','=',1)
                    ->sum('total_paid');
        
        return view('admin/dashboard',compact('end_user','agent','application','orders','invoice','payment','income'));
    }
}
