<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

use App\User;
use App\Order;
use App\Leave;
use App\LeaveDay;
use App\Unit;
use App\Design;
use DB;

class JobListController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('department');
    }
    
    public function joblist() 
    {
        $u_id = Auth::user()->u_id;
        
        $department = Auth::user()->u_type;

        if($department==3)
        {      
            $orders =  DB::table('orders')
                        ->where('u_id_designer','=',$u_id)
                        ->where('o_status','=','2')
                        ->get();
           // dd($orders);            

            return view('department/joblist',compact('orders'))->with('department',$department);
        }
        elseif($department==5)
        {
            $orders =  DB::table('orders')
                       ->join('material', 'orders.material_id', '=', 'material.m_id')
                        ->where('orders.o_status','=','4')
                        ->where('orders.u_id_print','=',$u_id)
                        ->get();
            //dd($orders);
            return view('department/joblist',compact('orders'))->with('department',$department);          
        }
        elseif($department==4)
        {
            $orders =  DB::table('orders')
                       ->join('material', 'orders.material_id', '=', 'material.m_id')
                        ->where('orders.o_status','=','6')
                        ->where('orders.u_id_taylor','=',$u_id)
                        ->get();
            //dd($orders);
            return view('department/joblist',compact('orders'))->with('department',$department);             
        }
        
        return view('department/joblist');
    }    
    
    public function UpdateJob(Request $request) {
        
        $data = $request->all();
        $o_id = $data['oid'];
        $u_id = $data['uid'];
        
        if($data['page']=="job_design")
        {
             $orders =  DB::table('orders')
                       ->join('material', 'orders.material_id', '=', 'material.m_id')
                        ->where('orders.o_id','=',$o_id)
                        ->get();
             
             $specs = DB::table('spec')
                     ->leftJoin('body', 'spec.b_id','=','body.b_id')
                     ->leftJoin('sleeve', 'spec.sl_id', '=', 'sleeve.sl_id')
                     ->leftJoin('neck', 'spec.n_id','=','neck.n_id')
                     ->where('spec.o_id','=',$o_id)
                     ->get();
             
             $units = Unit::all();
             
             $design = Design::all();
            //dd($orders);
            return view('department/job_design',compact('orders','specs','units','design'));             
            
        }
        if($data['page']=="job_print")
        {
             $orders =  DB::table('orders')
                       ->join('material', 'orders.material_id', '=', 'material.m_id')
                        ->where('orders.o_id','=',$o_id)
                        ->get();
             
             $units = DB::table('unit')
                     ->leftJoin('orders', 'unit.o_id','=','orders.o_id')
                     ->rightJoin('spec', 'orders.o_id', '=', 'spec.o_id')
                     ->rightJoin('neck', 'spec.n_id','=','neck.n_id')
                     ->rightJoin('body', 'spec.b_id','=','body.b_id')
                     ->rightJoin('sleeve', 'spec.sl_id','=','sleeve.sl_id')
                     ->where('unit.o_id','=',$o_id)
                     ->where('orders.u_id_designer','=',$u_id)
                     ->get();
            //dd($orders);
            return view('department/job_print',compact('orders','units'));             
            
        }
        if($data['page']=="job_sew")
        {
             $orders =  DB::table('orders')
                       ->join('material', 'orders.material_id', '=', 'material.m_id')
                        ->where('orders.o_id','=',$o_id)
                        ->get();
             
             $units = DB::table('unit')
                     ->leftJoin('orders', 'unit.o_id','=','orders.o_id')
                     ->rightJoin('spec', 'orders.o_id', '=', 'spec.o_id')
                     ->rightJoin('neck', 'spec.n_id','=','neck.n_id')
                     ->rightJoin('body', 'spec.b_id','=','body.b_id')
                     ->rightJoin('sleeve', 'spec.sl_id','=','sleeve.sl_id')
                     ->where('unit.o_id','=',$o_id)
                     ->where('orders.u_id_designer','=',$u_id)
                     ->get();
            //dd($orders);
            return view('department/job_sew',compact('orders','units'));             
            
        } 
    }
    
    public function caseDesigner($o_id) {
        
       $u_id = Auth::user()->u_id;
       
       $orders =  DB::table('orders')
                       ->join('material', 'orders.material_id', '=', 'material.m_id')
                        ->where('orders.o_id','=',$o_id)
                        ->get();
             
       $specs = DB::table('spec')
                     ->leftJoin('body', 'spec.b_id','=','body.b_id')
                     ->leftJoin('sleeve', 'spec.sl_id', '=', 'sleeve.sl_id')
                     ->leftJoin('neck', 'spec.n_id','=','neck.n_id')
                     ->where('spec.o_id','=',$o_id)
                     ->get();
             
       $units = Unit::all();
             
       $design = Design::all();
             
       //dd($orders);
       return view('department/job_design',compact('orders','specs','units','design'));
       //return view('department/job_design');
    }
    
    public function casePrinter($o_id){
        
       $u_id = Auth::user()->u_id;
       
       $orders =  DB::table('orders')
                       ->join('material', 'orders.material_id', '=', 'material.m_id')
                        ->where('orders.o_id','=',$o_id)
                        ->get();
             
       $specs = DB::table('spec')
                     ->leftJoin('body', 'spec.b_id','=','body.b_id')
                     ->leftJoin('sleeve', 'spec.sl_id', '=', 'sleeve.sl_id')
                     ->leftJoin('neck', 'spec.n_id','=','neck.n_id')
                     ->where('spec.o_id','=',$o_id)
                     ->get();
             
       $units = Unit::all();
             
       $design = Design::all();
             
       //dd($orders);
       return view('department/job_print',compact('orders','specs','units','design'));     
    }
    
    public function caseTailor($o_id){
        
       $u_id = Auth::user()->u_id;
       
       $orders =  DB::table('orders')
                       ->join('material', 'orders.material_id', '=', 'material.m_id')
                        ->where('orders.o_id','=',$o_id)
                        ->get();
             
       $specs = DB::table('spec')
                     ->leftJoin('body', 'spec.b_id','=','body.b_id')
                     ->leftJoin('sleeve', 'spec.sl_id', '=', 'sleeve.sl_id')
                     ->leftJoin('neck', 'spec.n_id','=','neck.n_id')
                     ->where('spec.o_id','=',$o_id)
                     ->get();
             
       $units = Unit::all();
             
       $design = Design::all();
             
       //dd($orders);
       return view('department/job_sew',compact('orders','specs','units','design'));       
    }

    public function updateDesign(Request $request){
        
        $data = $request->all();

        if($data['process']=="design"){
           $image = $request->file('job');                    
           $destinationPath = 'orders/confirm/'; // upload path
           $profileImage = 'confirm'.date('YmdHis') . "." . $image->getClientOriginalExtension();
           $image->move($destinationPath, $profileImage);
           $url = $destinationPath.$profileImage;
               
           DB::table('design')->insert([
                  'o_id' => $data['o_id'],
                  'u_id_designer'=>$data['u_id'],
                  'un_id'=>$data['un_id'],
                  'd_url' =>$profileImage,
                  'd_type'=>'3',
                  'created_at' => DB::raw('now()'),
                  'updated_at' => DB::raw('now()')
                   ]);
           
           return redirect('department/job_design/'.$data['o_id'])->with('message', 'Success');         
        }
        if($data['process']=="update")
        {
           DB::table('orders')
                 ->where('o_id', '=', $data['o_id'])
                 ->update(array('o_status'=>'3','updated_at' => DB::raw('now()')));
           
           return Redirect::route('job_list');           
        }
        
    }
    
    public function updatePrint(Request $request){

        $data = $request->all();
        
//dd($data);
        if($data['process']=="download"){
            
            $d = Design::find($data['d_id']);
            $file = public_path().'/orders/confirm/'.$d->d_url;
            //$filename = '/orders/confirm/'.$d->d_url;
//            dd($d);
//            $headers = array(
//              'Content-Type: multipart/form-data',
//                );

          //return Storage::download($file,$d->d_url,$headers);
          return Storage::disk('public')->download($file,$d->d_url);
          //return response()->download(storage_path("app/public/{$filename}"));
        }
        if($data['process']=="print")
        {

           DB::table('unit')
                 ->where('un_id', '=', $data['un_id'])
                 ->update(array('u_id_print'=>$data['u_id'],                   
                     'un_status'=>'1',
                     'updated_at'=>DB::raw('now()')));
           
          return back()->with('success','Order updated');           
        }          
        if($data['process']=="complete")
        {
           DB::table('orders')
                 ->where('o_id', '=', $data['o_id'])
                 ->update(array('o_status'=>'5','updated_at' => DB::raw('now()')));
           
           return Redirect::route('job_list');           
        }        
        
    } 
    
    public function updateSew(Request $request){

        $data = $request->all();
        
        if($data['process']=="sew")
        {

           DB::table('unit')
                 ->where('un_id', '=', $data['un_id'])
                 ->update(array('u_id_print'=>$data['u_id'],                   
                     'un_status'=>'2',
                     'updated_at'=>DB::raw('now()')));
           
          return back()->with('success','Order updated');           
        }          
        if($data['process']=="complete")
        {
           DB::table('orders')
                 ->where('o_id', '=', $data['o_id'])
                 ->update(array('o_status'=>'7','updated_at' => DB::raw('now()')));
           
           return Redirect::route('job_list');           
        }        
        
    }   
    
}
