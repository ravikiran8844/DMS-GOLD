<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JewelType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'jewel_type',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
}
