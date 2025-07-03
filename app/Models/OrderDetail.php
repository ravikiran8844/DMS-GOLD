<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'weight',
        'size',
        'is_delivered',
        'tracking_no',
        'remarks',
        'box',
        'box_details',
        'others',
        'is_approved',
        'approved_qty'
    ];
}
