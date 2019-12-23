<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SystemSettingController extends Controller
{
    //
    
    public function CompanyProfile()
    {
        return view('admin/system_setting');
    }
}
