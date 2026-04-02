<?php

namespace App\Enums;

enum SchemaPriceTypeEnum: string
{
    case STANDARD = 'standard';
    case CUSTOM = 'custom';

    public static function options(): array
    {
        return [
            self::STANDARD->value => 'Standard',
            self::CUSTOM->value => 'Custom',
        ];
    }
}
