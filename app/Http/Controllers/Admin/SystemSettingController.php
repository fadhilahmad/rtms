<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SystemSetting;
use App\BankDetail;
use App\ContactNumber;
use DB;
use Illuminate\Support\Facades\File;

class SystemSettingController extends Controller
{
    
    public function CompanyProfile()
    {
        $systemsettings = SystemSetting::all();
        $bankdetails = BankDetail::all();
        $contactdetails = ContactNumber::all();
        return view('admin/system_setting')
        ->with('systemsettings', $systemsettings)
        ->with('bankdetails', $bankdetails)
        ->with('contactdetails', $contactdetails);
    }

    public function UpdateCompanyProfile(Request $request)
    {
        if($request->input('companyname')){
            // company details
            $companyname = $request->input('companyname');
            $systemname = $request->input('systemname');
            $companyaddress = $request->input('companyaddress');
            // bank details
            $bankname = $request->input('bankname');
            $accountname = $request->input('accountname');
            $accountnumber = $request->input('accountnumber');
            // contact details
            $telconame = $request->input('telconame');
            $contactnumber = $request->input('contactnumber');
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
            // system setting db
            $systemsetting = new SystemSetting;
            $systemsetting->company_name = $companyname;
            $systemsetting->system_name = $systemname;
            $systemsetting->company_logo = $companylogo;
            $systemsetting->company_address = $companyaddress;
            $systemsetting->save();
            // bank detail db
            $bankdetail = new BankDetail;
            $bankdetail->bank_name = $bankname;
            $bankdetail->account_name = $accountname;
            $bankdetail->account_number = $accountnumber;
            $bankdetail->save();
            // contact number db
            $contactnumberdb = new ContactNumber;
            $contactnumberdb->telco_name = $telconame;
            $contactnumberdb->contact_number = $contactnumber;
            $contactnumberdb->save();
            return redirect('admin/system_setting')->with('message', 'Company Profile Added!');
        }else{
            $data = $request->all();
            if($data['type']=="update"){
                if($data['table']=="compname"){
                    DB::table('system_setting')
                        ->where('ss_id', '=', $data['id'])
                        ->update(array('company_name' => $data['description']));
                    return redirect('admin/system_setting')->with('message', 'Company Name Updated!');
                }else if($data['table']=="sysname"){
                    DB::table('system_setting')
                        ->where('ss_id', '=', $data['id'])
                        ->update(array('system_name' => $data['description']));
                    return redirect('admin/system_setting')->with('message', 'System Name Updated!');
                }else if($data['table']=="compaddress"){
                    DB::table('system_setting')
                        ->where('ss_id', '=', $data['id'])
                        ->update(array('company_address' => $data['description']));
                    
                    return redirect('admin/system_setting')->with('message', 'Company Address Updated!');
                }else if($data['table']=="complogo"){
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
                }else if($data['table']=="bankname"){
                    DB::table('bank_detail')
                        ->where('bd_id', '=', $data['id'])
                        ->update(array('bank_name' => $data['description']));
                    
                    return redirect('admin/system_setting')->with('message', 'Bank Name Updated!');
                }else if($data['table']=="accname"){
                    DB::table('bank_detail')
                        ->where('bd_id', '=', $data['id'])
                        ->update(array('account_name' => $data['description']));
                    
                    return redirect('admin/system_setting')->with('message', 'Account Name Updated!');
                }else if($data['table']=="accnum"){
                    DB::table('bank_detail')
                        ->where('bd_id', '=', $data['id'])
                        ->update(array('account_number' => $data['description']));
                    
                    return redirect('admin/system_setting')->with('message', 'Account Number Updated!');
                }else if($data['table']=="telconame"){
                    DB::table('contact_number')
                        ->where('cn_id', '=', $data['id'])
                        ->update(array('telco_name' => $data['description']));
                    
                    return redirect('admin/system_setting')->with('message', 'Telco Name Updated!');
                }else if($data['table']=="contactnum"){
                    DB::table('contact_number')
                        ->where('cn_id', '=', $data['id'])
                        ->update(array('contact_number' => $data['description']));
                    
                    return redirect('admin/system_setting')->with('message', 'Contact Number Updated!');
                }else{
                    return redirect('admin/order_setting')->with('message', 'Update Error');
                }
            }
        }
    }
}
