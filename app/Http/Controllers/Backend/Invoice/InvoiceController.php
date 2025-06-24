<?php

namespace App\Http\Controllers\Backend\Invoice;

use App\Http\Controllers\Controller;
use App\Traits\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    use Common;
    function invoice()
    {
        if ($this->permissionCheck(Auth::user()->id, 'Invoices')) {
            return view('backend.admin.invoice.invoice');
        } else {
            return view('backend.admin.error.restrict');
        }
    }
}
