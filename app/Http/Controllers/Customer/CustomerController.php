<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('customer');
    }
    
    public function customerProfile() 
    {
        return view('customer/customer_profile');
    }
    
    public function customerOrderlist() 
    {
        return view('customer/customer_orderlist');
    }
    
    public function invoice() 
    {
        return view('customer/invoice');
    }
    
    public function receipt() 
    {
        return view('customer/receipt');
    }
}
