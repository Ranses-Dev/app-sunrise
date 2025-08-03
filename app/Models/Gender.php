<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    protected $fillable = ['name', 'notes', 'code'];

    public function scopeSearch(Builder $query, string|null $search): Builder
    {
        return $query->when($search, function (Builder $query, string $search) {
            return $query->where('name', 'like', "%{$search}%");
        });
    }
}
