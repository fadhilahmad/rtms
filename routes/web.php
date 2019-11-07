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

//navigation bar for admin
//manage customer dropdown
Route::get('admin/manage_customer', 'HomeController@adminHome')->name('admin.home')->middleware('admin');
Route::get('admin/agent_list', 'Admin\AdminController@agentList')->middleware('admin');
Route::get('admin/add_customer', 'Admin\AdminController@addCustomer')->middleware('admin');
Route::get('admin/add_agent', 'Admin\AdminController@addAgent')->middleware('admin');
Route::get('admin/customer_application', 'Admin\AdminController@customerApplication')->middleware('admin');
//manage staff dropdown
Route::get('admin/manage_staff', 'Admin\AdminController@manageStaff')->middleware('admin');
Route::get('admin/staff_application', 'Admin\AdminController@staffApplication')->middleware('admin');
Route::get('admin/add_newstaff', 'Admin\AdminController@addStaff')->middleware('admin');
Route::get('admin/leave_list', 'Admin\AdminController@leaveList')->middleware('admin');
Route::get('admin/leave_application', 'Admin\AdminController@leaveApplication')->middleware('admin');
Route::get('admin/leave_day', 'Admin\AdminController@leaveDay')->middleware('admin');
Route::get('admin/staff_performance', 'Admin\AdminController@staffPerformance')->middleware('admin');
//order dropdown
Route::get('admin/order_setting', 'Admin\AdminController@orderSetting')->middleware('admin');
Route::get('admin/order_list', 'Admin\AdminController@orderList')->middleware('admin');
//stock
Route::get('admin/stock_list', 'Admin\AdminController@stockList')->middleware('admin');
//invoice and receipt
Route::get('admin/invoice_list', 'Admin\AdminController@invoiceList')->middleware('admin');
Route::get('admin/receipt_list', 'Admin\AdminController@receiptList')->middleware('admin');
Route::get('admin/invoice_pending', 'Admin\AdminController@invoicePending')->middleware('admin');
Route::get('admin/receipt_pending', 'Admin\AdminController@receiptPending')->middleware('admin');
//sale
Route::get('admin/sale', 'Admin\AdminController@sale')->middleware('admin');
//admin profile
Route::get('admin/admin_profile', 'Admin\AdminController@adminProfile')->middleware('admin');

//navigation bar for department
Route::get('department/department_orderlist', 'HomeController@departmentHome')->name('department.home')->middleware('department');
Route::get('department/staff_profile', 'Department\departmentController@staffProfile')->middleware('department');
Route::get('department/joblist', 'Department\departmentController@joblist')->middleware('department');
Route::get('department/performance', 'Department\departmentController@performance')->middleware('department');
Route::get('department/leave', 'Department\departmentController@leave')->middleware('department');

//navigation bar for customer
Route::get('customer/neworder', 'HomeController@customerHome')->name('customer.home')->middleware('customer');
Route::get('customer/customer_profile', 'Customer\customerController@customerProfile')->middleware('customer');
Route::get('customer/customer_orderlist', 'Customer\customerController@customerOrderlist')->middleware('customer');
Route::get('customer/invoice', 'Customer\customerController@invoice')->middleware('customer');
Route::get('customer/receipt', 'Customer\customerController@receipt')->middleware('customer');

//register agent (by link)
Route::get('register_agent','RegisterAgent@PageRegisterAgent');
Route::post('register_agent','RegisterAgent@register');

//register staff (by link)
Route::get('register_staff','RegisterStaff@pageRegisterStaff');
Route::post('register_staff','RegisterStaff@register');

//show and update customer
Route::any('admin/manage_customer','Admin\ManageCustomerController@CustomerList');
Route::post('admin/manage_customer','Admin\ManageCustomerController@edit')->name('edit_customer');

//show and update agent
Route::any('admin/agent_list','Admin\ManageAgentController@AgentList');
Route::post('admin/agent_list','Admin\ManageAgentController@edit')->name('edit_agent');

//new user application (for admin)
//Route::any('admin/customer_application','Admin\ManageCustomerController@applicationList');

//admin register customer
Route::post('admin/add_customer','Admin\RegisterCustomerController@register');

//admin register agent
Route::post('admin/add_agent','Admin\RegisterAgentController@register');

//admin approve reject customer agent application
Route::get('admin/customer_application/{id}/type/{type}','Admin\ManageCustomerController@approve')->name('approve');

//admin edit staff
Route::post('admin/manage_staff','Admin\ManageStaffController@edit')->name('edit_staff');
//admin approve reject staff application
Route::get('admin/staff_application/{id}/type/{type}','Admin\ManageStaffController@approve')->name('staff_approve');
//admin register staff
Route::post('admin/add_newstaff','Admin\RegisterStaffController@register');

//admin leave setting and update and application
Route::post('admin/leave_day','Admin\LeaveController@setting')->name('leave_setting');
Route::post('admin/leave_day2','Admin\LeaveController@updateDay')->name('leave_update');
Route::post('admin/leave_application/{id}/type/{type}','Admin\LeaveController@application')->name('leave_application');