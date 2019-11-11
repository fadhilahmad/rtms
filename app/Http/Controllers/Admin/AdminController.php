<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\LeaveDay;
use App\Leave;
use App\Body;
use App\Neck;
use App\Sleeve;
use App\Material;
use App\DeliverySetting;
use App\Design;
use App\Unit;
use App\Order;
use DB;

class AdminController extends Controller
{
    //
    
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    //navigation bar
    //manage customer dropdown
    public function addAgent() 
    {
        return \View::make('admin/add_agent');
    }
    
    public function agentList() 
    {
        return \View::make('admin/agent_list');
    }
    
    public function addCustomer() 
    {
        return \View::make('admin/add_customer');
    }
    
    public function customerApplication() 
    {
        //return \View::make('admin/customer_application');
        $customer = User::selectRaw('*')
                    ->where('u_type', 7)
                    ->where('u_status','=',2)
                    ->paginate(10);
                    //->get();
        $agent = User::selectRaw('*')
                    ->where('u_type', 6)
                    ->where('u_status','=',2)
                    ->paginate(10);          

        return view('admin/customer_application', compact('customer','agent'));
    }
    
    //manage staff dropdown
    public function manageStaff() 
    {
        $staffs = User::selectRaw('*')
                    ->whereIn('u_type', array(3,4,5))
                    ->where('u_status','=',1)
                    ->paginate(30);
         

        return view('admin/manage_staff', compact('staffs'));
    }
    
    public function staffApplication() 
    {
        $staff = User::selectRaw('*')
                    ->whereIn('u_type', array(3,4,5))
                    ->where('u_status','=',2)
                    ->paginate(10);        

        return view('admin/staff_application', compact('staff'));
    }
    
    public function addStaff() 
    {
        return \View::make('admin/add_newstaff');
    }
    
    public function leaveList() 
    {
        return \View::make('admin/leave_list');
    }
    
    public function leaveApplication() 
    {
        $leave = DB::table('leave')
                    ->join('user', 'leave.u_id', '=', 'user.u_id')
                    ->where('leave.l_status','=',2)
                    ->paginate(30);         
                
        return view('admin/leave_application', compact('leave'));
    }
    
    public function leaveDay() 
    {
        $staff = DB::table('leave_day')
                    ->rightJoin('user', 'leave_day.u_id', '=', 'user.u_id')
                    ->whereIn('user.u_type', array(3,4,5))
                    ->where('user.u_status','=',1)
                    ->paginate(30); 
         
        return view('admin/leave_day', compact('staff'));
    }
    
    public function staffPerformance() 
    {
        
        $unit = Unit::all();
        $designs = Design::all();
        $order = Order::all();
        $user = DB::table('user')
                    ->where('u_type', 3)
                    ->where('u_status','=',1)
                    ->paginate(5);
    
        $print = DB::table('user')
                    ->where('u_type', 5)
                    ->where('u_status','=',1)
                    ->paginate(5);
       
        $tailor = DB::table('user')
                    ->where('u_type', 4)
                    ->where('u_status','=',1)
                    ->paginate(5);
         
        return view('admin/staff_performance', compact('user','print','tailor','unit','designs','order'));
    }
    
    public function orderSetting() 
    {
        $body = Body::selectRaw('*')
                ->where('b_status','=',1)
                ->get();
    
        $material = Material::selectRaw('*')
                ->where('m_status','=',1)                
                ->get();
 
        $neck = Neck::selectRaw('*')
                ->where('n_status','=',1)                
                ->get();

        $sleeve = Sleeve::selectRaw('*')
                ->get();
        
        $delivery = DeliverySetting::selectRaw('*')
                ->first()
                ->get();
        
        return view('admin/order_setting', compact('body','material','neck','sleeve','delivery'));
    }
    
    public function orderList() 
    {
        $order = DB::table('orders')
                    ->Join('user', 'orders.u_id_customer', '=', 'user.u_id')
                    ->paginate(30);
        
        return view('admin/admin_orderlist',compact('order'));
    }
    
    //manage stock dropdown
    public function stockList() 
    {
        $material = Material::selectRaw('*')
                ->where('m_status','=',1)                
                ->get();
        
        return view('admin/stock_list', compact('material'));
    }
    
    //invoice and receipt dropdown
    public function invoiceList() 
    {
        return \View::make('admin/invoice_list');
    }
    
    public function invoicePending() 
    {
        return \View::make('admin/invoice_pending');
    }
    
    public function receiptList() 
    {
        return \View::make('admin/receipt_list');
    }
    
    public function receiptPending() 
    {
        return \View::make('admin/receipt_pending');
    }
    //sale
    public function sale() 
    {
        return \View::make('admin/sale');
    }
    //profile
    public function adminProfile() 
    {
       // Get the currently authenticated user's ID...
       $admin = Auth::user();
       return view('admin/admin_profile', compact('admin'));

    }
   
    //update profile
    public function updateProfile(Request $request,  $id) 
    {
     
       $admin = User::find($id);
       $admin->u_fullname = $request->input('name');
       $admin->email = $request->input('email');
       $admin->phone = $request->input('phone');
       $admin->address = $request->input('address');      
       $admin->save();
       
       return back()->with('success','Your profile updated successfully');

    }

    //display admin password form
    public function adminChangePassword () 
    {
       $admin = Auth::user();
       
       return view('admin/change_password', compact('admin'));
      
    }

     //change admin password
    public function updateChangePassword (Request $request,  $id) 
    {       
        $this->validate($request, [     
            'old_password'     => 'required',
            'new_password'     => 'required|min:8',
            'confirm_password' => 'required|same:new_password',     
        ]);

        $admin = User::find($id);
        $data = $request->all();

        if(!\Hash::check($data['old_password'], $admin->password)){
            return back()->with('error','You have entered wrong password');              
                } else {       
                    $admin->password = Hash::make($request->input('new_password'));        
            }
        $admin->save();
        return back()->with('success','Your password updated successfully');
    
    }   
    
    public function pricing() 
    {
        $body = Body::selectRaw('*')
                ->where('b_status','=',1)
                ->get();

        $sleeve = Sleeve::selectRaw('*')
                ->get();
        
        return view('admin/pricing', compact('body','sleeve'));
    }
    
   
}
