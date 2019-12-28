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
use App\Reprint;
use App\Notes;
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
                        ->where('active','=','1')
                        ->orderBy('delivery_date', 'asc')
                        ->get();
           // dd($orders); 
            $reprint =  DB::table('reprint')
                        ->join('orders','reprint.o_id','=','orders.o_id')
                        ->join('material', 'orders.material_id', '=', 'material.m_id')
                        ->where('orders.o_status','=','8')
                        ->where('orders.active','=','1')
                        ->where('orders.u_id_designer','=',$u_id)
                        ->orderBy('orders.delivery_date', 'asc')
                        ->get();

            return view('department/joblist',compact('orders','reprint'))->with('department',$department);
        }
        elseif($department==5)
        {
            $orders =  DB::table('orders')
                       ->join('material', 'orders.material_id', '=', 'material.m_id')
                        ->where('orders.o_status','=','4')
                        ->where('orders.u_id_print','=',$u_id)
                        ->where('orders.active','=','1')
                        ->orderBy('delivery_date', 'asc')
                        ->get();
            $reprint =  DB::table('orders')
                       ->join('material', 'orders.material_id', '=', 'material.m_id')
                        ->where('orders.o_status','=','8')
                        ->where('orders.u_id_print','=',$u_id)
                        ->where('orders.active','=','1')
                        ->orderBy('delivery_date', 'asc')
                        ->get();
            //dd($orders);
            return view('department/joblist',compact('orders','reprint'))->with('department',$department);          
        }
        elseif($department==4)
        {
            $orders =  DB::table('orders')
                       ->join('material', 'orders.material_id', '=', 'material.m_id')
                        ->where('orders.o_status','=','6')
                        ->where('orders.u_id_taylor','=',$u_id)
                        ->where('orders.active','=','1')
                        ->orderBy('delivery_date', 'asc')
                        ->get();
            //dd($orders);
            $reprint =  DB::table('orders')
                       ->join('material', 'orders.material_id', '=', 'material.m_id')
                        ->whereIn('orders.o_status',[8,11])
                        ->where('orders.u_id_taylor','=',$u_id)
                        ->where('orders.active','=','1')
                        ->orderBy('delivery_date', 'asc')
                        ->get();
            //dd($reprint);
            return view('department/joblist',compact('orders','reprint'))->with('department',$department);             
        }
        
        return view('department/joblist');
    }    
    
    public function UpdateJob(Request $request) {
        
        $data = $request->all();
        
        
        if($data['page']=="job_design")
        {
            $o_id = $data['oid'];
            $u_id = $data['uid'];
        
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
            $o_id = $data['oid'];
            $u_id = $data['uid'];
        
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
            $o_id = $data['oid'];
            $u_id = $data['uid'];
            
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
        
        if($data['page']=='putDesignLink')
        {
            if($data['operation']=="add")
            {
                DB::table('orders')
                    ->where('o_id', '=', $data['o_id'])
                    ->update(array('design_link' => $data['link'],'updated_at' => DB::raw('now()') ));
                return response()->json(['success'=>'sampai']);
            }

            if($data['operation']=="update")
            {
                DB::table('orders')
                    ->where('o_id', '=', $data['o_id'])
                    ->update(array('design_link' => $data['link'],'updated_at' => DB::raw('now()') ));
                return response()->json(['success'=>'sampai']);
            }
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
       
       $notes = DB::table('notes')
                     ->where('status','=','1')
                     ->where('active','=','1')
                     ->where('o_id','=',$o_id)
                     ->get();
       
       $user = User::all();

       return view('department/job_design',compact('orders','specs','units','design','notes','user'));
       //return view('department/job_design');
       
       /*  job order form     */
       
//       $orders =  DB::table('orders')
//                       ->join('material', 'orders.material_id', '=', 'material.m_id')
//                       ->leftJoin('user', 'orders.u_id_customer', '=', 'user.u_id')
//                       ->where('orders.o_id','=',$o_id)
//                       ->first();
//             
//             $specs = DB::table('spec')
//                     ->leftJoin('body', 'spec.b_id','=','body.b_id')
//                     ->leftJoin('sleeve', 'spec.sl_id', '=', 'sleeve.sl_id')
//                     ->leftJoin('neck', 'spec.n_id','=','neck.n_id')
//                     ->where('spec.o_id','=',$o_id)
//                     ->get();
//             
//             $pic =  DB::table('orders')
//                       ->leftJoin('user', 'orders.u_id_designer', '=', 'user.u_id')
//                       ->where('orders.o_id','=',$o_id)
//                       ->first();
//             
//             $user = User::all();
//             
//             $units = Unit::all();
//             
//             $design = DB::table('design')
//                       ->where('o_id','=',$o_id)
//                       ->first();
//             
//             $designs = DB::table('design')
//                       ->leftJoin('unit','design.o_id','=','unit.o_id')
//                       ->where('design.o_id','=',$o_id)
//                       ->get();
//            //dd($orders);
//            return view('department/job_design',compact('orders','specs','pic','units','design','designs')); 
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
       
       $tailors = DB::table('user')
                        ->where('u_type','=',4)
                        ->where('u_status','=',1)
                        ->get();
       
       $notes = DB::table('notes')
                     ->where('status','=','1')
                     ->where('active','=','1')
                     ->where('o_id','=',$o_id)
                     ->get();
       
       $user = User::all();
             
       //dd($orders);
       return view('department/job_print',compact('orders','specs','units','design','tailors','notes','user'));     
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
       
       $reprint = Reprint::all();
             
       $units = Unit::all();
       
       $notes = DB::table('notes')
                     ->where('status','=','1')
                     ->where('active','=','1')
                     ->where('o_id','=',$o_id)
                     ->get();
       
       $user = User::all();
       //dd($orders);
       return view('department/job_sew',compact('orders','specs','units','reprint','notes','user'));       
    }

    public function updateDesign(Request $request){
        
        $data = $request->all();

        if($data['process']=="design"){
//           $image = $request->file('job');                    
//           $destinationPath = 'orders/confirm/'; // upload path
//           $profileImage = 'confirm'.date('YmdHis') . "." . $image->getClientOriginalExtension();
//           $image->move($destinationPath, $profileImage);
//           $url = $destinationPath.$profileImage;
//               
//           DB::table('design')->insert([
//                  'o_id' => $data['o_id'],
//                  'u_id_designer'=>$data['u_id'],
//                  'un_id'=>$data['un_id'],
//                  'd_url' =>$profileImage,
//                  'd_type'=>'3',
//                  'created_at' => DB::raw('now()'),
//                  'updated_at' => DB::raw('now()')
//                   ]);
//           
//           return redirect('department/job_design/'.$data['o_id'])->with('message', 'Success'); 
            DB::table('unit')
                 ->where('un_id', '=', $data['un_id'])
                 ->update(array('u_id_designer'=>$data['u_id'],                   
                     'un_status'=>'1',
                     'updated_at'=>DB::raw('now()')));
           
            return response()->json(['success'=>'Unit Updated']);
         // return back()->with('success','Order updated');
        }
        if($data['process']=="update")
        {
           DB::table('orders')
                 ->where('o_id', '=', $data['o_id'])
                 ->update(array('o_status'=>'3','updated_at' => DB::raw('now()')));
           
           return Redirect::route('job_list');           
        }
        if($data['process']=="addnote")
        {
           DB::table('notes')->insert([
                     'o_id' => $data['oid'],
                     'u_id'=> $data['uid'],
                     'note'=> $data['note'],
                     'status'=> '1',
                     'active'=> '1',
                     'created_at'=> DB::raw('now()'),
                     'updated_at'=> DB::raw('now()')
                    ]);
        return Redirect::back()->with('message', 'Note added');          
        }
        if($data['process']=="updatenote")
        {
           DB::table('notes')
                 ->where('note_id', '=', $data['note_id'])
                 ->update(array('note'=>$data['note'] ,'updated_at'=> DB::raw('now()')));
           
        return Redirect::back()->with('message', 'Note update');          
        }
        if($data['process']=="deletenote")
        {
           DB::table('notes')
                 ->where('note_id', '=', $data['note_id'])
                 ->update(array('active'=>'0','updated_at' => DB::raw('now()')));
           
           return Redirect::back()->with('message', 'Note deleted');           
        }
        
    }
    
    public function updatePrint(Request $request){

        $data = $request->all();
        
        if($data['process']=="print")
        {

           DB::table('unit')
                 ->where('un_id', '=', $data['un_id'])
                 ->update(array('u_id_print'=>$data['u_id'],                   
                     'un_status'=>'2',
                     'updated_at'=>DB::raw('now()')));
           
           return response()->json(['success'=>'Unit Updated']);
          //return back()->with('success','Order updated');           
        }          
        if($data['process']=="complete")
        {
           DB::table('orders')
                 ->where('o_id', '=', $data['oid'])
                 ->update(array('o_status'=>'6','u_id_taylor'=>$data['tailor'],'updated_at' => DB::raw('now()')));
           
          // dd($data);
           //return response()->json(['success'=>'Order Updated']);
            return Redirect::route('job_list');           
        }        
        
    } 
    
    public function updateSew(Request $request){

        $data = $request->all();
        
        if($data['process']=="sew")
        {

           DB::table('unit')
                 ->where('un_id', '=', $data['un_id'])
                 ->update(array('u_id_taylor'=>$data['u_id'],                   
                     'un_status'=>'3',
                     'updated_at'=>DB::raw('now()')));
           
          return back()->with('success','Order updated');           
        }          
        if($data['process']=="complete")
        {
           DB::table('orders')
                 ->where('o_id', '=', $data['o_id'])
                 ->update(array('o_status'=>'9','updated_at' => DB::raw('now()')));
           
           return Redirect::route('job_list');           
        }
        if($data['process']=="reprint")
        {
           DB::table('orders')
                 ->where('o_id', '=', $data['o_id'])
                 ->update(array('o_status'=>'8','updated_at' => DB::raw('now()')));
           
           DB::table('unit')
                 ->where('un_id', '=', $data['un_id'])
                 ->update(array(                   
                     'un_status'=>'5',
                     'updated_at'=>DB::raw('now()')));
           
           DB::table('reprint')->insert([
                     'un_id' => $data['un_id'],
                     'o_id' => $data['o_id'],
                     'r_quantity'=> $data['quantity'],
                     'r_status'=> '1',
                     'created_at' => DB::raw('now()'),
                     'updated_at' => DB::raw('now()')
                    ]);
          
           DB::table('notes')->insert([
                     'o_id' => $data['o_id'],
                     'u_id'=> $data['uid'],
                     'un_id'=> $data['un_id'],
                     'note'=> $data['reprint_note'],
                     'status'=> '2',
                     'active'=> '1',
                     'created_at'=> DB::raw('now()'),
                     'updated_at'=> DB::raw('now()')
                    ]);
                      
        }

        if($data['process']=="update")
        {
           DB::table('unit')
                 ->where('un_id', '=', $data['un_id'])
                 ->update(array('u_id_taylor'=>$data['u_id'], 'updated_at' => DB::raw('now()')));
           
           DB::table('unit')
                 ->where('un_id', '=', $data['un_id'])
                 ->increment('sewed',  $data['quantity']);
           
           $sewed = Unit::where('un_id',$data['un_id'])->pluck('sewed')->first();
           $quantity = Unit::where('un_id',$data['un_id'])->pluck('un_quantity')->first();
           
           if($sewed == $quantity){
               DB::table('unit')
                 ->where('un_id', '=', $data['un_id'])
                 ->update(array('un_status'=>'3',
                     'updated_at'=>DB::raw('now()')));
           }
           
           return response()->json(['success'=>'Order Updated']);           
        }

        if($data['process']=="delivery")
        {  
           DB::table('unit')
                 ->where('un_id', '=', $data['un_id'])
                 ->increment('delivered',  $data['quantity']);
           
           $delivered = Unit::where('un_id',$data['un_id'])->pluck('delivered')->first();
           $quantity = Unit::where('un_id',$data['un_id'])->pluck('un_quantity')->first();
           
           if($delivered == $quantity){
               DB::table('unit')
                 ->where('un_id', '=', $data['un_id'])
                 ->update(array('un_status'=>'4',
                     'updated_at'=>DB::raw('now()')));
           }
           
           return response()->json(['success'=>'Order Updated']);           
        }           
        
    }
    
    public function viewJobOrder($o_id)
    {
        $orders =  DB::table('orders')
                       ->join('material', 'orders.material_id', '=', 'material.m_id')
                       ->leftJoin('user', 'orders.u_id_customer', '=', 'user.u_id')
                       ->where('orders.o_id','=',$o_id)
                       ->first();
             
             $specs = DB::table('spec')
                     ->leftJoin('body', 'spec.b_id','=','body.b_id')
                     ->leftJoin('sleeve', 'spec.sl_id', '=', 'sleeve.sl_id')
                     ->leftJoin('neck', 'spec.n_id','=','neck.n_id')
                     ->where('spec.o_id','=',$o_id)
                     ->get();
             
             $pic =  DB::table('orders')
                       ->leftJoin('user', 'orders.u_id_designer', '=', 'user.u_id')
                       ->where('orders.o_id','=',$o_id)
                       ->first();
             
             $user = User::all();
             
             $units = Unit::all();
             
             $design = DB::table('design')
                       ->where('o_id','=',$o_id)
                       ->first();
             
             $designs = DB::table('design')
                       ->leftJoin('unit','design.o_id','=','unit.o_id')
                       ->where('design.o_id','=',$o_id)
                       ->get();
            //dd($orders);
            return view('department/department_job_order',compact('orders','specs','pic','units','design','designs')); 
    }
    
    public function caseReprint($o_id) {
 
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
             
       //dd($orders);
       return view('department/job_sew_reprint',compact('orders','specs','units'));  
    }
    
    public function casePrinterReprint($o_id) {
 
       $reprint =  DB::table('orders')
                       ->join('material', 'orders.material_id', '=', 'material.m_id')
                        ->where('orders.o_id','=',$o_id)
                        ->get();
             
       $specs = DB::table('spec')
                     ->leftJoin('body', 'spec.b_id','=','body.b_id')
                     ->leftJoin('sleeve', 'spec.sl_id', '=', 'sleeve.sl_id')
                     ->leftJoin('neck', 'spec.n_id','=','neck.n_id')
                     ->where('spec.o_id','=',$o_id)
                     ->get();
       
       $print = Reprint::all();
       $units = Unit::all();
       $notes = Notes::all();
             
       //dd($orders);
       return view('department/job_print_reprint',compact('reprint','specs','units','print','notes'));  
    }
    
        public function PrinterReprint(Request $request){

        $data = $request->all();
        
        if($data['process']=="print")
        {

           DB::table('unit')
                 ->where('un_id', '=', $data['un_id'])
                 ->update(array(                   
                     'un_status'=>'2',
                     'updated_at'=>DB::raw('now()')));
           
           DB::table('reprint')
                 ->where('un_id', '=', $data['un_id'])
                 ->update(array(                   
                     'r_status'=>'2',
                     'updated_at'=>DB::raw('now()')));
           
           return response()->json(['success'=>'Unit Updated']);
          //return back()->with('success','Order updated');           
        }          
        if($data['process']=="complete")
        {
           DB::table('orders')
                 ->where('o_id', '=', $data['o_id'])
                 ->update(array('o_status'=>'11','updated_at' => DB::raw('now()')));
           
           return Redirect::route('job_list');           
        }        
        
    } 
    
}
