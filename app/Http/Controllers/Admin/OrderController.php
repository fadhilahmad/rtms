<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Price;
use App\Design;
use App\Unit;
use App\User;
use App\Invoice;

class OrderController extends Controller
{
    //
    public function updateOrderSetting(Request $request){
        
        $data = $request->all();
        
        if($data['type']=="add")
        {
            if($data['table']=="material")
            {
                DB::table('material')->insert([
                     'm_desc' => $data['description'],
                     'm_status'=>'1',
                     'm_stock'=>'0',
                     'created_at' => DB::raw('now()'),
                     'updated_at' => DB::raw('now()')
                    ]);
                return redirect('admin/order_setting')->with('message', 'New material added');
            }
            elseif($data['table']=="body")
            {
                DB::table('body')->insert([
                     'b_desc' => $data['description'],
                     'b_status'=>'1',
                     'created_at' => DB::raw('now()'),
                     'updated_at' => DB::raw('now()')
                    ]);
                return redirect('admin/order_setting')->with('message', 'New body type added');                
            }
            elseif($data['table']=="neck")
            {
                
                $validator=request()->validate([
                        'image_neck' => 'image|mimes:jpeg,png,jpg|max:2048',
                        ]);   

                if ($request->has('neck_image')) {

                    $image = $request->file('neck_image');                    
                    $destinationPath = 'uploads/'; // upload path
                    $profileImage = 'necktype'.date('YmdHis') . "." . $image->getClientOriginalExtension();
                    $image->move($destinationPath, $profileImage);
                    $url = $destinationPath.$profileImage;
               
                    DB::table('neck')->insert([
                        'n_desc' => $data['description'],
                        'n_status'=>'1',
                        'n_url' =>$profileImage,
                        'created_at' => DB::raw('now()'),
                        'updated_at' => DB::raw('now()')
                            ]);
                    return redirect('admin/order_setting')->with('message', 'New neck type added'); 
                } else {
                    return redirect('admin/order_setting')->with('error', 'Error!!!!Please insert image');
                }
            }
            else
            {
                return redirect('admin/order_setting')->with('message', 'Error to add');
            }
                        
        }
        
        if($data['type']=="update")
        {
            if($data['table']=="material")
            {
                DB::table('material')
                    ->where('m_id', '=', $data['id'])
                    ->update(array('m_desc' => $data['description']));
                
                return redirect('admin/order_setting')->with('message', 'Material updated');
            }
            elseif($data['table']=="body")
            {
                DB::table('body')
                    ->where('b_id', '=', $data['id'])
                    ->update(array('b_desc' => $data['description']));
                
                return redirect('admin/order_setting')->with('message', 'Body type updated');
            }
            elseif($data['table']=="neck")
            {
                DB::table('neck')
                    ->where('n_id', '=', $data['id'])
                    ->update(array('n_desc' => $data['description']));
                
                return redirect('admin/order_setting')->with('message', 'Neck type updated');
            }
            elseif($data['table']=="sleeve")
            {
                DB::table('sleeve')
                    ->where('sl_id', '=', $data['id'])
                    ->update(array('sl_desc' => $data['description']));
                
                return redirect('admin/order_setting')->with('message', 'Sleeve type updated');
            }
            elseif($data['table']=="delivery")
            {
                DB::table('delivery_setting')
                    ->where('ds_id', '=', $data['id'])
                    ->update(array('min_day' => $data['description']));
                
                return redirect('admin/order_setting')->with('message', 'Delivery day updated');
            }
            else
            {
                return redirect('admin/order_setting')->with('message', 'Update Error');
            }
        }
        
        if($data['type']=="delete")
        {
            if($data['table']=="material")
            {
                DB::table('material')
                    ->where('m_id', '=', $data['id'])
                    ->update(array('m_status' => '0'));
                
                return redirect('admin/order_setting')->with('message', 'Material deleted');
            }
            elseif($data['table']=="body")
            {
                DB::table('body')
                    ->where('b_id', '=', $data['id'])
                    ->update(array('b_status' => '0'));
                
                return redirect('admin/order_setting')->with('message', 'Body type deleted');
            }
            elseif($data['table']=="neck")
            {
                DB::table('neck')
                    ->where('n_id', '=', $data['id'])
                    ->update(array('n_status' => '0'));
                
                return redirect('admin/order_setting')->with('message', 'Neck type deleted');
            }
            else
            {
                return redirect('admin/order_setting')->with('message', 'Delete Error');
            }            
        }
        
        return redirect('admin/order_setting')->with('message', 'Error');
    }
    
    public static function getPrice($sl_id,$b_id,$n_id,$c_type,$name){
        
        $price = Price::selectRaw('*')
                ->where('b_id','=',$b_id)
                ->where('sl_id','=',$sl_id)
                ->where('n_id','=',$n_id)
                ->where('u_type','=',$c_type)
                ->first();

        $display = $price['price'];
        $id = $price['p_id'];
        
        if($display==NULL){
            $display='<a href="" class="addPrice" data-toggle="modal" data-target="#priceModal" data-tittle="Add Price" '
                    . 'data-slid="'.$sl_id.'" data-bid="'.$b_id.'" data-nid="'.$n_id.'" data-utype="'.$c_type.'" data-name="'.$name.'" data-process="insert">+</a>';
        }else{
            $display=$display.'  <a href="" class="editPrice" data-toggle="modal" data-target="#priceModal" data-tittle="Edit Price" '
                    . 'data-price="'.$display.'" data-name="'.$name.'" data-process="update" data-pid="'.$id.'">+</a>';            
        }
        return $display;
    }
    
    public function editPrice(Request $request){
        
        $data = $request->all();
        
        if($data['process']=="insert"){
            
                DB::table('price')->insert([
                     'b_id' => $data['b_id'],
                     'sl_id'=> $data['sl_id'],
                     'n_id'=> $data['n_id'],
                     'u_type'=> $data['u_type'],
                     'price'=> $data['price'],
                     'created_at' => DB::raw('now()'),
                     'updated_at' => DB::raw('now()')
                    ]);
                return redirect('admin/pricing')->with('message', 'New price added');
        }
        if($data['process']=="update"){
            
                DB::table('price')
                    ->where('p_id', '=', $data['p_id'])
                    ->update(array('price' => $data['price'],'updated_at'=>DB::raw('now()')));
                
                return redirect('admin/pricing')->with('message', 'Price updated');
        }
        
        return redirect('admin/pricing')->with('message', 'error');
    }
    
    public function updateStock(Request $request){
        
        $data = $request->all();
        
        if($data['operator']=='add'){
            $newstock = $data['oldvalue']+$data['value'];
            
                DB::table('material')
                    ->where('m_id', '=', $data['m_id'])
                    ->update(array('m_stock' => $newstock,'updated_at'=>DB::raw('now()')));
                
                return redirect('admin/stock_list')->with('message', 'Stock updated');           
            
        }
        if($data['operator']=='minus'){
            $newstock = $data['oldvalue']-$data['value'];
            
                DB::table('material')
                    ->where('m_id', '=', $data['m_id'])
                    ->update(array('m_stock' => $newstock,'updated_at'=>DB::raw('now()')));
                
                return redirect('admin/stock_list')->with('message', 'Stock updated');           
            
        }
        
    }
    
    public function orderInfo($o_id){
        
             $orders =  DB::table('orders')
                       ->join('material', 'orders.material_id', '=', 'material.m_id')
                       ->where('orders.o_id','=',$o_id)
                       ->get();
             
             $specs = DB::table('spec')
                     ->leftJoin('body', 'spec.b_id','=','body.b_id')
                     ->leftJoin('sleeve', 'spec.sl_id', '=', 'sleeve.sl_id')
                     ->leftJoin('neck', 'spec.n_id','=','neck.n_id')
                     ->where('spec.o_id','=',$o_id)
                     ->get();
             
             $user = User::all();
             
             $units = Unit::all();
             
             $design = Design::all();
            //dd($orders);
            return view('admin/order_info',compact('orders','specs','units','design','user')); 
    }
    
    public function invoiceInfo($o_id){
        
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
             
             $units = Unit::all();
             
             $invoice = Invoice::selectRaw('*')
                ->where('o_id','=',$o_id)
                ->first();
             
             $price = Price::all();
            // dd($specs);
//             $design = Design::all();       
        
        
        return view('admin/invoice_info',compact('orders','specs','user','units','invoice','price'));
    }
}                
