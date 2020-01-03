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
        $ye = date('Y')+1;
        $m = date('m');
        $y = date('Y');
        
        $years = [];
        for ($year=2017; $year <= $ye; $year++) $years[] = $year;
        
        $user = User::all();
//        $invoice = Invoice::all();
        $receipt = Receipt::all();
        
        $orders = DB::table('orders')
                ->join('invoice','orders.o_id','=','invoice.o_id')
                ->leftJoin('user','orders.u_id_customer','=','user.u_id')
                ->where('orders.active','=','1')
                ->where('orders.balance','<>','0')
                ->paginate(30);
        
        
        return view('admin/payment',compact('user','receipt','orders','m','y','years'));
    }
    
    public function PendingFilter(Request $request)
    {
        $data = $request->all();
       
        $m = $data['month'];
        $y = $data['years'];
        
        $ye = date('Y')+1;
        
        $years = [];
        for ($year=2017; $year <= $ye; $year++) { $years[] = $year ;}
        
        $user = User::all();
//        $invoice = Invoice::all();
        $receipt = Receipt::all();
        
        $orders = DB::table('orders')
                ->join('invoice','orders.o_id','=','invoice.o_id')
                ->leftJoin('user','orders.u_id_customer','=','user.u_id')
                ->where('orders.balance','<>','0')
                ->where('orders.active','=','1')
                ->whereMonth('orders.delivery_date','=',$m)
                ->whereYear('orders.delivery_date','=',$y)
                ->paginate(30);
        
        
        return view('admin/payment',compact('user','receipt','orders','m','y','years'));
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
        $y = date('Y');
        $m = date('m');
        
        $years = [];
        for ($year=2017; $year <= $y; $year++) $years[] = $year;
        
        $receipts = DB::table('receipt')
                ->leftJoin('orders','receipt.o_id','=','orders.o_id')
                ->leftJoin('user','orders.u_id_customer','=','user.u_id')
                ->where('orders.active','=','1')
                ->where('receipt.re_status','=','1')
                ->orderBy('receipt.created_at', 'asc')
                ->paginate(30);
        
        $invoice = Invoice::all();
        $user = User::all();
        
        return view('admin/receipt_list',compact('receipts','user','years','m','y','invoice'));
    }
    
    public function filterReceiptList(Request $request)
    {
        $data = $request->all();
        
        $m = $data['month'];
        $y = $data['years'];
        
        $ye = date('Y');
        
        $years = [];
        for ($year=2017; $year <= $ye; $year++) { $years[] = $year ;}
        
        $receipts = DB::table('receipt')
                ->leftJoin('orders','receipt.o_id','=','orders.o_id')
                ->leftJoin('user','orders.u_id_customer','=','user.u_id')
                ->where('orders.active','=','1')
                ->where('receipt.re_status','=','1')
                ->whereMonth('receipt.created_at', $m)
                ->whereYear('receipt.created_at', $y)
                ->orderBy('receipt.created_at', 'asc')
                ->paginate(30);
        
        $user = User::all();
        $invoice = Invoice::all();
        
        return view('admin/receipt_list',compact('receipts','user','years','m','y','invoice'));
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
    
    public function addCharges(Request $request)
    {
        $data = $request->all();
        
        $desc = $data['desc'];
        $price = $data['price'];
        $oid = $data['oid'];
        
        $order = DB::table('orders')
                ->where('o_id',$oid)
                ->first();
        
        $invoice = DB::table('invoice')
                    ->where('o_id',$oid)
                    ->first();
        
        $bal = $order->balance;
        $inv = $invoice->total_price;
        $balance_order = $bal + $price;
        $balance_invoice = $inv + $price;
        
        DB::table('additional_charges')->insert([
                     'o_id' => $oid,
                     'ac_desc'=> $desc,
                     'charges'=> $price,
                     'created_at' => DB::raw('now()'),
                     'updated_at' => DB::raw('now()')
                    ]);
        
        DB::table('orders')
                    ->where('o_id', '=', $oid)
                    ->update(array('balance' => $balance_order,'updated_at'=>DB::raw('now()')));
        
        DB::table('invoice')
                    ->where('o_id', '=', $oid)
                    ->update(array('total_price' => $balance_invoice,'updated_at'=>DB::raw('now()')));
        
       // dd($data);
        return response()->json(['success'=>'ok']);
    }
}
