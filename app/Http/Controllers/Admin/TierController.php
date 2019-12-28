<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tier;

class TierController extends Controller
{
    //
    public function TierSetting() 
    {
        $tiers = Tier::all();
        
        return view('admin/tier_setting', compact('tiers'));
    }
}
