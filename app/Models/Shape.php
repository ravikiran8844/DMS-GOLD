<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shape extends Model
{
    use HasFactory;

    protected $fillable = [
        'shape_name',
        'is_active',
        'created_by',
        'updated_by'
    ];
}
