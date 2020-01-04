<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('auth/login');
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('job_order/{oid}', 'GeneralController@ViewJobOrder')->name('general.joborder');
Route::get('invoice/{id}', 'GeneralController@ViewInvoice')->name('general.invoice');
Route::get('receipt/{id}', 'GeneralController@ViewReceipt')->name('general.receipt');
Route::post('invoice', 'GeneralController@AlterPrice')->name('general.alterprice');
//////////////////////////////////////////////////////////////ADMIN PAGE///////////////////////////////////////////////////////////////////////
//page manage_customer dropdown
Route::get('admin/manage_customer', 'HomeController@adminHome')->name('admin.home')->middleware('admin');
Route::any('admin/manage_customer','Admin\ManageCustomerController@CustomerList')->middleware('admin');
Route::post('admin/manage_customer','Admin\ManageCustomerController@edit')->name('edit_customer')->middleware('admin');
//page agent_list
Route::get('admin/agent_list', 'Admin\AdminController@agentList')->name('admin.agentlist')->middleware('admin');
Route::any('admin/agent_list','Admin\ManageAgentController@AgentList')->middleware('admin');
Route::post('admin/agent_list','Admin\ManageAgentController@edit')->name('edit_agent')->middleware('admin');
//page add_customer
Route::get('admin/add_customer', 'Admin\AdminController@addCustomer')->name('admin.addcustomer')->middleware('admin');
Route::post('admin/add_customer','Admin\RegisterCustomerController@register')->middleware('admin');
//page add_agent
Route::get('admin/add_agent', 'Admin\AdminController@addAgent')->name('admin.addagent')->middleware('admin');
Route::post('admin/add_agent','Admin\RegisterAgentController@register')->middleware('admin');
//page customer_application
Route::get('admin/customer_application', 'Admin\AdminController@customerApplication')->name('admin.newapplication')->middleware('admin');
Route::get('admin/customer_application/{id}/type/{type}','Admin\ManageCustomerController@approve')->name('approve')->middleware('admin');
//agent performance
Route::get('admin/agent_performance', 'Admin\ManageAgentController@agentPerformance')->name('admin.agentperformance')->middleware('admin');

//manage manage_staff
Route::get('admin/manage_staff', 'Admin\AdminController@manageStaff')->name('admin.managestaff')->middleware('admin');
Route::post('admin/manage_staff','Admin\ManageStaffController@edit')->name('edit_staff')->middleware('admin');
//page staff_application
Route::get('admin/staff_application', 'Admin\AdminController@staffApplication')->name('admin.staffapplication')->middleware('admin');
Route::get('admin/staff_application/{id}/type/{type}','Admin\ManageStaffController@approve')->name('staff_approve')->middleware('admin');
//page add_newstaff
Route::get('admin/add_newstaff', 'Admin\AdminController@addStaff')->name('admin.addstaff')->middleware('admin');
Route::post('admin/add_newstaff','Admin\RegisterStaffController@register')->middleware('admin');
//page leave_list
Route::get('admin/leave_list', 'Admin\AdminController@leaveList')->name('admin.leavelist')->middleware('admin');
//page leave_application
Route::get('admin/leave_application', 'Admin\AdminController@leaveApplication')->name('admin.leaveapplication')->middleware('admin');
Route::post('admin/leave_application','Admin\LeaveController@application')->name('leave_application')->middleware('admin');
//page leave_day
Route::get('admin/leave_day', 'Admin\AdminController@leaveDay')->name('admin.leavesetting')->middleware('admin');
Route::post('admin/leave_day','Admin\LeaveController@setting')->name('leave_setting')->middleware('admin');
Route::post('admin/leave_day2','Admin\LeaveController@updateDay')->name('leave_update')->middleware('admin');
//page staff_performance
Route::get('admin/staff_performance', 'Admin\AdminController@staffPerformance')->name('admin.staffperformance')->middleware('admin');
//page order_setting
Route::get('admin/order_setting','Admin\AdminController@OrderSetting')->name('admin.ordersetting')->middleware('admin');
Route::post('admin/order_setting','Admin\OrderController@updateOrderSetting')->middleware('admin')->name('order_setting');
//page order_list
Route::get('admin/order_list', 'Admin\AdminController@orderList')->name('admin.orderlist')->middleware('admin');
Route::post('admin/order_list', 'Admin\OrderController@deleteOrder')->name('admin.deleteorder')->middleware('admin');
Route::post('admin/order_list/filter', 'Admin\AdminController@filterOrder')->name('admin.filterorder')->middleware('admin');
Route::get('admin/order_list/filter', 'Admin\AdminController@orderList')->middleware('admin');
//page order history
Route::get('admin/order_history', 'Admin\AdminController@orderHistory')->name('admin.orderhistory')->middleware('admin');
Route::post('admin/order_history', 'Admin\AdminController@filterHistory')->name('admin.filterhistory')->middleware('admin');
//page pricing
Route::get('admin/pricing', 'Admin\AdminController@pricing')->name('admin.pricing')->middleware('admin');
Route::post('admin/pricing', 'Admin\OrderController@editPrice')->middleware('admin')->name('admin_pricing');
// //page new order
 Route::get('admin/neworder', 'Admin\AdminController@neworder')->name('admin.neworder')->middleware('admin');
 Route::post('admin/neworder', 'Admin\OrderController@addneworder')->middleware('admin')->name('admin_new_order');
//page stock_list
Route::get('admin/stock_list', 'Admin\AdminController@stockList')->name('admin.stocklist')->middleware('admin');
Route::post('admin/stock_list', 'Admin\OrderController@updateStock')->middleware('admin')->name('manage_stock');
//page invoice_list
Route::get('admin/invoice_list', 'Admin\AdminController@invoiceList')->name('admin.invoicelist')->middleware('admin');
Route::post('admin/invoice_list', 'Admin\PaymentController@addCharges')->middleware('admin');
Route::post('admin/invoice_list/filter', 'Admin\AdminController@invoiceFilter')->name('admin.filterinvoice')->middleware('admin');
Route::get('admin/invoice_list/filter', 'Admin\AdminController@invoiceList')->middleware('admin');
Route::get('admin/invoice_info/{id}', 'Admin\OrderController@invoiceInfo')->name('admin.invoiceinfo')->middleware('admin');
//page invoice_pending
Route::get('admin/invoice_pending', 'Admin\AdminController@invoicePending')->name('admin.invoicepending')->middleware('admin');
//page receipt_list
Route::get('admin/receipt_list', 'Admin\PaymentController@ReceiptList')->name('admin.receiptlist')->middleware('admin');
Route::get('admin/receipt_info/{id}', 'Admin\PaymentController@receiptInfo')->name('admin.receiptinfo')->middleware('admin');
Route::post('admin/receipt_list', 'Admin\PaymentController@filterReceiptList')->name('admin.filterreceiptlist')->middleware('admin');
//page receipt_pending
Route::get('admin/receipt_pending', 'Admin\AdminController@receiptPending')->name('admin.receiptpending')->middleware('admin');
//page sale
Route::get('admin/sale', 'Admin\SaleController@viewSale')->name('admin.sale')->middleware('admin');
Route::post('admin/sale', 'Admin\SaleController@showChart')->name('admin.salechart')->middleware('admin');
//page admin_profile
Route::get('admin/admin_profile', 'Admin\AdminController@adminProfile')->name('admin.profile')->middleware('admin');
Route::patch('admin/admin_profile/update/{id}', 'Admin\AdminController@updateProfile')->name('admin.update')->middleware('admin');
Route::get('admin/change_password', 'Admin\AdminController@adminChangePassword')->name('admin.changePassword')->middleware('admin');
Route::post('admin/change_password', 'Admin\AdminController@updateChangePassword')->name('admin.updatePassword')->middleware('admin');
//order info
Route::get('admin/order_info/{oid}', 'Admin\OrderController@orderInfo')->name('order_info')->middleware('admin');
//page delivery
Route::get('admin/delivery_schedule', 'Admin\DeliveryScheduleController@viewSchedule')->name('admin.delivery')->middleware('admin');

//page payment
Route::get('admin/payment', 'Admin\PaymentController@viewPendingPayment')->name('admin.payment')->middleware('admin');
Route::post('admin/payment', 'Admin\PaymentController@UpdatePayment')->name('admin.updatepayment')->middleware('admin');
Route::post('admin/payment/filter', 'Admin\PaymentController@PendingFilter')->name('admin.filterpayment')->middleware('admin');
Route::get('admin/payment/filter', 'Admin\PaymentController@viewPendingPayment')->middleware('admin');
//job order page
Route::get('admin/job_order/{oid}','Admin\OrderController@orderInfo')->name('order_info')->middleware('admin');
//admin dashboard
Route::get('admin/dashboard','Admin\DashboardController@showDashboard')->name('admin.dashboard')->middleware('admin');
Route::post('admin/dashboard','Admin\DashboardController@filterDashboard')->name('filter.dashboard')->middleware('admin');

//page company profile
Route::get('admin/system_setting','Admin\SystemSettingController@CompanyProfile')->name('admin.company_profile')->middleware('admin');
Route::post('admin/system_setting','Admin\SystemSettingController@UpdateCompanyProfile')->middleware('admin')->name('admin.update_company_profile');
//page update order
Route::get('admin/update_order/{oid}','Admin\AdminController@updateOrder')->name('admin.updateorder')->middleware('admin');
Route::post('admin/update_order', 'Admin\OrderController@updateorder')->name('admin_update_order')->middleware('admin');
//page tier setting
Route::get('admin/tier_setting','Admin\TierController@TierSetting')->name('admin.tier_setting')->middleware('admin');

//////////////////////////////////////////////////////////////DEPARTMENT PAGE///////////////////////////////////////////////////////////////
//page orderlist
Route::get('department/department_orderlist', 'HomeController@departmentHome')->name('department.home')->middleware('department');
Route::post('department/department_orderlist', 'Department\DepartmentController@updateOrder')->name('update_order')->middleware('department');
Route::get('department/staff_profile', 'Department\DepartmentController@staffProfile') ->name('staff.profile')->middleware('department');
Route::patch('department/staff_profile/update/{id}', 'Department\DepartmentController@updateProfile')->name('staff.update')->middleware('department');
Route::get('department/change_password', 'Department\DepartmentController@staffChangePassword')->name('staff.changePassword')->middleware('department');
Route::post('department/change_password', 'Department\DepartmentController@updateChangePassword')->name('staff.updatePassword')->middleware('department');
//page job list
Route::get('department/joblist', 'Department\JobListController@joblist')->name('job_list')->middleware('department');
Route::post('department/joblist', 'Department\JobListController@updateJob')->name('update.job')->middleware('department');
//page job design
Route::get('department/job_design/{oid}', 'Department\JobListController@caseDesigner')->name('job_design')->middleware('department');
Route::post('department/job_design', 'Department\JobListController@updateDesign')->name('update.design')->middleware('department');
//page job print
Route::get('department/job_print/{oid}', 'Department\JobListController@casePrinter')->name('job_print')->middleware('department');
Route::post('department/job_print', 'Department\JobListController@updatePrint')->name('update.print')->middleware('department');
Route::post('department/job_print/{oid}', 'Department\JobListController@updatePrint')->middleware('department');
Route::get('department/job_reprint_print/{oid}', 'Department\JobListController@casePrinterReprint')->name('job_print_reprint')->middleware('department');
Route::post('department/job_reprint_print', 'Department\JobListController@PrinterReprint')->name('print_reprint')->middleware('department');
//page job sew
Route::get('department/job_sew/{oid}', 'Department\JobListController@caseTailor')->name('job_sew')->middleware('department');
Route::get('department/job_reprint/{oid}', 'Department\JobListController@caseReprint')->name('job_reprint')->middleware('department');
Route::post('department/job_sew', 'Department\JobListController@updateSew')->name('update.sew')->middleware('department');
//department job order
Route::get('department/job_order/{oid}', 'Department\JobListController@viewJobOrder')->name('department.joborder')->middleware('department');
//page performance
Route::get('department/performance', 'Department\DepartmentController@performance')->name('performance')->middleware('department');
//page leave
Route::get('department/leave', 'Department\DepartmentController@leave')->name('leave')->middleware('department');
Route::post('department/leave', 'Department\DepartmentController@leaveApplication')->name('department.leave')->middleware('department');
//stock page
Route::get('department/stock', 'Department\DepartmentController@stockList')->name('department.stock')->middleware('department');
Route::post('department/stock', 'Department\DepartmentController@updateStock')->name('department.updatestock')->middleware('department');
//page delivery list
Route::get('department/delivery_list', 'Department\DeliveryController@deliveryList')->name('department.delivery')->middleware('department');
Route::get('department/job_delivery/{oid}', 'Department\DeliveryController@updateDelivery')->name('job_delivery')->middleware('department');
Route::post('department/job_delivery', 'Department\DeliveryController@completeDelivery')->name('update_delivery')->middleware('department');


///////////////////////////////////////////////////////////CUSTOMER PAGE///////////////////////////////////////////////////////////////////

Route::get('customer/customer_profile', 'Customer\CustomerController@customerProfile')->name('customer.profile')->middleware('customer');
Route::patch('customer/customer_profile/update/{id}', 'Customer\CustomerController@updateProfile')->name('customer.update')->middleware('customer');
Route::get('customer/change_password', 'Customer\CustomerController@CustomerChangePassword')->name('customer.changePassword')->middleware('customer');
Route::post('customer/change_password', 'Customer\CustomerController@updateChangePassword')->name('customer.updatePassword')->middleware('customer');
Route::get('customer/customer_orderlist', 'Customer\CustomerController@customerOrderlist')->name('customer_orderlist')->middleware('customer');
// Route::get('customer/invoice', 'Customer\customerController@invoice')->middleware('customer');
// Route::get('customer/receipt', 'Customer\customerController@receipt')->middleware('customer');
// // write route to multiple route (store, index, create, update, show, destroy, edit)
// Route::resource('order', 'Customer\CustomerController');
// route to new order page for customer
Route::get('customer/neworder', 'Customer\CustomerController@newOrder')->name('customer.home')->middleware('customer');
// route to customer order list page for customer
Route::get('customer/orderlist', 'Customer\CustomerController@customerOrderList')->middleware('customer');
//Route::post('customer/orderlist', 'Customer\CustomerController@requestConfirm')->middleware('customer');
Route::post('customer/orderlist','Customer\CustomerController@requestConfirm')->name('customer.orderlist');
// route to customer view mockup image
Route::get('customer/vieworder/{id}', 'Customer\CustomerController@customerViewOrder')->middleware('customer');
// route to customer view design image
Route::get('customer/viewdesign/{id}', 'Customer\CustomerController@customerViewDesign')->middleware('customer');
Route::get('customer/jobOrder/{id}', 'Customer\CustomerController@customerViewJobOrder')->middleware('customer');
// route to invoice page for customer
Route::get('customer/invoice', 'Customer\CustomerController@invoice')->name('invoice')->middleware('customer');
Route::get('customer/view_invoice', 'Customer\CustomerController@viewInvoice')->middleware('customer');
// route to receipt page for customer
Route::get('customer/receipt', 'Customer\CustomerController@receipt')->name('receipt')->middleware('customer');
Route::get('customer/customer_receipt_info/{id}', 'Customer\CustomerController@customerReceiptInfo')->name('customer.customerreceiptinfo')->middleware('customer');
Route::post('customer/neworder', 'Customer\CustomerController@store')->name('customer.store')->middleware('customer');
Route::post('customer/viewinvoice','Customer\CustomerController@viewInvoice')->name('customer.viewinvoice')->middleware('customer');
//Route::post('customer/neworder1', 'Department\PriceCheckingController@BaseOnBodyId')->middleware('customer');
//Route::post('customer/orderlist', 'Customer\CustomerController@requestConfirm')->name('customer.orderlist');
Route::get('customer/addorder', 'Customer\OrderController@OrderForm')->name('addorder')->middleware('customer');

/////////////////////////////////////////////////////////////////REGISTRATION PAGE///////////////////////////////////////////////////
//register agent (by link)
Route::get('register_agent','RegisterAgent@PageRegisterAgent');
Route::post('register_agent','RegisterAgent@register');
//register staff (by link)
Route::get('register_staff','RegisterStaff@pageRegisterStaff');
Route::post('register_staff','RegisterStaff@register');
