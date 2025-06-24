<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_unique_id',
        'product_name',
        'product_image',
        'product_price',
        'designed_date',
        'design_updated_date',
        'height',
        'width',
        'depth',
        'density',
        'weight',
        'product_carat',
        'color_id',
        'style_id',
        'finish_id',
        'size_id',
        'finishing',
        'project_id',
        'base_product',
        'category_id',
        'sub_category_id',
        'zone_id',
        'collection_id',
        'sub_collection_id',
        'collection_id',
        'metal_type_id',
        'brand_id',
        'jewel_type_id',
        'purity_id',
        'shape',
        'plating_id',
        'making_percent',
        'moq',
        'hallmarking',
        'crwcolcode',
        'crwsubcolcode',
        'gender',
        'cwqty',
        'qty',
        'unit_id',
        'net_weight',
        'keywordtags',
        'otherrate',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
