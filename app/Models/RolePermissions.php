<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermissions extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'menu_id',
        'role_id',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
}
