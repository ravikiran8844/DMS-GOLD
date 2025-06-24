<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'role_name',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
}
