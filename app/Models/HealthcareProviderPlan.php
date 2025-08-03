<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class HealthcareProviderPlan extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function scopeSearch(Builder $query, string|null $search): Builder
    {
        return empty($search) ? $query : $query->where('name', 'like', "%{$search}%");
    }

    public function providers(): BelongsToMany
    {
        return $this->belongsToMany(HealthcareProvider::class);
    }
}
