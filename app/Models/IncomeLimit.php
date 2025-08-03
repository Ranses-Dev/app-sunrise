<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class IncomeLimit extends Model
{
    protected $fillable = [
        'percentage_category',
        'household_size',
        'income_limit'
    ];

    public function scopeFilters(Builder $query, array $filters = []): Builder
    {
        foreach ($filters as $column => $value) {
            if (!empty($value)) {
                $query->where($column, $value);
            }
        }
        return $query;
    }
}
