<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeliveryScheduleController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function viewSchedule()
    {
        
        return view('admin/delivery_schedule');
    }
}
