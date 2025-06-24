<?php

namespace App\Http\Controllers\Backend\Shipment;

use App\Http\Controllers\Controller;
use App\Traits\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShipmentController extends Controller
{
    use Common;
    function shipment()
    {
        if ($this->permissionCheck(Auth::user()->id, 'Shipment')) {
            return view('backend.admin.shipment.shipment');
        } else {
            return view('backend.admin.error.restrict');
        }
    }
}
