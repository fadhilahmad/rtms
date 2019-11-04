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

Route::get('admin/manage_customer', 'HomeController@adminHome')->name('admin.home')->middleware('admin');

Route::get('department/department_orderlist', 'HomeController@departmentHome')->name('department.home')->middleware('department');

Route::get('customer/neworder', 'HomeController@customerHome')->name('customer.home')->middleware('customer');
