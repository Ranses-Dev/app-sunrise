<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;

class Address extends Model
{
    protected $fillable = [
        'delivery_line_1',
        'last_line',
        'street_name',
        'city',
        'state_abbreviation',
        'postal_code',
        'county_name',
    ];

    protected $casts = [
        'delivery_line_1' => 'string',
        'last_line' => 'string',
        'street_name' => 'string',
        'city' => 'string',
        'state_abbreviation' => 'string',
        'postal_code' => 'string',
        'county_name' => 'string',
    ];

    public function inspections(): HasMany
    {
        return $this->hasMany(Inspection::class);
    }

    public function scopeSearch(Builder $query, array $filters = []): Builder
    {
        $nz = fn($v) => is_string($v) ? trim($v) : $v;
        $deliveryLine1 = $nz($filters['deliveryLine1'] ?? null);
        $streetName = $nz($filters['streetName'] ?? null);
        $city = $nz($filters['city'] ?? null);
        $stateAbbreviation = $nz($filters['stateAbbreviation'] ?? null);
        $postalCode = $nz($filters['postalCode'] ?? null);
        $countyName = $nz($filters['countyName'] ?? null);

        if ($deliveryLine1) {
            $query->where(function ($qq) use ($deliveryLine1) {
                $qq->whereRaw('LOWER(delivery_line_1) LIKE ?', ["%{$deliveryLine1}%"])
                    ->orWhereRaw('LOWER(last_line)        LIKE ?', ["%{$deliveryLine1}%"]);
            });
        }
        if ($streetName) {
            $query->whereRaw('LOWER(street_name) LIKE ?', ["%{$streetName}%"]);
        }
        if ($city) {
            $query->whereRaw('LOWER(city) LIKE ?', ["%{$city}%"]);
        }
        if ($stateAbbreviation) {
            $query->whereRaw('LOWER(state_abbreviation) LIKE ?', ["%{$stateAbbreviation}%"]);
        }
        if ($postalCode) {
            $query->whereRaw('LOWER(postal_code) LIKE ?', ["%{$postalCode}%"]);
        }
        if ($countyName) {
            $query->whereRaw('LOWER(county_name) LIKE ?', ["%{$countyName}%"]);
        }

        return $query;
    }
public function scopeVerify(Builder $query, array $filters = []): Builder
    {
        $nz = fn($v) => is_string($v) ? trim($v) : $v;
        $deliveryLine1 = $nz($filters['delivery_line_1'] ?? null);
        $lastLine = $nz($filters['last_line'] ?? null);
        $streetName = $nz($filters['street_name'] ?? null);
        $city = $nz($filters['city'] ?? null);
        $stateAbbreviation = $nz($filters['state_abbreviation'] ?? null);
        $postalCode = $nz($filters['postal_code'] ?? null);
        $countyName = $nz($filters['county_name'] ?? null);
        if ($deliveryLine1) {
            $query->whereRaw('LOWER(delivery_line_1) = ?', [strtolower($deliveryLine1)]);
        }
        if ($lastLine) {
            $query->whereRaw('LOWER(last_line) = ?', [strtolower($lastLine)]);
        }
        if ($streetName) {
            $query->whereRaw('LOWER(street_name) = ?', [strtolower($streetName)]);
        }
        if ($city) {
            $query->whereRaw('LOWER(city) = ?', [strtolower($city)]);
        }
        if ($stateAbbreviation) {
            $query->whereRaw('LOWER(state_abbreviation) = ?', [strtolower($stateAbbreviation)]);
        }
        if ($postalCode) {
            $query->whereRaw('LOWER(postal_code) = ?', [strtolower($postalCode)]);
        }
        if ($countyName) {
            $query->whereRaw('LOWER(county_name) = ?', [strtolower($countyName)]);
        }

        return $query;
    }

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    public function getAddressFormattedAttribute(): string
    {
        return sprintf(
            '%s, %s, %s %s',
            $this->delivery_line_1,
            $this->city,
            $this->state_abbreviation,
            $this->postal_code
        );
    }
}
