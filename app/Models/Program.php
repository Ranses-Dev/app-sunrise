<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Program extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function branches(): HasMany
    {
        return $this->hasMany(ProgramBranch::class);
    }

    public function scopeSearch(Builder $query, string|null $search): Builder
    {
        return $query->when($search, function (Builder $query, string $search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        });
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'program_user', 'program_id', 'user_id');
    }

    public function contractMeals(): HasManyThrough
    {
        return $this->hasManyThrough(ContractMeal::class, ProgramBranch::class);
    }

    public function contractHowpas(): HasManyThrough
    {
        return $this->hasManyThrough(HowpaContract::class, ProgramBranch::class);
    }
}
