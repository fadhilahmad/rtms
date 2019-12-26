<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Order;
use DB;

class ManageAgentController extends Controller
{
    //
    public function AgentList()
    {
        $agent = User::selectRaw('*')
                    ->whereIn('u_type', [6,8,9])
                    ->where('u_status','=',1)
                    ->paginate(30);
                    //->get();
                    

        return view('admin/agent_list', compact('agent'));
    }
    
    public function edit(Request $request)
    {
        $data = $request->all();
        
        if($data['function']=='delete'){
        $customer = DB::table('user')
                ->where('u_id', '=', $data['id'])
                ->update(array('u_status' => 0));

        return redirect()->back()->with('message', 'Deleted');
        }
        
        if($data['function']=='update'){
        $customer = DB::table('user')
                ->where('u_id', '=', $data['id'])
                ->update(array('u_type' => $data['tier']));

        return redirect()->back()->with('message', 'Updated');
        }
    }
    
    public function agentPerformance()
    {
        $agent = User::selectRaw('*')
                    ->whereIn('u_type', [6,8,9])
                    ->where('u_status','=',1)
                    ->paginate(30);
        
        $orders = Order::all();
        
        return view('admin/agent_performance',compact('agent','orders'));
    }
}
