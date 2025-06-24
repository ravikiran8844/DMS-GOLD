<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

final class Roles extends Enum
{
    const SuperAdmin = '1';
    const Admin = '2';
    const Dealer = '3';
    const Retailer = '4';
    const CRM = '5';
}
