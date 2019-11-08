<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\LeaveDay;
use App\Leave;
use App\Body;
use App\Neck;
use App\Sleeve;
use App\Material;
use App\DeliverySetting;
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
                    ->where('user.u_status','=',2)
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
        $design = DB::table('orders')
                    ->rightJoin('user', 'orders.u_id_designer', '=', 'user.u_id')
                    ->where('user.u_type', 3)
                    ->where('user.u_status','=',1)
                    ->paginate(5);
    
        $print = DB::table('orders')
                    ->rightJoin('user', 'orders.u_id_print', '=', 'user.u_id')
                    ->where('user.u_type', 5)
                    ->where('user.u_status','=',1)
                    ->paginate(5);
       
        $tailor = DB::table('orders')
                    ->rightJoin('user', 'orders.u_id_taylor', '=', 'user.u_id')
                    ->where('user.u_type', 4)
                    ->where('user.u_status','=',1)
                    ->paginate(5);
         
        return view('admin/staff_performance', compact('design','print','tailor'));
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
        return view('admin/stock_list');
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
        return \View::make('admin/admin_profile');
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
