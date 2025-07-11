<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dealer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'mobile',
        'zone',
        'party_name',
        'code',
        'customer_code',
        'person_name',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
}
