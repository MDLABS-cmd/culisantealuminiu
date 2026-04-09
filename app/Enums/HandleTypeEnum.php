<?php

namespace App\Enums;

enum HandleTypeEnum: string
{
    case STANDARD = 'standard';
    case PREMIUM = 'premium';

    public static function options(): array
    {
        return [
            self::STANDARD->value => 'Standard',
            self::PREMIUM->value => 'Premium',
        ];
    }
}
