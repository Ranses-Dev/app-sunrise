<?php

namespace App\Models;

use App\Enums\InspectionStatus;
use App\Traits\ConvertToDateStandard;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Log;

class Inspection extends Model
{
    use ConvertToDateStandard;
    protected $fillable = [
        'program_branch_id',
        'address_id',
        'inspection_requested_date',
        'inspection_requested_incomplete',
        'inspection_requested_incomplete_notes',
        'inspection_requested_not_scheduled',
        'inspection_requested_not_scheduled_notes',
        'inspection_requested_scheduled_date',
        'landlord_name',
        'landlord_contact_information',
        'landlord_address_id',
        'landlord_howpa_id',
        'tenant_name',
        'tenant_howpa_id',
        'tenant_contact_information',
        'tenant_address_id',
        'housing_type_id',
        'number_of_bedrooms',
        'housing_inspector_id',
        'inspection_status',
    ];
    protected $casts = [
        'inspection_requested_incomplete' => 'boolean',
        'inspection_requested_not_scheduled' => 'boolean',
        'inspection_status' => InspectionStatus::class,
        'inspection_requested_date' => 'date',
        'inspection_requested_scheduled_date' => 'date',

    ];

    public function programBranch(): BelongsTo
    {
        return $this->belongsTo(ProgramBranch::class);
    }
    public function tenantHowpa(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'tenant_howpa_id');
    }
    public function landlordHowpa(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'landlord_howpa_id');
    }
    public function tenantAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'tenant_address_id', 'id');
    }
    public function landlordAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'landlord_address_id', 'id');
    }

    public function housingType(): BelongsTo
    {
        return $this->belongsTo(HousingType::class);
    }

    public function housingInspector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'housing_inspector_id');
    }

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class, 'client_inspection');
    }

    public function scopeSearch(Builder $query, array $filters): Builder
    {
        $query->with(['programBranch', 'tenantHowpa', 'landlordHowpa', 'tenantAddress', 'landlordAddress', 'housingType', 'housingInspector', 'address']);
        if (!empty($filters['search'])) {
            $query->where('landlord_name', 'like', '%' . $filters['search'] . '%')
                ->orWhere('landlord_contact_information', 'like', '%' . $filters['search'] . '%')
                ->orWhere('tenant_name', 'like', '%' . $filters['search'] . '%')
                ->orWhere('tenant_contact_information', 'like', '%' . $filters['search']);
        }
        if (isset($filters['inspectionStatus']) && $filters['inspectionStatus']) {
            $query->where('inspection_status', $filters['inspectionStatus']);
        }

        if (isset($filters['programBranchId']) && $filters['programBranchId']) {

            $query->where('program_branch_id', $filters['programBranchId']);
        }
        if (!empty($filters['inspectionRequestedDateRange'])) {
            $start = $filters['inspectionRequestedDateRange']['start'] ?? null;
            $end   = $filters['inspectionRequestedDateRange']['end'] ?? null;
            $query->whereBetween('inspection_requested_date', [$start, $end]);
        }
        if (!empty($filters['inspectionRequestedScheduledRange'])) {
            $start = $filters['inspectionRequestedScheduledRange']['start'] ?? null;
            $end   = $filters['inspectionRequestedScheduledRange']['end'] ?? null;
            $query->whereBetween('inspection_requested_scheduled_date', [$start, $end]);
        }
        $incomplete = filter_var(
            $filters['inspectionRequestedIncomplete'] ?? null,
            FILTER_VALIDATE_BOOLEAN,
            FILTER_NULL_ON_FAILURE
        );

        $notScheduled = filter_var(
            $filters['inspectionRequestedNotScheduled'] ?? null,
            FILTER_VALIDATE_BOOLEAN,
            FILTER_NULL_ON_FAILURE
        );

        $query
            ->when($incomplete === true,    fn($q) => $q->where('inspection_requested_incomplete', 1))
            ->when($notScheduled === true,  fn($q) => $q->where('inspection_requested_not_scheduled', 1));

        if (isset($filters['housingTypeId']) && $filters['housingTypeId']) {
            $query->where('housing_type_id', $filters['housingTypeId']);
        }
        if (isset($filters['housingInspectorId']) && $filters['housingInspectorId']) {
            $query->where('housing_inspector_id', $filters['housingInspectorId']);
        }
        return $query;
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'address_id', 'id');
    }
    public function getInspectionRequestedDateFormattedAttribute(): string|null
    {
        return $this->inspection_requested_date ? $this->convertToDateStandard($this->inspection_requested_date) : "";
    }
    public function getInspectionRequestedScheduledDateFormattedAttribute(): string
    {
        return $this->inspection_requested_scheduled_date ? $this->convertToDateStandard($this->inspection_requested_scheduled_date) : "";
    }
}
