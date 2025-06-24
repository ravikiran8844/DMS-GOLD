<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'qty',
        'size_id',
        'weight',
        'color_id',
        'finish_id',
        'plating_id',
        'remarks',
        'box_id',
        'box_details',
        'others',
        'is_ready_stock'
    ];
}
