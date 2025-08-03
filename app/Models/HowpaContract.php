<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HowpaContract extends Model
{
    protected $fillable = [
        'client_id',
        'city_id',
        'phone_number_id',
        'program_branch_id',
        'date',
        'number_bedrooms_req',
        'number_bedrooms_approved',
        'recent_living_situation',
        'recent_living_situation_notes',
        'owns_real_estate',
        'has_savings',
        'savings_balance',
        'has_checking_account',
        'checking_avg_balance_six_months',
        'assets_notes',
        'outside_support',
        'outside_support_explanation',
        'committed_fraud_or_asked_to_repay',
        'fraud_explanation',
        'has_aids',
        'howpa_prior_to_2023',
        'currently_receiving_other_aid',
        'agreed_statements',
        'emergency_contact_one_id',
        'emergency_contact_two_id',
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
}
