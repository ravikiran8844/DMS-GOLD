<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plating extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'plating_name',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
}
