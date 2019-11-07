<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// use Illuminate\Support\Facades\Response;
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
        $materials = Material::all();
        $deliverysettings = DeliverySetting::all();
        $bodies = Body::all();
        $sleeves = Sleeve::all();
        $necks = Neck::all();
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

        // // get the user id
        // $user_id = auth()->user()->u_id;
        // $user = User::find($user_id);

        $orders = Order::orderBy('updated_at', 'desc')->paginate(10);
        // $orders = Order::where('u_id_customer', $user_id);


        // // read from order table based on cust id
        // $order = Order::find($user_id);
        // $orderid = Order::where('o_id', $order->o_id);
        // // $orderid = $order->o_id;
        // // read from design table based on order id
        // $design = Design::where('o_id', $orderid);
        // $specs = Spec::where('o_id', $orderid);
        // $units = Unit::where('o_id', $orderid);

        return view('customer/customer_orderlist')->with('orders', $orders);

        
        // ->with('order', $order)
        // ->with('design', $design)
        // ->with('specs', $specs)
        // ->with('units', $units)
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
        // // make validation
        // $this->validate($request, [
        //     'title' => 'required',
        //     'description' => 'required',
        //     'amount' => 'required'
            
        // ]);

        // ------------------ table order (one row) ---------------------------------- //
        // get from form
        $clothname;
        $category;
        $material;
        $totalquantity;
        $note;
        // generated into table
        $refnum;
        // get from form
        $deliverydate;
        // generated into table
        $orderstatus;
        $customerid;
        $designerid;
        $printid;
        $taylorid;
        $datecreatedorder;

        // ------------------ table design (many row) ---------------------------------- //
        // get from other table
        $orderid;
        $unitid;
        $designerid;
        // get from form
        $mockupdesign;
        // generated into table
        $designtype;  // assign 1 (mockup)
        $datecreateddessign;
        

        // ------------------ table spec (many row) ---------------------------------- //
        // get from other table
        $orderid;
        // get from form
        $neckid; // if round neck, assign 0
        $bodyid;
        $sleeveid;
        $collarcolor;
        // generated into table
        $datecreatedspec;

        // ------------------ table unit (many row) ---------------------------------- //
        // get from other table
        $orderid;
        $specid; // need explain, ask os
        // get from form
        $name; // if user choose nameset, assign name. Else assign null
        $size;
        $unitquantity;
        // get from other table
        $printid;
        $taylorid;
        $unitstatus; // assign 0, (uncomplete)
        // generated into table
        $datecreatedunit;


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
        $orderstatus = 0;
        $customerid = 7; // currently auto assign
        $designerid = 3; // currently auto assign
        $printid = 5; // currently auto assign
        $taylorid = 4; // currently auto assign
        // $datecreatedorder; // auto assign to the table

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




        // ------------------ insert data into table design ---------------------------------- //
        // get from other table
        $orderid = $order->o_id;
        $unitid = 2;
        $designerid = 3;
        // get from form
        //$mockupdesign;
        //$mockupdesign = $request->input('cover_image'); // update this later
        // generated into table
        $designtype = 1;  // assign 1 (mockup)
        // $datecreateddessign; // auto assign to the table

        // Create design model
        $design = new Design;

        // insert into table design
        $design->o_id = $orderid;
        $design->un_id = $unitid; // self assign for now
        $design->u_id_designer = $designerid; // self assign for now
        $design->d_url = "mockupdesign"; // self assign for now
        $design->d_type = $designtype;

        // save it
        $design->save();



        // ------------------ insert data into table spec ---------------------------------- //
        // get from other table
        //$orderid = $order->o_id;
        // get from form
        // $neckid; // if round neck, assign 0
        // $bodyid;
        // $sleeveid;
        // $collarcolor;
        // // generated into table
        // $datecreatedspec;

        // // Create spec model
        // $spec = new Spec;

        // $specs = array();

        // // total number of set
        // $totalset = number_format($request->input('setamount'));

        // for($i = 0; $i < $totalset; $i++){

        //     $collartype = $request->input('collartype$i');
        //     if($collartype == "Round Neck"){
        //         $neckid = 0;
        //     }else{
        //         $neckid = $request->input('necktype$i');
        //     }

        //     $bodyid = $request->input('type$i');
        //     $sleeveid = $request->input('sleeve$i');
        //     $collarcolor = $request->input('collar_color$i');

        //     $specs[] = new  Specs([
        //         'o_id' => $orderid,
        //         'n_id' => $neckid,
        //         'b_id' => $bodyid,
        //         'sl_id' => $sleeveid,
        //         'collar_color' => $collarcolor,
        //     ]);

        //     // // Create spec model
        //     // $spec = new Spec;

        //     // // insert into table spec
        //     // $spec->o_id = $orderid;
        //     // $spec->n_id = $neckid; 
        //     // $spec->b_id = $bodyid; 
        //     // $spec->sl_id = $sleeveid;
        //     // $spec->collar_color = $collarcolor;

        //     // // save it
        //     // $spec->save();
            
        // }

        // //save  into the DB
        // $spec->save();
        // $spec->specs()->saveMany($specs);

        // redirect and set success message
        return redirect('/customer/orderlist')->with('success', 'Order Created');





        // ------------------ insert data into table unit ---------------------------------- //
        // get from other table
        $orderid;
        $specid; // need explain, ask os
        // get from form
        $name; // if user choose nameset, assign name. Else assign null
        $size;
        $unitquantity;
        // get from other table
        $printid;
        $taylorid;
        $unitstatus; // assign 0, (uncomplete)
        // generated into table
        $datecreatedunit;



        //'cover_image' => 'image|max:1999|required'

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

        // }else{
        //     $fileNameToStore = 'noimage.jpg';
        // }

        // // create post
        // $post = new Post;

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
        // // get user id that create the order
        // $post->user_id = auth()->user()->id;
        // // insert the cover image into database
        // $post->cover_image = $fileNameToStore;
        // $post->status = "Submitted";
        // $post->delivery = $request->input('delivery');

        // // save it
        // $post->save();

        // $title = $request->input('title');
        // $description = $request->input('description');
        // $gender = $request->input('gender');
        // $size = $request->input('size');
        // $collar = $request->input('collar');
        // $sleeve = $request->input('sleeve');
        // $color = $request->input('color');

        // return "Title: ".$title." Description: ".$description." Gender: ".$gender." Size: ".$size." Collar: ".$collar." Sleeve: ".$sleeve." Color: ".$color;
        // // redirect and set success message
        // return redirect('/home')->with('success', 'Order Created');
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
