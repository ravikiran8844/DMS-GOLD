<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    public $table = 'tbl_notes';

    public $timestamps = false;

    protected $fillable = [
        'p_id',
        'notes',
        'in_date',
        'pdf_file',
        'added_by'
    ];
}
