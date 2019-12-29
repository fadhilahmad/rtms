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
        $company = SystemSetting::first();
        $banks = BankDetail::all();
        $contacts = ContactNumber::all();
        //dd($company);
        return view('admin/system_setting',compact('company','banks','contacts'));
    }

    public function UpdateCompanyProfile(Request $request)
    {
        $data = $request->all();
        //dd($data);
        if($data['operation'] == 'company'){
            
            if($data['process'] == 'add'){
                //dd($data);
                $companyname = $request->input('name');
                $systemname = $request->input('ssname');
                $street1 = $request->input('address1');
                $street2 = $request->input('address2');
                $city = $request->input('city');
                $state = $request->input('state');
                $poscode = $request->input('poscode');
                $country = $request->input('country');

                if($request->hasFile('logo')){
                    $filenameWithExt = $request->file('logo')->getClientOriginalName();
                    $originalname = $request->file('logo')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $image = $request->file('logo');                    
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
                $systemsetting->address_first = $street1;
                $systemsetting->address_second = $street2;
                $systemsetting->city = $city;
                $systemsetting->state = $state;
                $systemsetting->poscode = $poscode;
                $systemsetting->country = $country;
                $systemsetting->save();
                
                return redirect('admin/system_setting')->with('message', 'Company Profile added');
            }
            
            if($data['process'] == 'update')
            {
                if($request->hasFile('logo'))
                {
                    $filenameWithExt = $request->file('logo')->getClientOriginalName();
                    $originalname = $request->file('logo')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $image = $request->file('logo');                    
                    $destinationPath = 'img/logo/'; 
                    $profileImage = 'complogo-'.$filename.'-'.date('YmdHis') . "." . $image->getClientOriginalExtension();
                    $url = $destinationPath.$profileImage;
                    $companylogo = $profileImage;
                    $image->move($destinationPath, $profileImage);
                    
                    DB::table('system_setting')
                    ->where('ss_id', '=', $data['ss_id'])
                    ->update(array(
                        'company_name' => $data['name'],
                        'system_name' => $data['ssname'],
                        'company_logo' => $companylogo,
                        'address_first' => $data['address1'],
                        'address_second' => $data['address2'],
                        'poscode' => $data['poscode'],
                        'city' => $data['city'],
                        'state' => $data['state'],
                        'country' => $data['country'],
                        'updated_at' => DB::raw('now()')
                        )); 
                    
                    return redirect('admin/system_setting')->with('message', 'Company Profile updated');
                }
                else{
                    
                    DB::table('system_setting')
                    ->where('ss_id', '=', $data['ss_id'])
                    ->update(array(
                        'company_name' => $data['name'],
                        'system_name' => $data['ssname'],
                        'address_first' => $data['address1'],
                        'address_second' => $data['address2'],
                        'poscode' => $data['poscode'],
                        'city' => $data['city'],
                        'state' => $data['state'],
                        'country' => $data['country'],
                        'updated_at' => DB::raw('now()')
                        )); 
                    
                    return redirect('admin/system_setting')->with('message', 'Company Profile updated');
                }
                                               
            }
        }
        if($data['operation'] == 'bank')
        {           
            if($data['process'] == 'addBank'){
                //dd($data);
//                if($request->hasFile('bank_logo'))
//                {                   
//                    $filenameWithExt = $request->file('bank_logo')->getClientOriginalName();
//                    $originalname = $request->file('bank_logo')->getClientOriginalName();
//                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
//                    $image = $request->file('bank_logo');                    
//                    $destinationPath = 'img/logo/'; 
//                    $profileImage = 'bank-'.$filename.'-'.date('YmdHis') . "." . $image->getClientOriginalExtension();
//                    $url = $destinationPath.$profileImage;
//                    $companylogo = $profileImage;
//                    $image->move($destinationPath, $profileImage);
//                    
//                }else{
//                    $companylogo = 'nologo.jpg';
//                }
                $companylogo = 'nologo.jpg';
                $bank = new BankDetail;
                $bank->bank_name = $data['bank_name'];
                $bank->account_name = $data['account_name'];
                $bank->account_number = $data['account_num'];
                $bank->bank_logo = $companylogo;
                $bank->save();
                
                return redirect('admin/system_setting')->with('message', 'Bank detail added');
                
            }
            if($data['process'] == 'updateBank'){
               
//                if($request->hasFile('bank_logo')){
//                    $filenameWithExt = $request->file('bank_logo')->getClientOriginalName();
//                    $originalname = $request->file('bank_logo')->getClientOriginalName();
//                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
//                    $image = $request->file('bank_logo');                    
//                    $destinationPath = 'img/logo/'; 
//                    $profileImage = 'bank-'.$filename.'-'.date('YmdHis') . "." . $image->getClientOriginalExtension();
//                    $url = $destinationPath.$profileImage;
//                    $companylogo = $profileImage;
//                    $image->move($destinationPath, $profileImage);
//                    
//                    DB::table('bank_detail')
//                    ->where('bd_id', '=', $data['bd_id'])
//                    ->update(array(
//                        'bank_name' => $data['bank_name'],
//                        'account_name' => $data['account_name'],
//                        'account_number' => $data['account_num'],
//                        'bank_logo' => $companylogo,
//                        'updated_at' => DB::raw('now()')
//                        ));
//                    
//                    return redirect('admin/system_setting')->with('message', 'Bank detail updated');
//                }
//                else{
                   DB::table('bank_detail')
                    ->where('bd_id', '=', $data['bd_id'])
                    ->update(array(
                        'bank_name' => $data['bank_name'],
                        'account_name' => $data['account_name'],
                        'account_number' => $data['account_num'],
                        'updated_at' => DB::raw('now()')
                        ));
                   
                   return redirect('admin/system_setting')->with('message', 'Bank detail updated');
//                }
                          
            }
            if($data['process'] == 'bankDelete'){
                
                $bankid = $data['bd_id'];
                $bankdetail = BankDetail::find($bankid);
                $bankdetail->delete();
                
                return redirect('admin/system_setting')->with('message', 'Bank Details Deleted!');
            }
        }
        if($data['operation'] == 'contact')
        {           
            if($data['process'] == 'addContact'){
                $contact = new ContactNumber;
                $contact->telco_name = $data['telco'];
                $contact->contact_number = $data['contact_number'];               
                $contact->save();
                
                return redirect('admin/system_setting')->with('message', 'Contact Added');
            }
            if($data['process'] == 'updateContact'){
                DB::table('contact_number')
                    ->where('cn_id', '=', $data['cn_id'])
                    ->update(array(
                        'telco_name' => $data['telco'],
                        'contact_number' => $data['contact_number'],
                        'updated_at' => DB::raw('now()')
                        ));
                   
                   return redirect('admin/system_setting')->with('message', 'Contact number updated');
            }
            if($data['process'] == 'contactDelete'){
                
                $id = $data['cn_id'];
                $contact= ContactNumber::find($id);
                $contact->delete();
                
                return redirect('admin/system_setting')->with('message', 'Contact number Deleted!');
            }
        }
        
    }
}
