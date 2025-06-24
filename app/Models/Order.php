<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_no',
        'invoice_no',
        'expected_delivery_date',
        'status_id',
        'is_cancel',
        'assigned_dealer_id',
        'invoice_path',
        'invoice',
        'approved_invoice',
        'pdf_invoice',
        'remarks',
        'admin_remarks',
        'box',
        'others',
        'reference',
        'totalweight',
        'zone_id'
    ];
}
