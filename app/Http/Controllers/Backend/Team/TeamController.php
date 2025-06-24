<?php

namespace App\Http\Controllers\Backend\Team;

use App\Http\Controllers\Controller;
use App\Traits\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    use Common;
    function team()
    {
        if ($this->permissionCheck(Auth::user()->id, 'Team')) {
            return view('backend.admin.team.team');
        } else {
            return view('backend.admin.error.restrict');
        }
    }
}
