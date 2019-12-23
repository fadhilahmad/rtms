<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TierController extends Controller
{
    //
    public function TierSetting() 
    {
        return view('admin/tier_setting');
    }
}
