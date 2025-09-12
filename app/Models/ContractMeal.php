<?php

namespace App\Models;

use App\Traits\ConvertToDateStandard;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ContractMeal extends Model
{
    use ConvertToDateStandard;
    protected $fillable = [
        'client_id',
        'program_branch_id',
        'delivery_cost_id',
        'food_cost_id',
        'program_delivery_cost_id',
        'termination_reason_id',
        'client_service_specialist_id',
        'is_active',
        'recertification_date',
        'notes',
        'code',
        'delivery_days',
    ];
    protected $casts = [
        'is_active' => 'boolean',
        'recertification_date' => 'date',
        'delivery_days' => 'array',
    ];
    public function scopeSearch(Builder $query, array $filters): Builder
    {
        $query->with([
            'client.legalStatus',
            'client.identificationType',
            'client.incomeType',
            'client.cityDistrict',
            'client.countyDistrict',
            'client.city',
            'client.healthcareProvider',
            'client.healthcareProviderPlan',
            'client.housingStatus',
            'client.howpaContracts',
            'client.contractMeals',
            'mealContractType',
            'clientServiceSpecialist',
            'deliveryCost',
            'foodCost',
            'programDeliveryCost',
            'terminationReason',

        ]);
        if (filled($filters['search'] ?? null)) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%$search%")
                    ->orWhereHas('client', function ($q) use ($search) {
                        $q->where('first_name', 'like', "%$search%")
                            ->orWhere('last_name', 'like', "%$search%");
                    });
            });
        }

        if (filled($filters['clientServiceSpecialistId'] ?? null)) {
            $query->where('client_service_specialist_id', (int) $filters['clientServiceSpecialistId']);
        }
        if (filled($filters['cityDistrictId'] ?? null)) {
            $query->whereHas('client', function ($q) use ($filters) {
                $q->where('city_district_id', (int) $filters['cityDistrictId']);
            });
        }
        if (filled($filters['countyDistrictId'] ?? null)) {
            $query->whereHas('client', function ($q) use ($filters) {
                $q->where('county_district_id', (int) $filters['countyDistrictId']);
            });
        }
        if (filled($filters['cityId'] ?? null)) {
            $query->whereHas('client', function ($q) use ($filters) {
                $q->where('city_id', (int) $filters['cityId']);
            });
        }
        if (isset($filters['programBranchId']) && filled($filters['programBranchId'])) {
            $query->where('program_branch_id', $filters['programBranchId']);
        }
        $query->withSum('deliveryCost as total_delivery_cost', 'cost')
            ->withSum('foodCost as total_food_cost', 'cost')
            ->withSum('programDeliveryCost as total_program_delivery_cost', 'cost');
        return $query;
    }
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
    public function mealContractType(): BelongsTo
    {
        return $this->belongsTo(ProgramBranch::class, 'program_branch_id');
    }
    public function deliveryCost(): BelongsTo
    {
        return $this->belongsTo(DeliveryCost::class);
    }
    public function foodCost(): BelongsTo
    {
        return $this->belongsTo(FoodCost::class);
    }

    public function programDeliveryCost(): BelongsTo
    {
        return $this->belongsTo(ProgramDeliveryCost::class);
    }
    public function terminationReason(): BelongsTo
    {
        return $this->belongsTo(TerminationReason::class);
    }
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }
    protected static  function booted()
    {
        parent::boot();
        static::creating(function ($mealContract) {
            $mealContract->program_id = Program::where('name', 'MEALS')->first()->id;
        });
        static::saving(function ($model) {
            if (empty($model->code)) {
                do {
                    $prefix = Str::upper(Str::random(3));
                    $id = $model->id ?? (static::max('id') ?? 0) + 1;
                    $code = "$prefix-$id";
                } while (static::where('code', $code)->exists());
                $model->code = $code;
            }
        });
    }
    public function clientServiceSpecialist(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_service_specialist_id');
    }
    public function getClientServiceSpecialistNameAttribute(): string
    {
        return $this->clientServiceSpecialist ? $this->clientServiceSpecialist->name : "";
    }

    public function getRecertificationDateFormattedAttribute(): ?string
    {
        return $this->convertToDateStandard($this->recertification_date);
    }
}
