<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagerMap extends Model
{
    use HasFactory;

    public $table = 'tbl_manager_map';

    public $timestamps = false;

    protected $fillable = [
        'doc_id',
        'executive_id',
        'active_from',
        'active_to',
        'in_date'
    ];
}
