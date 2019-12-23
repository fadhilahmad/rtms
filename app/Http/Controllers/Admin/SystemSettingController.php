<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SystemSetting;
use DB;
use Illuminate\Support\Facades\File;

class SystemSettingController extends Controller
{
    
    public function CompanyProfile()
    {
        $systemsettings = SystemSetting::all();
        return view('admin/system_setting')
        ->with('systemsettings', $systemsettings);
    }

    public function UpdateCompanyProfile(Request $request)
    {
        if($request->input('companyname')){
            $companyname = $request->input('companyname');
            $systemname = $request->input('systemname');
            $companyaddress = $request->input('companyaddress');
            var_dump($companyname);
            var_dump($systemname);
            var_dump($companyaddress);
            if($request->hasFile('companylogo')){
                $filenameWithExt = $request->file('companylogo')->getClientOriginalName();
                $originalname = $request->file('companylogo')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $image = $request->file('companylogo');                    
                $destinationPath = 'img/logo/'; 
                $profileImage = 'complogo-'.$filename.'-'.date('YmdHis') . "." . $image->getClientOriginalExtension();
                $url = $destinationPath.$profileImage;
                $companylogo = $profileImage;
                $image->move($destinationPath, $profileImage);
            }else{
                $companylogo = 'nologo.jpg';
            }
            $systemsetting = new SystemSetting;
            $systemsetting->company_name = $companyname;
            $systemsetting->system_name = $systemname;
            $systemsetting->company_logo = $companylogo;
            $systemsetting->company_address = $companyaddress;
            $systemsetting->save();
            return redirect('admin/system_setting')->with('message', 'Company Profile Added!');
        }else{
            $data = $request->all();
            if($data['type']=="update")
            {
                if($data['table']=="compname")
                {
                    DB::table('system_setting')
                        ->where('ss_id', '=', $data['id'])
                        ->update(array('company_name' => $data['description']));
                    return redirect('admin/system_setting')->with('message', 'Company Name Updated!');
                }
                elseif($data['table']=="sysname")
                {
                    DB::table('system_setting')
                        ->where('ss_id', '=', $data['id'])
                        ->update(array('system_name' => $data['description']));
                    return redirect('admin/system_setting')->with('message', 'System Name Updated!');
                }
                elseif($data['table']=="compaddress")
                {
                    DB::table('system_setting')
                        ->where('ss_id', '=', $data['id'])
                        ->update(array('company_address' => $data['description']));
                    
                    return redirect('admin/system_setting')->with('message', 'Company Address Updated!');
                }
                elseif($data['table']=="complogo")
                {
                    if ($request->has('complogo')) {
                        // Folder path to be flushed 
                        $folder_path = "img/logo"; 
                        // List of name of files inside specified folder 
                        $files = glob($folder_path.'/*');  
                        // Deleting all the files in the list 
                        foreach($files as $file) { 
                            if(is_file($file))  
                                // Delete the given file 
                                unlink($file);  
                        } 
                        $image = $request->file('complogo');                    
                        $destinationPath = 'img/logo/'; // upload path
                        $profileImage = 'complogo'.date('YmdHis') . "." . $image->getClientOriginalExtension();
                        $image->move($destinationPath, $profileImage);
                        $url = $destinationPath.$profileImage;
                        DB::table('system_setting')
                            ->where('ss_id', '=', $data['id'])
                            ->update(array('company_logo' => $profileImage));
                        return redirect('admin/system_setting')->with('message', 'Company Logo Updated!');
                    } 
                }
                else
                {
                    return redirect('admin/order_setting')->with('message', 'Update Error');
                }
            }
        }
    }
}
