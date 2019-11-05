<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('department');
    }
    
    public function staffProfile() 
    {
        return view('department/staff_profile');
    }
    
    public function departmentOrderlist() 
    {
        return view('department/department_orderlist');
    }
    
    public function joblist() 
    {
        return view('department/joblist');
    }
    
    public function performance() 
    {
        return view('department/performance');
    }
    
    public function leave() 
    {
        return view('department/leave');
    }
}
