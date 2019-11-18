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
                ->where('orders.balance','<>','0')
                ->paginate(30);
        
        
        return view('admin/payment',compact('user','invoice','receipt','orders'));
    }
    
    public function UpdatePayment(Request $request) 
    {
        $data = $request->all();
        //dd($data);
        
        $balance = $data['balance'] - $data['payment'];
        
        DB::table('orders')
                    ->where('o_id', '=', $data['oid'])
                    ->update(array('balance' => $balance,'updated_at'=>DB::raw('now()')));
        
        DB::table('receipt')->insert([
                     'o_id' => $data['oid'],
                     'description'=> $data['description'],
                     'total_paid'=> $data['payment'],
                     're_status'=> '1',
                     'created_at' => DB::raw('now()'),
                     'updated_at' => DB::raw('now()')
                    ]);
        
        return response()->json(['success'=>'Payment Updated']);
    }
    
    public function ReceiptList()
    {
        $receipts = DB::table('receipt')
                ->leftJoin('orders','receipt.o_id','=','orders.o_id')
                ->leftJoin('user','orders.u_id_customer','=','user.u_id')
                ->where('receipt.re_status','=','1')
                ->paginate(30);
        
        $user = User::all();
        
        return view('admin/receipt_list',compact('receipts','user'));
    }
    
    public function receiptInfo($id)
    {
        
            $receipts = DB::table('receipt')
                ->leftJoin('orders','receipt.o_id','=','orders.o_id')
                ->leftJoin('user','orders.u_id_customer','=','user.u_id')
                ->where('receipt.re_id','=',$id)
                ->first();
            
            //dd($orders);
            return view('admin/receipt_info',compact('receipts'));        
    }
}
