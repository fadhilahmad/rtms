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
use App\BlockDay;
use App\BlockDate;
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
use App\SystemSetting;
use App\BankDetail;
use App\ContactNumber;
use Gate;
use DB;
class CustomerController extends Controller
{

    private $errbody;
    private $errsleeve = 0;
    private $errneck = 0;

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
        return view('customer/change_password');
     }
 
     //change admin password
     public function updateChangePassword (Request $request) 
     {       
//         $this->validate($request, [     
//             'old_password'     => 'required',
//             'new_password'     => 'required|min:8',
//             'confirm_password' => 'required|same:new_password',     
//         ]);
         
        $data = $request->all();
        
        $id = Auth::id();
        $user = User::find($id);
        
        if(!Hash::check($data['old_password'], $user->password))
        {
            return back()->with('error','Your current password is incorrect!');              
        }
        elseif($data['new_password'] <> $data['confirm_password'])
        {
            return back()->with('error','New password and confirm password did not match!');
        }
        else 
        {       
            $user->password = Hash::make($request->input('new_password'));
            $user->save();
            
            return back()->with('success','Your new password updated successfully');
        } 
     
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
        $deliverysettings = DeliverySetting::select('min_day')->first();
        $blockdays = BlockDay::select('day')->where('bd_status', 1)->get();
        $blockdates = BlockDate::select('date')->get();
        $bodies = Body::where('b_status', 1)->get();
        $sleeves = Sleeve::where('sl_status', 1)->get();
        $necks = Neck::where('n_status', 1)->get();
        $prices = Price::all();
        // return view with all the data from the tables
        return view('customer/neworder')
        ->with('materials', $materials)
        ->with('deliverysettings', $deliverysettings)
        ->with('blockdays', $blockdays)
        ->with('blockdates', $blockdates)
        ->with('bodies', $bodies)
        ->with('sleeves', $sleeves)
        ->with('necks', $necks)
        ->with('prices', $prices);
    }
    // method to view order list page for customer based on customer id
    public function customerOrderList()
    {
        // get the user id
        $user_id = auth()->user()->u_id;
        $user = User::find($user_id);
        // get order id with status draft
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
        $orders =  DB::table('orders')
                ->join('material', 'orders.material_id', '=', 'material.m_id')
                ->leftJoin('user', 'orders.u_id_customer', '=', 'user.u_id')
                ->where('orders.o_id','=',$order_id)
                ->first();
        $specs = DB::table('spec')
                ->leftJoin('body', 'spec.b_id','=','body.b_id')
                ->leftJoin('sleeve', 'spec.sl_id', '=', 'sleeve.sl_id')
                ->leftJoin('neck', 'spec.n_id','=','neck.n_id')
                ->where('spec.o_id','=',$order_id)
                ->get();
        $pic =  DB::table('orders')
                ->leftJoin('user', 'orders.u_id_designer', '=', 'user.u_id')
                ->where('orders.o_id','=',$order_id)
                ->first();
        $user = User::all();
        $units = Unit::all();
        $design = DB::table('design')
                ->where('o_id','=',$order_id)
                ->first();
        $designs = DB::table('design')
                ->leftJoin('unit','design.o_id','=','unit.o_id')
                ->where('design.o_id','=',$order_id)
                ->get();
        return view('customer.cust_job_order',compact('orders','specs','pic','units','design','designs')); 
    }
    // method to view invoice page for customer
    public function invoice()
    {
        $user_id = auth()->user()->u_id;
        
        $invoice = DB::table('invoice')
                    ->leftJoin('orders', 'invoice.o_id', '=', 'orders.o_id')
                    ->leftJoin('user', 'orders.u_id_customer', '=', 'user.u_id')
                ->where('orders.active','=','1')
                ->where('orders.u_id_customer','=',$user_id)
                    ->paginate(30);
        
        return view('customer/invoice', compact('invoice'));
    }
    // method to view or print invoice details
    public function viewInvoice(Request $request){
        $o_id = $request->input('orderid');
        $systemsettings = SystemSetting::all();
        $bankdetails = BankDetail::all();
        $contactdetails = ContactNumber::all();
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
        return view('customer/view_invoice',compact('orders','specs','user','units','invoice','invoice_p','charges'))
        ->with('systemsettings', $systemsettings)
        ->with('bankdetails', $bankdetails)
        ->with('contactdetails', $contactdetails);
    }
    // method to view receipt page for customer
    public function receipt()
    {
        $user_id = auth()->user()->u_id;
        
        $receipts = DB::table('receipt')
                ->leftJoin('orders','receipt.o_id','=','orders.o_id')
                ->leftJoin('user','orders.u_id_customer','=','user.u_id')
                ->where('receipt.re_status','=','1')
                ->where('orders.u_id_customer','=',$user_id)
                ->paginate(30);
        $user = User::all();
        return view('customer/receipt',compact('receipts','user'));
        // return view('customer/receipt');
    }
    // method for customer view receipt details
    public function customerReceiptInfo($id)
    {
            $receipts = DB::table('receipt')
                ->leftJoin('orders','receipt.o_id','=','orders.o_id')
                ->leftJoin('user','orders.u_id_customer','=','user.u_id')
                ->where('receipt.re_id','=',$id)
                ->first();
            return view('customer/customer_receipt_info',compact('receipts'));        
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
            'cover_image' => 'image|required'
        ]); 
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
        $customerid = auth()->user()->u_id;
        $customername = auth()->user()->username;
        $active = 1;
        $designerid; 
        $printid = null;
        $taylorid = null; 

        $filenameWithExt;
        $originalname;
        $filename;
        $image;                 
        $destinationPath; 
        $profileImage;

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
        //$order->category = "will del";
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
        $boolprice = $this->requestConfirm($orderid);
        if($boolprice != false){
            $this->storeDesign($idunit, $mockupdesign, $orderid, $designerid, $image, $destinationPath, $profileImage); 
            return redirect('/customer/orderlist')->with('message', 'Order Submitted');
        }else{
            $errbodydesc = Body::where('b_id', $this->errbody)
                ->pluck('b_desc')->toArray();
            $errsleevedesc = Sleeve::where('sl_id', $this->errsleeve)
                ->pluck('sl_desc')->toArray();
            return redirect('/customer/neworder')->with('message', 'Error! Price for set "'.$errbodydesc[0].'" and "'.$errsleevedesc[0].'" that you\'ve selected is not placed by admin. Please contact admin');
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
    public function requestConfirm($orderid){
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