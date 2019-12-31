<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use App\Unit;
use App\Invoice;
use App\Receipt;
use App\InvoicePermanent;
use App\SystemSetting;
use App\BankDetail;
use App\ContactNumber;
use App\Discount;
use App\AdditionalCharges;
use Illuminate\Support\Facades\Redirect;

class GeneralController extends Controller
{
    //
    public function ViewJobOrder($o_id) 
    {       
             $orders =  DB::table('orders')
                       ->join('material', 'orders.material_id', '=', 'material.m_id')
                       ->leftJoin('user', 'orders.u_id_customer', '=', 'user.u_id')
                       ->where('orders.o_id','=',$o_id)
                       ->first();
             
             $specs = DB::table('spec')
                     ->leftJoin('body', 'spec.b_id','=','body.b_id')
                     ->leftJoin('sleeve', 'spec.sl_id', '=', 'sleeve.sl_id')
                     ->leftJoin('neck', 'spec.n_id','=','neck.n_id')
                     ->where('spec.o_id','=',$o_id)
                     ->get();
             
             $pic =  DB::table('orders')
                       ->leftJoin('user', 'orders.u_id_designer', '=', 'user.u_id')
                       ->where('orders.o_id','=',$o_id)
                       ->first();
             
             $user = User::all();
             
             $units = Unit::all();
             
             $design = DB::table('design')
                       ->where('o_id','=',$o_id)
                       ->first();
             
             $designs = DB::table('design')
                       ->leftJoin('unit','design.o_id','=','unit.o_id')
                       ->where('design.o_id','=',$o_id)
                       ->get();
             
             $notes = DB::table('notes')
                     ->where('status','=','1')
                     ->where('active','=','1')
                     ->where('o_id','=',$o_id)
                     ->get();
            //dd($orders);
            return view('job_order',compact('orders','specs','pic','units','design','designs','notes')); 
    }
    
    public function ViewInvoice($o_id){
        
             $orders =  DB::table('orders')
                       ->where('o_id','=',$o_id)
                       ->first();
             
             $specs = DB::table('spec')
                     ->leftJoin('body', 'spec.b_id','=','body.b_id')
                     ->leftJoin('sleeve', 'spec.sl_id', '=', 'sleeve.sl_id')
                     ->leftJoin('neck', 'spec.n_id','=','neck.n_id')
                     ->where('spec.o_id','=',$o_id)
                     ->get();
             
             $user = DB::table('user')
                       ->leftJoin('orders', 'user.u_id', '=', 'orders.u_id_customer')
                       ->where('orders.o_id','=',$o_id)
                       ->first();
             
             $charges = DB::table('additional_charges')
                       ->where('o_id','=',$o_id)
                       ->get();
             
             $units = Unit::all();
             
             $invoice = Invoice::selectRaw('*')
                ->where('o_id','=',$o_id)
                ->first();
             
             $invoice_p = InvoicePermanent::all();
             
             $oid = $o_id;
             
             $settings = SystemSetting::first();
             
             $banks = BankDetail::all();
             
             $contacts = ContactNumber::all();
                                      
             $discounts = DB::table('discount')
                       ->where('o_id','=',$o_id)
                       ->get();
      
        return view('invoice',compact('orders','specs','user','units','invoice','invoice_p','charges','oid','settings','banks','contacts','discounts'));
    }
    
    public function ViewReceipt($id)
    {
        
            $receipts = DB::table('receipt')
                ->leftJoin('orders','receipt.o_id','=','orders.o_id')
                ->leftJoin('user','orders.u_id_customer','=','user.u_id')
                ->where('receipt.re_id','=',$id)
                ->first();
            
            $settings = SystemSetting::first();
             
             $banks = BankDetail::all();
             
             $contacts = ContactNumber::all();
             
             $invoice = Invoice::all();
            
            //dd($orders);
            return view('receipt',compact('receipts','settings','banks','contacts','invoice'));        
    }
    
    public function AlterPrice(Request $request)
    {
        $data = $request->all();
        
        if($data['operation'] == 'delete_charge')
        {
            //dapatkan charges, balance tolak charges, total_price tolak charges, update table orders dan invoice kemudian delete charges
            $oid = $data['oid'];
            $ac_id = $data['ac_id'];
            
            $order = DB::table('orders')
                    ->where('o_id',$oid)
                    ->first();
            
            $charge = DB::table('additional_charges')
                    ->where('ac_id',$ac_id)
                    ->first();
            
            $invoice = DB::table('invoice')
                    ->where('o_id',$oid)
                    ->first();

            $bal = $order->balance;
            $cas = $charge->charges;
            $inv = $invoice->total_price;
            
            $balance_order = $bal - $cas;
            $balance_invoice = $inv - $cas;
            
            DB::table('orders')
                        ->where('o_id', '=', $oid)
                        ->update(array('balance' => $balance_order,'updated_at'=>DB::raw('now()')));

            DB::table('invoice')
                        ->where('o_id', '=', $oid)
                        ->update(array('total_price' => $balance_invoice,'updated_at'=>DB::raw('now()')));
            
            $delete = AdditionalCharges::find($ac_id);
            $delete->delete();
            
            return Redirect::back()->with(['msg', 'Additional charge deleted']);
        }
        if($data['operation'] == 'add_discount')
        {
            $desc = $data['discount'];
            $amount = $data['amount'];
            $oid = $data['oid'];

            $order = DB::table('orders')
                    ->where('o_id',$oid)
                    ->first();
            
            $invoice = DB::table('invoice')
                    ->where('o_id',$oid)
                    ->first();

            $bal = $order->balance;
            $inv = $invoice->total_price;
            $balance_order = $bal - $amount;
            $balance_invoice = $inv - $amount;

            DB::table('discount')->insert([
                         'o_id' => $oid,
                         'dis_desc'=> $desc,
                         'dis_amount'=> $amount,
                         'created_at' => DB::raw('now()'),
                         'updated_at' => DB::raw('now()')
                        ]);

            DB::table('orders')
                        ->where('o_id', '=', $oid)
                        ->update(array('balance' => $balance_order,'updated_at'=>DB::raw('now()')));

            DB::table('invoice')
                        ->where('o_id', '=', $oid)
                        ->update(array('total_price' => $balance_invoice,'updated_at'=>DB::raw('now()')));
            
            return Redirect::back()->with(['msg', 'Discount added']);
            
        }
        if($data['operation'] == 'delete_discount')
        {
            $oid = $data['oid'];
            $dis_id = $data['dis_id'];
            
            $order = DB::table('orders')
                    ->where('o_id',$oid)
                    ->first();
            
            $discount = DB::table('discount')
                    ->where('dis_id',$dis_id)
                    ->first();
            
            $invoice = DB::table('invoice')
                    ->where('o_id',$oid)
                    ->first();

            $bal = $order->balance;
            $dis = $discount->dis_amount;
            $inv = $invoice->total_price;
            
            $balance_order = $bal + $dis;
            $balance_invoice = $inv + $dis;
            
            DB::table('orders')
                        ->where('o_id', '=', $oid)
                        ->update(array('balance' => $balance_order,'updated_at'=>DB::raw('now()')));

            DB::table('invoice')
                        ->where('o_id', '=', $oid)
                        ->update(array('total_price' => $balance_invoice,'updated_at'=>DB::raw('now()')));
            
            $delete = Discount::find($dis_id);
            $delete->delete();
            
            return Redirect::back()->with(['msg', 'Discount deleted']);
        }
    }
}
