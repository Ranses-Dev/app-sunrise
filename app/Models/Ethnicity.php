<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ethnicity extends Model
{
    protected $fillable = ['name', 'notes'];

    public function scopeSearch(Builder $query, string|null $search): Builder
    {
        return $query->when($search, function (Builder $query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
    }
    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }
}
