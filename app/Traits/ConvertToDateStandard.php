<?php

namespace App\Traits;

trait ConvertToDateStandard
{
    public function convertToDateStandard($date): ?string
    {
        if (empty($date)) {
            return null;
        }
        try {
            $dateTime = new \DateTime($date);
            return $dateTime->format('m-d-Y');
        } catch (\Exception $e) {
            return null;
        }
    }
}
