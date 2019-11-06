<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DB;

class ManageAgentController extends Controller
{
    //
    public function AgentList()
    {
        $agent = User::selectRaw('*')
                    ->where('u_type', '=', 6)
                    ->where('u_status','=',1)
                    ->paginate(30);
                    //->get();
                    

        return view('admin/agent_list', compact('agent'));
    }
    
    public function edit(Request $request)
    {
        $data = $request->all();
        $customer = DB::table('user')
                ->where('u_id', '=', $data['id'])
                ->update(array('u_status' => 0));

        return redirect()->back()->with('message', 'Deleted');
    }
}
