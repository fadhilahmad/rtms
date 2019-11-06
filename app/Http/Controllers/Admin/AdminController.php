<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
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
        return \View::make('admin/manage_staff');
    }
    
    public function staffApplication() 
    {
        return \View::make('admin/staff_application');
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
        return \View::make('admin/leave_application');
    }
    
    public function leaveDay() 
    {
        return \View::make('admin/leave_day');
    }
    
    public function staffPerformance() 
    {
        return \View::make('admin/staff_performance');
    }
    
    //order dropdown
    public function orderSetting() 
    {
        return \View::make('admin/order_setting');
    }
    
    public function orderList() 
    {
        return view('admin/admin_orderlist');
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
    
}
