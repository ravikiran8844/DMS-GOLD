<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Weight extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'weight_range_from',
        'weight_range_to',
        'mc_charge',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
}
