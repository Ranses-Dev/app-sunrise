<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CountyDistrict extends Model
{
    protected $fillable = [
        'name',
    ];
    public function cities(): BelongsToMany
    {
        return $this->belongsToMany(City::class, 'city_county_district');
    }

    public function scopeSearch(Builder $query, string|null $search): Builder
    {
        return empty($query) ? $query : $query->where('name', 'like', "%{$search}%");
    }
}
