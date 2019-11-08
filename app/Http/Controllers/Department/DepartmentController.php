<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use DB;

class DepartmentController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('department');
    }

    /* display staff profile */
    public function staffProfile(Request $request) 
    {       
        // Get the currently authenticated user's ID...
        $staff = Auth::user();
        return view('department/staff_profile', compact('staff'));
    }

    /* update staff profile */
    public function updateProfile(Request $request,  $id)
    {
        // dd($request);
        $this->validate($request, [          
            'password' => 'nullable|string|min:8|confirmed',
        ]);
  
        $staff = User::find($id);
        $staff->u_fullname = $request->input('name');
        $staff->email = $request->input('email');
        $staff->phone = $request->input('phone');
        $staff->address = $request->input('address');
       
        if(!empty($request->input('password')))
        {
            $staff->password = Hash::make($request->input('password'));
        }
        $staff->save();
        // return back(); 
        return redirect()->route('staff.profile')
                         ->with ('success','profile updated successfully');    
    
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
