<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempRegister extends Model
{
    use HasFactory;

    protected $table = 'tbl_temp_register';

    public $timestamps = false;

    protected $fillable = [
        'Full_name',
        'Degree',
        'Clinic_name',
        'mobile',
        'email',
        'Clinic_add',
        'active',
        'in_date',
        'doc_reg_no',
        'Bank_Account_Name',
        'Bank_Account_Number',
        'Bank_Name',
        'Branch',
        'IFSC_Code',
        'PAN_Number',
        'Manager',
        'salutation',
        'Manager_id',
        'added_executive',
        'verify',
        'location',
        'category',
        'old_manager_id',
        'service',
        'status',
        'source',
        'otp'
    ];
}
