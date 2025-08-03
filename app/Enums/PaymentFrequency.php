<?php

namespace App\Enums;

enum PaymentFrequency: string
{
    case WEEKLY = 'weekly';
    case BIWEEKLY = 'biweekly';
    case MONTHLY = 'monthly';

    public function label(): string
    {
        return match ($this) {
            self::WEEKLY => 'Weekly',
            self::BIWEEKLY => 'Biweekly',
            self::MONTHLY => 'Monthly',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
