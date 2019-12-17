<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Material;
use App\Body;
use App\Sleeve;
use App\Neck;

class OrderController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('customer');
    }
    
    public function OrderForm() {
        $month = date('m');
        $day = date('d');
        $year = date('Y');
        $today = $year . '-' . $month . '-' . $day; //get today date
                
        $materials = Material::where('m_status', 1)->get();
        $bodies = Body::where('b_status', 1)->get();
        $sleeves = Sleeve::where('sl_status', 1)->get();
        $necks = Neck::where('n_status', 1)->get();
        
        return view('customer/addorder',compact('materials','bodies','sleeves','necks'))->with('today',$today);
    }
}
