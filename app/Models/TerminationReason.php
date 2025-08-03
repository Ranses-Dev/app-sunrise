<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TerminationReason extends Model
{
    protected $fillable = ['name', 'description'];

    /**
     * Get the name of the termination reason.
     *
     * @return string
     */
    public function getNameAttribute($value): string
    {
        return ucfirst($value);
    }

    public function scopeSearch(Builder $query, string|null $search): Builder
    {
        return empty($search) ? $query : $query->where('name', 'like', "%$search%")
            ->orWhere('description', 'like', "%$search%");
    }
}
