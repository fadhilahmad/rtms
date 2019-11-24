<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Receipt;

class SaleController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function viewSale()
    {
        $y = date('Y');
        $m = date('m');
        
        $years = [];
        for ($year=2017; $year <= $y; $year++) $years[] = $year;
        //dd($years);
        
        $number = cal_days_in_month(CAL_GREGORIAN,$m , $y);
        
        for($x = 1; $x <= $number; $x++){
            $labelday[] = $x;                      
            $thisdate = $y . '-' . $m . '-' . $x;
            $summ = Receipt::select('total_paid')
                ->whereDate('created_at', $thisdate)
                ->sum('total_paid');
           
            if(is_null($summ)){
                $labelsale[] = 0;
            }else{
                $labelsale[] = $summ;
            }
        }
        //dd($labelsale);
        return view('admin/sale',compact('years','labelday','labelsale','m','y'));
    }
    
    public function showChart(Request $request)
    {        
        $data = $request->all();
        
        $y = date('Y');
        $m = date('m');
        
        $yy = $data['year'];
        $mm = $data['month'];
        
        $years = [];
        for ($year=2017; $year <= $y; $year++) $years[] = $year;
        //dd($years);
        
        $number = cal_days_in_month(CAL_GREGORIAN,$mm , $yy);
        
        for($x = 1; $x <= $number; $x++){
            $labelday[] = $x;                      
            $thisdate = $yy . '-' . $mm . '-' . $x;
            $summ = Receipt::select('total_paid')
                ->whereDate('created_at', $thisdate)
                ->sum('total_paid');
           
            if(is_null($summ)){
                $labelsale[] = 0;
            }else{
                $labelsale[] = $summ;
            }
        }
        
        $y = $data['year'];
        $m = $data['month'];
        
        //dd($labelsale);
        //return view('admin/sale',compact('years','labelday','labelsale','m','y'));
        //return response()->json($years,$labelday,$labelsale,$m,$y);
       // return response()->json(['success'=>'New price added']);
       return response()->json(['years'=>$years,'labelday'=> $labelday,'labelsale'=>$labelsale,'m'=>$m,'y'=>$y]);
    }
    
}
