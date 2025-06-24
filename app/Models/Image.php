<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    public $table = 'tbl_img';

    public $timestamps = false;

    protected $fillable = [
        'p_id',
        'pdf_file',
        'temp_field',
        'in_date'
    ];
}
