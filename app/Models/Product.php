<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'D365_Latest_Photo_Number',
        'product_image',
        'Project',
        'Cateory',
        'Subcategory',
        'Item',
        'Procatgory',
        'weight',
        'color',
        'size',
        'style',
        'unit',
        'making',
        'qty',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
