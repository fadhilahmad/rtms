<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;

class PriceCheckingController extends Controller
{
    //
    public function BaseOnBodyId(Request $request) 
    {
          $data = $request->all();
          
          $sl_info =  DB::table('price')
                       ->join('sleeve', 'price.sl_id', '=', 'sleeve.sl_id')
                       ->where('price.b_id','=',$data['bid'])
                       ->get();
          
               foreach ($sl_info as $sl){
                   $slid[]=$sl->sl_id;
                   $sldesc[]=$sl->sl_desc;
               }
          
         return response()->json(['slid'=>$slid,'sldesc'=>$sldesc]);
          //return response()->json(['slid'=>'ss']);
    }   
}
