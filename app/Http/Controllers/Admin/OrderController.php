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
use App\InvoicePermanent;
use App\BlockDay;
use App\Order;
use App\Material;
use App\Body;
use App\Sleeve;
use App\Neck;
use App\Spec;

class OrderController extends Controller
{
    //
    public function updateOrderSetting(Request $request){
        
        $data = $request->all();
       // dd($data);
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
                        'n_type' => $data['necktype'],
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
            elseif($data['table']=="block_date")
            {
                DB::table('block_date')->insert([
                     'date' => $data['date'],
                     'remark'=>$data['remark'],
                     'bdt_status'=>'1',
                     'created_at' => DB::raw('now()'),
                     'updated_at' => DB::raw('now()')
                    ]);
                return redirect('admin/order_setting')->with('message', 'New block date added');                
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
                    ->update(array('n_desc' => $data['description'],'n_type' => $data['necktype']));
                
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
            elseif($data['table']=="block_day")
            {
                DB::table('block_day')
                    ->where('bd_id', '=', $data['id'])
                    ->update(array('bd_status' => $data['status']));
                
                return redirect('admin/order_setting')->with('message', 'Block day updated');
            }
            elseif($data['table']=="block_date")
            {
                DB::table('block_date')
                    ->where('bdt_id', '=', $data['id'])
                    ->update(array('date' => $data['date'],'remark'=>$data['remark']));
                
                return redirect('admin/order_setting')->with('message', 'Block date updated');
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
            elseif($data['table']=="block_date")
            {
                DB::table('block_date')
                    ->where('bdt_id', '=', $data['id'])
                    ->update(array('bdt_status' => '0'));
                
                return redirect('admin/order_setting')->with('message', 'Block date deleted');
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
                ->where('n_type','=',$n_id)
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
                     'n_type'=> $data['n_id'],
                     'u_type'=> $data['u_type'],
                     'price'=> $data['price'],
                     'created_at' => DB::raw('now()'),
                     'updated_at' => DB::raw('now()')
                    ]);
                //return redirect()->back()->with('message', 'New price added');
                //return redirect('admin/pricing')->with('message', 'New price added');
                return response()->json(['success'=>'New price added']);
        }
        if($data['process']=="update"){
            
                DB::table('price')
                    ->where('p_id', '=', $data['p_id'])
                    ->update(array('price' => $data['price'],'updated_at'=>DB::raw('now()')));
                
                //return redirect('admin/pricing')->with('message', 'Price updated');
                //return redirect()->back()->with('message', 'Price updated');
                return response()->json(['success'=>'Price updated']);
        }
        
        //return redirect('admin/pricing')->with('message', 'error');
        //return redirect()->back()->with('message', 'Error');
        return response()->json(['success'=>'Error']);
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
        if($data['operator']=='newinventory'){
            
                DB::table('stock')->insert([
                        'item' => $data['item'],
                        'st_quantity' => $data['quantity'],
                        'st_status'=>'1',
                        'created_at' => DB::raw('now()'),
                        'updated_at' => DB::raw('now()')
                            ]);
                
                return redirect('admin/stock_list')->with('imessage', 'New inventory added');           
            
        }
        if($data['operator']=='plusinventory'){
            
                $newstock = $data['oldvalue']+$data['value'];
            
                DB::table('stock')
                    ->where('st_id', '=', $data['st_id'])
                    ->update(array('st_quantity' => $newstock,'updated_at'=>DB::raw('now()')));
                
                return redirect('admin/stock_list')->with('imessage', 'Inventry stock updated');          
            
        }
        if($data['operator']=='minusinventory'){
            
                $newstock = $data['oldvalue']-$data['value'];
            
                DB::table('stock')
                    ->where('st_id', '=', $data['st_id'])
                    ->update(array('st_quantity' => $newstock,'updated_at'=>DB::raw('now()')));
                
                return redirect('admin/stock_list')->with('imessage', 'Inventry stock updated');          
            
        }
        if($data['operator']=='deleteinventory'){
            
                DB::table('stock')
                    ->where('st_id', '=', $data['st_id'])
                    ->update(array('st_status' => '0','updated_at'=>DB::raw('now()')));
                
                return redirect('admin/stock_list')->with('imessage', 'Inventry deleted');          
            
        }
        
    }
    
    public function orderInfo($o_id){
        
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
            return view('admin/job_order',compact('orders','specs','pic','units','design','designs','notes')); 
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
             
             $charges = DB::table('additional_charges')
                       ->where('o_id','=',$o_id)
                       ->get();
             
             $units = Unit::all();
             
             $invoice = Invoice::selectRaw('*')
                ->where('o_id','=',$o_id)
                ->first();
             
             $invoice_p = InvoicePermanent::all();
             
            // dd($specs);          
        
        
        return view('admin/invoice_info',compact('orders','specs','user','units','invoice','invoice_p','charges'));
    }

    public function deleteOrder(Request $request) 
    {
        $data = $request->all();
        
        DB::table('orders')
                    ->where('o_id', '=', $data['o_id'])
                    ->update(array('active' => '0','updated_at'=>DB::raw('now()')));
        
        return redirect('admin/order_list')->with('message','Order deleted');
    }

    public function addneworder(Request $request) 
    {
        
        // ------------------ insert data into table order ---------------------------------- //
        $clothname = $request->input('cloth_name');
        // $category = $request->input('category');
        $material = $request->input('material');
        $totalquantity = $request->input('total_quantity');
        $note = $request->input('note');
        $refnum = null; // currently auto assign
        $deliverydate = $request->input('somedate');
        $deliverytype = $request->input('dealtype');
        $orderstatus = 2; // set to drafted
        $custid = $request->input('usertype');
        $customername = auth()->user()->username;
        $active = 1;
        $designerid = $request->input('designer'); 
        $printid = null;
        $taylorid = null; 

        $customerid = User::where('u_id', $custid)->pluck('u_type')->first();

        $usertypename;
        if($customerid == '6'){
            $usertypename = 'Agent Tier One';
        }else if($customerid == '7'){
            $usertypename = 'End User';
        }else if($customerid == '8'){
            $usertypename = 'Agent Tier Two';
        }else{
            $usertypename = 'Agent Tier Three';
        }

        $filenameWithExt;
        $originalname;
        $filename;
        $image;                 
        $destinationPath; 
        $profileImage;

        // // assign order design to designer
        // $userdesigner = User::where('u_type', 3)->where('u_status', 1)->pluck('u_id')->toArray();   // get all designer id
        // $hasorder = Order::all()->toArray();    // check if order existed
        // if($hasorder == 0){ // if no order
        //     $designerid = $userdesigner[0]; // assign first index of designer id to the first order
        // }else{
        //     $orderiddesigner = Order::all()->pluck('u_id_designer')->toArray(); // get array of designer id from order table 
        //     $totaldesigner = count($userdesigner);  // total designer
        //     $totalorder = count($orderiddesigner);  // total order
        //     if($totalorder >= $totaldesigner){  // check if total order is more than designer
        //         $remainderindex = $totalorder % $totaldesigner; // get the remainder of the order
        //         $nextorderdesignerid = $userdesigner[$remainderindex];  // get next designer id
        //         $designerid = $nextorderdesignerid; // assign to variable
        //     }else{
        //         $lastiddesignerindex = count($orderiddesigner)-1;   // last designer id index
        //         $nextorderdesignerid = $userdesigner[$lastiddesignerindex + 1]; // get next designer id
        //         $designerid = $nextorderdesignerid; // assign to variable
        //     }
        // }
        $order = new Order;
        $order->file_name = $clothname;
        //$order->category = "will del";
        $order->material_id = $material;
        $order->quantity_total = $totalquantity;
        $order->note = $note;
        $order->ref_num = $refnum;
        $order->delivery_type = $deliverytype;
        $order->delivery_date = $deliverydate;
        $order->o_status = $orderstatus;
        $order->u_id_customer = $custid;
        $order->u_id_designer = $designerid;
        $order->u_id_print = $printid;
        $order->u_id_taylor = $taylorid;
        $order->active = $active;
        $order->save();
        // ------------------ insert data into table spec ---------------------------------- //
        
        $orderid = $order->o_id;
        $neckid; 
        $bodyid;
        $sleeveid;
        $collarcolor;
        if(number_format($request->input('setamount')) == 0){
            $totalset = 1;
        }else{
            // total number of set
            $totalset = number_format($request->input('setamount'));
        }
        $num = 0;
        for($i = 0; $i < $totalset; $i++){


            $spec = new Spec;
            $spec->n_id = $request->input('necktype'.$i);
            $bodyid = $request->input('type'.$i);
            $sleeveid = $request->input('sleeve'.$i);
            $collarcolor = $request->input('collar_color'.$i);
            $category = $request->input('category'.$i);
            $spec->o_id = $orderid;
            $spec->b_id = $bodyid;
            $spec->sl_id = $sleeveid;
            $spec->collar_color = $collarcolor;
            $spec->category = $category;
            $spec->save();
            // ------------------ insert data into table unit and design ---------------------------------- //
            $idspec = DB::getPdo()->lastInsertId();
            $name; // if user choose nameset, assign name. Else assign null
            $size;
            $unitquantity;
            $unitstatus = 0; // assign 0, (uncomplete)
            if($category == "Nameset"){
                // case nameset
                // get total row nameset
                if(number_format($request->input('namesetnum'.$i)) == 0){
                    $namesetnum = 1;
                }else{
                    // total number of row nameset
                    $namesetnum = number_format($request->input('namesetnum'.$i));
                }
                for($j = 0; $j < $namesetnum; $j++){
                    $unit = new Unit;
                    $name = $request->input('name'.$i.'-'.$j);
                    $size = $request->input('size'.$i.'-'.$j);
                    // $unitquantity = $request->input('quantitysinglenamesetname'.$i.'-'.$j);
                    $unitquantity = 1; // one quantity per unit
                    $unit->o_id = $orderid;
                    $unit->s_id = $idspec; 
                    $unit->name = $name; 
                    $unit->size = $size; 
                    $unit->un_quantity = $unitquantity;
                    $unit->u_id_designer = $designerid;
                    $unit->u_id_print = $printid;
                    $unit->u_id_taylor = $taylorid;
                    $unit->un_status = $unitstatus;
                    $unit->save();
                    if($request->hasFile('cover_image')){
                        // get the file name with the extension
                        $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
                        $originalname = $request->file('cover_image')->getClientOriginalName();
                        // get just file name
                        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                        $image = $request->file('cover_image');                    
                        $destinationPath = 'orders/mockup/'; 
                        $profileImage = $customername.'-mockup-'.$filename.'-'.date('YmdHis') . "." . $image->getClientOriginalExtension();
                        $url = $destinationPath.$profileImage;
                        $mockupdesign = $profileImage;
                    }else{
                        $mockupdesign = 'noimage.jpg';
                    }
                }
                $idunit = null;
            }else{
                // case size
                $xxs = $request->input('quantitysinglexxs'.$i);
                $xs = $request->input('quantitysinglexs'.$i);
                $s = $request->input('quantitysingles'.$i);
                $m = $request->input('quantitysinglem'.$i);
                $l = $request->input('quantitysinglel'.$i);
                $xl = $request->input('quantitysinglexl'.$i);
                $xl2 = $request->input('quantitysingle2xl'.$i);
                $xl3 = $request->input('quantitysingle3xl'.$i);
                $xl4 = $request->input('quantitysingle4xl'.$i);
                $xl5 = $request->input('quantitysingle5xl'.$i);
                $xl6 = $request->input('quantitysingle6xl'.$i);
                $xl7 = $request->input('quantitysingle7xl'.$i);
                if($request->hasFile('cover_image')){
                    $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
                    $originalname = $request->file('cover_image')->getClientOriginalName();
                    // get just file name
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $image = $request->file('cover_image');                    
                    $destinationPath = 'orders/mockup/'; 
                    $profileImage = $customername.'-mockup-'.$filename.'-'.date('YmdHis') . "." . $image->getClientOriginalExtension();
                    $url = $destinationPath.$profileImage;
                    $mockupdesign = $profileImage;
                }else{
                    $mockupdesign = 'noimage.jpg';
                }
                if($xxs != 0){
                    $name = null;
                    $size = "XXS";
                    $unitquantity = $xxs; 
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $designerid, $printid, $taylorid, $unitstatus); 
                }
                if($xs != 0){
                    $name = null;
                    $size = "XS";
                    $unitquantity = $xs; 
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $designerid, $printid, $taylorid, $unitstatus); 
                }
                if($s != 0){
                    $name = null;
                    $size = "S";
                    $unitquantity = $s; 
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $designerid, $printid, $taylorid, $unitstatus); 
                }
                if($m != 0){
                    $name = null;
                    $size = "M";
                    $unitquantity = $m; 
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $designerid, $printid, $taylorid, $unitstatus); 
                }
                if($l != 0){
                    $name = null;
                    $size = "L";
                    $unitquantity = $l; 
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $designerid, $printid, $taylorid, $unitstatus); 
                }
                if($xl != 0){
                    $name = null;
                    $size = "XL";
                    $unitquantity = $xl; 
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $designerid, $printid, $taylorid, $unitstatus); 
                }
                if($xl2 != 0){
                    $name = null;
                    $size = "2XL";
                    $unitquantity = $xl2; 
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $designerid, $printid, $taylorid, $unitstatus); 
                }
                if($xl3 != 0){
                    $name = null;
                    $size = "3XL";
                    $unitquantity = $xl3; 
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $designerid, $printid, $taylorid, $unitstatus); 
                }
                if($xl4 != 0){
                    $name = null;
                    $size = "4XL";
                    $unitquantity = $xl4; 
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $designerid, $printid, $taylorid, $unitstatus); 
                }
                if($xl5 != 0){
                    $name = null;
                    $size = "5XL";
                    $unitquantity = $xl5; 
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $designerid, $printid, $taylorid, $unitstatus); 
                }
                if($xl6 != 0){
                    $name = null;
                    $size = "6XL";
                    $unitquantity = $xl6;
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $designerid, $printid, $taylorid, $unitstatus); 
                }
                if($xl7 != 0){
                    $name = null;
                    $size = "7XL";
                    $unitquantity = $xl7;
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $designerid, $printid, $taylorid, $unitstatus); 
                }
                $idunit = null;
            }
        }
        $boolprice = $this->requestConfirm($orderid, $customerid);
        if($boolprice != false){
            $this->storeDesign($idunit, $mockupdesign, $orderid, $designerid, $image, $destinationPath, $profileImage); 
            return redirect('/admin/order_list')->with('message', 'Order Submitted');
        }else{
            $errbodydesc = Body::where('b_id', $this->errbody)
                ->pluck('b_desc')->toArray();
            $errsleevedesc = Sleeve::where('sl_id', $this->errsleeve)
                ->pluck('sl_desc')->toArray();
            return redirect('/admin/neworder')->with('message', 'Error! Price for set "'.$errbodydesc[0].'" and "'.$errsleevedesc[0].'", for customer type "'.$usertypename.'" that you\'ve selected is not placed yet. Please enter price in "Pricing" page to have this order.');
        }

    }

    // function to store data to table unit
    public function storeUnit($orderid, $idspec, $name, $size, $unitquantity, $designerid, $printid, $taylorid, $unitstatus){
        $unit = new Unit; 
        $unit->o_id = $orderid;
        $unit->s_id = $idspec;
        $unit->name = $name; 
        $unit->size = $size; 
        $unit->un_quantity = $unitquantity;
        $unit->u_id_designer = $designerid;
        $unit->u_id_print = $printid;
        $unit->u_id_taylor = $taylorid;
        $unit->un_status = $unitstatus; 
        $unit->save(); 
        $idunit = $unit->un_id;
        return $idunit;
    } 

    // function to store data to table design
    public function storeDesign($unitid, $mockupdesign, $orderid, $designerid, $image, $destinationPath, $profileImage){
        $image->move($destinationPath, $profileImage);
        $designtype = 1; // set to 1 (mockup) 
        $design = new Design;
        $design->o_id = $orderid;
        $design->un_id = $unitid; 
        $design->u_id_designer = $designerid; 
        $design->d_url = $mockupdesign; 
        $design->d_type = $designtype;
        $design->save();
    } 
    public function requestConfirm($orderid, $usertype){
        $orderidrequest = $orderid;
        $boolprice = true;
        if($orderidrequest != null){
            //-------------------- confirm design   ----------------------//
            $user_id = auth()->user()->u_id;
            $thisyear = date("Y");
            $recordedyear = Order::select('ref_num')
                ->whereYear('created_at', $thisyear)
                ->first();
            if($recordedyear == null){
                $newrefnum = date("y")."/".sprintf('%04d', 1); 
                DB::table('orders')
                    ->where('o_id', '=', $orderidrequest)
                    ->update(array('ref_num' => $newrefnum,
                    'o_status'=>'2'));
            }else{
                $userrefnum = Order::where('ref_num', '!=' , null)->whereYear('created_at', $thisyear)->pluck('ref_num')->toArray();
                $totalrefnum = count($userrefnum);
                $newrefnum = date("y")."/".sprintf('%04d', ($totalrefnum + 1)); 
                // update ref num in table order
                DB::table('orders')
                    ->where('o_id', '=', $orderidrequest)
                    ->update(array('ref_num' => $newrefnum,
                    'o_status'=>'2'));
            }
            $orderid = $orderidrequest;
            $neckid = Spec::where('o_id', '=' , $orderidrequest)->pluck('n_id')->toArray();
            $bodyid = Spec::where('o_id', '=' , $orderidrequest)->pluck('b_id')->toArray();
            $sleeveid = Spec::where('o_id', '=' , $orderidrequest)->pluck('sl_id')->toArray();
            $specid = Spec::where('o_id', '=' , $orderidrequest)->pluck('s_id')->toArray();
            //$usertype = auth()->user()->u_type;
            $category;
            $size;
            $price;
            $totprice = 0;
            $totorderrow = count($neckid);
            for($i = 0; $i < $totorderrow; $i++){
                $necktype = Neck::find($neckid[$i]);
                $price = Price::where('n_type', '=', $necktype->n_type)
                    ->where('b_id', '=' , $bodyid[$i])
                    ->where('sl_id', '=' , $sleeveid[$i])
                    ->where('u_type', '=' , $usertype)->pluck('price');
                if($price->isNotEmpty() == false){
                    $boolprice = false;
                    //var_dump("empty");
                    //var_dump("Price for chosen set body id: ".$bodyid[$i].", neck type: ".$necktype->n_type.", sleeve id: ".$sleeveid[$i]." not set by admin");
                    $this->errbody = $bodyid[$i];
                    $this->errsleeve = $sleeveid[$i];
                    $this->errneck = $necktype->n_type;
                    Order::where('o_id', '=', $orderidrequest)->delete();
                    InvoicePermanent::where('o_id', '=', $orderidrequest)->delete();
                    break;
                }
                $category = Spec::where('s_id', '=', $specid[$i])->pluck('category');
                $size = Unit::where('o_id', '=', $orderidrequest)->pluck('size');
                $totsize = count($size);
                $specs = Unit::where('s_id', '=', $specid[$i])->pluck('s_id');
                $totunits = count($specs);
                $specprice = 0;
                $specquantity = 0;
                $oneunitprice = 0;
                for($j = 0; $j < $totunits; $j++){
                    $size = Unit::where('o_id', '=', $orderidrequest)
                    ->where('s_id', '=', $specid[$i])
                    ->pluck('size');
                    $quantity = Unit::where('o_id', '=', $orderidrequest)
                    ->where('s_id', '=', $specid[$i])
                    ->pluck('un_quantity');
                    $totsize = count($size);
                    $specquantity += $quantity[$j];
                    $pricecalc = $this->calcPrice($price, $category, $size[$j], $quantity[$j]);
                    $priceperunit = $this->calcPricePerUnit($price, $category, $size[$j]); 
                    $specprice += $pricecalc;
                    $totprice += $pricecalc;
                }
                if($boolprice == true){
                    $oneunitprice += intval($price[0]);
                    $invoicePermanent = new InvoicePermanent;
                    $invoicePermanent->s_id = $specid[$i];
                    $invoicePermanent->o_id = $orderidrequest;
                    $invoicePermanent->spec_total_price = $specprice;
                    $invoicePermanent->one_unit_price = $oneunitprice;
                    $invoicePermanent->spec_total_quantity = $specquantity;
                    $invoicePermanent->save();
                }
            }
            if($boolprice == true){
                $invoice = new Invoice;
                $invoice->o_id = $orderid;
                $invoice->i_status = 1;
                $invoice->total_price = $totprice; 
                $invoice->save();
            }
            DB::table('orders')
                ->where('o_id', '=', $orderid)
                ->update(array('balance' => $totprice));
            return $boolprice;
        }
    }
    // method to calculate total price with quantity
    public function calcPrice($price, $category, $size, $quantity){
        $pricecalc = 0;
        if($category[0] == "Nameset"){
            $priceint = intval($price[0]);
            $quantityint = intval($quantity);
            $pricecalc = $priceint + 4;
            $pricecalc *= $quantityint;
            if($size == "4XL" || $size == "5XL"){
                $pricecalc += 4;
            }else if($size == "6XL" || $size == "7XL"){
                $pricecalc += 8;
            }
        }else{
            $pricecalc = intval($price[0]);
            $quantityint = intval($quantity);
            $pricecalc *= $quantityint;
            if($size == "4XL" || $size == "5XL"){
                $priceint = intval($price[0]);
                $quantityint = intval($quantity);
                $pricecalc = $priceint + 4;
                $pricecalc *= $quantityint;
            }else if($size == "6XL" || $size == "7XL"){
                $priceint = intval($price[0]);
                $quantityint = intval($quantity);
                $pricecalc = $priceint + 8;
                $pricecalc *= $quantityint;
            }else{
                $pricecalc = intval($price[0]);
                $quantityint = intval($quantity);
                $pricecalc *= $quantityint;
            }
        }
        return $pricecalc;
    }
    // method to calculate total price without quantity
    public function calcPricePerUnit($price, $category, $size){
        $pricecalc = 0;
        if($category[0] == "Nameset"){
            $priceint = intval($price[0]);
            $pricecalc = $priceint + 4;
            if($size == "4XL" || $size == "5XL"){
                $pricecalc += 4;
            }else if($size == "6XL" || $size == "7XL"){
                $pricecalc += 8;
            }
        }else{
            $pricecalc = intval($price[0]);
            if($size == "4XL" || $size == "5XL"){
                $priceint = intval($price[0]);
                $pricecalc = $priceint + 4;
            }else if($size == "6XL" || $size == "7XL"){
                $priceint = intval($price[0]);
                $pricecalc = $priceint + 8;
            }else{
                $pricecalc = intval($price[0]);
            }
        }
        return $pricecalc;
    }

    // ----------------------------------------------------- update -------------------------------------------------//

    public function updateorder(Request $request) 
    {
        
        $orderid = $request->input('custorderid');
        $designerid = $request->input('designer'); 
        $updatedate = $request->input('current_date'); 
        $totalquantity = $request->input('total_quantity');
        $clothname = $request->input('cloth_name');
        $deliverydate = $request->input('somedate');
        $material = $request->input('material');
        $deliverytype = $request->input('dealtype');
        $note = $request->input('note');
        $currentmockupdesign = $request->input('namemockupimg');
        $refnum = null; 
        $orderstatus = 2; // set to drafted 
        // $customerid = $request->input('usertype');
        $customername = $request->input('custuname');
        $active = 1;
        $printid = null;
        $taylorid = null; 

        $custid = $request->input('usertype');
        $customerid = User::where('u_id', $custid)->pluck('u_type')->first();
        
        $usertypename;
        if($customerid == '6'){
            $usertypename = 'Agent Tier One';
        }else if($customerid == '7'){
            $usertypename = 'End User';
        }else if($customerid == '8'){
            $usertypename = 'Agent Tier Two';
        }else{
            $usertypename = 'Agent Tier Three';
        }

        $filenameWithExt;
        $originalname;
        $filename;
        $image;                 
        $destinationPath; 
        $profileImage;

        DB::table('orders')
            ->where('o_id', '=', $orderid)
            ->update(array('file_name' => $clothname, 'material_id' => $material, 'quantity_total' => $totalquantity, 'note' => $note,
            'delivery_type' => $deliverytype, 'delivery_date' => $deliverydate, 'u_id_designer' => $designerid));

        // ------------------ insert data into table spec ---------------------------------- //
        
        if(number_format($request->input('setamount')) == 0){
            $totalset = 1;
        }else{
            $totalset = number_format($request->input('setamount'));
        }
        $num = 0;

        $arrset = [];
        for($i = 0; $i < $totalset; $i++){

            $specid = $request->input('specid'.$i);
            $neckid = $request->input('necktype'.$i); 
            $bodyid = $request->input('type'.$i);
            $sleeveid = $request->input('sleeve'.$i);
            $collarcolor = $request->input('collar_color'.$i);
            $category = $request->input('category'.$i);

            if($specid == 'newset'){
                $lastsetid = DB::table('spec')->insertGetId(array('o_id' => $orderid, 'n_id' => $neckid, 'b_id' => $bodyid, 'sl_id' => $sleeveid,
                    'collar_color' => $collarcolor, 'category' => $category));
                array_push($arrset, $lastsetid);
                $specid = $lastsetid;
            }else{
                DB::table('spec')
                    ->where('s_id', '=', $specid)
                    ->update(array('n_id' => $neckid, 'b_id' => $bodyid, 'sl_id' => $sleeveid, 'collar_color' => $collarcolor,
                    'category' => $category));
                array_push($arrset, $specid);
            }
            
            // ------------------ insert data into table unit and design ---------------------------------- //
            $idspec = $specid;
            $name; // if user choose nameset, assign name. Else assign null
            $size;
            $unitquantity;
            $unitstatus = 0; // assign 0, (uncomplete)
            if($category == "Nameset"){
                if(number_format($request->input('namesetnum'.$i)) == 0){
                    $namesetnum = 1;
                }else{
                    $namesetnum = number_format($request->input('namesetnum'.$i));
                }

                $arrns = [];
                for($j = 0; $j < $namesetnum; $j++){

                    $unitidns = $request->input('unitidns'.$i.'-'.$j);
                    $name = $request->input('name'.$i.'-'.$j);
                    $size = $request->input('size'.$i.'-'.$j);
                    $unitquantity = 1; // one quantity per unit

                    if($unitidns == 'newns'){
                        $lastid = DB::table('unit')->insertGetId(array('o_id' => $orderid, 's_id' => $idspec, 'name' => $name, 'size' => $size,
                            'un_quantity' => $unitquantity, 'u_id_designer' => $designerid, 'un_status' => $unitstatus));
                        array_push($arrns, $lastid);
                    }else{
                        DB::table('unit')
                            ->where('un_id', '=', $unitidns)
                            ->update(array('name' => $name, 'size' => $size, 'un_quantity' => $unitquantity, 'u_id_designer' => $designerid));
                        array_push($arrns, $unitidns);
                    }
                    if($request->hasFile('cover_image')){
                        // get the file name with the extension
                        $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
                        $originalname = $request->file('cover_image')->getClientOriginalName();
                        // get just file name
                        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                        $image = $request->file('cover_image');                    
                        $destinationPath = 'orders/mockup/'; 
                        $profileImage = $customername.'-mockup-'.$filename.'-'.date('YmdHis') . "." . $image->getClientOriginalExtension();
                        $url = $destinationPath.$profileImage;
                        $mockupdesign = $profileImage;
                    }else{
                        $image = null;                    
                        $destinationPath = null; 
                        $profileImage = null;
                        $mockupdesign = $currentmockupdesign;
                    }
                }
                Unit::where('s_id', $idspec)->whereNotIn('un_id', $arrns)->delete();
                $idunit = null;
            }else{

                global $arrsz;
                $arrsz = array();

                // case size
                $xxs = $request->input('quantitysinglexxs'.$i);
                $xs = $request->input('quantitysinglexs'.$i);
                $s = $request->input('quantitysingles'.$i);
                $m = $request->input('quantitysinglem'.$i);
                $l = $request->input('quantitysinglel'.$i);
                $xl = $request->input('quantitysinglexl'.$i);
                $xl2 = $request->input('quantitysingle2xl'.$i);
                $xl3 = $request->input('quantitysingle3xl'.$i);
                $xl4 = $request->input('quantitysingle4xl'.$i);
                $xl5 = $request->input('quantitysingle5xl'.$i);
                $xl6 = $request->input('quantitysingle6xl'.$i);
                $xl7 = $request->input('quantitysingle7xl'.$i);

                
                if($request->hasFile('cover_image')){
                    $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
                    $originalname = $request->file('cover_image')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $image = $request->file('cover_image');                    
                    $destinationPath = 'orders/mockup/'; 
                    $profileImage = $customername.'-mockup-'.$filename.'-'.date('YmdHis') . "." . $image->getClientOriginalExtension();
                    $url = $destinationPath.$profileImage;
                    $mockupdesign = $profileImage;
                }else{
                    $image = null;                    
                    $destinationPath = null; 
                    $profileImage = null;
                    $mockupdesign = $currentmockupdesign;
                }
                if($xxs != 0){
                    $name = null;
                    $size = "XXS";
                    $unitquantity = $xxs; 
                    $unitidxxs = $request->input('unitidxxs'.$i);
                    $idunit = $this->storeUnitUpdate($orderid, $idspec, $name, $size, $unitquantity, $designerid, $printid, $taylorid, $unitstatus, $unitidxxs, $arrsz); 
                }
                if($xs != 0){
                    $name = null;
                    $size = "XS";
                    $unitquantity = $xs; $unitidxxs = $request->input('unitidxxs'.$i);
                    $unitidxs = $request->input('unitidxs'.$i);
                    $idunit = $this->storeUnitUpdate($orderid, $idspec, $name, $size, $unitquantity, $designerid, $printid, $taylorid, $unitstatus, $unitidxs, $arrsz); 
                }
                if($s != 0){
                    $name = null;
                    $size = "S";
                    $unitquantity = $s; $unitidxxs = $request->input('unitidxxs'.$i);
                    $unitids = $request->input('unitids'.$i);
                    $idunit = $this->storeUnitUpdate($orderid, $idspec, $name, $size, $unitquantity, $designerid, $printid, $taylorid, $unitstatus, $unitids, $arrsz); 
                }
                if($m != 0){
                    $name = null;
                    $size = "M";
                    $unitquantity = $m; $unitidxxs = $request->input('unitidxxs'.$i);
                    $unitidm = $request->input('unitidm'.$i);
                    $idunit = $this->storeUnitUpdate($orderid, $idspec, $name, $size, $unitquantity, $designerid, $printid, $taylorid, $unitstatus, $unitidm, $arrsz); 
                }
                if($l != 0){
                    $name = null;
                    $size = "L";
                    $unitquantity = $l; 
                    $unitidl = $request->input('unitidl'.$i);
                    $idunit = $this->storeUnitUpdate($orderid, $idspec, $name, $size, $unitquantity, $designerid, $printid, $taylorid, $unitstatus, $unitidl, $arrsz); 
                }
                if($xl != 0){
                    $name = null;
                    $size = "XL";
                    $unitquantity = $xl; 
                    $unitidxl = $request->input('unitidxl'.$i);
                    $idunit = $this->storeUnitUpdate($orderid, $idspec, $name, $size, $unitquantity, $designerid, $printid, $taylorid, $unitstatus, $unitidxl, $arrsz); 
                }
                if($xl2 != 0){
                    $name = null;
                    $size = "2XL";
                    $unitquantity = $xl2; 
                    $unitidxl2 = $request->input('unitid2xl'.$i);
                    $idunit = $this->storeUnitUpdate($orderid, $idspec, $name, $size, $unitquantity, $designerid, $printid, $taylorid, $unitstatus, $unitidxl2, $arrsz); 
                }
                if($xl3 != 0){
                    $name = null;
                    $size = "3XL";
                    $unitquantity = $xl3; 
                    $unitidxl3 = $request->input('unitid3xl'.$i);
                    $idunit = $this->storeUnitUpdate($orderid, $idspec, $name, $size, $unitquantity, $designerid, $printid, $taylorid, $unitstatus, $unitidxl3, $arrsz); 
                }
                if($xl4 != 0){
                    $name = null;
                    $size = "4XL";
                    $unitquantity = $xl4; 
                    $unitidxl4 = $request->input('unitid4xl'.$i);
                    $idunit = $this->storeUnitUpdate($orderid, $idspec, $name, $size, $unitquantity, $designerid, $printid, $taylorid, $unitstatus, $unitidxl4, $arrsz); 
                }
                if($xl5 != 0){
                    $name = null;
                    $size = "5XL";
                    $unitquantity = $xl5; 
                    $unitidxl5 = $request->input('unitid5xl'.$i);
                    $idunit = $this->storeUnitUpdate($orderid, $idspec, $name, $size, $unitquantity, $designerid, $printid, $taylorid, $unitstatus, $unitidxl5, $arrsz); 
                }
                if($xl6 != 0){
                    $name = null;
                    $size = "6XL";
                    $unitquantity = $xl6;
                    $unitidxl6 = $request->input('unitid6xl'.$i);
                    $idunit = $this->storeUnitUpdate($orderid, $idspec, $name, $size, $unitquantity, $designerid, $printid, $taylorid, $unitstatus, $unitidxl6, $arrsz); 
                }
                if($xl7 != 0){
                    $name = null;
                    $size = "7XL";
                    $unitquantity = $xl7;
                    $unitidxl7 = $request->input('unitid7xl'.$i);
                    $idunit = $this->storeUnitUpdate($orderid, $idspec, $name, $size, $unitquantity, $designerid, $printid, $taylorid, $unitstatus, $unitidxl7, $arrsz); 
                }
                Unit::where('s_id', $idspec)->whereNotIn('un_id', $arrsz)->delete();
                $idunit = null;
            }
        }
        Spec::where('o_id', $orderid)->whereNotIn('s_id', $arrset)->delete();
        $boolprice = $this->requestConfirmUpdate($orderid, $customerid);
        if($boolprice != false){
            $curmkpimg = $request->input('namemockupimg');
            $designid = $request->input('idmockupimg');
            $this->storeDesignUpdate($idunit, $mockupdesign, $orderid, $designerid, $image, $destinationPath, $profileImage, $curmkpimg, $designid); 
            return redirect('/admin/order_list')->with('message', 'Order Updated');
        }else{
            $errbodydesc = Body::where('b_id', $this->errbody)
                ->pluck('b_desc')->toArray();
            $errsleevedesc = Sleeve::where('sl_id', $this->errsleeve)
                ->pluck('sl_desc')->toArray();
            return redirect('/admin/order_list')->with('message', 'Error! Price for body type "'.$errbodydesc[0].'" and sleeve type "'.$errsleevedesc[0].'", for customer type "'.$usertypename.'" that you\'ve selected is not placed. Please enter price in "Pricing" page to have this order!!!');
        }

    }

    public function storeUnitUpdate($orderid, $idspec, $name, $size, $unitquantity, $designerid, $printid, $taylorid, $unitstatus, $unitid, &$arrsz){
        
        if($unitid == ''){
            $lastid = DB::table('unit')->insertGetId(array('o_id' => $orderid, 's_id' => $idspec, 'name' => $name, 'size' => $size,
                'un_quantity' => $unitquantity, 'u_id_designer' => $designerid, 'un_status' => $unitstatus));
            array_push($arrsz, $lastid);
            return $unitid;
        }else{
            if($unitquantity != 0){
                DB::table('unit')
                    ->where('un_id', '=', $unitid)
                    ->update(array('name' => $name, 'size' => $size, 'un_quantity' => $unitquantity, 'u_id_designer' => $designerid));
                array_push($arrsz, $unitid);
                return $unitid;
            }
        }
    } 

    // function to store data to table design
    public function storeDesignUpdate($unitid, $mockupdesign, $orderid, $designerid, $image, $destinationPath, $profileImage, $curmkpimg, $designid){
        if($mockupdesign != $curmkpimg){
            $image->move($destinationPath, $profileImage);
        }
        DB::table('design')
            ->where('id', '=', $designid)
            ->update(array('u_id_designer' => $designerid, 'd_url' => $mockupdesign));
    } 

    public function requestConfirmUpdate($orderid, $usertype){
        $orderidrequest = $orderid;
        $boolprice = true;
        if($orderidrequest != null){
            $user_id = auth()->user()->u_id;
            $thisyear = date("Y");
            $orderid = $orderidrequest;
            $neckid = Spec::where('o_id', '=' , $orderidrequest)->pluck('n_id')->toArray();
            $bodyid = Spec::where('o_id', '=' , $orderidrequest)->pluck('b_id')->toArray();
            $sleeveid = Spec::where('o_id', '=' , $orderidrequest)->pluck('sl_id')->toArray();
            $specid = Spec::where('o_id', '=' , $orderidrequest)->pluck('s_id')->toArray();
            $category;
            $size;
            $price;
            $totprice = 0;
            $totorderrow = count($neckid);
            for($i = 0; $i < $totorderrow; $i++){
                $necktype = Neck::find($neckid[$i]);
                $price = Price::where('n_type', '=', $necktype->n_type)
                    ->where('b_id', '=' , $bodyid[$i])
                    ->where('sl_id', '=' , $sleeveid[$i])
                    ->where('u_type', '=' , $usertype)->pluck('price');
                if($price->isNotEmpty() == false){
                    $boolprice = false;
                    $this->errbody = $bodyid[$i];
                    $this->errsleeve = $sleeveid[$i];
                    $this->errneck = $necktype->n_type;
                    //return $boolprice;
                    // Order::where('o_id', '=', $orderidrequest)->delete();
                    // InvoicePermanent::where('o_id', '=', $orderidrequest)->delete();
                    break;
                }
                $category = Spec::where('s_id', '=', $specid[$i])->pluck('category');
                $size = Unit::where('o_id', '=', $orderidrequest)->pluck('size');
                $totsize = count($size);
                $specs = Unit::where('s_id', '=', $specid[$i])->pluck('s_id');
                $totunits = count($specs);
                $specprice = 0;
                $specquantity = 0;
                $oneunitprice = 0;
                for($j = 0; $j < $totunits; $j++){
                    $size = Unit::where('o_id', '=', $orderidrequest)
                    ->where('s_id', '=', $specid[$i])
                    ->pluck('size');
                    $quantity = Unit::where('o_id', '=', $orderidrequest)
                    ->where('s_id', '=', $specid[$i])
                    ->pluck('un_quantity');
                    $totsize = count($size);
                    $specquantity += $quantity[$j];
                    $pricecalc = $this->calcPriceUpdate($price, $category, $size[$j], $quantity[$j]);
                    $priceperunit = $this->calcPricePerUnitUpdate($price, $category, $size[$j]); 
                    $specprice += $pricecalc;
                    $totprice += $pricecalc;
                }
                if($boolprice == true){
                    $oneunitprice += intval($price[0]);
                    DB::table('invoice_permenant')
                        ->where('s_id', '=', $specid[$i])
                        ->update(array('spec_total_price' => $specprice, 'one_unit_price' => $oneunitprice, 'spec_total_quantity' => $specquantity));
                }
            }
            if($boolprice == true){
                DB::table('invoice')
                    ->where('o_id', '=', $orderid)
                    ->update(array('total_price' => $totprice));
            }
            $currentpayment = DB::table('receipt')->where('o_id', $orderid)->pluck('total_paid')->first();
            $currentbalance = $totprice - $currentpayment;
            DB::table('orders')
                ->where('o_id', '=', $orderid)
                ->update(array('balance' => $currentbalance));
            return $boolprice;
        }
    }
    // method to calculate total price with quantity
    public function calcPriceUpdate($price, $category, $size, $quantity){
        $pricecalc = 0;
        if($category[0] == "Nameset"){
            $priceint = intval($price[0]);
            $quantityint = intval($quantity);
            $pricecalc = $priceint + 4;
            $pricecalc *= $quantityint;
            if($size == "4XL" || $size == "5XL"){
                $pricecalc += 4;
            }else if($size == "6XL" || $size == "7XL"){
                $pricecalc += 8;
            }
        }else{
            $pricecalc = intval($price[0]);
            $quantityint = intval($quantity);
            $pricecalc *= $quantityint;
            if($size == "4XL" || $size == "5XL"){
                $priceint = intval($price[0]);
                $quantityint = intval($quantity);
                $pricecalc = $priceint + 4;
                $pricecalc *= $quantityint;
            }else if($size == "6XL" || $size == "7XL"){
                $priceint = intval($price[0]);
                $quantityint = intval($quantity);
                $pricecalc = $priceint + 8;
                $pricecalc *= $quantityint;
            }else{
                $pricecalc = intval($price[0]);
                $quantityint = intval($quantity);
                $pricecalc *= $quantityint;
            }
        }
        return $pricecalc;
    }
    // method to calculate total price without quantity
    public function calcPricePerUnitUpdate($price, $category, $size){
        $pricecalc = 0;
        if($category[0] == "Nameset"){
            $priceint = intval($price[0]);
            $pricecalc = $priceint + 4;
            if($size == "4xl" || $size == "5xl"){
                $pricecalc += 4;
            }else if($size == "6xl" || $size == "7xl"){
                $pricecalc += 8;
            }
        }else{
            $pricecalc = intval($price[0]);
            if($size == "4XL" || $size == "5XL"){
                $priceint = intval($price[0]);
                $pricecalc = $priceint + 4;
            }else if($size == "6XL" || $size == "7XL"){
                $priceint = intval($price[0]);
                $pricecalc = $priceint + 8;
            }else{
                $pricecalc = intval($price[0]);
            }
        }
        return $pricecalc;
    }

}                
