<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'banner_position_id',
        'project',
        'banner_url',
        'banner_image',
        'is_active',
        'created_by',
        'updated_by'
    ];
}
