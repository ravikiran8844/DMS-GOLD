<?php

namespace App\Http\Controllers\Backend\Notification;

use App\Http\Controllers\Controller;
use App\Traits\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    use Common;
    function notification()
    {
        if ($this->permissionCheck(Auth::user()->id, 'Notifications')) {
            return view('backend.admin.notification.notification');
        } else {
            return view('backend.admin.error.restrict');
        }
    }
}
