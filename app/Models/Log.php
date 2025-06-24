<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'transaction_name',
        'mode',
        'log_message',
        'user_id',
        'ip_address',
        'system_name',
        'is_app',
        'log_date'
    ];
}
