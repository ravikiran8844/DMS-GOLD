<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NumberGenerate extends Model
{
    use HasFactory;

    public $table = 'tbl_number_generate';

    public $timestamps = false;

    protected $fillable = [
        'refno',
        'fbno'
    ];
}
