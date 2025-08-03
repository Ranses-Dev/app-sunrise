<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AttachmentType extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];
    public function scopeSearch(Builder $query, string|null  $search): Builder
    {
        return  empty($query) ? $query : $query->where('name', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%");
    }
}
