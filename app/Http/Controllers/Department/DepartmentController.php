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
    public function staffProfile() 
    {       
        // Get the currently authenticated user's ID...
        $staff = Auth::user();
        return view('department/staff_profile', compact('staff'));
    }

    /* update staff profile */
    public function updateProfile(Request $request,  $id)
    {
      
        $staff = User::find($id);
        $staff->u_fullname = $request->input('name');
        $staff->email = $request->input('email');
        $staff->phone = $request->input('phone');
        $staff->address = $request->input('address');  
        $staff->save();

        return back()->with('success','Your profile updated successfully');
    
    }

    //display staff password form
    public function staffChangePassword () 
    {
        $staff = Auth::user();

        return view('department/change_password', compact('staff'));
    
    }
 
    //change staff password
    public function updateChangePassword (Request $request,  $id) 
    {       
        $this->validate($request, [     
            'old_password'     => 'required',
            'new_password'     => 'required|min:8',
            'confirm_password' => 'required|same:new_password',     
        ]);

        $staff = User::find($id);
        $data = $request->all();

        if(!\Hash::check($data['old_password'], $staff->password)){
            return back()->with('error','You have entered wrong password');
                } else{
                    $staff->password = Hash::make($request->input('new_password'));
        }
        $staff->save();
        return back()->with('success','Your password updated successfully');
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
