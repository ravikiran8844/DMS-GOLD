<?php

namespace App\Http\Controllers\Backend\Activity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    function activity()
    {
        return view('backend.admin.activity.activity');
    }
}
