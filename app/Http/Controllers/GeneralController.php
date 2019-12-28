<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use App\Unit;
use App\Invoice;
use App\Receipt;
use App\InvoicePermanent;

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
      
        return view('invoice',compact('orders','specs','user','units','invoice','invoice_p','charges'));
    }
    
    public function ViewReceipt($id)
    {
        
            $receipts = DB::table('receipt')
                ->leftJoin('orders','receipt.o_id','=','orders.o_id')
                ->leftJoin('user','orders.u_id_customer','=','user.u_id')
                ->where('receipt.re_id','=',$id)
                ->first();
            
            //dd($orders);
            return view('receipt',compact('receipts'));        
    }
}
