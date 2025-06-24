<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Finish extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id',
        'finish_name',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
}
