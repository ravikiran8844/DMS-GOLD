<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagerLog extends Model
{
    use HasFactory;

    public $table = 'tbl_manager_log';

    public $timestamps = false;

    protected $fillable = [
        'M_id',
        'Manager_Name',
        'old_name',
        'action',
        'D_id'
    ];
}
