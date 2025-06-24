<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    public $table = 'tbl_location';

    public $timestamps = false;

    protected $fillable = [
        'Name'
    ];
}
