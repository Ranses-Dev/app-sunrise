<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ContractMeal extends Model
{
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
        'code'
    ];
    protected $casts = [
        'is_active' => 'boolean',
        'recertification_date' => 'date',
    ];
    public function scopeSearch(Builder $query, string|null $search): Builder
    {
        return empty($search) ? $query : $query->where('notes', 'like', "$search");
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
}
