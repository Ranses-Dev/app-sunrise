<?php

namespace App\Traits;

use Illuminate\Support\Number;

trait ConvertFormatCurrency
{
    public function convertToCurrencyFormat(int|float|null $amount): string
    {
        return Number::currency(number: $amount ? ((float) $amount) : 0, in: Number::defaultCurrency(), locale: config('app.locale'), precision: 2);
    }
}
