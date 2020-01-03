@php
use App\SystemSetting;

$settings = SystemSetting::first();

if($settings){
$company = $settings->company_name;
$system = $settings->system_name;
}else
{
$company = 'R.D. SOLUTION';
$system = 'Textile Management System';
}
@endphp

<nav class="side-navbar">
      <div class="side-navbar-wrapper">

        <div class="sidenav-header d-flex align-items-center justify-content-center">
          <div class="sidenav-header-inner text-center">
              <!--  <img src="{{ asset('img/avatar-7.jpg') }}" alt="person" class="img-fluid rounded-circle">-->
            <h2 class="h5">{{ $company }}</h2><span>{{ $system }}</span>
          </div>
          <!-- Small Brand information, appears on minimized sidebar-->
          <!--<div class="sidenav-header-logo"><a href="index.html" class="brand-small text-center"> <strong>R</strong><strong class="text-primary">T</strong></a></div>-->
        </div>
       
    @can('isCustomer')
        <div class="customer-menu">
          <ul id="side-main-menu" class="side-menu list-unstyled">                  
            <li><a href="{{ route('customer.home') }}"> <i class="fa fa-plus-square"></i>Add Order</a></li>
            <li><a href="{{ route('customer_orderlist') }}"> <i class="fa fa-list-ol"></i> Order List</a></li>
            <li><a href="{{ route('invoice') }}"> <i class="fa fa-file"></i> Invoice</a></li>
            <li><a href="{{ route('receipt') }}"> <i class="fa fa-file-text-o"></i>Receipt</a></li>
          </ul>
        </div>
    @endcan
    
    @can('isDepartment')
        <div class="department-menu">
          <ul id="side-main-menu" class="side-menu list-unstyled">
            @if(Auth::user()->u_type==5)
            <li><a href="{{ route('department.home') }}"> <i class="fa fa-list-ol"></i> Order List</a></li>
            @endif
            <li><a href="{{ route('job_list') }}"> <i class="fa fa-list"></i> Job List</a></li>
            @if(Auth::user()->u_type ==5)
            <li><a href="{{ route('department.stock') }}"> <i class="icon-screen"> </i> Stock</a></li>
            @endif
            <li><a href="{{ route('performance') }}"> <i class="fa fa-tachometer"></i> Performance</a></li>
            <li><a href="{{ route('leave') }}"> <i class="fa fa-file-text"></i>  Leave Application</a></li>                      
          </ul>
        </div>
    @endcan
    
    @can('isAdmin')
        <div class="admin-menu">
          <ul id="side-admin-menu" class="side-menu list-unstyled">
            <li> <a href="{{ route('admin.dashboard') }}"> <i class="fa fa-dashboard"> </i>Dashboard</a></li>
            <li><a href="#orderDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-plus-square"></i> Order </a>
              <ul id="orderDropdown" class="collapse list-unstyled ">
                <li><a href="{{ route('admin.delivery') }}">Delivery Schedule</a></li>
                <li><a href="{{ route('admin.orderlist') }}">Order List</a></li>
                <li><a href="{{ route('admin.orderhistory') }}">Order History</a></li>
                <li><a href="{{ route('admin.neworder') }}">Add Order</a></li>
                <li><a href="{{ route('admin.ordersetting') }}">Order Setting</a></li>
                <li><a href="{{ route('admin.pricing') }}">Pricing</a></li>                 
              </ul>
            </li> 
            <li><a href="#paymentDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-file"></i>Payment </a>
              <ul id="paymentDropdown" class="collapse list-unstyled ">
                <li><a href="{{ route('admin.payment') }}">Pending Payment</a></li>
                <li><a href="{{ route('admin.invoicelist') }}">Invoice </a></li>
                <li><a href="{{ route('admin.receiptlist') }}">Receipt</a></li>
              </ul>
            </li>
            <li> <a href="{{ route('admin.sale') }}"> <i class="fa fa-money"> </i>Sale</a></li>
            <li> <a href="{{ route('admin.stocklist') }}"> <i class="fa fa-book"> </i>Manage Stock </a></li>
            <li><a href="#manageCustomerDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-user"></i>Customer </a>
              <ul id="manageCustomerDropdown" class="collapse list-unstyled ">
                <li><a href="{{ route('admin.home') }}">End User List</a></li>
                <li><a href="{{ route('admin.agentlist') }}">Agent List</a></li>
                <!-- <li><a href="{{ route('admin.addcustomer') }}">Add End User</a></li>
                <li><a href="{{ route('admin.addagent') }}">Add Agent</a></li>               -->
                <li><a href="{{ route('admin.agentperformance') }}">Agent Performance</a></li>
                <li><a href="{{ route('admin.newapplication') }}">New Application</a></li>
              </ul>
            </li>
            <li><a href="#manageStaffDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-child"></i>Staff </a>
              <ul id="manageStaffDropdown" class="collapse list-unstyled ">
                <li><a href="{{ route('admin.managestaff') }}">Staff List</a></li>
                <li><a href="{{ route('admin.staffapplication') }}">New Application</a></li>
                <!-- <li><a href="{{ route('admin.addstaff') }}">Add Staff</a></li> -->
                <li><a href="{{ route('admin.leavelist') }}">Leave List</a></li>
                <li><a href="{{ route('admin.leaveapplication') }}">Leave Application</a></li>                
                <li><a href="{{ route('admin.leavesetting') }}">Leave Setting</a></li>
                <li><a href="{{ route('admin.staffperformance') }}">Performance</a></li>
              </ul>
            </li>
            <li><a href="#SystemSettingDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-desktop"></i>System Setting </a>
              <ul id="SystemSettingDropdown" class="collapse list-unstyled ">
                <li><a href="{{ route('admin.company_profile') }}">Company Profile</a></li>
<!--                <li><a href="{{-- route('admin.tier_setting') --}}">Tier Setting</a></li>-->
              </ul>
            </li>            
          </ul>
        </div>
    @endcan
    
      </div>
    </nav>