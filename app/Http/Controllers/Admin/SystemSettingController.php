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
        if($request->input('banknameadd')){
            $banknameadd = $request->input('banknameadd');
            $accountnameadd = $request->input('accountnameadd');
            $accountnumberadd = $request->input('accountnumberadd');
            for($i = 0; $i < count($banknameadd); $i++){
                $bankdetail = new BankDetail;
                $bankdetail->bank_name = $banknameadd[$i];
                $bankdetail->account_name = $accountnameadd[$i];
                $bankdetail->account_number = $accountnumberadd[$i];
                $bankdetail->save();
            }
            return redirect('admin/system_setting')->with('message', 'New Bank Details Added!');
        }

        if($request->input('telconameadd')){
            $telconameadd = $request->input('telconameadd');
            $contactnumberadd = $request->input('contactnumberadd');
            for($i = 0; $i < count($telconameadd); $i++){
                $contactnumberdb = new ContactNumber;
                $contactnumberdb->telco_name = $telconameadd[$i];
                $contactnumberdb->contact_number = $contactnumberadd[$i];
                $contactnumberdb->save();
            }
            return redirect('admin/system_setting')->with('message', 'New Contact Details Added!');
        }

        if($request->input('deletebank')){
            $bankid = $request->input('deletebank');
            $bankdetail = BankDetail::find($bankid);
            $bankdetail->delete();
            return redirect('admin/system_setting')->with('message', 'Bank Details Deleted!');
        }

        if($request->input('deletecontact')){
            $contactid = $request->input('deletecontact');
            $contactdetail = ContactNumber::find($contactid);
            $contactdetail->delete();
            return redirect('admin/system_setting')->with('message', 'Contact Details Deleted!');
        }

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
            for($i = 0; $i < count($bankname); $i++){
                $bankdetail = new BankDetail;
                $bankdetail->bank_name = $bankname[$i];
                $bankdetail->account_name = $accountname[$i];
                $bankdetail->account_number = $accountnumber[$i];
                $bankdetail->save();
            }

            // contact number db
            for($i = 0; $i < count($telconame); $i++){
                $contactnumberdb = new ContactNumber;
                $contactnumberdb->telco_name = $telconame[$i];
                $contactnumberdb->contact_number = $contactnumber[$i];
                $contactnumberdb->save();
            }

            return redirect('admin/system_setting')->with('message', 'Company Profile Added!');
        }
        
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
