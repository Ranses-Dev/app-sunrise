<?php

namespace App\Traits;

use Illuminate\Support\Number;

trait ConvertFormatCurrency
{
    public function convertToCurrencyFormat(int|float|null|string $amount): string
    {
        $value = Number::parseFloat($amount);
        return Number::currency(number: $value, in: Number::defaultCurrency(), locale: config('app.locale'), precision: 2);
    }
}
