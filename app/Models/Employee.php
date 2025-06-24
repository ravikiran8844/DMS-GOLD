<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    public $table = 'tbl_employee';

    public $timestamps = false;

    protected $fillable = [
        'Name',
        'Mobile',
        'E_id',
        'email',
        'Date_in'
    ];
}
