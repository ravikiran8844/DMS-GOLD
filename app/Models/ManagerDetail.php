<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagerDetail extends Model
{
    use HasFactory;

    public $table = 'tbl_manager_detail';

    public $timestamps = false;

    protected $fillable = [
        'p_id',
        'Manager_Name',
        'in_date',
        'M_id'
    ];
}
