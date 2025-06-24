<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IPNumber extends Model
{
    use HasFactory;

    public $table = 'tbl_IP_No';

    public $timestamps = false;

    protected $fillable = [
        'p_id',
        'IP_No',
        'UH_ID',
        'in_date',
        'exe_id',
        'Remarks',
        'cheque_no',
        'cheque_date',
        'cheque_value',
        'cheque_amount',
        'cheque_deliver_date',
        'cheque_in_date',
        'f_b_diagnosed',
        'f_b_treatment',
        'f_b_reviewed',
        'patient_visit_date',
        'feedback_date'
    ];
}
