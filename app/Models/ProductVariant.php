<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'weight',
        'color',
        'style',
        'Purity',
        'size',
        'qty',
        'making',
        'unit',
    ];
}
