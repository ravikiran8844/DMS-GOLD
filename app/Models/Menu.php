<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'menu_name',
        'group_name',
        'parent_id',
        'is_mainmenu',
        'is_module',
        'menu_order',
        'is_visible',
        'show_superadmin',
        'menu_url',
        'icon'
    ];
}
