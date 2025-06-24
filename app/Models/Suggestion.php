<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    use HasFactory;

    protected $table = 'tbl_suggestion';

    public $timestamps = false;

    protected $fillable = [
        'r_id',
        'Suggestion',
        'verify',
        'in_date',
        'temp'
    ];
}
