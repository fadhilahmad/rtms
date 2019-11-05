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
Route::get('admin/add_agent', 'Admin\AdminController@agentList')->middleware('admin');
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
