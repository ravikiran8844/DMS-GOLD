<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_maintanance_mode',
        'otp_length',
        'otp_expiry_duration',
        'company_logo',
        'east_zone_name',
        'east_zone_incharge_name',
        'east_zone_mobile_no',
        'east_zone_incharge_email',
        'west_zone_name',
        'west_zone_incharge_name',
        'west_zone_mobile_no',
        'west_zone_incharge_email',
        'north_zone_name',
        'north_zone_incharge_name',
        'north_zone_mobile_no',
        'north_zone_incharge_email',
        'north_zone_name1',
        'north_zone_incharge_name1',
        'north_zone_mobile_no1',
        'north_zone_incharge_email1',
        'south_zone_name',
        'south_zone_incharge_name',
        'south_zone_mobile_no',
        'south_zone_incharge_email',
        'south_zone_name1',
        'south_zone_incharge_name1',
        'south_zone_mobile_no1',
        'south_zone_incharge_email1',
    ];
}
