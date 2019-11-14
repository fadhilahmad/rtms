<?php
namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use App\Order;
use App\Material;
use App\DeliverySetting;
use App\Body;
use App\Sleeve;
use App\Neck;
use App\Design;
use App\Spec;
use App\Unit;
use App\User;
use App\Price;
use App\Invoice;
use Gate;
// use Illuminate\Support\Facades\Hash;
use DB;
class CustomerController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('customer');
    }
    
    public function customerProfile() 
    {
        // Get the currently authenticated user's ID...
        $customer = Auth::user();
        return view('customer/customer_profile', compact('customer'));
    }
    
     //update customer profile
     public function updateProfile(Request $request,  $id) 
     {
      
        $customer = User::find($id);
        $customer->u_fullname = $request->input('name');
        $customer->email = $request->input('email');
        $customer->phone = $request->input('phone');
        $customer->address = $request->input('address');      
        $customer->save();
        
        return back()->with('success','Your profile updated successfully');
 
     }
 
     //display admin password form
     public function customerChangePassword () 
     {
        $customer = Auth::user();
        return view('customer/change_password', compact('customer'));
       
     }
 
     //change admin password
     public function updateChangePassword (Request $request,  $id) 
     {       
         $this->validate($request, [     
             'old_password'     => 'required',
             'new_password'     => 'required|min:8',
             'confirm_password' => 'required|same:new_password',     
         ]);
 
         $customer = User::find($id);
         $data = $request->all();
 
         if(!\Hash::check($data['old_password'], $customer->password)){
             return back()->with('error','You have entered wrong password');              
                 } else {       
                     $customer->password = Hash::make($request->input('new_password'));        
             }
         $customer->save();
         
         return back()->with('success','Your password updated successfully');
     
    }   
    // method to view new order page for customer
    public function newOrder()
    {
        // set limit to view on page only to customer
        if(!Gate::allows('isCustomer')){
            abort(404, "Sorry, you cannot do this action");
        }
        // get data from tables
        $materials = Material::where('m_status', 1)->get();
        $deliverysettings = DeliverySetting::all();
        $bodies = Body::where('b_status', 1)->get();
        $sleeves = Sleeve::where('sl_status', 1)->get();
        $necks = Neck::where('n_status', 1)->get();
        // return view with all the data from the tables
        return view('customer/neworder')
        ->with('materials', $materials)
        ->with('deliverysettings', $deliverysettings)
        ->with('bodies', $bodies)
        ->with('sleeves', $sleeves)
        ->with('necks', $necks);
    }
    // method to view order list page for customer based on customer id
    public function customerOrderList()
    {
        // // set limit to view on page to different type of users
        // if(!Gate::allows('isCustomer')){
        //     abort(404, "Sorry, you cannot do this action");
        // }
        // get the user id
        $user_id = auth()->user()->u_id;
        $user = User::find($user_id);
        // get order id with status draft
        //$ordercustdraft = Order::where('u_id_customer', $user_id)->where('o_status', 0)->get();
        $ordercustdraft = Order::where('u_id_customer', $user_id)->where('o_status', '!=' , 1)->orWhereNull('o_status')->get();
        $orderiddraft = $ordercustdraft->pluck('o_id')->all();
        $ordersdraft = Order::find($orderiddraft);
        // get order id with status pending
        $ordercustpending = Order::where('u_id_customer', $user_id)->where('o_status', 1)->get();
        $orderidpending = $ordercustpending->pluck('o_id')->all();
        $orderspending = Order::find($orderidpending);
        // get all order
        $orders = Order::all();
        if($orders != null){
            return view('customer/customer_orderlist')
            ->with('orders', $orders)
            ->with('ordersdraft', $ordersdraft)
            ->with('orderspending', $orderspending);
        }else{
            return view('customer/customer_orderlist')->with('orders', $orders);
        }
    }

    public function requestConfirm($orderid){
        
        $orderidrequest = $orderid;
        if($orderidrequest != null){
            //-------------------- confirm design ----------------------//
            // get the user id
            $user_id = auth()->user()->u_id;
            //$user = User::find($user_id);
            // make ref num to be inserted in table order
            // get array of ref num from order table based on user id
            $userrefnum = Order::where('ref_num', '!=' , null)->pluck('ref_num')->toArray();
            // total ref num
            $totalrefnum = count($userrefnum);
            $newrefnum = $totalrefnum + 1;
            // update ref num in table order
            DB::table('orders')
                ->where('o_id', '=', $orderidrequest)
                ->update(array('ref_num' => $newrefnum,
                'o_status'=>'2'));
            // calculate price
            // get n_id, b_id, sl_id, u_type,
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
            //var_dump(": ".$totorderrow);
            //var_dump(": ".$neckid[1]);
            for($i = 0; $i < $totorderrow; $i++){
                // get neck id to check if collar or not
                if($neckid[$i] == 1){
                    $checkneck = 1;
                }else{
                    $checkneck = 2;
                }
                //var_dump(": ".$checkneck);
                $price = Price::where('n_id', '=', $checkneck)
                    ->where('b_id', '=' , $bodyid[$i])
                    ->where('sl_id', '=' , $sleeveid[$i])
                    ->where('u_type', '=' , $usertype)->pluck('price');
                $category = Order::where('o_id', '=', $orderidrequest)->pluck('category');
                //var_dump(": ".$category);
                //var_dump(": ".$price[$i]);
                //var_dump(": ".$neckid[$i]);
                
                
                //$units = Unit::where('o_id', $orderidrequest)->get();
                $size = Unit::where('o_id', '=', $orderidrequest)->pluck('size');
                $totsize = count($size);
                $specs = Unit::where('s_id', '=', $specid[$i])->pluck('s_id');
                $totunits = count($specs);
                //var_dump(": ".$specid[$i]);
                //var_dump(": ".$totunits);
                //var_dump(": ".$size[4]);
                for($j = 0; $j < $totunits; $j++){
                    $size = Unit::where('o_id', '=', $orderidrequest)
                    ->where('s_id', '=', $specs[$i])
                    ->pluck('size');
                    // get the quantity
                    $quantity = Unit::where('o_id', '=', $orderidrequest)
                    ->where('s_id', '=', $specs[$i])
                    ->pluck('un_quantity');
                    $totsize = count($size);
                    //var_dump(": ".$totsize);
                    //var_dump(": ".$size[$j]);
                    //var_dump(": ".$quantity[$j]);
                    $pricecalc = $this->calcPrice($price, $category, $size[$j], $quantity[$j]); 
                    //$priceint = intval($pricecalc[0]);
                    $totprice += $pricecalc;
                    //var_dump(": ".$pricecalc);
                    //var_dump(": ".$pricecalc);
                    //var_dump(": ".$this->calcPrice($price, $category, $size[$j]));
                    //var_dump(": ".$totprice);
                }
                // var_dump(": ".$totsize);
            }
            //var_dump(": ".$totprice);
            $invoice = new Invoice;
            $invoice->o_id = $orderid;
            $invoice->i_status = 1;
            $invoice->total_price = $totprice;
            $invoice->save();
            
                
            //return redirect('customer/customer_orderlist')->with('message', 'Order confirmed');
        }else{
            //-------------------- request redesign ----------------------//
            // $data = $request->all();
            
            // if ($request->has('design')) {
            //     $image = $request->file('design');                    
            //     $destinationPath = 'orders/draft/'; 
            //     $profileImage = 'draft'.date('YmdHis') . "." . $image->getClientOriginalExtension();
            //     $image->move($destinationPath, $profileImage);
            //     $url = $destinationPath.$profileImage;
                    
            //     DB::table('design')->insert([
            //             'o_id' => $data['o_id'],
            //             'u_id_designer'=>$data['u_id'],
            //             'd_url' =>$profileImage,
            //             'd_type'=>'2',
            //             'created_at' => DB::raw('now()'),
            //             'updated_at' => DB::raw('now()')
            //             ]);
                
            //     if($data['note'] != null){
            //         DB::table('orders')
            //                 ->where('o_id', '=', $data['o_id'])
            //                 ->update(array('note' => $data['note'],
            //                                 'o_status'=>'10'));
            //     }else{
            //         DB::table('orders')
            //             ->where('o_id', '=', $data['o_id'])
            //             ->update(array('o_status'=>'10'));
            //         return redirect('customer/customer_orderlist')->with('message', 'Request redesign submitted'); 
            //     }
                
            //     return redirect('customer/customer_orderlist')->with('message', 'Request redesign submitted'); 
            // }else{
            //     if($data['note'] != null){
            //         DB::table('orders')
            //             ->where('o_id', '=', $data['o_id'])
            //             ->update(array('note' => $data['note'],
            //             'o_status'=>'10'));
                
            //         return redirect('customer/customer_orderlist')->with('message', 'Request redesign submitted'); 
            //     }else{
            //         DB::table('orders')
            //             ->where('o_id', '=', $data['o_id'])
            //             ->update(array('o_status'=>'10'));
            //         return redirect('customer/customer_orderlist')->with('message', 'Request redesign submitted'); 
            //     }
                
                
            // }
        }
    }
    // method to calculate total price
    public function calcPrice($price, $category, $size, $quantity){
        //var_dump(": ".$size);
        $pricecalc = 0;
        if($category == "Nameset"){
            $priceint = intval($price[0]);
            $quantityint = intval($quantity);
            $pricecalc = $priceint + 4;
            $pricecalc *= $quantityint;
        }else{
            $pricecalc = intval($price[0]);
            $quantityint = intval($quantity);
            $pricecalc *= $quantityint;
        }
        if($size == "4XL" || $size == "5XL"){
            $priceint = intval($price[0]);
            $quantityint = intval($quantity);
            $pricecalc = $priceint + 4;
            $pricecalc *= $quantityint;
        }else{
            $pricecalc = intval($price[0]);
            $quantityint = intval($quantity);
            $pricecalc *= $quantityint;
        }
        if($size == "6XL" || $size == "7XL"){
            $priceint = intval($price[0]);
            $quantityint = intval($quantity);
            $pricecalc = $priceint + 8;
            $pricecalc *= $quantityint;
        }else{
            $pricecalc = intval($price[0]);
            $quantityint = intval($quantity);
            $pricecalc *= $quantityint;
        }
        return $pricecalc;
    }
    // method to view mockup image
    public function customerViewOrder($order_id)
    {
        $design = Design::where('o_id', $order_id)->where('d_type', 1)->get();
        $spec = Spec::where('o_id', $order_id)->get();
        $unit = Unit::where('o_id', $order_id)->get();
        $order = Order::find($order_id);
        return view('customer/customer_view_order')
        ->with('order', $order)
        ->with('designs', $design)
        ->with('spec', $spec)
        ->with('unit', $unit);
        
    }
    // method to view design image
    public function customerViewDesign($order_id)
    {
        $design = Design::where('o_id', $order_id)->where('d_type', 2)->get();
        $spec = Spec::where('o_id', $order_id)->get();
        $unit = Unit::where('o_id', $order_id)->get();
        $order = Order::find($order_id);
        return view('customer/customer_view_design')
        ->with('order', $order)
        ->with('designs', $design)
        ->with('spec', $spec)
        ->with('unit', $unit);
        
    }
    
    // method to view mockup image
    public function customerViewJobOrder($order_id)
    {
        $userid = auth()->user()->u_id;
        $user = User::find($userid);
        // $user = User::where('u_id', '=' , $userid)->get();
        $design = Design::where('o_id', $order_id)->where('d_type', 1)->get();
        $specs = Spec::where('o_id', $order_id)->get();
        $unit = Unit::where('o_id', $order_id)->get();
        $order = Order::find($order_id);
        $materials = Material::all();
        $sleeves = Sleeve::all();
        $necks = Neck::all();
        $designer = User::find($order->u_id_designer);

        //$specs = Spec::find($order_id);

        //var_dump($spec);
        
        //->with('specs', $specs)

        return view('customer.cust_job_order')
        ->with('user', $user)
        ->with('order', $order)
        ->with('designs', $design)
        ->with('specs', $specs)
        ->with('unit', $unit)
        ->with('materials', $materials)
        ->with('sleeves', $sleeves)
        ->with('necks', $necks)
        ->with('designer', $designer);
        
    }
    // // method to view customer job order
    // public function customerViewJobOrder($order_id)
    // {
    //     $design = Design::where('o_id', $order_id)->where('d_type', 1)->get();
    //     $spec = Spec::where('o_id', $order_id)->get();
    //     $unit = Unit::where('o_id', $order_id)->get();
    //     $order = Order::find($order_id);
    //     return view('customer/customer_view_order')
    //     ->with('order', $order)
    //     ->with('designs', $design)
    //     ->with('spec', $spec)
    //     ->with('unit', $unit);
        
    // }
    // method to view invoice page for customer
    public function invoice()
    {
        $user_id = auth()->user()->u_id;
        $orderconfirm = Order::where('u_id_customer', '=' , $user_id)
        ->where('o_status', '!=' , 0)
        ->where('o_status', '!=' , 1)
        ->get();
        $materials = Material::all();
        $invoices = Invoice::all();
        //var_dump($orderconfirm);
        return view('customer/invoice')
        ->with('orders', $orderconfirm)
        ->with('materials', $materials)
        ->with('invoices', $invoices);
    }
    // method to view receipt page for customer
    public function receipt()
    {
        return view('customer/receipt');
    }
    // method to view or print invoice details
    public function viewInvoice(Request $request){
        $action = $request->input('actionbutton');
        $orderid = $request->input('orderid');
        // var_dump($action);
        if($action == "View"){
            $userid = auth()->user()->u_id;
            $user = User::where('u_id', '=' , $userid)->get();
            $orderconfirm = Order::where('o_id', '=' , $orderid)->get();
            $units = Unit::where('o_id', '=', $orderid)->get();
            $specsget = Spec::where('o_id', '=', $orderid)->get();
            $invoices = Invoice::where('o_id', '=', $orderid)->get();
            //var_dump($bodytype);
            $materials = Material::all();
            $bodies = Body::all();
            $sleeves = Sleeve::all();
            $necks = Neck::all();
            //$prices = Price::all();
            $usertype = auth()->user()->u_type;
            $prices = array();
            $neckid = Spec::where('o_id', '=' , $orderid)->pluck('n_id')->toArray();
            $bodyid = Spec::where('o_id', '=' , $orderid)->pluck('b_id')->toArray();
            $sleeveid = Spec::where('o_id', '=' , $orderid)->pluck('sl_id')->toArray();
            $specid = Spec::where('o_id', '=' , $orderid)->pluck('s_id')->toArray();
            $category;
            $size;
            $price;
            $totprice = 0;
            $totorderrow = count($neckid);
            for($i = 0; $i < $totorderrow; $i++){
                if($neckid[$i] == 1){
                    $checkneck = 1;
                }else{
                    $checkneck = 2;
                }
                $price = Price::where('n_id', '=', $checkneck)
                    ->where('b_id', '=' , $bodyid[$i])
                    ->where('sl_id', '=' , $sleeveid[$i])
                    ->where('u_type', '=' , $usertype)->pluck('price');
                $category = Order::where('o_id', '=', $orderid)->pluck('category');
                
                $size = Unit::where('o_id', '=', $orderid)->pluck('size');
                $totsize = count($size);
                $specs = Unit::where('s_id', '=', $specid[$i])->pluck('s_id');
                $totunits = count($specs);
                for($j = 0; $j < $totunits; $j++){
                    $size = Unit::where('o_id', '=', $orderid)
                    ->where('s_id', '=', $specs[$i])
                    ->pluck('size');
                    
                    $quantity = Unit::where('o_id', '=', $orderid)
                    ->where('s_id', '=', $specs[$i])
                    ->pluck('un_quantity');
                    $totsize = count($size);
                    $pricescalc = $this->calcPrice($price, $category, $size[$j], $quantity[$j]);
                    array_push($prices, $pricescalc); 
                }
            }
            return view('customer/view_invoice')
            ->with('users', $user)
            ->with('orders', $orderconfirm)
            ->with('invoices', $invoices)
            ->with('orderid', $orderid)
            ->with('units', $units)
            ->with('specs', $specsget)
            ->with('bodies', $bodies)
            ->with('sleeves', $sleeves)
            ->with('necks', $necks)
            ->with('prices', $prices)
            ->with('usertype', $usertype);
        }
    }
// -------------------------------------- Add order to db --------------------------------------------------
    /**
     * Display a listing of the resource. 
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }
    /**
     * 
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // make validation
        $this->validate($request, [
            'somedate' => 'required',
            'cloth_name' => 'required',
            'category' => 'required',
            'cover_image' => 'image|required|max:1999'
        ]);
// set cover image max to 1999 because a lot of apache server not allowed user to upload image more than 2mb
        // ------------------ insert data into table order ---------------------------------- //

        // $request->input('orderid');

        $clothname = $request->input('cloth_name');
        $category = $request->input('category');
        $material = $request->input('material');
        $totalquantity = $request->input('total_quantity');
        $note = $request->input('note');
        $refnum = null; // currently auto assign
        $deliverydate = $request->input('somedate');
        $orderstatus = 2; // set to drafted
        $customerid = auth()->user()->u_id;
        $customername = auth()->user()->username;
        $designerid; 
        $printid = null;
        $taylorid = null; 
        // assign order design to designer
        // get all designer id
        $userdesigner = User::where('u_type', 3)->where('u_status', 1)->pluck('u_id')->toArray();
        // var_dump("--------------- total designer ------------Total Designer: ".$totaldesigner);
        // check if order existed
        $hasorder = Order::all()->toArray();
        //var_dump("--------------- total order ------------Total Order: ".count($hasorder));
        // if no order
        if($hasorder == 0){
            // assign first index of designer id to the first order
            $designerid = $userdesigner[0];
        }else{
            // get array of designer id from order table 
            $orderiddesigner = Order::all()->pluck('u_id_designer')->toArray();
            // total designer
            $totaldesigner = count($userdesigner);
            // total order
            $totalorder = count($orderiddesigner);
            // check if total order is more than designer
            if($totalorder >= $totaldesigner){
                // get the remainder of the order
                $remainderindex = $totalorder % $totaldesigner;
                // get next designer id
                $nextorderdesignerid = $userdesigner[$remainderindex];
                // assign to variable
                $designerid = $nextorderdesignerid;
            }else{
                // last designer id index
                $lastiddesignerindex = count($orderiddesigner)-1;
                //var_dump("--------------- last designer id index ------------Latest index ID: ".$lastiddesignerindex);
                // get next designer id
                $nextorderdesignerid = $userdesigner[$lastiddesignerindex + 1];
                //var_dump("--------------- next designer id order ------------Next Order Designer ID: ".$nextorderdesignerid);
                // assign to variable
                $designerid = $nextorderdesignerid;
            }
            
        }
        
        // Create order model
        $order = new Order;
        // insert into table order
        $order->file_name = $clothname;
        $order->category = $category;
        $order->material_id = $material;
        $order->quantity_total = $totalquantity;
        $order->note = $note;
        $order->ref_num = $refnum;
        $order->delivery_date = $deliverydate;
        $order->o_status = $orderstatus;
        $order->u_id_customer = $customerid;
        $order->u_id_designer = $designerid;
        $order->u_id_print = $printid;
        $order->u_id_taylor = $taylorid;
        // // save it
        $order->save();
        // ------------------ insert data into table spec ---------------------------------- //
        $orderid = $order->o_id;
        $neckid; // if round neck, assign 0
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
            // Create spec model
            $spec = new Spec;
            $spec->n_id = $request->input('necktype'.$i);
            $bodyid = $request->input('type'.$i);
            $sleeveid = $request->input('sleeve'.$i);
            $collarcolor = $request->input('collar_color'.$i);
            $spec->o_id = $orderid;
            $spec->b_id = $bodyid;
            $spec->sl_id = $sleeveid;
            $spec->collar_color = $collarcolor;
            // save it
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
                    var_dump("----------name set: ----------".$namesetnum);
                }
                
                for($j = 0; $j < $namesetnum; $j++){
                    // Create unit model
                    $unit = new Unit;
        
                    $name = $request->input('name'.$i.'-'.$j);
                    $size = $request->input('size'.$i.'-'.$j);
                    $unitquantity = $request->input('quantitysinglenamesetname'.$i.'-'.$j); 
        
                    // insert into table unit
                    $unit->o_id = $orderid;
                    $unit->s_id = $idspec; 
                    $unit->name = $name; 
                    $unit->size = $size; 
                    $unit->un_quantity = $unitquantity;
                    $unit->u_id_print = $printid;
                    $unit->u_id_taylor = $taylorid;
                    $unit->un_status = $unitstatus;
        
                    // save it
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
                        //var_dump("no file");
                    }
                    $idunit = $unit->un_id;
                    $this->storeDesign($idunit, $mockupdesign, $orderid, $designerid); 
                    
                }
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
                    //var_dump("no file");
                }
                if($xxs != 0){
                    $name = null;
                    $size = "XXS";
                    $unitquantity = $xxs; 
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $printid, $taylorid, $unitstatus); 
                    $this->storeDesign($idunit, $mockupdesign, $orderid, $designerid); 
                }
                if($xs != 0){
                    $name = null;
                    $size = "XS";
                    $unitquantity = $xs; 
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $printid, $taylorid, $unitstatus); 
                    $this->storeDesign($idunit, $mockupdesign, $orderid, $designerid);
                }
                if($s != 0){
                    $name = null;
                    $size = "S";
                    $unitquantity = $s; 
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $printid, $taylorid, $unitstatus); 
                    $this->storeDesign($idunit, $mockupdesign, $orderid, $designerid);
                }
                if($m != 0){
                    $name = null;
                    $size = "M";
                    $unitquantity = $m; 
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $printid, $taylorid, $unitstatus); 
                    $this->storeDesign($idunit, $mockupdesign, $orderid, $designerid);
                }
                if($l != 0){
                    $name = null;
                    $size = "L";
                    $unitquantity = $l; 
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $printid, $taylorid, $unitstatus); 
                    $this->storeDesign($idunit, $mockupdesign, $orderid, $designerid);
                }
                if($xl != 0){
                    $name = null;
                    $size = "XL";
                    $unitquantity = $xl; 
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $printid, $taylorid, $unitstatus); 
                    $this->storeDesign($idunit, $mockupdesign, $orderid, $designerid);
                }
                if($xl2 != 0){
                    $name = null;
                    $size = "2XL";
                    $unitquantity = $xl2; 
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $printid, $taylorid, $unitstatus); 
                    $this->storeDesign($idunit, $mockupdesign, $orderid, $designerid);
                }
                if($xl3 != 0){
                    $name = null;
                    $size = "3XL";
                    $unitquantity = $xl3; 
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $printid, $taylorid, $unitstatus); 
                    $this->storeDesign($idunit, $mockupdesign, $orderid, $designerid);
                }
                if($xl4 != 0){
                    $name = null;
                    $size = "4XL";
                    $unitquantity = $xl4; 
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $printid, $taylorid, $unitstatus); 
                    $this->storeDesign($idunit, $mockupdesign, $orderid, $designerid);
                }
                if($xl5 != 0){
                    $name = null;
                    $size = "5XL";
                    $unitquantity = $xl5; 
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $printid, $taylorid, $unitstatus); 
                    $this->storeDesign($idunit, $mockupdesign, $orderid, $designerid);
                }
                if($xl6 != 0){
                    $name = null;
                    $size = "6XL";
                    $unitquantity = $xl6;
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $printid, $taylorid, $unitstatus); 
                    $this->storeDesign($idunit, $mockupdesign, $orderid, $designerid);
                }
                if($xl7 != 0){
                    $name = null;
                    $size = "7XL";
                    $unitquantity = $xl7;
                    $idunit = $this->storeUnit($orderid, $idspec, $name, $size, $unitquantity, $printid, $taylorid, $unitstatus); 
                    $this->storeDesign($idunit, $mockupdesign, $orderid, $designerid);
                }
            }
            
        }

        // set the status to 2
        $this->requestConfirm($orderid);

        return redirect('/customer/orderlist')->with('success', 'Order Created');
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
        // Create design model
        $design = new Design;
        // insert into table design
        $design->o_id = $orderid;
        $design->un_id = $unitid; 
        $design->u_id_designer = $designerid; 
        $design->d_url = $mockupdesign; 
        $design->d_type = $designtype;
        // save it
        $design->save();
    } 
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // function
    public function show($id)
    {
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}