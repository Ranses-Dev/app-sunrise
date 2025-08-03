<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class HouseholdRelationType extends Model
{
    protected $fillable = ['name'];

    public function scopeSearch(Builder $query, string|null $search): Builder
    {
        return empty($search) ? $query : $query->where('name', 'like', "%{$search}%");
    }
}
