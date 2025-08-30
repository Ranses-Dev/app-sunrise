<?php

namespace App\Traits;

use Illuminate\Support\Number;

trait ConvertFormatCurrency
{
      public function convert($amount): string
    {
        return Number::currency((float) $amount ?? 0);
    }
}
