<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Receipt;
use DateTime;
use DateInterval;
use DatePeriod;

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
                    ->leftJoin('orders','orders.o_id','=','invoice.o_id')
                    ->where('orders.active','=','1')
                    ->where('invoice.i_status','=',1)
                    ->count('invoice.i_id');
        
        $payment = DB::table('orders')
                    ->where('balance','=',0)
                    ->where('active','=','1')
                    ->count('o_id');
        
        $income = DB::table('receipt')
                    ->leftJoin('orders','orders.o_id','=','receipt.o_id')
                    ->where('orders.active','=','1')
                    ->where('receipt.re_status','=',1)
                    ->sum('receipt.total_paid');
        
        $income2 = DB::table('orders')
                    ->where('active','=','1')
                    ->sum('balance');
        
        $income3 = DB::table('invoice')
                    ->leftJoin('orders','orders.o_id','=','invoice.o_id')
                    ->where('orders.active','=','1')
                    ->where('invoice.i_status','=',1)
                    ->sum('invoice.total_price');
        
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
        $month = (int)date('m');
        $year = date('Y');
                
        $number = cal_days_in_month(CAL_GREGORIAN,$month , $year);
        
        for($x = 1; $x <= $number; $x++){
            $labelday[] = $x;                      
            $thisdate = $year . '-' . $month . '-' . $x;
//            $summ = Receipt::select('total_paid')
//                ->whereDate('created_at', $thisdate)
//                ->sum('total_paid');
            
            $summ = DB::table('receipt')
                        ->leftJoin('orders','orders.o_id','=','receipt.o_id')
                        ->where('orders.active','=','1')
                        ->where('receipt.re_status','=','1')
                        ->whereDate('orders.created_at', $thisdate)
                        ->sum('receipt.total_paid');
           
            if(is_null($summ)){
                $labelsale[] = 0;
            }else{
                $labelsale[] = $summ;
            }
        }
//          $last7 = $today - 7;
//        for($x = $last7; $x <= $today; $x++){
//            $labelday[] = $last7;                      
//            $thisdate = $year . '-' . $month . '-' . $last7;
//            $summ = Receipt::select('total_paid')
//                ->whereDate('created_at', $thisdate)
//                ->sum('total_paid');
//        
//            if(is_null($summ)){
//                $labelsale[] = 0;
//            }else{
//               // dd($summ);
//                $labelsale[] = $summ;
//            }
//            $last7++;
//        }
        
        $reprint = DB::table('reprint')
                    ->leftJoin('orders','orders.o_id','=','reprint.o_id')
                    ->where('orders.active','=','1')
                    ->sum('reprint.r_quantity');
        
        if($total_unit==0){
            $reprint_rate = 0;
        }else{
            $reprint_rate = intval($reprint/$total_unit*100);  
        }
        
        return view('admin/dashboard',compact('user','application','orders','invoice','payment','income','income2','income3','deliver','com',
                'pen','depo','total_unit','design','design_p','print','print_p','tailor','tailor_p','dp','pp','tp','labelday','month','labelsale','reprint_rate'));
    }
    
    public function filterDashboard(Request $request)
    {
        $data = $request->all();
        
        $start = $data['start'];
        $end = $data['end'];
        
        $ends = new DateTime( $end );
        $ends = $ends->modify('+1 day');
        
        $user = DB::table('user')
                    ->whereIn('u_type',['6','7','8','9'])
                    ->where('u_status','=',1)
                    ->whereBetween('created_at', array($start, $ends))
                    ->count();
        
        $application = DB::table('user')
                    ->whereIn('u_type',['6','7','8','9'])
                    ->where('u_status','=',2)
                    ->whereBetween('created_at', array($start, $ends))
                    ->count();
        
        $orders = DB::table('orders')
                    ->where('active','=','1')
                    ->whereBetween('created_at', array($start, $ends))
                    ->count('o_id');
        
        $deliver = DB::table('orders')
                    ->where('o_status','=',9)
                    ->where('active','=','1')
                    ->whereBetween('created_at', array($start, $ends))
                    ->count('o_id');
        
        $invoice = DB::table('invoice')
                    ->leftJoin('orders','orders.o_id','=','invoice.o_id')
                    ->where('orders.active','=','1')
                    ->where('invoice.i_status','=',1)
                    ->whereBetween('orders.created_at', array($start, $ends))
                    ->count('invoice.i_id');
        
        $payment = DB::table('orders')
                    ->where('balance','=',0)
                    ->where('active','=','1')
                    ->whereBetween('created_at', array($start, $ends))
                    ->count('o_id');
        
        $income = DB::table('receipt')
                    ->leftJoin('orders','orders.o_id','=','receipt.o_id')
                    ->where('orders.active','=','1')
                    ->where('receipt.re_status','=',1)
                    ->whereBetween('orders.created_at', array($start, $ends))
                    ->sum('receipt.total_paid');
        
        $income2 = DB::table('orders')
                    ->where('active','=','1')
                    ->whereBetween('created_at', array($start, $ends))
                    ->sum('balance');
        
        $income3 = DB::table('invoice')
                    ->leftJoin('orders','orders.o_id','=','invoice.o_id')
                    ->where('orders.active','=','1')
                    ->where('invoice.i_status','=',1)
                    ->whereBetween('orders.created_at', array($start, $ends))
                    ->sum('invoice.total_price');
        
        $completed = DB::table('orders')
                    ->where('balance','=',0)
                    ->where('active','=','1')
                    ->whereBetween('created_at', array($start, $ends))
                    ->count();
        
        $pending = DB::table('orders')
                    ->leftJoin('invoice','orders.o_id','=','invoice.o_id')
                    ->whereColumn([['orders.balance', '=', 'invoice.total_price']])
                    ->where('orders.active','=','1')
                    ->whereBetween('orders.created_at', array($start, $ends))
                    ->count();
        
        $deposited = DB::table('orders')
                    ->leftJoin('invoice','orders.o_id','=','invoice.o_id')
                    ->whereColumn([['orders.balance', '!=', 'invoice.total_price']])
                    ->where('orders.balance','!=',0)
                    ->where('orders.active','=','1')
                    ->whereBetween('orders.created_at', array($start, $ends))
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
                    ->whereBetween('created_at', array($start, $ends))
                    ->sum('quantity_total');
        
        $design = DB::table('orders')
                    ->whereNotIn('o_status', [0, 1, 2])
                    ->where('active','=','1')
                    ->whereBetween('created_at', array($start, $ends))
                    ->sum('quantity_total');
        
        $print = DB::table('orders')
                    ->whereNotIn('o_status', [0, 1, 2,3,4])
                    ->where('active','=','1')
                    ->whereBetween('created_at', array($start, $ends))
                    ->sum('quantity_total');
        
        $tailor = DB::table('orders')
                    ->whereIn('o_status', [ 7, 9, 10])
                    ->where('active','=','1')
                    ->whereBetween('created_at', array($start, $ends))
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
        
        $begin = new DateTime( $start );
        
        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval ,$ends);
        //dd($daterange);
        foreach($daterange as $range)
        {
            $labelday[] = (int)$range->format('d');
//            $summ = Receipt::select('total_paid')
//                ->whereDate('created_at', $range->format('Y-m-d'))
//                ->sum('total_paid');
            $summ = DB::table('receipt')
                        ->leftJoin('orders','orders.o_id','=','receipt.o_id')
                        ->where('orders.active','=','1')
                        ->where('receipt.re_status','=','1')
                        ->whereDate('orders.created_at', $range->format('Y-m-d'))
                        ->sum('receipt.total_paid');
            
            if(is_null($summ)){
                $labelsale[] = 0;
            }else{
               // dd($summ);
                $labelsale[] = $summ;
            }
        }
//        dd($labelday,$labelsale);
//        $today = date('d');
        $month = (int)date('m');
//        $year = date('Y');
//        
//        $last7 = $today - 7;
//        
//        for($x = $last7; $x <= $today; $x++){
//            $labelday[] = $last7;                      
//            $thisdate = $year . '-' . $month . '-' . $last7;
//            $summ = Receipt::select('total_paid')
//                ->whereDate('created_at', $thisdate)
//                ->sum('total_paid');
//        
//            if(is_null($summ)){
//                $labelsale[] = 0;
//            }else{
//               // dd($summ);
//                $labelsale[] = $summ;
//            }
//            $last7++;
//        }
        
        $reprint = DB::table('reprint')
                    ->leftJoin('orders','orders.o_id','=','reprint.o_id')
                    ->where('orders.active','=','1')
                    ->whereBetween('orders.created_at', array($start, $ends))
                    ->sum('reprint.r_quantity');
             
        if($total_unit==0){
            $reprint_rate = 0;
        }else{
            $reprint_rate = intval($reprint/$total_unit*100);  
        }
          //dd($labelsale);       
        return view('admin/dashboard',compact('user','application','orders','invoice','payment','income','income2','income3','deliver','com',
                'pen','depo','total_unit','design','design_p','print','print_p','tailor','tailor_p','dp','pp','tp','labelday','month','labelsale','reprint_rate','start','end'));
        
    }
 }
