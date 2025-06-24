<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    public $table = 'tbl_dept';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'p_id',
        'Qualifications',
        'depart',
        'designation',
        'mobile_no',
        'email',
        'user_name',
        'password',
        'in_date',
        'status'
    ];
}
