<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerPosition extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'banner_position',
        'height',
        'width'
    ];
}
