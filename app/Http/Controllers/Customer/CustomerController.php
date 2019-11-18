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
use App\InvoicePermanent;
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
        $prices = Price::all();
        // return view with all the data from the tables
        return view('customer/neworder')
        ->with('materials', $materials)
        ->with('deliverysettings', $deliverysettings)
        ->with('bodies', $bodies)
        ->with('sleeves', $sleeves)
        ->with('necks', $necks)
        ->with('prices', $prices);
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
            $user_id = auth()->user()->u_id;
            $userrefnum = Order::where('ref_num', '!=' , null)->pluck('ref_num')->toArray();
            $totalrefnum = count($userrefnum);
            $newrefnum = $totalrefnum + 1;
            // update ref num in table order
            DB::table('orders')
                ->where('o_id', '=', $orderidrequest)
                ->update(array('ref_num' => $newrefnum,
                'o_status'=>'2'));
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
        return $pricecalc;
    }
    // method to calculate total price without quantity
    public function calcPricePerUnit($price, $category, $size){
        $pricecalc = 0;
        if($category == "Nameset"){
            $priceint = intval($price[0]);
            $pricecalc = $priceint + 4;
        }else{
            $pricecalc = intval($price[0]);
        }
        if($size == "4XL" || $size == "5XL"){
            $priceint = intval($price[0]);
            $pricecalc = $priceint + 4;
        }else if($size == "6XL" || $size == "7XL"){
            $priceint = intval($price[0]);
            $pricecalc = $priceint + 8;
        }else{
            $pricecalc = intval($price[0]);
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
    
    // method to display job order page
    public function customerViewJobOrder($order_id)
    {
        $userid = auth()->user()->u_id;
        $user = User::find($userid);
        $design = Design::where('o_id', $order_id)->get();
        //$specs = Spec::where('o_id', $order_id)->get();
        //$units = Unit::where('o_id', $order_id)->get();
        $order = Order::find($order_id);
        $materials = Material::all();
        $sleeves = Sleeve::all();
        $necks = Neck::all();
        $designer = User::find($order->u_id_designer);
        $specs = DB::table('spec')
            ->leftJoin('body', 'spec.b_id','=','body.b_id')
            ->leftJoin('sleeve', 'spec.sl_id', '=', 'sleeve.sl_id')
            ->leftJoin('neck', 'spec.n_id','=','neck.n_id')
            ->where('spec.o_id','=',$order_id)
            ->get();
        $units = DB::table('unit')
            ->join('design', 'unit.un_id','=','design.un_id')
            ->where('unit.o_id','=',$order_id)
            ->get();
        $invoicepermanents = InvoicePermanent::where('o_id', $order_id)->get();
        // $units = DB::table('unit')
        //     ->leftJoin('spec', 'spec.b_id','=','body.b_id')
        //     ->where('o_id', $order_id)->get();

        //$specs = Spec::find($order_id);

        //var_dump($spec);
        
        //->with('specs', $specs)

        return view('customer.cust_job_order')
        ->with('user', $user)
        ->with('order', $order)
        ->with('designs', $design)
        ->with('specs', $specs)
        ->with('units', $units)
        ->with('materials', $materials)
        ->with('sleeves', $sleeves)
        ->with('necks', $necks)
        ->with('designer', $designer)
        ->with('invoicepermanents', $invoicepermanents);
        
    }
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
                $necktype = Neck::find($neckid[$i]);
                $price = Price::where('n_type', '=', $necktype->n_type)
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
        ]); // set cover image max to 1999 because a lot of apache server not allowed user to upload image more than 2mb
        // ------------------ insert data into table order ---------------------------------- //
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
        $order->delivery_date = $deliverydate;
        $order->o_status = $orderstatus;
        $order->u_id_customer = $customerid;
        $order->u_id_designer = $designerid;
        $order->u_id_print = $printid;
        $order->u_id_taylor = $taylorid;
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
                    $unitquantity = $request->input('quantitysinglenamesetname'.$i.'-'.$j); 
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
        $design = new Design;
        $design->o_id = $orderid;
        $design->un_id = $unitid; 
        $design->u_id_designer = $designerid; 
        $design->d_url = $mockupdesign; 
        $design->d_type = $designtype;
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