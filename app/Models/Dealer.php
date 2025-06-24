<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dealer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'company_name',
        'communication_address',
        'mobile',
        'email',
        'zone_id',
        'city',
        'state',
        'a_name',
        'a_designation',
        'a_mobile',
        'a_email',
        'b_name',
        'b_designation',
        'b_mobile',
        'b_email',
        'gst',
        'income_tax_pan',
        'bank_name',
        'branch_name',
        'address',
        'account_number',
        'account_type',
        'ifsc',
        'cheque_leaf',
        'gst_certificate',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
}
