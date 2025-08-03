<?php

namespace App\Models;

use App\Enums\PaymentFrequency;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HouseholdMember extends Model
{
    protected $fillable = [
        'client_id',
        'first_name',
        'last_name',
        'ssn',
        'ssn_hash',
        'dob',
        'gender_id',
        'household_relation_type_id',
        'ethnicity_id',
        'frequency_payment',
        'payment_amounts',
        'hiv_aids_status',
        'hispanic',
    ];
    protected $casts = [
        'payment_amounts' => 'array',
    ];
    public function scopeSearch(Builder $query, string|null $search): Builder
    {
        if (empty($search)) {
            return  $query;
        }
        $query->where('first_name', 'like', "%{$search}%")
            ->orWhere('last_name', 'like', "%{$search}%")
            ->orWhere('income', 'like', "%{$search}%");
        if (preg_match('/^\d{3}-?\d{2}-?\d{4}$/', $search)) {
            $query->orWhere('ssn_hash', '=', hash('sha256', $search));
        }
        return $query;
    }
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class);
    }
    public function householdRelationType(): BelongsTo
    {
        return $this->belongsTo(HouseholdRelationType::class);
    }
    public function ethnicity(): BelongsTo
    {
        return $this->belongsTo(Ethnicity::class);
    }
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
    public function getAgeAttribute(): int
    {
        return $this->dob ? Carbon::parse($this->dob)->diffInYears(now()) : 0;
    }
    public function getFormattedIncomeAttribute(): string
    {
        return number_format($this->income, 2);
    }
    public function getEthnicityNameAttribute(): string
    {
        return $this->ethnicity?->name ?? '';
    }
    public function getEthnicityCodeAttribute(): string
    {
        return $this->ethnicity?->id ?? '';
    }
    public function getDobFormattedAttribute(): string
    {
        return $this->dob ? Carbon::parse($this->dob)->format('m/d/Y') : '';
    }
    public function getGenderNameAttribute(): string
    {
        return   $this->gender?->name ?? '';
    }
    public function getGenderCodeAttribute(): string
    {
        return   $this->gender?->code ?? '';
    }

    public function getHouseholdRelationTypeNameAttribute(): string
    {
        return $this->householdRelationType?->name ?? '';
    }

    public static function boot()
    {
        parent::boot();
        static::saving(function (HouseholdMember $model) {
            $model->income = round(self::calculateIncome(
                $model->payment_amounts,
                $model->frequency_payment
            ), 2);
        });
    }

    public static function calculateIncome(array $payments, string|null $frequency): float
    {
        return (!empty($payments) && isset($frequency)) ?
            match ($frequency) {
                PaymentFrequency::WEEKLY->value => round(array_sum($payments) / count($payments) * 52, 2),
                PaymentFrequency::BIWEEKLY->value => round(array_sum($payments) / count($payments) * 26, 2),
                PaymentFrequency::MONTHLY->value => round(array_sum($payments) / count($payments) * 12, 2),
                default => 0,
            } : 0;
    }
    public function getMonthlyIncomeAttribute(): float
    {
        return $this->income ? round($this->income / 12, 2) : 0;
    }

    public function setSsnAttribute($value)
    {
        $this->attributes['ssn'] = encrypt($value);
        $this->attributes['ssn_hash'] = hash('sha256', $value);
    }
    public function getSsnAttribute(): string|null
    {
        $ssn = $this->attributes['ssn'] ?? null;
        return $ssn ? decrypt($ssn) : null;
    }
}
