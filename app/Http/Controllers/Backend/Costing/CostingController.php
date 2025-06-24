<?php

namespace App\Http\Controllers\Backend\Costing;

use App\Http\Controllers\Controller;
use App\Traits\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CostingController extends Controller
{
    use Common;
    function costing()
    {
        if ($this->permissionCheck(Auth::user()->id, 'Costing')) {
            return view('backend.admin.costing.costing');
        } else {
            return view('backend.admin.error.restrict');
        }
    }
}
