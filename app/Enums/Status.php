<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

final class Status extends Enum
{
    const Starting = '1';
    const Wip = '2';
    const Pending = '3';
    const Overdue = '4';
    const Delivered = '5';
}
