<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCollection extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sub_collection_name',
        'collection_id',
        'project_id',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'sub_collection_id');
    }
}
