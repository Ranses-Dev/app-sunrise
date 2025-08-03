<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class City extends Model
{
    protected $fillable = ['name', 'district_id'];



    public function scopeSearch(Builder $query, string|null $search)
    {
        return empty($search) ? $query : $query->where('name', 'like', "%{$search}%");
    }

    public function districts(): BelongsToMany
    {
        return $this->belongsToMany(CountyDistrict::class, 'city_county_district');
    }
}
