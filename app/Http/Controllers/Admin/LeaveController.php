<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\LeaveDay;
use DB;
use Carbon\Carbon;

class LeaveController extends Controller
{
    //
    public function setting(Request $request){
        
        $data = $request->all();
        
        DB::table('leave_day')->insert([
                 'u_id'   => $data['uid'], 
                 'al_day' => $data['alday'],
                 'el_day' => $data['elday'],
                 'mc_day' => $data['mcday'],
                 'created_at' => DB::raw('now()'),
                 'updated_at' => DB::raw('now()')
            ]);
        
        return redirect('admin/leave_day')->with('message', 'success');
    }
    
    public function updateDay(Request $request){
        
        $data = $request->all();
        DB::table('leave_day')
                ->where('u_id', '=', $data['uid'])
                ->update(['al_day'=> $data['alday'],
                    'el_day'=> $data['elday'],
                    'mc_day'=> $data['mcday'],
                    'updated_at'=>DB::raw('now()')
                    ]);
        return redirect('admin/leave_day')->with('message', 'updated');
    }
    
    public function application($id,$type){
        
        if($type==='app')
            {
                DB::table('leave')
                    ->where('l_id', '=', $id)
                    ->update(array('l_status' => 1));

                return redirect('admin/leave_application')->with('message', 'Approved');
            }
        elseif($type==='rej')
            {
                DB::table('leave')
                    ->where('l_id', '=', $id)
                    ->update(array('l_status' => 0));

                return redirect('admin/leave_application')->with('message', 'Rejected');
            }       
        
        return redirect('admin/leave_application');
    }
    
}
