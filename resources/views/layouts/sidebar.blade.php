<nav class="side-navbar">
      <div class="side-navbar-wrapper">

        <div class="sidenav-header d-flex align-items-center justify-content-center">
          <div class="sidenav-header-inner text-center">
              <!--  <img src="{{ asset('img/avatar-7.jpg') }}" alt="person" class="img-fluid rounded-circle">-->
            <h2 class="h5">Rezeal Textile</h2><span>Management System</span>
          </div>
          <!-- Small Brand information, appears on minimized sidebar-->
          <!--<div class="sidenav-header-logo"><a href="index.html" class="brand-small text-center"> <strong>R</strong><strong class="text-primary">T</strong></a></div>-->
        </div>
       
    @can('isCustomer')
        <div class="customer-menu">
          <ul id="side-main-menu" class="side-menu list-unstyled">                  
            <li><a href="neworder"> <i class="fa fa-plus-square"></i>Add Order</a></li>
            <li><a href="customer_orderlist"> <i class="fa fa-list-ol"></i> Order List</a></li>
            <li><a href="invoice"> <i class="fa fa-file"></i> Invoice</a></li>
            <li><a href="receipt"> <i class="fa fa-file-text-o"></i>Receipt</a></li>
          </ul>
        </div>
    @endcan
    
    @can('isDepartment')
        <div class="department-menu">
          <ul id="side-main-menu" class="side-menu list-unstyled">     
            <li><a href="department_orderlist"> <i class="fa fa-list-ol"></i> Order List</a></li>
            <li><a href="joblist"> <i class="fa fa-list"></i> Job List</a></li>
            <li><a href="performance"> <i class="fa fa-tachometer"></i> Performance</a></li>
            <li><a href="leave"> <i class="fa fa-file-text"></i>  Leave Application</a></li>                      
          </ul>
        </div>
    @endcan
    
    @can('isAdmin')
        <div class="admin-menu">
          <ul id="side-admin-menu" class="side-menu list-unstyled"> 
            <li><a href="#manageCustomerDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-user"></i> Manage Customer </a>
              <ul id="manageCustomerDropdown" class="collapse list-unstyled ">
                <li><a href="manage_customer">End User List</a></li>
                <li><a href="agent_list">Agent List</a></li>
                <li><a href="add_customer">Add End User</a></li>
                <li><a href="add_agent">Add Agent</a></li>              
                <li><a href="customer_application">New Application</a></li>
              </ul>
            </li>
            <li><a href="#manageStaffDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-child"></i> Manage Staff </a>
              <ul id="manageStaffDropdown" class="collapse list-unstyled ">
                <li><a href="manage_staff">Staff List</a></li>
                <li><a href="staff_application">New Application</a></li>
                <li><a href="add_newstaff">Add Staff</a></li>
                <li><a href="leave_list">Leave List</a></li>
                <li><a href="leave_application">Leave Application</a></li>                
                <li><a href="leave_day">Leave Setting</a></li>
                <li><a href="staff_performance">Performance</a></li>
              </ul>
            </li>
            <li><a href="#orderDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-plus-square"></i> Order </a>
              <ul id="orderDropdown" class="collapse list-unstyled ">
                <li><a href="order_setting">Order Setting</a></li>
                <li><a href="order_list">Order List</a></li>
              </ul>
            </li>
            <li> <a href="stock_list"> <i class="icon-screen"> </i>Manage Stock </a></li>
            <li><a href="#invoiceDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-file"></i> Invoice </a>
              <ul id="invoiceDropdown" class="collapse list-unstyled ">
                <li><a href="invoice_list">List</a></li>
                <li><a href="invoice_pending">Pending</a></li>
              </ul>
            </li>
            <li><a href="#receiptDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-file-text-o"></i> Receipt </a>
              <ul id="receiptDropdown" class="collapse list-unstyled ">
                <li><a href="receipt_list">List</a></li>
                <li><a href="receipt_pending">Pending</a></li>
              </ul>
            </li>
            <li> <a href="sale"> <i class="fa fa-money"> </i>Sale</a></li>
          </ul>
        </div>
    @endcan
    
      </div>
    </nav>