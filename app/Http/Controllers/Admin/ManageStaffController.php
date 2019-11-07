<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DB;

class ManageStaffController extends Controller
{
    public function edit(Request $request)
    {
        $data = $request->all();
        $staff = DB::table('user')
                ->where('u_id', '=', $data['id'])
                ->update(array('u_status' => 0));

        return redirect()->back()->with('message', 'Deleted');
    }
    
    public function approve($id,$type)
    {
        if($type==='app')
            {
                $customer = DB::table('user')
                    ->where('u_id', '=', $id)
                    ->update(array('u_status' => 1));

                return redirect('admin/staff_application')->with('message', 'Approved');
            }
        elseif($type==='rej')
            {
                $customer = DB::table('user')
                ->where('u_id', '=', $id)
                ->update(array('u_status' => 0));

                return redirect('admin/staff_application')->with('message', 'Rejected');
            }
        return redirect('admin/staff_application')->with('message', 'error');
    }
}
