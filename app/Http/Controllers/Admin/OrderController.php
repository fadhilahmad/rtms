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
            //dd($orders);
            return view('admin/job_order',compact('orders','specs','pic','units','design','designs')); 
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
             
             $invoice_p = InvoicePermanent::all();
             
            // dd($specs);      
        
        
        return view('admin/invoice_info',compact('orders','specs','user','units','invoice','invoice_p'));
    }

    // method to add new order
    public function addneworder(Request $request){
        
        // make validation
        $this->validate($request, [
            'somedate' => 'required',
            'cloth_name' => 'required',
            'category' => 'required',
            'cover_image' => 'image|required|max:1999'
        ]); // set cover image max to 1999 because a lot of apache server not allowed user to upload image more than 2mb
        // ------------------ insert data into table order ---------------------------------- //
        $clothname = $request->input('cloth_name');
        $category = $request->input('category');
        $material = $request->input('material');
        $totalquantity = $request->input('total_quantity');
        $note = $request->input('note');
        $refnum = null; // currently auto assign
        $deliverydate = $request->input('somedate');
        $deliverytype = $request->input('dealtype');
        $orderstatus = 2; // set to drafted
        $customerid = auth()->user()->u_id;
        $customername = auth()->user()->username;
        $designerid; 
        $printid = null;
        $taylorid = null; 
        // assign order design to designer
        $userdesigner = User::where('u_type', 3)->where('u_status', 1)->pluck('u_id')->toArray();   // get all designer id
        $hasorder = Order::all()->toArray();    // check if order existed
        if($hasorder == 0){ // if no order
            $designerid = $userdesigner[0]; // assign first index of designer id to the first order
        }else{
            $orderiddesigner = Order::all()->pluck('u_id_designer')->toArray(); // get array of designer id from order table 
            $totaldesigner = count($userdesigner);  // total designer
            $totalorder = count($orderiddesigner);  // total order
            if($totalorder >= $totaldesigner){  // check if total order is more than designer
                $remainderindex = $totalorder % $totaldesigner; // get the remainder of the order
                $nextorderdesignerid = $userdesigner[$remainderindex];  // get next designer id
                $designerid = $nextorderdesignerid; // assign to variable
            }else{
                $lastiddesignerindex = count($orderiddesigner)-1;   // last designer id index
                $nextorderdesignerid = $userdesigner[$lastiddesignerindex + 1]; // get next designer id
                $designerid = $nextorderdesignerid; // assign to variable
            }
        }
        $order = new Order;
        $order->file_name = $clothname;
        $order->category = $category;
        $order->material_id = $material;
        $order->quantity_total = $totalquantity;
        $order->note = $note;
        $order->ref_num = $refnum;
        $order->delivery_type = $deliverytype;
        $order->delivery_date = $deliverydate;
        $order->o_status = $orderstatus;
        $order->u_id_customer = $customerid;
        $order->u_id_designer = $designerid;
        $order->u_id_print = $printid;
        $order->u_id_taylor = $taylorid;
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
            $spec->o_id = $orderid;
            $spec->b_id = $bodyid;
            $spec->sl_id = $sleeveid;
            $spec->collar_color = $collarcolor;
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
                        if($num == 0){
                            $image->move($destinationPath, $profileImage);
                            $num++;
                        }
                        $url = $destinationPath.$profileImage;
                        $mockupdesign = $profileImage;
    
                    }else{
                        $mockupdesign = 'noimage.jpg';
                    }
                }
                $idunit = null;
                $this->storeDesign($idunit, $mockupdesign, $orderid, $designerid); 
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
                    // get the file name with the extension
                    $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
                    $originalname = $request->file('cover_image')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $request->file('cover_image')->getClientOriginalExtension();
                    $originalextension = $request->file('cover_image')->getClientOriginalExtension();
                    $mockupdesign = $customername.'-mockup-'.$filename.'_'.time().'.'.$extension;
                    $destinationPath = 'orders/mockup';
                    $image = $request->file('cover_image');
                    $imagerequestfile = $request->file('cover_image');
                    if($i == 0){
                        $image->move($destinationPath, $mockupdesign);
                    }
                    
                }else{
                    $mockupdesign = 'noimage.jpg';
                }
                if($xxs != 0){
                    $name = null;
                    $size = "XXS";
                    $unitquantity = $xxs; 
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $printid, $taylorid, $unitstatus); 
                }
                if($xs != 0){
                    $name = null;
                    $size = "XS";
                    $unitquantity = $xs; 
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $printid, $taylorid, $unitstatus); 
                }
                if($s != 0){
                    $name = null;
                    $size = "S";
                    $unitquantity = $s; 
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $printid, $taylorid, $unitstatus); 
                }
                if($m != 0){
                    $name = null;
                    $size = "M";
                    $unitquantity = $m; 
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $printid, $taylorid, $unitstatus); 
                }
                if($l != 0){
                    $name = null;
                    $size = "L";
                    $unitquantity = $l; 
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $printid, $taylorid, $unitstatus); 
                }
                if($xl != 0){
                    $name = null;
                    $size = "XL";
                    $unitquantity = $xl; 
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $printid, $taylorid, $unitstatus); 
                }
                if($xl2 != 0){
                    $name = null;
                    $size = "2XL";
                    $unitquantity = $xl2; 
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $printid, $taylorid, $unitstatus); 
                }
                if($xl3 != 0){
                    $name = null;
                    $size = "3XL";
                    $unitquantity = $xl3; 
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $printid, $taylorid, $unitstatus); 
                }
                if($xl4 != 0){
                    $name = null;
                    $size = "4XL";
                    $unitquantity = $xl4; 
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $printid, $taylorid, $unitstatus); 
                }
                if($xl5 != 0){
                    $name = null;
                    $size = "5XL";
                    $unitquantity = $xl5; 
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $printid, $taylorid, $unitstatus); 
                }
                if($xl6 != 0){
                    $name = null;
                    $size = "6XL";
                    $unitquantity = $xl6;
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $printid, $taylorid, $unitstatus); 
                }
                if($xl7 != 0){
                    $name = null;
                    $size = "7XL";
                    $unitquantity = $xl7;
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $printid, $taylorid, $unitstatus); 
                }
                $idunit = null;
                $this->storeDesign($idunit, $mockupdesign, $orderid, $designerid); 
            }
            
        }
        $this->requestConfirm($orderid);
        return redirect('/admin/order_list')->with('success', 'Order Created');
    }

    // function to store data to table unit
    public function storeUnit($orderid, $idspec, $name, $size, $unitquantity, $printid, $taylorid, $unitstatus){
        $unit = new Unit; 
        $unit->o_id = $orderid;
        $unit->s_id = $idspec;
        $unit->name = $name; 
        $unit->size = $size; 
        $unit->un_quantity = $unitquantity;
        $unit->u_id_print = $printid;
        $unit->u_id_taylor = $taylorid;
        $unit->un_status = $unitstatus; 
        $unit->save(); 
        $idunit = $unit->un_id;
        return $idunit;
    } 

    // function to store data to table design
    public function storeDesign($unitid, $mockupdesign, $orderid, $designerid){
        $designtype = 1; // set to 1 (mockup) 
        $design = new Design;
        $design->o_id = $orderid;
        $design->un_id = $unitid; 
        $design->u_id_designer = $designerid; 
        $design->d_url = $mockupdesign; 
        $design->d_type = $designtype;
        $design->save();
    } 
    public function requestConfirm($orderid){
        $orderidrequest = $orderid;
        if($orderidrequest != null){
            $user_id = auth()->user()->u_id;
            $thisyear = date("Y");
            $recordedyear = Order::select('ref_num')
                ->whereYear('created_at', $thisyear)
                ->first();
            if($recordedyear == null){
                $newrefnum = date("y")."/1"; 
                DB::table('orders')
                    ->where('o_id', '=', $orderidrequest)
                    ->update(array('ref_num' => $newrefnum,
                    'o_status'=>'2'));
            }else{

                $userrefnum = Order::where('ref_num', '!=' , null)->whereYear('created_at', $thisyear)->pluck('ref_num')->toArray();
                $totalrefnum = count($userrefnum);
                $newrefnum = date("y")."/".($totalrefnum + 1); 
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
            $usertype = auth()->user()->u_type;
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
                $category = Order::where('o_id', '=', $orderidrequest)->pluck('category');
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
                $oneunitprice += intval($price[0]);
                $invoicePermanent = new InvoicePermanent;
                $invoicePermanent->s_id = $specid[$i];
                $invoicePermanent->o_id = $orderidrequest;
                $invoicePermanent->spec_total_price = $specprice;
                $invoicePermanent->one_unit_price = $oneunitprice;
                $invoicePermanent->spec_total_quantity = $specquantity;
                $invoicePermanent->save();
            }
            $invoice = new Invoice;
            $invoice->o_id = $orderid;
            $invoice->i_status = 1;
            $invoice->total_price = $totprice; 
            $invoice->save();

            DB::table('orders')
                ->where('o_id', '=', $orderid)
                ->update(array('balance' => $totprice));
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
            if($size == "4xl" || $size == "5xl"){
                $pricecalc += 4;
            }else if($size == "6xl" || $size == "7xl"){
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
