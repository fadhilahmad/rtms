<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Receipt;

class DashboardController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('admin');
    }
        
    public function showDashboard()
    {
         
        $user = DB::table('user')
                    ->whereIn('u_type',['6','7','8','9'])
                    ->where('u_status','=',1)
                    ->count();
        
        $application = DB::table('user')
                    ->whereIn('u_type',['6','7','8','9'])
                    ->where('u_status','=',2)
                    ->count();
        
        $orders = DB::table('orders')
                ->where('active','=','1')
                    ->count('o_id');
        
        $deliver = DB::table('orders')
                    ->where('o_status','=',9)
                ->where('active','=','1')
                    ->count('o_id');
        
        $invoice = DB::table('invoice')
                    ->where('i_status','=',1)
                    ->count('i_id');
        
        $payment = DB::table('orders')
                    ->where('balance','=',0)
                ->where('active','=','1')
                    ->count('o_id');
        
        $income = DB::table('receipt')
                    ->where('re_status','=',1)
                    ->sum('total_paid');
        
        $income2 = DB::table('orders')
                ->where('active','=','1')
                    ->sum('balance');
        
        $income3 = DB::table('invoice')
                    ->where('i_status','=',1)
                    ->sum('total_price');
        
        $completed = DB::table('orders')
                    ->where('balance','=',0)
                ->where('active','=','1')
                    ->count();
        
        $pending = DB::table('orders')
                    ->leftJoin('invoice','orders.o_id','=','invoice.o_id')
                    ->whereColumn([['orders.balance', '=', 'invoice.total_price']])
                ->where('orders.active','=','1')
                    ->count();
        
        $deposited = DB::table('orders')
                    ->leftJoin('invoice','orders.o_id','=','invoice.o_id')
                    ->whereColumn([['orders.balance', '!=', 'invoice.total_price']])
                    ->where('orders.balance','!=',0)
                ->where('orders.active','=','1')
                    ->count();
        
        
        if($orders==0){
            $com = 0;
            $pen = 0;
            $depo = 0;
        } else {          
            $com = intval($completed/$orders*100);
            $pen = intval($pending/$orders*100);
            $depo = intval($deposited/$orders*100);
        }
        
//        $com = intval($completed/$orders*100);
//        $pen = intval($pending/$orders*100);
//        $depo = intval($deposited/$orders*100);
        
        $total_unit = DB::table('orders')
                ->where('active','=','1')
                    ->sum('quantity_total');
        
        $design = DB::table('orders')
                    ->whereNotIn('o_status', [0, 1, 2])
                ->where('active','=','1')
                    ->sum('quantity_total');
        
        $print = DB::table('orders')
                    ->whereNotIn('o_status', [0, 1, 2,3,4])
                ->where('active','=','1')
                    ->sum('quantity_total');
        
        $tailor = DB::table('orders')
                    ->whereIn('o_status', [ 7, 9, 10])
                ->where('active','=','1')
                    ->sum('quantity_total');
        
        if($total_unit==0){
            $design_p = 0;
            $dp = 0;

            $print_p = 0;
            $pp = 0;

            $tailor_p = 0;
            $tp = 0;
        }else{
            $design_p = round($design/$total_unit*100, 1);
            $dp = intval($design/$total_unit*100);

            $print_p = round($print/$total_unit*100, 1);
            $pp = intval($print/$total_unit*100);

            $tailor_p = round($tailor/$total_unit*100, 1);
            $tp = intval($tailor/$total_unit*100);  
        }
        
//        $design_p = round($design/$total_unit*100, 1);
//        $dp = intval($design/$total_unit*100);
//        
//        $print_p = round($print/$total_unit*100, 1);
//        $pp = intval($print/$total_unit*100);
//        
//        $tailor_p = round($tailor/$total_unit*100, 1);
//        $tp = intval($tailor/$total_unit*100);
        
        $today = date('d');
        $month = date('m');
        $year = date('Y');
        
        $last7 = $today - 7;
        
        for($x = $last7; $x <= $today; $x++){
            $labelday[] = $last7;                      
            $thisdate = $year . '-' . $month . '-' . $last7;
            $summ = Receipt::select('total_paid')
                ->whereDate('created_at', $thisdate)
                ->sum('total_paid');
        
            if(is_null($summ)){
                $labelsale[] = 0;
            }else{
               // dd($summ);
                $labelsale[] = $summ;
            }
            $last7++;
        }
        
        $reprint = DB::table('reprint')
                    ->sum('r_quantity');
        
        $reprint_rate = intval($reprint/$total_unit);
          //dd($labelsale);       
        return view('admin/dashboard',compact('user','application','orders','invoice','payment','income','income2','income3','deliver','com',
                'pen','depo','total_unit','design','design_p','print','print_p','tailor','tailor_p','dp','pp','tp','labelday','month','labelsale','reprint_rate'));
    }
    
    public function filterDashboard(Request $request)
    {
        $data = $request->all();
        
        $start = $data['start'];
        $end = $data['end'];
        
        $user = DB::table('user')
                    ->whereIn('u_type',['6','7','8','9'])
                    ->where('u_status','=',1)
                    ->whereBetween('created_at', array($start, $end))
                    ->count();
        
        $application = DB::table('user')
                    ->whereIn('u_type',['6','7','8','9'])
                    ->where('u_status','=',2)
                ->whereBetween('created_at', array($start, $end))
                    ->count();
        
        $orders = DB::table('orders')
                ->where('active','=','1')
                ->whereBetween('created_at', array($start, $end))
                    ->count('o_id');
        
        $deliver = DB::table('orders')
                    ->where('o_status','=',9)
                ->where('active','=','1')
                ->whereBetween('created_at', array($start, $end))
                    ->count('o_id');
        
        $invoice = DB::table('invoice')
                    ->where('i_status','=',1)
                ->whereBetween('created_at', array($start, $end))
                    ->count('i_id');
        
        $payment = DB::table('orders')
                    ->where('balance','=',0)
                ->where('active','=','1')
                ->whereBetween('created_at', array($start, $end))
                    ->count('o_id');
        
        $income = DB::table('receipt')
                    ->where('re_status','=',1)
                ->whereBetween('created_at', array($start, $end))
                    ->sum('total_paid');
        
        $income2 = DB::table('orders')
                ->where('active','=','1')
                ->whereBetween('created_at', array($start, $end))
                    ->sum('balance');
        
        $income3 = DB::table('invoice')
                    ->where('i_status','=',1)
                ->whereBetween('created_at', array($start, $end))
                    ->sum('total_price');
        
        $completed = DB::table('orders')
                    ->where('balance','=',0)
                ->where('active','=','1')
                ->whereBetween('created_at', array($start, $end))
                    ->count();
        
        $pending = DB::table('orders')
                    ->leftJoin('invoice','orders.o_id','=','invoice.o_id')
                    ->whereColumn([['orders.balance', '=', 'invoice.total_price']])
                ->where('orders.active','=','1')
                ->whereBetween('orders.created_at', array($start, $end))
                    ->count();
        
        $deposited = DB::table('orders')
                    ->leftJoin('invoice','orders.o_id','=','invoice.o_id')
                    ->whereColumn([['orders.balance', '!=', 'invoice.total_price']])
                    ->where('orders.balance','!=',0)
                ->where('orders.active','=','1')
                ->whereBetween('orders.created_at', array($start, $end))
                    ->count();
        
        
        if($orders==0){
            $com = 0;
            $pen = 0;
            $depo = 0;
        } else {          
            $com = intval($completed/$orders*100);
            $pen = intval($pending/$orders*100);
            $depo = intval($deposited/$orders*100);
        }
        
        $total_unit = DB::table('orders')
                ->where('active','=','1')
                ->whereBetween('created_at', array($start, $end))
                    ->sum('quantity_total');
        
        $design = DB::table('orders')
                    ->whereNotIn('o_status', [0, 1, 2])
                ->where('active','=','1')
                ->whereBetween('created_at', array($start, $end))
                    ->sum('quantity_total');
        
        $print = DB::table('orders')
                    ->whereNotIn('o_status', [0, 1, 2,3,4])
                ->where('active','=','1')
                ->whereBetween('created_at', array($start, $end))
                    ->sum('quantity_total');
        
        $tailor = DB::table('orders')
                    ->whereIn('o_status', [ 7, 9, 10])
                ->where('active','=','1')
                ->whereBetween('created_at', array($start, $end))
                    ->sum('quantity_total');
        
        if($total_unit==0){
            $design_p = 0;
            $dp = 0;

            $print_p = 0;
            $pp = 0;

            $tailor_p = 0;
            $tp = 0;
        }else{
            $design_p = round($design/$total_unit*100, 1);
            $dp = intval($design/$total_unit*100);

            $print_p = round($print/$total_unit*100, 1);
            $pp = intval($print/$total_unit*100);

            $tailor_p = round($tailor/$total_unit*100, 1);
            $tp = intval($tailor/$total_unit*100);  
        }
        
        $today = date('d');
        $month = date('m');
        $year = date('Y');
        
        $last7 = $today - 7;
        
        for($x = $last7; $x <= $today; $x++){
            $labelday[] = $last7;                      
            $thisdate = $year . '-' . $month . '-' . $last7;
            $summ = Receipt::select('total_paid')
                ->whereDate('created_at', $thisdate)
                ->sum('total_paid');
        
            if(is_null($summ)){
                $labelsale[] = 0;
            }else{
               // dd($summ);
                $labelsale[] = $summ;
            }
            $last7++;
        }
        
        $reprint = DB::table('reprint')
                ->whereBetween('created_at', array($start, $end))
                    ->sum('r_quantity');
             
        if($total_unit==0){
            $reprint_rate = 0;
        }else{
            $reprint_rate = intval($reprint/$total_unit);  
        }
          //dd($labelsale);       
        return view('admin/dashboard',compact('user','application','orders','invoice','payment','income','income2','income3','deliver','com',
                'pen','depo','total_unit','design','design_p','print','print_p','tailor','tailor_p','dp','pp','tp','labelday','month','labelsale','reprint_rate','start','end'));
        
    }
}
