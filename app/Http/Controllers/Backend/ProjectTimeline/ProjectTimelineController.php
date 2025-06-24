<?php

namespace App\Http\Controllers\Backend\ProjectTimeline;

use App\Http\Controllers\Controller;
use App\Traits\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectTimelineController extends Controller
{
    use Common;
    function projectTimeline()
    {
        if ($this->permissionCheck(Auth::user()->id, 'Projects & Timeline')) {
            return view('backend.admin.porjecttimeline.projecttimeline');
        } else {
            return view('backend.admin.error.restrict');
        }
    }

    function projectDetail()
    {
        return view('backend.admin.porjecttimeline.projectdetail');
    }
}
