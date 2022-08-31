<?php

namespace App\Enums;

enum DeliveryTypeEnums: string
{
    case BPOST = 'bpost';
    case PICKUP = 'pickup';
    case SPRINTER = 'sprinter';
}
