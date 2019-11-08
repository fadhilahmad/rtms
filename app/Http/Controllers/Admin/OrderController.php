<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Price;

class OrderController extends Controller
{
    //
    public function updateOrderSetting(Request $request){
        
        $data = $request->all();
        
        if($data['type']=="add")
        {
            if($data['table']=="material")
            {
                DB::table('material')->insert([
                     'm_desc' => $data['description'],
                     'm_status'=>'1',
                     'm_stock'=>'0',
                     'created_at' => DB::raw('now()'),
                     'updated_at' => DB::raw('now()')
                    ]);
                return redirect('admin/order_setting')->with('message', 'New material added');
            }
            elseif($data['table']=="body")
            {
                DB::table('body')->insert([
                     'b_desc' => $data['description'],
                     'b_status'=>'1',
                     'created_at' => DB::raw('now()'),
                     'updated_at' => DB::raw('now()')
                    ]);
                return redirect('admin/order_setting')->with('message', 'New body type added');                
            }
            elseif($data['table']=="neck")
            {
                
                $validator=request()->validate([
                        'image_neck' => 'image|mimes:jpeg,png,jpg|max:2048',
                        ]);   

                if ($request->has('neck_image')) {

                    $image = $request->file('neck_image');                    
                    $destinationPath = 'uploads/'; // upload path
                    $profileImage = 'necktype'.date('YmdHis') . "." . $image->getClientOriginalExtension();
                    $image->move($destinationPath, $profileImage);
                    $url = $destinationPath.$profileImage;
               
                    DB::table('neck')->insert([
                        'n_desc' => $data['description'],
                        'n_status'=>'1',
                        'n_url' =>$profileImage,
                        'created_at' => DB::raw('now()'),
                        'updated_at' => DB::raw('now()')
                            ]);
                    return redirect('admin/order_setting')->with('message', 'New neck type added'); 
                } else {
                    return redirect('admin/order_setting')->with('error', 'Error!!!!Please insert image');
                }
            }
            else
            {
                return redirect('admin/order_setting')->with('message', 'Error to add');
            }
                        
        }
        
        if($data['type']=="update")
        {
            if($data['table']=="material")
            {
                DB::table('material')
                    ->where('m_id', '=', $data['id'])
                    ->update(array('m_desc' => $data['description']));
                
                return redirect('admin/order_setting')->with('message', 'Material updated');
            }
            elseif($data['table']=="body")
            {
                DB::table('body')
                    ->where('b_id', '=', $data['id'])
                    ->update(array('b_desc' => $data['description']));
                
                return redirect('admin/order_setting')->with('message', 'Body type updated');
            }
            elseif($data['table']=="neck")
            {
                DB::table('neck')
                    ->where('n_id', '=', $data['id'])
                    ->update(array('n_desc' => $data['description']));
                
                return redirect('admin/order_setting')->with('message', 'Neck type updated');
            }
            elseif($data['table']=="sleeve")
            {
                DB::table('sleeve')
                    ->where('sl_id', '=', $data['id'])
                    ->update(array('sl_desc' => $data['description']));
                
                return redirect('admin/order_setting')->with('message', 'Sleeve type updated');
            }
            elseif($data['table']=="delivery")
            {
                DB::table('delivery_setting')
                    ->where('ds_id', '=', $data['id'])
                    ->update(array('min_day' => $data['description']));
                
                return redirect('admin/order_setting')->with('message', 'Delivery day updated');
            }
            else
            {
                return redirect('admin/order_setting')->with('message', 'Update Error');
            }
        }
        
        if($data['type']=="delete")
        {
            if($data['table']=="material")
            {
                DB::table('material')
                    ->where('m_id', '=', $data['id'])
                    ->update(array('m_status' => '0'));
                
                return redirect('admin/order_setting')->with('message', 'Material deleted');
            }
            elseif($data['table']=="body")
            {
                DB::table('body')
                    ->where('b_id', '=', $data['id'])
                    ->update(array('b_status' => '0'));
                
                return redirect('admin/order_setting')->with('message', 'Body type deleted');
            }
            elseif($data['table']=="neck")
            {
                DB::table('neck')
                    ->where('n_id', '=', $data['id'])
                    ->update(array('n_status' => '0'));
                
                return redirect('admin/order_setting')->with('message', 'Neck type deleted');
            }
            else
            {
                return redirect('admin/order_setting')->with('message', 'Delete Error');
            }            
        }
        
        return redirect('admin/order_setting')->with('message', 'Error');
    }
    
    public static function getPrice($sl_id,$b_id,$n_id,$c_type){
        
//        $price = Price::selectRaw('*')
//                ->where('b_status','=',1)
//                ->get();        
        
        return 'sampai';
    }
}
