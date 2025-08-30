<?php

namespace App\Enums;

enum InspectionStatus: string
{
    case PASS = 'Pass';
    case FAIL = 'Fail';
}
