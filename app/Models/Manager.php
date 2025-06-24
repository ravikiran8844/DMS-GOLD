<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Manager extends Model
{
    use HasFactory, HasApiTokens;

    public $table = 'tbl_manager';

    public $timestamps = false;

    protected $fillable = [
        'Name',
        'Mobile',
        'M_id',
        'email',
        'Date_in',
        'pass_word',
        'office_supplies_list',
        'status'
    ];
}
