<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'DesignNo',
        'Jeweltype',
        'product_image',
        'Project',
        'Category',
        'Subcategory',
        'Item',
        'Procatgory',
        'weight',
        'Purity',
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
