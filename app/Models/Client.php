<?php

namespace App\Models;

use App\Enums\PaymentFrequency;
use App\Traits\ConvertFormatCurrency;
use App\Traits\ImageHandler;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Number;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Client extends Model
{
    use ImageHandler, LogsActivity, ConvertFormatCurrency;
    protected $fillable = [
        'address_id',
        'city_district_id',
        'city_id',
        'client_number',
        'county_district_id',
        'dob',
        'email',
        'ethnicity_id',
        'effective_date',
        'first_name',
        'frequency_payment',
        'gender_id',
        'healthcare_provider_id',
        'healthcare_provider_plan_id',
        'housing_status_id',
        'housing_status_id',
        'howpa_client_number',
        'howpa_ssn_hash',
        'howpa_ssn',
        'identification_expiration_date',
        'identification_number',
        'identification_picture',
        'identification_type_id',
        'is_deceased',
        'last_name',
        'legal_status_id',
        'meal_client_number',
        'monthly_client_payment_portion',
        'payment_amounts',
        'ssn',
        'hispanic',
        'income_type_id',
        'income'

    ];
    protected $casts = [
        'dob' => 'date',
        'effective_date' => 'date',
        'identification_expiration_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'monthly_client_payment_portion' => 'decimal:2',
        'is_deceased' => 'boolean',
        'payment_amounts' => 'array',
        'frequency_payment' => 'string',
        'income' => 'decimal:2',


    ];
    protected $appends = ["age"];

    public function getIncomeFormattedAttribute(): string
    {
        return  $this->convertToCurrencyFormat($this->income);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Client')
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
    public function getEffectiveDateFormattedAttribute(): string
    {
        return $this->effective_date ? $this->effective_date->format('m-d-Y') : '';
    }
    public function getIdentificationExpirationDateFormattedAttribute(): string
    {
        return $this->identification_expiration_date ? $this->identification_expiration_date->format('m-d-Y') : '';
    }
    public function legalStatus(): BelongsTo
    {
        return $this->belongsTo(LegalStatus::class);
    }

    public function clientFiles(): HasMany
    {
        return $this->hasMany(ClientFile::class);
    }

    public function identificationType(): BelongsTo
    {
        return $this->belongsTo(IdentificationType::class);
    }

    public function cityDistrict(): BelongsTo
    {
        return $this->belongsTo(CityDistrict::class);
    }

    public function countyDistrict(): BelongsTo
    {
        return $this->belongsTo(CountyDistrict::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function healthcareProvider(): BelongsTo
    {
        return $this->belongsTo(HealthcareProvider::class);
    }
    public function healthcareProviderPlan(): BelongsTo
    {
        return $this->belongsTo(HealthcareProviderPlan::class);
    }
    public function incomeType(): BelongsTo
    {
        return $this->belongsTo(IncomeType::class);
    }
    public function scopeSearch(Builder $query, array $filters): Builder
    {

        $query->with(['legalStatus', 'identificationType', 'incomeType', 'cityDistrict', 'countyDistrict', 'city', 'healthcareProvider', 'healthcareProviderPlan', 'howpaContracts', 'contractMeals', 'housingStatus']);
        if (filled($filters['search']) && !empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function (Builder $qq) use ($search) {
                $qq->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('client_number', 'like', "%{$search}%")
                    ->orWhere('howpa_client_number', 'like', "%{$search}%");

                if (preg_match('/^\d{3}-?\d{2}-?\d{4}$/', $search)) {
                    $qq->orWhere('howpa_ssn_hash', hash('sha256', $search));
                }
                if (preg_match('/^\d{4}$/', $search)) {
                    $qq->orWhere('ssn_hash', hash('sha256', $search));
                }
            });
        }

        $query->when(filled($filters['legal_status_id'] ?? null), function (Builder $q) use ($filters) {
            $q->where('legal_status_id', (int) $filters['legal_status_id']);
        });
        $query->when(filled($filters['identification_type_id'] ?? null), function (Builder $q) use ($filters) {
            $q->where('identification_type_id', (int) $filters['identification_type_id']);
        });
        $query->when(filled($filters['ethnicity_id'] ?? null), function (Builder $q) use ($filters) {
            $q->where('ethnicity_id', (int) $filters['ethnicity_id']);
        });
        $query->when(filled($filters['healthcare_provider_id'] ?? null), function (Builder $q) use ($filters) {
            $q->where('healthcare_provider_id', (int) $filters['healthcare_provider_id']);
        });
        $query->when(filled($filters['gender_id'] ?? null), function (Builder $q) use ($filters) {
            $q->where('gender_id', (int) $filters['gender_id']);
        });
        $hasHowpa = filter_var(
            $filters['has_howpa'] ?? null,
            FILTER_VALIDATE_BOOLEAN,
            FILTER_NULL_ON_FAILURE
        );

        $hasMeals = filter_var(
            $filters['has_meals'] ?? null,
            FILTER_VALIDATE_BOOLEAN,
            FILTER_NULL_ON_FAILURE
        );
        if ($hasHowpa === true && $hasMeals === true) {
            $query->where(function (Builder $q) {
                $q->whereHas('howpaContracts')
                    ->whereHas('contractMeals');
            });
        } elseif ($hasHowpa === true) {
            $query->whereHas('howpaContracts');
        } elseif ($hasMeals === true) {
            $query->whereHas('contractMeals');
        }
        $fromAge = filter_var($filters['from_age'] ?? null, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        $toAge   = filter_var($filters['to_age']   ?? null, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);

        if ($fromAge !== null) {
            $cutoff = Carbon::today()->subYears((int) $fromAge)->toDateString();
            $query->whereDate('dob', '<=', $cutoff)->whereNotNull('dob');
        }
        if ($toAge !== null) {
            $lower = Carbon::today()->subYears((int) $toAge + 1)->addDay()->toDateString();
            $query->whereDate('dob', '>=', $lower)->whereNotNull('dob');
        }
        $query->when(filled($filters['income_type_id'] ?? null), function (Builder $q) use ($filters) {
            $q->where('income_type_id', (int) $filters['income_type_id']);
        });
        if (filled($filters['city_district_id'] ?? null)) {
            $query->where('city_district_id', (int) $filters['city_district_id']);
        }
        if (filled($filters['countyDistrictId'] ?? null)) {
            $query->where('county_district_id', (int) $filters['countyDistrictId']);
        }
        if (filled($filters['city_id'] ?? null)) {
            $query->where('city_id', (int) $filters['city_id']);
        }
        $hispanic = filter_var(
            $filters['hispanic'] ?? null,
            FILTER_VALIDATE_BOOLEAN,
            FILTER_NULL_ON_FAILURE
        );
        if ($hispanic !== null) {
            $query->where('hispanic', $hispanic);
        }
        $deceased = filter_var(
            $filters['isDeceased'] ?? null,
            FILTER_VALIDATE_BOOLEAN,
            FILTER_NULL_ON_FAILURE
        );
        if ($deceased !== null) {
            $query->where('is_deceased', $deceased);
        }
        return $query;
    }
    public function scopeSsn(Builder $query, string|null $ssn): Builder
    {
        return $query->when($ssn, function (Builder $query, string $ssn) {
            $query->where('ssn_hash',  hash('sha256', $ssn));
        });
    }
    public function householdMembers(): HasMany
    {
        return $this->hasMany(HouseholdMember::class);
    }
    public function phoneNumbers(): HasMany
    {
        return $this->hasMany(ClientPhoneNumber::class);
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function (Client $model) {
            $model->client_number = $model->generateUniqueClientNumber();
        });
        static::saving(function (Client $model) {
            $model->income =   self::calculateIncome(
                $model->payment_amounts,
                $model->frequency_payment
            );
        });
        static::deleting(function ($model) {
            if ($model->identification_picture) {
                $model->deleteFileIfExists();
            }
            $model->loadMissing('clientFiles');
            if ($model->clientFiles) {
                foreach ($model->clientFiles as $file) {
                    $file->deleteFileIfExists();
                }
            }
        });
    }

    public function getIdentificationPictureAttribute(): string|null
    {
        $fileName = $this->attributes['identification_picture'] ?? null;
        return $fileName ? $this->getBase64Image($fileName, 'clients') : null;
    }

    public function verifyFileExist(): bool
    {
        $fileName = $this->attributes['identification_picture'] ?? null;
        return $fileName ? $this->existsFile($fileName, 'clients') : null;
    }

    public function downloadFileIfExists(): ?StreamedResponse
    {
        $fileName = $this->attributes['identification_picture'] ?? null;
        $exists = $fileName && $this->existsFile($fileName, 'clients');
        if ($exists) {
            return $this->downloadFile($fileName, 'clients');
        }
        return null;
    }
    public function deleteFileIfExists(): void
    {
        $fileName = $this->attributes['identification_picture'] ?? null;
        $exists = $fileName && $this->existsFile($fileName, 'clients');
        if ($exists) {
            $this->deleteFile($fileName, 'clients');
        }
    }
    public function getFullNameAttribute(): string
    {
        return strtoupper("$this->first_name  $this->last_name");
    }
    public function getFullAddressAttribute(): string
    {
        return strtoupper("$this->address, $this->zip_code");
    }
    public function getFullIdentificationDataAttribute(): string
    {
        $this->loadMissing('identificationType');

        $type = $this->identificationType->name ?? '';
        $number = $this->identification_number ?? '';

        return strtoupper(trim("$type $number"));
    }

    public function getFullHealthcareProviderAttribute(): string
    {
        $this->loadMissing(['healthcareProvider', 'healthcareProviderPlan']);
        $provider = $this->healthcareProvider->name ?? '';
        $plan = $this->healthcareProviderPlan->name ?? '';
        return strtoupper($plan ? "$provider, $plan" : $provider);
    }
    public function getAgeAttribute(): int
    {
        $dob = $this->dob instanceof Carbon ? $this->dob : Carbon::parse($this->dob);
        return $dob->diffInYears(now());
    }
    public function getTotalIncomeAttribute(): float|int
    {
        $this->loadMissing('householdMembers');
        $clientIncome = $this->income ?? 0;
        $membersIncome = $this->householdMembers->sum(fn($member) => $member->income ?? 0);
        return round($clientIncome + $membersIncome, 2);
    }
    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = strtoupper($value);
    }
    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = strtoupper($value);
    }
    public function setClientNumberAttribute($value)
    {
        $this->attributes['client_number'] = strtoupper($value);
    }

    public function getIncomeCategoryAttribute(): string|null
    {
        $totalIncome = $this->total_income;
        $householdSize = $this->householdMembers->count() + 1;
        $value = DB::table('income_limits')
            ->where('household_size', $householdSize)
            ->where('income_limit', '>=', $totalIncome)
            ->orderBy('percentage_category')
            ->value('percentage_category');
        return $value ? Number::percentage($value, 0) : null;
    }

    public function getHouseholdTotalAttribute(): int
    {
        return $this->householdMembers->count() + 1;
    }
    public function getDobFormattedAttribute(): string
    {
        return $this->dob ? $this->dob->format('m-d-Y') : '';
    }

    public function contractMeals(): HasMany
    {
        return $this->hasMany(ContractMeal::class);
    }
    public function contractMealsActive(): HasMany
    {
        return $this->hasMany(ContractMeal::class)->where('is_active', true);
    }

    public static function recertificationsDue(?array $filters): Builder
    {

        $today = filled($filters['date_range'] ?? null) ? explode(' - ', $filters['date_range'])[0] : Carbon::today();
        $lastDay = filled($filters['date_range'] ?? null) ? explode(' - ', $filters['date_range'])[1] : $today->copy()->addMonths(3);
        $query = static::query();
        if (filled($filters['city_district_id'] ?? null)) {
            $query->where('city_district_id', (int) $filters['city_district_id']);
        }
        if (filled($filters['county_district_id'] ?? null)) {
            $query->where('county_district_id', (int) $filters['county_district_id']);
        }
        if (filled($filters['city_id'] ?? null)) {
            $query->where('city_id', (int) $filters['city_id']);
        }

        $query->with([
            'contractMeals' => function ($query) use ($today, $lastDay, $filters) {
                $query->whereBetween('recertification_date', [$today, $lastDay]);
                $query->when(filled($filters['user_id'] ?? null), function ($q) use ($filters) {
                    $q->where('client_service_specialist_id', (int) $filters['user_id']);
                });
            },
            'howpaContracts' => function ($query) use ($today, $lastDay, $filters) {
                $query->whereBetween('re_certification_date', [$today, $lastDay]);
                $query->when(filled($filters['user_id'] ?? null), function ($q) use ($filters) {
                    $q->where('client_service_specialist_id', (int) $filters['user_id']);
                });
            },
        ]);
        $query->where(function ($q) use ($today, $lastDay) {
            $q->whereHas('contractMeals', function ($query) use ($today, $lastDay) {
                $query->whereBetween('recertification_date', [$today, $lastDay]);
            })
                ->orWhereHas('howpaContracts', function ($query) use ($today, $lastDay) {
                    $query->whereBetween('re_certification_date', [$today, $lastDay]);
                });
        });
        return $query;
    }
    public static function identificationsOverdue(?array $filters): Builder
    {
        $today = now();
        $query = static::with(['identificationType', 'legalStatus']);
        if (filled($filters['city_district_id'] ?? null)) {
            $query->where('city_district_id', (int) $filters['city_district_id']);
        }
        if (filled($filters['county_district_id'] ?? null)) {
            $query->where('county_district_id', (int) $filters['county_district_id']);
        }
        if (filled($filters['city_id'] ?? null)) {
            $query->where('city_id', (int) $filters['city_id']);
        }
        if (filled($filters['date_range'] ?? null)) {
            $dateRange = explode(' - ', $filters['date_range']);
            if (count($dateRange) === 2) {
                $startDate = Carbon::parse(trim($dateRange[0]));
                $endDate = Carbon::parse(trim($dateRange[1]));
                $query->whereBetween('identification_expiration_date', [$startDate, $endDate]);
            }
        } else {
            $query->where('identification_expiration_date', '<', $today);
        }
        $query->whereHas('legalStatus', function (Builder $query) {
            $query->whereRaw('LOWER(name) != ?', ['citizen']);
        });

        return $query;
    }
    public static function identificationsOverdueCount(): int
    {
        return static::identificationsOverdue([])->get()->count();
    }
    public static function identificationsDue(?array $filters): Builder
    {
        $today = now();
        $lastDay = $today->copy()->addMonths(3);
        return static::query()
            ->join('legal_statuses', 'clients.legal_status_id', '=', 'legal_statuses.id')
            ->join('identification_types', 'clients.identification_type_id', '=', 'identification_types.id')
            ->whereRaw('LOWER(legal_statuses.name) != ?', ['citizen'])
            ->when(!empty($filters['city_district_id'] ?? null), function (Builder $query) use ($filters) {
                $query->where('clients.city_district_id', $filters['city_district_id']);
            })
            ->when(!empty($filters['county_district_id'] ?? null), function (Builder $query) use ($filters) {
                $query->where('clients.county_district_id', $filters['county_district_id']);
            })
            ->when(!empty($filters['city_id'] ?? null), function (Builder $query) use ($filters) {
                $query->where('clients.city_id', $filters['city_id']);
            })
            ->when(!empty($filters['date_range'] ?? null), function (Builder $query) use ($filters) {
                $dateRange = explode(' - ', $filters['date_range']);
                if (count($dateRange) === 2) {
                    $startDate = Carbon::parse(trim($dateRange[0]))->startOfDay();
                    $endDate = Carbon::parse(trim($dateRange[1]))->endOfDay();
                    $query->where('clients.identification_expiration_date', '>=', $startDate)
                        ->where('clients.identification_expiration_date', '<=', $endDate);
                }
            })
            ->whereBetween('clients.identification_expiration_date', [$today, $lastDay])
            ->select([
                'clients.*',
                DB::raw("CONCAT(clients.first_name, ' ', clients.last_name) AS full_name"),
                DB::raw("CONCAT(identification_types.name, ' - ', clients.identification_number) AS identification_data"),
                'legal_statuses.name as legal_status_name'
            ]);
    }
    public static function identificationsDueCount(): int
    {
        return static::identificationsDue([])->get()->count();
    }

    public static function  recertificationsOverdue(?array $filters): Builder
    {
        $today = Carbon::today();
        $rangeStart = null;
        $rangeEnd   = null;
        if (filled($filters['date_range'] ?? null)) {
            $parts = explode(' - ', $filters['date_range']);
            if (count($parts) === 2) {
                $rangeStart = Carbon::parse(trim($parts[0]))->startOfDay();
                $rangeEnd   = Carbon::parse(trim($parts[1]))->endOfDay();
            }
        }
        $query = static::query();
        if (filled($filters['city_district_id'] ?? null)) {
            $query->where('city_district_id', (int) $filters['city_district_id']);
        }
        if (filled($filters['county_district_id'] ?? null)) {
            $query->where('county_district_id', (int) $filters['county_district_id']);
        }
        if (filled($filters['city_id'] ?? null)) {
            $query->where('city_id', (int) $filters['city_id']);
        }
        $applyMeals = function ($q) use ($today, $rangeStart, $rangeEnd, $filters) {
            if ($rangeStart && $rangeEnd) {
                $q->whereBetween('recertification_date', [$rangeStart, $rangeEnd]);
            } else {
                // Overdue: fecha <= hoy
                $q->where('recertification_date', '<=', $today);
            }

            if (filled($filters['user_id'] ?? null)) {
                $q->where('client_service_specialist_id', (int) $filters['user_id']);
            }
        };
        $applyHowpa = function ($q) use ($today, $rangeStart, $rangeEnd, $filters) {
            if ($rangeStart && $rangeEnd) {
                $q->whereBetween('re_certification_date', [$rangeStart, $rangeEnd]);
            } else {
                // Overdue: fecha <= hoy
                $q->where('re_certification_date', '<=', $today);
            }

            if (filled($filters['user_id'] ?? null)) {
                $q->where('client_service_specialist_id', (int) $filters['user_id']);
            }
        };
        $query->with([
            'contractMeals'   => $applyMeals,
            'howpaContracts'  => $applyHowpa,
        ]);
        $query->where(function ($q) use ($applyMeals, $applyHowpa) {
            $q->whereHas('contractMeals', $applyMeals)
                ->orWhereHas('howpaContracts', $applyHowpa);
        });


        return $query;
    }
    public static function recertificationsDueCount(): int
    {
        $today = Carbon::today();
        $lastDay = $today->copy()->addMonths(3);

        return static::query()
            ->join('contract_meals', 'contract_meals.client_id', '=', 'clients.id')
            ->where('contract_meals.is_active', true)
            ->whereBetween('contract_meals.recertification_date', [$today, $lastDay])
            ->distinct()
            ->count('clients.id');
    }

    public static function recertificationsOverdueCount(): int
    {
        $today = Carbon::today();

        return static::query()
            ->join('contract_meals', 'contract_meals.client_id', '=', 'clients.id')
            ->where('contract_meals.is_active', true)
            ->whereDate('contract_meals.recertification_date', '<', $today)
            ->distinct()
            ->count('clients.id');
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
    public function getIncomeMonthlyAttribute(): string
    {
        return $this->convertToCurrencyFormat($this->income);
    }
    public function getTotalIncomeMonthlyAttribute(): string
    {
        return $this->convertToCurrencyFormat($this->total_income);
    }

    public function howpaContracts(): HasMany
    {
        return $this->hasMany(HowpaContract::class, 'client_id');
    }

    public function setSsnAttribute($value)
    {
        $this->attributes['ssn'] = encrypt($value);
        $this->attributes['ssn_hash'] = hash('sha256', $value);
    }
    public function setHowpaSsnAttribute($value)
    {
        $this->attributes['howpa_ssn'] = encrypt($value);
        $this->attributes['howpa_ssn_hash'] = hash('sha256', $value);
    }
    public function getSsnAttribute(): string|null
    {
        $ssn = $this->attributes['ssn'] ?? null;
        return $ssn ? decrypt($ssn) : null;
    }
    public function getHowpaSsnAttribute(): string|null
    {
        $ssn = $this->attributes['howpa_ssn'] ?? null;
        return $ssn ? decrypt($ssn) : null;
    }

    public function emergencyContacts(): HasMany
    {
        return $this->hasMany(EmergencyContact::class, 'client_id');
    }

    public function generateUniqueClientNumber(): string
    {

        $year = now()->format('y');
        $lastId = self::latest('id')->value('id') ?? 0;
        return sprintf('%s-%03d', $year, $lastId + 1);
    }

    public static function isAvailableHowpaSsn(string $ssn, int|null $clientId = null): bool
    {
        if (!preg_match('/^\d{3}-\d{2}-\d{4}$/', $ssn)) {
            return false;
        }
        return static::query()
            ->where('howpa_ssn_hash', hash('sha256', $ssn))
            ->when($clientId, function (Builder $query) use ($clientId) {
                $query->where('id', '!=', $clientId);
            })
            ->doesntExist();
    }

    public function setHowpaClientNumberAttribute($value)
    {
        $this->attributes['howpa_client_number'] = strtoupper($value);
    }
    public static function clientHasHowpaContractActive(string $date, int $clientId): bool
    {
        return static::query()
            ->whereHas('howpaContracts', function (Builder $query) use ($date) {
                $query->whereDate('date', '<=', $date)
                    ->whereDate('re_certification_date', '>=', $date);
            })
            ->where('id', $clientId)
            ->exists();
    }

    public function getIdentificationDataAttribute()
    {
        $this->loadMissing('identificationType');
        return $this->identificationType ? "{$this->identificationType->name} - {$this->identification_number}" : null;
    }

    public function inspections(): BelongsToMany
    {
        return $this->belongsToMany(Inspection::class, 'client_inspection');
    }
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }
    public function housingStatus(): BelongsTo
    {
        return $this->belongsTo(HousingStatus::class);
    }
    public function ethnicity(): BelongsTo
    {
        return $this->belongsTo(Ethnicity::class);
    }
    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class);
    }

    public function getAddressFormattedAttribute(): string|null
    {
        $address = $this->address;
        return $address ? $address->address_formatted : "";
    }
}
