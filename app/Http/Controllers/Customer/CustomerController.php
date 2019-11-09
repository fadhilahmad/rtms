<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Response;
// use Illuminate\Support\Facades\File;
// // use the storage library
// use Illuminate\Support\Facades\Storage;
// bring in 'Order' model
use App\Order;
// bring in 'Material' model
use App\Material;
// bring in 'DeliverySetting' model
use App\DeliverySetting;
// bring in 'Body' model
use App\Body;
// bring in 'Sleeve' model
use App\Sleeve;
// bring in 'Neck' model
use App\Neck;
// bring in 'Design' model
use App\Design;
// bring in 'Spec' model
use App\Spec;
// bring in 'Unit' model
use App\Unit;
// bring in 'User' model
use App\User;
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
        return view('customer/customer_profile');
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
            // $orderid = Order::where('o_id', $orders->o_id)->get();
            //$orders = Order::where('u_id_customer', $user_id);  ->where('u_status', 1)
            
            // get 
            //$designdraft = Design::where('o_id', $orderiddraft)->get();

            // $material = Order::where('o_id', $orderid)->get();
            // $materialid = $material->pluck('m_id');
            // $materialname = Material::find($materialid);

            return view('customer/customer_orderlist')
            ->with('orders', $orders)
            ->with('ordersdraft', $ordersdraft)
            ->with('orderspending', $orderspending);
        }else{
            return view('customer/customer_orderlist')->with('orders', $orders);
        }
        


        //var_dump($orders);

        // // read from order table based on cust id
        // $order = Order::find($user_id);
        // $orderid = Order::where('o_id', $order->o_id);
        // // $orderid = $order->o_id;
        // // read from design table based on order id
        // $design = Design::where('o_id', $orderid);
        // $specs = Spec::where('o_id', $orderid);
        // $units = Unit::where('o_id', $orderid);
        
        // ->with('order', $order)
        // ->with('design', $design)
        // ->with('specs', $specs)
        // ->with('units', $units)
    }

    public function requestConfirm(Request $request){


        //-------------------- confirm design ----------------------//
        $orderidrequest = $request->input('orderid');
        //$orderpendingid = $id;

        var_dump($orderidrequest);

        if($orderidrequest != null){

            DB::table('orders')
                        ->where('o_id', '=', $orderidrequest)
                        ->update(array('o_status'=>'2'));
                
                return redirect('customer/customer_orderlist')->with('message', 'Order confirmed');

        }else{

            //-------------------- request redesign ----------------------//
            $data = $request->all();
            
            if ($request->has('design')) {

                //var_dump($data['uid']);

                $image = $request->file('design');                    
                $destinationPath = 'orders/draft/'; // upload path
                $profileImage = 'draft'.date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $url = $destinationPath.$profileImage;
                    
                DB::table('design')->insert([
                        'o_id' => $data['o_id'],
                        'u_id_designer'=>$data['u_id'],
                        'd_url' =>$profileImage,
                        'd_type'=>'2',
                        'created_at' => DB::raw('now()'),
                        'updated_at' => DB::raw('now()')
                        ]);
                
                DB::table('orders')
                        ->where('o_id', '=', $data['o_id'])
                        ->update(array('designer_note' => $data['note'],
                                        'o_status'=>'10'));
                
                return redirect('customer/customer_orderlist')->with('message', 'Request redesign submitted'); 
            }   

        }


        
        
        // // get the user id
        // $user_id = auth()->user()->u_id;
        // $user = User::find($user_id);

        // // get order id with status draft
        // $ordercustdraft = Order::where('u_id_customer', $user_id)->where('o_status', '!=' , 1)->orWhereNull('o_status')->get();
        // $orderiddraft = $ordercustdraft->pluck('o_id')->all();
        // $ordersdraft = Order::find($orderiddraft);

        // // get order id with status pending
        // $ordercustpending = Order::where('u_id_customer', $user_id)->where('o_status', 1)->get();
        // $orderidpending = $ordercustpending->pluck('o_id')->all();
        // $orderspending = Order::find($orderidpending);

        // // get all order
        // $orders = Order::all();

        // if($orders != null){

        //     return view('customer/customer_orderlist')
        //     ->with('orders', $orders)
        //     ->with('ordersdraft', $ordersdraft)
        //     ->with('orderspending', $orderspending);
        // }
    }

    // method to view invoice page for customer
    public function customerViewOrder($order_id)
    {
        // // read from order table based on cust id
        // $order = Order::find($user_id);
        // $orderid = Order::where('o_id', $order->o_id);
        // // $orderid = $order->o_id;
        // read from design table based on order id
        $design = Design::where('o_id', $order_id)->get();
        $spec = Spec::where('o_id', $order_id)->get();
        $unit = Unit::where('o_id', $order_id)->get();

        // $design = Design::find($order_id);
        // $specs = Spec::find($order_id);
        // $units = Unit::find($order_id);


        $order = Order::find($order_id);
        return view('customer/customer_view_order')
        ->with('order', $order)
        ->with('design', $design)
        ->with('spec', $spec)
        ->with('unit', $unit);
        
    }

    // method to view invoice page for customer
    public function invoice()
    {
        return view('customer/invoice');
    }

    // method to view receipt page for customer
    public function receipt()
    {
        return view('customer/receipt');
    }

// -------------------------------------- Add order to db --------------------------------------------------

    /**
     * Display a listing of the resource. 
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // // use ant of the 'Post' model function(using eloquent(ORM))
        // //$posts = Post::all(); // fetch all the data in 'Post' model/table

        // // set limit to view on page to different tyep of users
        // if(Gate::allows('isManager')){
        //     $posts = Post::orderBy('updated_at', 'desc')->paginate(10);  // paginate page to 10 data per page
        // }else if(Gate::allows('isAdmin')){
        //     $posts = Post::orderBy('updated_at', 'desc')->paginate(10);  
        // }else if(Gate::allows('isDesigner')){
        //     $posts = Post::where('status', 'Submitted')->orWhere('status', 'Drafted')->orWhere('status', 'Accepted')
        //         ->orWhere('status', 'Rejected')->orderBy('updated_at', 'desc')->paginate(10); 
        // }else if(Gate::allows('isMoulder')){
        //     $posts = Post::where('status', 'Designed')->orderBy('updated_at', 'desc')->paginate(10);  
        // }else if(Gate::allows('isTailor')){
        //     $posts = Post::where('status', 'Mouldered')->orWhere('status', 'Tailored')->orderBy('updated_at', 'desc')->paginate(10);  
        // }else if(Gate::allows('isHR')){
        //     $posts = Post::orderBy('updated_at', 'desc')->paginate(10);  
        // }else{
        //     // else customer
        //     abort(404, "Sorry, you cannot do this action");
        // }

        
        // // return view of index file with 'posts' table data
        // return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // // set limit to view on page to different tyep of users
        // if(!Gate::allows('isCustomer')){
        //     abort(404, "Sorry, you cannot do this action");
        // }

        // // load create view
        // return view('posts.create');
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
        // get from form
        $clothname = $request->input('cloth_name');
        $category = $request->input('category');
        $material = $request->input('material');
        $totalquantity = $request->input('total_quantity');
        $note = $request->input('note');
        // generated into table
        $refnum = 3; // currently auto assign
        // get from form
        $deliverydate = $request->input('somedate');
        // generated into table
        $orderstatus = 0; // set to drafted
        $customerid = auth()->user()->u_id;
        $designerid; 
        $printid = null; // currently auto assign
        $taylorid = null; // currently auto assign
        // // $datecreatedorder; // auto assign to the table

        //var_dump("--------------- customer id ------------ Customer ID: ".$customerid);

        // assign order design to designer
        // get all designer id
        $userdesigner = User::where('u_type', 3)->where('u_status', 1)->pluck('u_id')->toArray();

        // $totaldesigner = count($userdesigner);
        
        // for($i = 0; $i < $totaldesigner; $i++){
        //     var_dump("--------------- id designer ------------ ID: ".$userdesigner[$i]);
        // }
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

        // save it
        $order->save();

        // ------------------ insert data into table spec ---------------------------------- //
        // get from other table
        $orderid = $order->o_id;
        // get from form
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
            
        }

        // ------------------ insert data into table unit and design ---------------------------------- //
        
        // get from form
        $name; // if user choose nameset, assign name. Else assign null
        $size;
        $unitquantity;
        // get from other table
        // $printid = null;  // self generate for now
        // $taylorid = null;  // self generate for now
        $unitstatus = 0; // assign 0, (uncomplete)
        // // generated into table
        // $datecreatedunit;

        if($category == "Nameset"){

            // get total nameset
            if(number_format($request->input('totalcasenameset')) == 0){
                $totalcasenameset = 1;
            }else{
                // total number of nameset
                $totalcasenameset = number_format($request->input('totalcasenameset'));
            }
            //var_dump("--------------- unit nameset ------------Total Case Nameset: ".$totalcasenameset);

            for($i = 0; $i < $totalcasenameset; $i++){

                // Create unit model
                $unit = new Unit;
    
                $name = $request->input('name'.$i);
                $size = $request->input('size'.$i);
                $unitquantity = $request->input('quantitysinglenameset'.$i); 
    
                // insert into table unit
                $unit->o_id = $orderid;
                $unit->name = $name; 
                $unit->size = $size; 
                $unit->un_quantity = $unitquantity;
                $unit->u_id_print = $printid;
                $unit->u_id_taylor = $taylorid;
                $unit->un_status = $unitstatus;
    
                // save it
                $unit->save();

                // // handle file upload
                // if($request->hasFile('cover_image')){

                //     // get the file name with the extension
                //     $filenameWithExt = $request->file('cover_image')->getClientOriginalName();

                //     // get just file name
                //     $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

                //     // get just extension
                //     $extension = $request->file('cover_image')->getClientOriginalExtension();

                //     // create filename to store
                //     $mockupdesign = $filename.'_'.time().'.'.$extension;

                //     // upload the image
                //     $destinationPath = 'orders/mockup';
                //     $image = $request->file('cover_image');
                //     $image->move($destinationPath, $mockupdesign);

                //     //$path = $request->file('cover_image')->storeAs('public/mockup_images', $fileNameToStore);
                //     // this will store to storage/app/public
                //     // Storage::disk('public')->put($cover->getFilename().'.'.$extension,  File::get($cover));

                //     // $image = $request->file('cover_image');                    
                //     // $destinationPath = 'orders/mockup'; // upload path
                //     // $profileImage = 'mockup'.date('YmdHis') . "." . $image->getClientOriginalExtension();
                //     // //Storage::disk($destinationPath)->put($profileImage, $image);
                //     // $image->move($destinationPath, $profileImage);
                //     //$url = $destinationPath.$profileImage;

                //     // if (!$image->move($destinationPath, $profileImage)) {
                //     //     // return 'Error saving the file.';
                //     //     var_dump("error save file");
                //     // }else{
                //     //     var_dump("Image: ", $image);
                //     // }

                // }else{
                //     $mockupdesign = 'noimage.jpg';
                //     var_dump("no file");
                // }

                // // store to design table
                // $idunit = $unit->un_id;
                // $this->storeDesign($idunit, $mockupdesign, $orderid, $designerid);
                
            }

            

        }else{

            $xxs = $request->input('quantitysinglexxs');
            $xs = $request->input('quantitysinglexs');
            $s = $request->input('quantitysingles');
            $m = $request->input('quantitysinglem');
            $l = $request->input('quantitysinglel');
            $xl = $request->input('quantitysinglexl');
            $xl2 = $request->input('quantitysingle2xl');
            $xl3 = $request->input('quantitysingle3xl');
            $xl4 = $request->input('quantitysingle4xl');
            $xl5 = $request->input('quantitysingle5xl');
            $xl6 = $request->input('quantitysingle6xl');
            $xl7 = $request->input('quantitysingle7xl');

            // if($request->hasFile('cover_image')){
            //     $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            //     $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //     $extension = $request->file('cover_image')->getClientOriginalExtension();
            //     $mockupdesign = $filename.'_'.time().'.'.$extension;
            //     // upload the image
            //     $destinationPath = 'orders/mockup';
            //     $image = $request->file('cover_image');
            //     $image->move($destinationPath, $mockupdesign);
            // }else{
            //     $mockupdesign = 'noimage.jpg';
            // }

            if($xxs != 0){
                $name = null;
                $size = "xxs";
                $unitquantity = $xxs; 
                $unit = new Unit; 
                $unit->o_id = $orderid;
                $unit->name = $name; 
                $unit->size = $size; 
                $unit->un_quantity = $unitquantity;
                $unit->u_id_print = $printid;
                $unit->u_id_taylor = $taylorid;
                $unit->un_status = $unitstatus; 
                $unit->save(); 
                // $idunit = $unit->un_id;
                // $this->storeDesign($idunit, $mockupdesign, $orderid, $designerid); 
            }
            if($xs != 0){
                $name = null;
                $size = "xs";
                $unitquantity = $xs; 
                $unit = new Unit; 
                $unit->o_id = $orderid;
                $unit->name = $name; 
                $unit->size = $size; 
                $unit->un_quantity = $unitquantity;
                $unit->u_id_print = $printid;
                $unit->u_id_taylor = $taylorid;
                $unit->un_status = $unitstatus; 
                $unit->save(); 
                // $idunit = $unit->un_id;
                // $this->storeDesign($idunit, $mockupdesign, $orderid, $designerid);
            }
            if($s != 0){
                $name = null;
                $size = "s";
                $unitquantity = $s; 
                $unit = new Unit; 
                $unit->o_id = $orderid;
                $unit->name = $name; 
                $unit->size = $size; 
                $unit->un_quantity = $unitquantity;
                $unit->u_id_print = $printid;
                $unit->u_id_taylor = $taylorid;
                $unit->un_status = $unitstatus; 
                $unit->save(); 
                // $idunit = $unit->un_id;
                // $this->storeDesign($idunit, $mockupdesign, $orderid, $designerid);
            }
            if($m != 0){
                $name = null;
                $size = "m";
                $unitquantity = $m; 
                $unit = new Unit; 
                $unit->o_id = $orderid;
                $unit->name = $name; 
                $unit->size = $size; 
                $unit->un_quantity = $unitquantity;
                $unit->u_id_print = $printid;
                $unit->u_id_taylor = $taylorid;
                $unit->un_status = $unitstatus; 
                $unit->save(); 
                // $idunit = $unit->un_id;
                // $this->storeDesign($idunit, $mockupdesign, $orderid, $designerid);
            }
            if($l != 0){
                $name = null;
                $size = "l";
                $unitquantity = $l; 
                $unit = new Unit; 
                $unit->o_id = $orderid;
                $unit->name = $name; 
                $unit->size = $size; 
                $unit->un_quantity = $unitquantity;
                $unit->u_id_print = $printid;
                $unit->u_id_taylor = $taylorid;
                $unit->un_status = $unitstatus; 
                $unit->save(); 
                // $idunit = $unit->un_id;
                // $this->storeDesign($idunit, $mockupdesign, $orderid, $designerid);
            }
            if($xl != 0){
                $name = null;
                $size = "xl";
                $unitquantity = $xl; 
                $unit = new Unit; 
                $unit->o_id = $orderid;
                $unit->name = $name; 
                $unit->size = $size; 
                $unit->un_quantity = $unitquantity;
                $unit->u_id_print = $printid;
                $unit->u_id_taylor = $taylorid;
                $unit->un_status = $unitstatus; 
                $unit->save(); 
                // $idunit = $unit->un_id;
                // $this->storeDesign($idunit, $mockupdesign, $orderid, $designerid);
            }
            if($xl2 != 0){
                $name = null;
                $size = "2xl";
                $unitquantity = $xl2; 
                $unit = new Unit; 
                $unit->o_id = $orderid;
                $unit->name = $name; 
                $unit->size = $size; 
                $unit->un_quantity = $unitquantity;
                $unit->u_id_print = $printid;
                $unit->u_id_taylor = $taylorid;
                $unit->un_status = $unitstatus; 
                $unit->save(); 
                // $idunit = $unit->un_id;
                // $this->storeDesign($idunit, $mockupdesign, $orderid, $designerid);
            }
            if($xl3 != 0){
                $name = null;
                $size = "3xl";
                $unitquantity = $xl3; 
                $unit = new Unit; 
                $unit->o_id = $orderid;
                $unit->name = $name; 
                $unit->size = $size; 
                $unit->un_quantity = $unitquantity;
                $unit->u_id_print = $printid;
                $unit->u_id_taylor = $taylorid;
                $unit->un_status = $unitstatus; 
                $unit->save(); 
                // $idunit = $unit->un_id;
                // $this->storeDesign($idunit, $mockupdesign, $orderid, $designerid);
            }
            if($xl4 != 0){
                $name = null;
                $size = "4xl";
                $unitquantity = $xl4; 
                $unit = new Unit; 
                $unit->o_id = $orderid;
                $unit->name = $name; 
                $unit->size = $size; 
                $unit->un_quantity = $unitquantity;
                $unit->u_id_print = $printid;
                $unit->u_id_taylor = $taylorid;
                $unit->un_status = $unitstatus; 
                $unit->save(); 
                // $idunit = $unit->un_id;
                // $this->storeDesign($idunit, $mockupdesign, $orderid, $designerid);
            }
            if($xl5 != 0){
                $name = null;
                $size = "5xl";
                $unitquantity = $xl5; 
                $unit = new Unit; 
                $unit->o_id = $orderid;
                $unit->name = $name; 
                $unit->size = $size; 
                $unit->un_quantity = $unitquantity;
                $unit->u_id_print = $printid;
                $unit->u_id_taylor = $taylorid;
                $unit->un_status = $unitstatus; 
                $unit->save();
                // $idunit = $unit->un_id;
                // $this->storeDesign($idunit, $mockupdesign, $orderid, $designerid);
            }
            if($xl6 != 0){
                $name = null;
                $size = "6xl";
                $unitquantity = $xl6;
                $unit = new Unit;
                $unit->o_id = $orderid;
                $unit->name = $name; 
                $unit->size = $size; 
                $unit->un_quantity = $unitquantity;
                $unit->u_id_print = $printid;
                $unit->u_id_taylor = $taylorid;
                $unit->un_status = $unitstatus;
                $unit->save();
                // $idunit = $unit->un_id;
                // $this->storeDesign($idunit, $mockupdesign, $orderid, $designerid);
            }
            if($xl7 != 0){
                $name = null;
                $size = "7xl";
                $unitquantity = $xl7;
                $unit = new Unit;
                $unit->o_id = $orderid;
                $unit->name = $name; 
                $unit->size = $size; 
                $unit->un_quantity = $unitquantity;
                $unit->u_id_print = $printid;
                $unit->u_id_taylor = $taylorid;
                $unit->un_status = $unitstatus;
                $unit->save();
                // $idunit = $unit->un_id;
                // $this->storeDesign($idunit, $mockupdesign, $orderid, $designerid);
            }

        }

        // handle file upload
        if($request->hasFile('cover_image')){

            // get the file name with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();

            // get just file name
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            // get just extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();

            // create filename to store
            $mockupdesign = $filename.'_'.time().'.'.$extension;

            // upload the image
            $destinationPath = 'orders/mockup';
            $image = $request->file('cover_image');
            $image->move($destinationPath, $mockupdesign);

        }else{
            $mockupdesign = 'noimage.jpg';
            var_dump("no file");
        }

        // store to design table
        $idunit = null;
        $this->storeDesign($idunit, $mockupdesign, $orderid, $designerid);

        // redirect and set success message
        return redirect('/customer/orderlist')->with('success', 'Order Created');

    }

    // function to store data to table design
    public function storeDesign($unitid, $mockupdesign, $orderid, $designerid){

        // $designerid = 3; // self assign for now

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
        // // read from order table based on cust id
        // $order = Order::find($custid);
        // $orderid = $order->o_id;
        // // read from design table based on order id
        // $design = Design::where('o_id', $orderid);
        // $specs = Spec::where('o_id', $orderid);
        // $units = Unit::where('o_id', $orderid);

        // return view('customer/customer_orderlist')
        // ->with('order', $order)
        // ->with('design', $design)
        // ->with('specs', $specs)
        // ->with('units', $units);

        //-------------------------------------------------------------------------

        // // fetch data based on id from database
        // $post = Post::find($id);

        // // return show page
        // return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // // set limit to view on page to different admin
        // if(!Gate::allows('isAdmin') && !Gate::allows('isManager')){
        //     abort(404, "Sorry, you cannot do this action");
        // }
        
        // // fetch data based on id from database
        // $post = Post::find($id);

        // // return edit page
        // return view('posts.edit')->with('post', $post);
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
        // // make validation
        // $this->validate($request, [
        //     'title' => 'required',
        //     'description' => 'required',
        //     'amount' => 'required',
        //     'cover_image' => 'image|max:1999|nullable'
        // ]);

        // // handle file upload
        // if($request->hasFile('cover_image')){

        //     // get the file name with the extension
        //     $filenameWithExt = $request->file('cover_image')->getClientOriginalName();

        //     // get just file name
        //     $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        //     // get just extension
        //     $extension = $request->file('cover_image')->getClientOriginalExtension();

        //     // create filename to store
        //     $fileNameToStore = $filename.'_'.time().'.'.$extension;

        //     // upload the image
        //     $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);

        // }

        // // fetch data based on id from database
        // $post = Post::find($id);

        // // add out var value and get it from submitted form
        // $post->title = $request->input('title');
        // $post->description = $request->input('description');
        // $post->gender = $request->input('gender');
        // $post->size = $request->input('size');
        // $post->collar = $request->input('collar');
        // $post->sleeve = $request->input('sleeve');
        // $post->color = $request->input('color');
        // // features array
        // if($request->features != null){
        //     $post->features = implode(", ", $request->features);
        // }else{
        //     $post->features = 'no feature';
        // }

        // $post->material = $request->input('material');
        // $post->amount = $request->input('amount');
        // // get user id that update the order
        // // $post->user_id = auth()->user()->id;
        // // insert the cover image into database
        // //$post->cover_image = $fileNameToStore;
        

        // if($request->hasFile('cover_image')){
        //     if($post->cover_image != 'noimage.jpg'){
        //         // Delete image with storage object delete()
        //         Storage::delete('public/cover_images/'.$post->cover_image);
        //     }
        //     $post->cover_image = $fileNameToStore;
        // }

        // $post->status = $request->input('status');
        // $post->delivery = $request->input('delivery');

        // // save it
        // $post->save();

        // // redirect and set success message
        // return redirect('/posts')->with('success', 'Order Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // // find the post by it's @id that has been passed in
        // $post = Post::find($id);

        // // check for correct user
        // // if(auth()->user()->id !== $post->user_id){
        // //     return redirect('/posts')->with('error', 'Unauthorized Page');
        // // }

        // // we don't want the 'no_image' to disappear because we gonna need that in case someone upload new post without an image
        // if($post->cover_image != 'noimage.jpg'){
        //     // Delete image with storage object delete()
        //     Storage::delete('public/cover_images/'.$post->cover_image);
        // }

        // // simply delete it
        // $post->delete();
        // // redirect back to post
        // return redirect('/posts')->with('success', 'Order Removed');
    }

}
