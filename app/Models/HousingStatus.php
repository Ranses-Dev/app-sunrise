<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use function PHPUnit\Framework\isEmpty;

class HousingStatus extends Model
{
    protected $fillable = ['name'];

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    public function scopeSearch(Builder $query, string|null $search)
    {
        return isEmpty($search) ? $query : $query->where('name', 'like', "%{$search}%");
    }
}
