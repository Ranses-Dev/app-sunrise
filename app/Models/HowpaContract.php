<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HowpaContract extends Model
{
    protected $fillable = [
        'agreed_statements',
        'assets_notes',
        'checking_avg_balance_six_months',
        'city_id',
        'client_id',
        'client_service_specialist_id',
        'committed_fraud_or_asked_to_repay',
        'currently_receiving_other_aid',
        'date',
        're_certification_date',
        'emergency_contact_one_id',
        'emergency_contact_two_id',
        'fraud_explanation',
        'has_aids',
        'has_checking_account',
        'has_savings',
        'howpa_prior_to_2023',
        'number_bedrooms_approved',
        'number_bedrooms_req',
        'outside_support_explanation',
        'outside_support',
        'own_any_stock_or_bonds',
        'owns_real_estate',
        'phone_number_id',
        'program_branch_id',
        'recent_living_situation_notes',
        'recent_living_situation',
        'savings_balance',
    ];

    protected $casts = [
        'date' => 'date',
        're_certification_date' => 'date',
        'has_aids' => 'boolean',
        'howpa_prior_to_2023' => 'boolean',
        'currently_receiving_other_aid' => 'boolean',
        'agreed_statements' => 'boolean',
        'outside_support' => 'boolean',
        'own_any_stock_or_bonds' => 'boolean',
        'owns_real_estate' => 'boolean',
        'has_checking_account' => 'boolean',
        'has_savings' => 'boolean',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function programBranch(): BelongsTo
    {
        return $this->belongsTo(ProgramBranch::class, 'program_branch_id');
    }
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function emergencyContactOne(): BelongsTo
    {
        return $this->belongsTo(EmergencyContact::class, 'emergency_contact_one_id');
    }
    public function emergencyContactTwo(): BelongsTo
    {
        return $this->belongsTo(EmergencyContact::class, 'emergency_contact_two_id');
    }
    public function scopeSearch(Builder $query, string|null $search = null): Builder
    {
        if ($search) {
            return $query->whereHas('client', function (Builder $q) use ($search) {
                $q->where('ssn', 'like', "%$search%")
                    ->orWhere('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%");
            });
        }
        return $query;
    }

    public function clientServiceSpecialist(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_service_specialist_id');
    }

    public function getIsActiveAttribute(): bool
    {
        return  Carbon::now()->isAfter($this->date) && Carbon::now()->isBefore($this->re_certification_date);
    }
}
