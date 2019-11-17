<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\User;
use App\Invoice;
use App\Receipt;
use DB;

class PaymentController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function viewPendingPayment()
    {
        
        $user = User::all();
//        $invoice = Invoice::all();
        $receipt = Receipt::all();
        
        $orders = DB::table('orders')
                ->join('invoice','orders.o_id','=','invoice.o_id')
                ->leftJoin('user','orders.u_id_customer','=','user.u_id')
                ->paginate(30);
        
        
        return view('admin/payment',compact('user','invoice','receipt','orders'));
    }
}
