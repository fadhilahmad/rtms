<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Order;
use App\Leave;
use App\LeaveDay;
use App\Design;
use App\Unit;
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
//        $u_id = Auth::id();
        
//        $orders =  DB::table('orders')
//                    ->where('u_id_designer','=','3')
//                    ->where('o_status','=','0')
//                    ->get();
//
//        return view('department/department_orderlist',compact('orders'));
    }
    
    public function performance() 
    {
        $u_id = Auth::user()->u_id;
        $u_type = Auth::user()->u_type;
        $orders = Order::all();
        $unit = Unit::all();
        $design = Design::all();
        
        if($u_type==3)
        {
            $order_completed = $orders->where('u_id_designer',$u_id)->where('o_status','9')->count();
            $unit_completed = $design->where('u_id_designer')->where('d_type','3')->count();
            
             return view('department/performance')->with('unit',$unit_completed)->with('order',$order_completed);
        }
        if($u_type==5)
        {
            $order_completed = $orders->where('u_id_print',$u_id)->where('o_status','9')->count();
            $unit_completed = $unit->where('u_id_print')->whereIn('un_status',['1','2'])->count();
            
             return view('department/performance')->with('unit',$unit_completed)->with('order',$order_completed);
        }
        if($u_type==4)
        {
            $order_completed = $orders->where('u_id_taylor',$u_id)->where('o_status','9')->count();
            $unit_completed = $unit->where('u_id_taylor')->where('un_status','2')->count();
            
             return view('department/performance')->with('unit',$unit_completed)->with('order',$order_completed);
        }        
        
        return view('department/performance');
    }
    
    public function leave() 
    {
        $staff = Auth::user();
        $id = $staff->u_id;
        $days = DB::table('leave_day')->where('u_id', '=', $id)->first();
        
        $leave = DB::table('leave')->where('u_id', '=', $id)->get();
        
        return view('department/leave', compact('staff','days','leave'));
    }
    
    public function leaveApplication(Request $request)
    {
        
        $this->validate($request, [
            'start_date'     => 'required',
            'end_date' => 'required', 
            'reason' => 'required',
        ]);
        
        $data = $request->all();
        
        DB::table('leave')->insert([
                     'u_id' => $data['u_id'],
                     'raeson'=> $data['reason'],
                     'l_type'=> $data['leave_type'],
                     'l_status'=> '2',
                     'apply_date'=> DB::raw('now()'),
                     'start_date'=> $data['start_date'],
                     'end_date'=> $data['end_date'],
                     'updated_date' => DB::raw('now()')
                    ]);
        return redirect('department/leave')->with('message', 'Success');        
    }
    
    public function updateOrder(Request $request){
        
        $data = $request->all();
        $role = $data['role'];
        $u_id = Auth::user()->u_id;
        
        if($role=="designer"){
        
        if ($request->has('design')) {

           $image = $request->file('design');                    
           $destinationPath = 'orders/draft/'; // upload path
           $profileImage = 'draft'.date('YmdHis') . "." . $image->getClientOriginalExtension();
           $image->move($destinationPath, $profileImage);
           $url = $destinationPath.$profileImage;
               
           DB::table('design')->insert([
                  'o_id' => $data['o_id'],
                  'u_id_designer'=>$data['u_id'],
                  'd_url' =>$profileImage,
                  'd_type'=>'2',
                  'created_at' => DB::raw('now()'),
                  'updated_at' => DB::raw('now()')
                   ]);
           
           DB::table('orders')
                 ->where('o_id', '=', $data['o_id'])
                 ->update(array('designer_note' => $data['note'],
                                'o_status'=>'1'));
           
           return redirect('department/department_orderlist')->with('message', 'Success'); 
         } 
        }
        if($role=="print"){
           DB::table('orders')
                 ->where('o_id', '=', $data['oid'])
                 ->update(array('u_id_print' => $u_id,
                                'o_status'=>'4',
                                'updated_at' => DB::raw('now()')));
           DB::table('unit')
                 ->where('o_id', '=', $data['oid'])
                 ->update(array('u_id_print' => $u_id,
                                'updated_at' => DB::raw('now()')));
           
           return redirect('department/joblist');
        }
        if($role=="tailor"){
           DB::table('orders')
                 ->where('o_id', '=', $data['oid'])
                 ->update(array('u_id_taylor' => $u_id,
                                'o_status'=>'6',
                                'updated_at' => DB::raw('now()')));

           DB::table('unit')
                 ->where('o_id', '=', $data['oid'])
                 ->update(array('u_id_taylor' => $u_id,
                                'updated_at' => DB::raw('now()')));           
           
           return redirect('department/joblist');            
        }
    }
}
