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




        return  $query->when(
            $deliveryLine1,
            fn($q) =>
            $q->where(function ($qq) use ($deliveryLine1) {
                $qq->whereRaw('LOWER(delivery_line_1) LIKE ?', ["%{$deliveryLine1}%"])
                    ->orWhereRaw('LOWER(last_line)        LIKE ?', ["%{$deliveryLine1}%"]);
            })
        )->when(
            $streetName,
            fn($q) =>
            $q->whereRaw('LOWER(street_name) LIKE ?', ['%' . strtolower($streetName) . '%'])
        )->when(
            $city,
            fn($q) =>
            $q->whereRaw('LOWER(city) LIKE ?', ['%' . strtolower($city) . '%'])
        )->when(
            $stateAbbreviation,
            fn($q) =>
            $q->whereRaw('LOWER(state_abbreviation) LIKE ?', ['%' . strtolower($stateAbbreviation) . '%'])
        )->when(
            $postalCode,
            fn($q) =>
            $q->whereRaw('LOWER(postal_code) LIKE ?', ['%' . strtolower($postalCode) . '%'])
        )->when(
            $countyName,
            fn($q) =>
            $q->whereRaw('LOWER(county_name) LIKE ?', ['%' . strtolower($countyName) . '%'])
        );
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
