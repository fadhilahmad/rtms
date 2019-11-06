<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DB;

class ManageCustomerController extends Controller
{
    //
    public function CustomerList()
    {
        $customer = User::selectRaw('*')
                    ->where('u_type', '=', 7)
                    ->where('u_status','=',1)
                    ->paginate(30);
                    //->get();
                    

        return view('admin/manage_customer', compact('customer'));
    }
    
    public function edit(Request $request)
    {
        $data = $request->all();
        $customer = DB::table('user')
                ->where('u_id', '=', $data['id'])
                ->update(array('u_status' => 0));

        return redirect()->back()->with('message', 'Deleted');
    }
    
    public function applicationList()
    {
        
        $customer = User::selectRaw('*')
                    ->where('u_type', 7)
                    ->where('u_status','=',2)
                    ->paginate(10);
                    //->get();
        $agent = User::selectRaw('*')
                    ->where('u_type', 6)
                    ->where('u_status','=',2)
                    ->paginate(10);          

        return view('admin/customer_application', compact('customer','agent'));
    }
    
    public function approve($id,$type)
    {
        if($type==='app')
            {
                $customer = DB::table('user')
                    ->where('u_id', '=', $id)
                    ->update(array('u_status' => 1));

                return redirect('admin/customer_application')->with('message', 'Approved');
            }
        elseif($type==='rej')
            {
                $customer = DB::table('user')
                ->where('u_id', '=', $id)
                ->update(array('u_status' => 0));

                return redirect('admin/customer_application')->with('message', 'Rejected');
            }
        return redirect('admin/customer_application')->with('message', 'error');
    }

}
