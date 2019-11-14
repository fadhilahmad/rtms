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
    return view('welcome');
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
//////////////////////////////////////////////////////////////ADMIN PAGE///////////////////////////////////////////////////////////////////////
//page manage_customer dropdown
Route::get('admin/manage_customer', 'HomeController@adminHome')->name('admin.home')->middleware('admin');
Route::any('admin/manage_customer','Admin\ManageCustomerController@CustomerList');
Route::post('admin/manage_customer','Admin\ManageCustomerController@edit')->name('edit_customer');
//page agent_list
Route::get('admin/agent_list', 'Admin\AdminController@agentList')->name('admin.agentlist')->middleware('admin');
Route::any('admin/agent_list','Admin\ManageAgentController@AgentList');
Route::post('admin/agent_list','Admin\ManageAgentController@edit')->name('edit_agent');
//page add_customer
Route::get('admin/add_customer', 'Admin\AdminController@addCustomer')->name('admin.addcustomer')->middleware('admin');
Route::post('admin/add_customer','Admin\RegisterCustomerController@register');
//page add_agent
Route::get('admin/add_agent', 'Admin\AdminController@addAgent')->name('admin.addagent')->middleware('admin');
Route::post('admin/add_agent','Admin\RegisterAgentController@register');
//page customer_application
Route::get('admin/customer_application', 'Admin\AdminController@customerApplication')->name('admin.newapplication')->middleware('admin');
Route::get('admin/customer_application/{id}/type/{type}','Admin\ManageCustomerController@approve')->name('approve');
//manage manage_staff
Route::get('admin/manage_staff', 'Admin\AdminController@manageStaff')->name('admin.managestaff')->middleware('admin');
Route::post('admin/manage_staff','Admin\ManageStaffController@edit')->name('edit_staff');
//page staff_application
Route::get('admin/staff_application', 'Admin\AdminController@staffApplication')->name('admin.staffapplication')->middleware('admin');
Route::get('admin/staff_application/{id}/type/{type}','Admin\ManageStaffController@approve')->name('staff_approve');
//page add_newstaff
Route::get('admin/add_newstaff', 'Admin\AdminController@addStaff')->name('admin.addstaff')->middleware('admin');
Route::post('admin/add_newstaff','Admin\RegisterStaffController@register');
//page leave_list
Route::get('admin/leave_list', 'Admin\AdminController@leaveList')->name('admin.leavelist')->middleware('admin');
//page leave_application
Route::get('admin/leave_application', 'Admin\AdminController@leaveApplication')->name('admin.leaveapplication')->middleware('admin');
Route::post('admin/leave_application','Admin\LeaveController@application')->name('leave_application')->middleware('admin');
//page leave_day
Route::get('admin/leave_day', 'Admin\AdminController@leaveDay')->name('admin.leavesetting')->middleware('admin');
Route::post('admin/leave_day','Admin\LeaveController@setting')->name('leave_setting');
Route::post('admin/leave_day2','Admin\LeaveController@updateDay')->name('leave_update');
//page staff_performance
Route::get('admin/staff_performance', 'Admin\AdminController@staffPerformance')->name('admin.staffperformance')->middleware('admin');
//page order_setting
Route::get('admin/order_setting','Admin\AdminController@OrderSetting')->name('admin.ordersetting')->middleware('admin');
Route::post('admin/order_setting','Admin\OrderController@updateOrderSetting')->middleware('admin')->name('order_setting');
//page order_list
Route::get('admin/order_list', 'Admin\AdminController@orderList')->name('admin.orderlist')->middleware('admin');
//page pricing
Route::get('admin/pricing', 'Admin\AdminController@pricing')->name('admin.pricing')->middleware('admin');
Route::post('admin/pricing', 'Admin\OrderController@editPrice')->middleware('admin')->name('admin_pricing');
//page stock_list
Route::get('admin/stock_list', 'Admin\AdminController@stockList')->name('admin.stocklist')->middleware('admin');
Route::post('admin/stock_list', 'Admin\OrderController@updateStock')->middleware('admin')->name('manage_stock');
//page invoice_list
Route::get('admin/invoice_list', 'Admin\AdminController@invoiceList')->name('admin.invoicelist')->middleware('admin');
//page invoice_pending
Route::get('admin/invoice_pending', 'Admin\AdminController@invoicePending')->name('admin.invoicepending')->middleware('admin');
//page receipt_list
Route::get('admin/receipt_list', 'Admin\AdminController@receiptList')->name('admin.receiptlist')->middleware('admin');
//page receipt_pending
Route::get('admin/receipt_pending', 'Admin\AdminController@receiptPending')->name('admin.receiptpending')->middleware('admin');
//page sale
Route::get('admin/sale', 'Admin\AdminController@sale')->name('admin.sale')->middleware('admin');
//page admin_profile
Route::get('admin/admin_profile', 'Admin\AdminController@adminProfile')->name('admin.profile')->middleware('admin');
Route::patch('admin/admin_profile/update/{id}', 'Admin\AdminController@updateProfile')->name('admin.update')->middleware('admin');
Route::get('admin/change_password', 'Admin\AdminController@adminChangePassword')->name('admin.changePassword')->middleware('admin');
Route::patch('admin/change_password/update/{id}', 'Admin\AdminController@updateChangePassword')->name('admin.updatePassword')->middleware('admin');
//order info
Route::get('admin/order_info/{oid}', 'Admin\OrderController@orderInfo')->name('order_info')->middleware('admin');

//test route 
Route::get('/jobOrder', function () {
    return view('admin.job_order');
});


//////////////////////////////////////////////////////////////DEPARTMENT PAGE///////////////////////////////////////////////////////////////
//page orderlist
Route::get('department/department_orderlist', 'HomeController@departmentHome')->name('department.home')->middleware('department');
Route::post('department/department_orderlist', 'Department\DepartmentController@updateOrder')->name('update_order')->middleware('department');
Route::get('department/staff_profile', 'Department\departmentController@staffProfile') ->name('staff.profile')->middleware('department');
Route::patch('department/staff_profile/update/{id}', 'Department\departmentController@updateProfile')->name('staff.update')->middleware('department');
Route::get('department/change_password', 'Department\departmentController@staffChangePassword')->name('staff.changePassword')->middleware('department');
Route::patch('department/change_password/update/{id}', 'Department\departmentController@updateChangePassword')->name('staff.updatePassword')->middleware('department');
//page job list
Route::get('department/joblist', 'Department\JobListController@joblist')->name('job_list')->middleware('department');
Route::post('department/joblist', 'Department\JobListController@updateJob')->name('update.job')->middleware('department');
//page job design
Route::get('department/job_design/{oid}', 'Department\JobListController@caseDesigner')->name('job_design')->middleware('department');
Route::post('department/job_design', 'Department\JobListController@updateDesign')->name('update.design')->middleware('department');
//page job print
Route::get('department/job_print/{oid}', 'Department\JobListController@casePrinter')->name('job_print')->middleware('department');
Route::post('department/job_print', 'Department\JobListController@updatePrint')->name('update.print')->middleware('department');
//page job sew
Route::get('department/job_sew/{oid}', 'Department\JobListController@caseTailor')->name('job_sew')->middleware('department');
Route::post('department/job_sew', 'Department\JobListController@updateSew')->name('update.sew')->middleware('department');
//page performance
Route::get('department/performance', 'Department\departmentController@performance')->name('performance')->middleware('department');
//page leave
Route::get('department/leave', 'Department\departmentController@leave')->name('leave')->middleware('department');
Route::post('department/leave', 'Department\departmentController@leaveApplication')->name('department.leave')->middleware('department');
///////////////////////////////////////////////////////////CUSTOMER PAGE///////////////////////////////////////////////////////////////////
//Route::get('customer/neworder', 'HomeController@customerHome')->name('customer.home')->middleware('customer');
Route::get('customer/customer_profile', 'Customer\customerController@customerProfile')->middleware('customer');
Route::patch('customer/customer_profile/update/{id}', 'Customer\customerController@updateProfile')->name('customer.update')->middleware('customer');
Route::get('customer/change_password', 'Customer\customerController@customerChangePassword')->name('customer.changePassword')->middleware('customer');
Route::patch('customer/change_password/update/{id}', 'Customer\customerController@updateChangePassword')->name('customer.updatePassword')->middleware('customer');
Route::get('customer/customer_orderlist', 'Customer\customerController@customerOrderlist')->middleware('customer');
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
Route::get('customer/invoice', 'Customer\CustomerController@invoice')->middleware('customer');
Route::get('customer/view_invoice', 'Customer\CustomerController@viewInvoice')->middleware('customer');
// route to receipt page for customer
Route::get('customer/receipt', 'Customer\CustomerController@receipt')->middleware('customer');
Route::post('customer/neworder', 'Customer\CustomerController@store')->name('customer.store');
Route::post('customer/viewinvoice','Customer\CustomerController@viewInvoice')->name('customer.viewinvoice');
//Route::post('customer/orderlist', 'Customer\CustomerController@requestConfirm')->name('customer.orderlist');
/////////////////////////////////////////////////////////////////REGISTRATION PAGE///////////////////////////////////////////////////
//register agent (by link)
Route::get('register_agent','RegisterAgent@PageRegisterAgent');
Route::post('register_agent','RegisterAgent@register');
//register staff (by link)
Route::get('register_staff','RegisterStaff@pageRegisterStaff');
Route::post('register_staff','RegisterStaff@register');