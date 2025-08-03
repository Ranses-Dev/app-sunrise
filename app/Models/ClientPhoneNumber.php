<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientPhoneNumber extends Model
{
    protected $fillable = [
        'client_id',
        'phone_number',
        'notes',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function scopeSearch(Builder $query, string|null $search): Builder
    {
        return empty($query) ? $query : $query->where(function (Builder $query) use ($search) {
            $query->where('phone_number', 'like', "%{$search}%")
                ->orWhere('notes', 'like', "%{$search}%");
        });
    }
}
