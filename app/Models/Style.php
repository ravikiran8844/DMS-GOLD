<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Style extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'project_id',
        'style_name',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'style_id');
    }
}
