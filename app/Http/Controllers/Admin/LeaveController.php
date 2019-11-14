<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\LeaveDay;
use App\Leave;
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
    
    public function application(Request $request){
        
        $data = $request->all();
        
       // dd($data);
        if($data['function']==='approve')
            {
        $leave = LeaveDay::selectRaw('*')
                ->where('u_id','=',$data['uid'])
                ->first();
        
            if($data['leave_type']=='1')
            {
                $al = $leave->al_day;
                $day = $data['total_day'];
                $bal = $al-$day;
            
                DB::table('leave_day')
                    ->where('u_id', '=', $data['uid'])
                    ->update(['al_day'=> $bal,
                    'updated_at'=>DB::raw('now()')
                    ]);
                
                 DB::table('leave')
                    ->where('l_id', '=', $data['id'])
                    ->update(array('l_status' => 1));

                return redirect('admin/leave_application')->with('message', 'Approved');               
                
            }
            elseif($data['leave_type']=='2')
            {
                $el = $leave->el_day;
                $day = $data['total_day'];
                $bal = $el-$day;
            
                DB::table('leave_day')
                    ->where('u_id', '=', $data['uid'])
                    ->update(['el_day'=> $bal,
                    'updated_at'=>DB::raw('now()')
                    ]);
                
                 DB::table('leave')
                    ->where('l_id', '=', $data['id'])
                    ->update(array('l_status' => 1));

                return redirect('admin/leave_application')->with('message', 'Approved');                   
            }
            elseif($data['leave_type']=='3')
            {
                $mc = $leave->mc_day;
                $day = $data['total_day'];
                $bal = $mc-$day;
            
                DB::table('leave_day')
                    ->where('u_id', '=', $data['uid'])
                    ->update(['mc_day'=> $bal,
                    'updated_at'=>DB::raw('now()')
                    ]);
                
                 DB::table('leave')
                    ->where('l_id', '=', $data['id'])
                    ->update(array('l_status' => 1));

                return redirect('admin/leave_application')->with('message', 'Approved');                   
            }        

            }
        elseif($data['function']==='reject')
            {
                DB::table('leave')
                    ->where('l_id', '=', $data['id'])
                    ->update(array('l_status' => 0));

                return redirect('admin/leave_application')->with('message', 'Rejected');
            }
        elseif($data['function']==='download')
            {               
                return response()->download($data['file_url']);               
            }            
        
        return redirect('admin/leave_application');
    }
    
}
