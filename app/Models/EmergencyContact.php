<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmergencyContact extends Model
{
    protected $fillable = [
        'client_id',
        'household_relation_type_id',
        'name',
        'address',
        'phone_number',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function householdRelationType(): BelongsTo
    {
        return $this->belongsTo(HouseholdRelationType::class);
    }

    public function scopeSearch(Builder $query, string|null $search = null): Builder
    {
        return empty($search) ?
            $query :
            $query->where('name', 'like', "%{$search}%")
            ->orWhere('address', 'like', "%{$search}%")
            ->orWhere('phone_number', 'like', "%{$search}%");
    }
}
