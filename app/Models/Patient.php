<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    public $table = 'tbl_patient';

    public $timestamps = false;

    protected $fillable = [
        'Patient_Name',
        'gender',
        'age',
        'email',
        'Patient_Details',
        'Patient_Description',
        'Patient_Department',
        'Doctor',
        'Mobile',
        'secondary_mobile',
        'p_id',
        'Concession',
        'doc_name',
        'depart_name',
        'in_date',
        'notes',
        'ref_Doctor',
        'viewed',
        'reviewed',
        'Location',
        'salutation',
        'MRN',
        'IP_No',
        'source'
    ];
}
