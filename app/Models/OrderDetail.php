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
        'size_id',
        'color_id',
        'plating_id',
        'is_delivered',
        'tracking_no',
        'remarks',
        'box_id',
        'box_details',
        'others',
        'finish',
        'is_approved',
        'approved_qty',
        'is_ready_stock'
    ];
}
