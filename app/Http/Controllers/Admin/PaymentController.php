<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function viewPendingPayment()
    {
        
        return view('admin/payment');
    }
}
