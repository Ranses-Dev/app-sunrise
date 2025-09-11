<?php

namespace App\Livewire\Forms;

use App\Enums\RecentLivingSituation;
use Illuminate\Validation\Rule;
use Livewire\Form;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use App\Repositories\HowpaContractRepositoryInterface;
use App\Repositories\ClientRepositoryInterface;
use App\Repositories\CityRepositoryInterface;
use App\Repositories\ClientPhoneNumberRepositoryInterface;
use App\Repositories\EmergencyContactRepositoryInterface;
use App\Repositories\IncomeTypeRepositoryInterface;
use App\Models\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use App\Models\EmergencyContact;
use App\Repositories\CityDistrictRepositoryInterface as CityDistrictRepository;
use App\Repositories\CountyDistrictRepositoryInterface as CountyDistrictRepository;
use App\Repositories\CityRepositoryInterface as CityRepository;
use App\Enums\HowpaContractColumns;


class HowpaContract extends Form
{
    public ?int $id = null;
    public ?int $clientId = null;
    public ?int $emergencyContactOneId = null;
    public ?int $emergencyContactTwoId = null;
    public ?Client $client = null;
    public ?int $clientPhoneNumberId = null;
    public ?Collection $clientPhoneNumbers = null;
    public ?SupportCollection $recentLivingSituations = null;
    public ?int $cityId = null;
    public ?Collection $cities = null;
    public ?string $date = null;
    public ?string $reCertificationDate = null;
    public ?string $enrollmentDay = null;
    public ?int $numberBedroomsReq = null;
    public ?int $numberBedroomsApproved = null;
    public ?string $recentLivingSituation = null;
    public ?string $recentLivingSituationNotes = null;
    public bool $ownsRealEstate = false;
    public bool $ownAnyStockOrBonds = false;
    public bool $hasSavings = false;
    public ?string $howpaClientNumber = null;
    public ?string $savingsBalance = null;
    public bool $hasCheckingAccount = false;
    public ?string $checkingAvgBalanceSixMonths = null;
    public ?string $assetsNotes = null;
    public bool $outsideSupport = false;
    public ?string $outsideSupportExplanation = null;
    public bool $committedFraudOrAskedToRepay = false;
    public ?string $fraudExplanation = null;
    public bool $hasAids = false;
    public bool $howpaPriorTo2023 = false;
    public bool $currentlyReceivingOtherAid = false;
    public bool $agreedStatements = false;
    public   $clientServiceSpecialists = null;
    public  $incomeTypes = null;
    public ?int $incomeTypeId = null;
    public ?int $clientServiceSpecialistId = null;
    public ?string $howpaSsn = null;
    public bool $isActive = true;
    public $cityDistrictsFilter = null;
    public $countyDistrictsFilter = null;
    public $citiesFilter = null;
    public array $filters = [
        'programBranchId' => null,
        'clientId' => null,
        'clientServiceSpecialistId' => null,
        'rangeDate' => null,
        'rangeReCertificationDate' => null,
        'rangeEnrollmentDay' => null,
        'isActive' => true,
        'countyDistrictId' => null,
        'cityDistrictId' => null,
        'cityId' => null
    ];
    public array $columnsSelected = [];
    public array $columns = [];
    public ?Collection $emergencyContacts = null;
    public ?int $emergencyContactId = null;
    public ?Collection $programBranches = null;
    public ?int $programBranchId = null;
    public ?EmergencyContact $emergencyContactOne = null;
    public ?EmergencyContact $emergencyContactTwo = null;
    protected HowpaContractRepositoryInterface $howpaContractRepository;
    protected ClientRepositoryInterface $clientRepository;
    protected ClientPhoneNumberRepositoryInterface $clientPhoneNumberRepository;
    protected EmergencyContactRepositoryInterface $emergencyContactRepository;
    protected IncomeTypeRepositoryInterface $incomeTypeRepository;
    protected CityDistrictRepository $cityDistrictRepository;
    protected CountyDistrictRepository $countyDistrictRepository;
    protected CityRepository $cityRepository;
    public function boot()
    {
        $this->howpaContractRepository = app(HowpaContractRepositoryInterface::class);
        $this->clientRepository = app(ClientRepositoryInterface::class);
        $this->cityRepository = app(CityRepositoryInterface::class);
        $this->clientPhoneNumberRepository = app(ClientPhoneNumberRepositoryInterface::class);
        $this->emergencyContactRepository = app(EmergencyContactRepositoryInterface::class);
        $this->incomeTypeRepository = app(IncomeTypeRepositoryInterface::class);
        $this->cityDistrictRepository = app(CityDistrictRepository::class);
        $this->countyDistrictRepository = app(CountyDistrictRepository::class);
        $this->cityRepository = app(CityRepository::class);
    }
    public function rules()
    {
        return  [
            'clientId' => ['required', Rule::exists('clients', 'id'), function ($attribute, $value, $fail) {
                if (!$this->id && $this->date && $this->clientRepository->hasHowpaContractActive($this->date, $value)) {
                    $fail('The client already has an active HOWPA contract for the selected date.');
                }
            }],
            'cityId' => 'required|exists:cities,id',
            'clientPhoneNumberId' => 'required|exists:client_phone_numbers,id',
            'programBranchId' => 'required|exists:program_branches,id',
            'date' => ['required', 'date', 'before:reCertificationDate'],
            'reCertificationDate' => ['required', 'date', 'after:date'],
            'numberBedroomsReq' => [
                'nullable',
                'integer',
                'min:0'
            ],
            'numberBedroomsApproved' => 'nullable|integer|min:0',
            'clientServiceSpecialistId' => ['required',  function ($attribute, $value, $fail) {
                if ($this->programBranchId) {
                    $exists = $this->clientRepository->getClientServiceSpecialistsByProgramBranch($this->programBranchId)
                        ->contains('id', $value);
                    if (!$exists) {
                        $fail('The selected client service specialist does not belong to the program of the meal contract type.');
                    }
                } else {
                    $fail('The meal contract type must be selected to validate the client service specialist.');
                }
            },],
            'recentLivingSituation' => ['required', 'string', Rule::in(collect(RecentLivingSituation::cases())->pluck('name')->toArray())],
            'recentLivingSituationNotes' => ['nullable', 'string', Rule::excludeIf($this->recentLivingSituation !== RecentLivingSituation::OTHER->name), Rule::requiredIf($this->recentLivingSituation === RecentLivingSituation::OTHER->name), 'max:255'],
            'ownsRealEstate' => 'boolean',
            'hasSavings' => 'boolean',
            'savingsBalance' => ['nullable', 'numeric', 'min:0', Rule::requiredIf(fn() => $this->hasSavings)],
            'hasCheckingAccount' => 'boolean',
            'checkingAvgBalanceSixMonths' => ['nullable', 'numeric', 'min:0', Rule::requiredIf(fn() => $this->hasCheckingAccount)],
            'assetsNotes' => ['nullable', 'string', 'max:255'],
            'outsideSupport' => 'boolean',
            'outsideSupportExplanation' => ['nullable', 'string', 'max:255', Rule::excludeIf(!$this->outsideSupport), Rule::requiredIf($this->outsideSupport)],
            'committedFraudOrAskedToRepay' => 'boolean',
            'fraudExplanation' => ['nullable', 'string', 'max:255'],
            'hasAids' => 'boolean',
            'howpaPriorTo2023' => 'boolean',
            'currentlyReceivingOtherAid' => 'boolean',
            'agreedStatements' => 'boolean',
            'emergencyContactOneId' => 'nullable|exists:emergency_contacts,id',
            'emergencyContactTwoId' => 'nullable|exists:emergency_contacts,id',
            'howpaClientNumber' => ['nullable', 'string', function ($attribute, $value, $fail) {
                if ($value && $this->clientRepository->existsHowpaClientNumber($value, $this->clientId)) {
                    $fail('The HOWPA client number has already been taken.');
                }
            }],
            'howpaSsn' => ['required', 'string', 'regex:/^\d{3}-\d{2}-\d{4}$/', function ($attribute, $value, $fail) {
                if (!$this->clientRepository->isValidHowpaSsn($value, $this->clientId)) {
                    $fail('The SSN is invalid.');
                }
            }],
            'enrollmentDay' => ['required', 'date'],
            'isActive' => 'boolean',
            'incomeTypeId' => 'required|exists:income_types,id',
        ];
    }
    public function messages(): array
    {
        return [

            'clientId.required' => 'Client is required.',
            'clientId.exists' => 'Selected client does not exist.',

            'cityId.required' => 'City is required.',
            'cityId.exists' => 'Selected city does not exist.',
            'clientPhoneNumberId.required' => 'Phone number is required.',
            'clientPhoneNumberId.exists' => 'Selected phone number does not exist.',
            'programBranchId.required' => 'Program branch is required.',
            'programBranchId.exists' => 'Selected program branch does not exist.',

            'date.required' => 'Date is required.',
            'date.date' => 'Date must be a valid date.',

            'numberBedroomsReq.required' => 'Number of bedrooms requested is required.',
            'numberBedroomsReq.integer' => 'Number of bedrooms requested must be an integer.',
            'numberBedroomsReq.min' => 'Number of bedrooms requested cannot be negative.',

            'numberBedroomsApproved.required' => 'Number of bedrooms approved is required.',
            'numberBedroomsApproved.integer' => 'Number of bedrooms approved must be an integer.',
            'numberBedroomsApproved.min' => 'Number of bedrooms approved cannot be negative.',

            'recentLivingSituation.required' => 'Recent living situation is required.',
            'recentLivingSituation.in' => 'Selected recent living situation is invalid.',

            'recentLivingSituationNotes.required_if' => 'Please provide details for the recent living situation.',
            'recentLivingSituationNotes.max' => 'Recent living situation notes cannot exceed 255 characters.',

            'ownsRealEstate.boolean' => 'Owns real estate must be true or false.',

            'hasSavings.boolean' => 'Has savings must be true or false.',
            'savingsBalance.numeric' => 'Savings balance must be a valid number.',
            'savingsBalance.min' => 'Savings balance cannot be negative.',

            'hasCheckingAccount.boolean' => 'Has checking account must be true or false.',
            'checkingAvgBalanceSixMonths.numeric' => 'Average checking balance must be a valid number.',
            'checkingAvgBalanceSixMonths.min' => 'Average checking balance cannot be negative.',

            'assetsNotes.max' => 'Assets notes cannot exceed 255 characters.',

            'outsideSupport.boolean' => 'Outside support must be true or false.',
            'outsideSupportExplanation.required_if' => 'Please explain the outside support.',
            'outsideSupportExplanation.max' => 'Outside support explanation cannot exceed 255 characters.',

            'committedFraudOrAskedToRepay.boolean' => 'Fraud history must be true or false.',
            'fraudExplanation.max' => 'Fraud explanation cannot exceed 255 characters.',

            'hasAids.boolean' => 'This field must be true or false.',
            'howpaPriorTo2023.boolean' => 'This field must be true or false.',
            'currentlyReceivingOtherAid.boolean' => 'This field must be true or false.',

            'agreedStatements.boolean' => 'You must agree to the statements.',
            'emergencyContactOneId.exists' => 'Selected emergency contact one does not exist.',
            'emergencyContactTwoId.exists' => 'Selected emergency contact two does not exist.',

            'clientId.exists' => 'Selected client does not exist.',
            'enrollmentDay.required' => 'Enrollment day is required.',
            'enrollmentDay.date' => 'Enrollment day must be a valid date.',


        ];
    }
    public function setData(?int $id = null)
    {
        if ($id) {
            $result = $this->howpaContractRepository->findById($id);
            if ($result) {
                $this->id = $result->id;
                $this->clientId = $result->client_id;
                $this->getClientById($this->clientId);
                $this->programBranchId = $result->program_branch_id;
                $this->date = $result->date?->format('Y-m-d');
                $this->reCertificationDate = $result->re_certification_date?->format('Y-m-d');
                $this->numberBedroomsReq = $result->number_bedrooms_req;
                $this->numberBedroomsApproved = $result->number_bedrooms_approved;
                $this->getRecentLivingSituations();
                $this->recentLivingSituation = $result->recent_living_situation;
                $this->recentLivingSituationNotes = $result->recent_living_situation_notes;
                $this->ownsRealEstate = $result->owns_real_estate;
                $this->hasSavings = $result->has_savings;
                $this->savingsBalance = $result->savings_balance;
                $this->hasCheckingAccount = $result->has_checking_account;
                $this->checkingAvgBalanceSixMonths = $result->checking_avg_balance_six_months;
                $this->assetsNotes = $result->assets_notes;
                $this->outsideSupport = $result->outside_support;
                $this->outsideSupportExplanation = $result->outside_support_explanation;
                $this->committedFraudOrAskedToRepay = $result->committed_fraud_or_asked_to_repay;
                $this->fraudExplanation = $result->fraud_explanation;
                $this->hasAids = $result->has_aids;
                $this->howpaPriorTo2023 = $result->howpa_prior_to_2023;
                $this->currentlyReceivingOtherAid = $result->currently_receiving_other_aid;
                $this->agreedStatements = $result->agreed_statements;
                $this->emergencyContactOneId = $result->emergency_contact_one_id;
                $this->emergencyContactTwoId = $result->emergency_contact_two_id;
                $this->howpaClientNumber = $result->client?->howpa_client_number;
                $this->howpaSsn = $result->client?->howpa_ssn;
                $this->getProgramBranches();
                $this->programBranchId = $result->program_branch_id;
                $this->getclientServiceSpecialists();
                $this->clientServiceSpecialistId = $result->client_service_specialist_id;
                $this->getCities();
                $this->cityId = $result->city_id;
                $this->getClientPhoneNumbers();
                $this->clientPhoneNumberId = $result->phone_number_id;
                $this->ownAnyStockOrBonds = $result->own_any_stock_or_bonds;
                $this->emergencyContactOneId = $result->emergency_contact_one_id;
                $this->getEmergencyContactOne();
                $this->emergencyContactTwoId = $result->emergency_contact_two_id;
                $this->getEmergencyContactTwo();
                $this->enrollmentDay = $result->enrollment_day?->format('Y-m-d');
                $this->isActive = (bool)$result->is_active;
                $this->getIncomeTypes();
                $this->incomeTypeId = $result->client?->income_type_id;
            }
        }
    }

    public function save()
    {
        $this->validate($this->rules(), $this->messages());
        $data = [
            'client_id' => $this->clientId,
            'city_id' => $this->cityId,
            'phone_number_id' => $this->clientPhoneNumberId,
            'program_branch_id' => $this->programBranchId,
            'date' => $this->date,
            're_certification_date' => $this->reCertificationDate,
            'client_service_specialist_id' => $this->clientServiceSpecialistId,
            'number_bedrooms_req' => $this->numberBedroomsReq,
            'number_bedrooms_approved' => $this->numberBedroomsApproved,
            'recent_living_situation' => $this->recentLivingSituation,
            'recent_living_situation_notes' => $this->recentLivingSituationNotes,
            'owns_real_estate' => $this->ownsRealEstate,
            'own_any_stock_or_bonds' => $this->ownAnyStockOrBonds,
            'has_savings' => $this->hasSavings,
            'savings_balance' => $this->savingsBalance,
            'has_checking_account' => $this->hasCheckingAccount,
            'checking_avg_balance_six_months' => $this->checkingAvgBalanceSixMonths,
            'assets_notes' => $this->assetsNotes,
            'outside_support' => $this->outsideSupport,
            'outside_support_explanation' => $this->outsideSupportExplanation,
            'committed_fraud_or_asked_to_repay' => $this->committedFraudOrAskedToRepay,
            'fraud_explanation' => $this->fraudExplanation,
            'has_aids' => $this->hasAids,
            'howpa_prior_to_2023' => $this->howpaPriorTo2023,
            'currently_receiving_other_aid' => $this->currentlyReceivingOtherAid,
            'agreed_statements' => $this->agreedStatements,
            'emergency_contact_one_id' => $this->emergencyContactOneId,
            'emergency_contact_two_id' => $this->emergencyContactTwoId,
            'enrollment_day' => $this->enrollmentDay,
            'is_active' => $this->isActive,

        ];

        if ($this->id) {
            $this->howpaContractRepository->update($this->id, $data);
        } else {
            $this->howpaContractRepository->create($data);
        }
        $this->clientRepository->update($this->clientId, [
            'howpa_client_number' => $this->howpaClientNumber,
            'howpa_ssn' => $this->howpaSsn,
            'income_type_id' => $this->incomeTypeId,
        ]);
        $this->reset();
    }
    public function delete()
    {
        if ($this->id) {
            $this->howpaContractRepository->delete($this->id);
        }
    }
    #[Computed]
    public function result(): LengthAwarePaginator
    {
        return $this->howpaContractRepository->getFiltered($this->filters)->paginate(pageName: 'howpa_contracts');
    }
    public function findClientBySsn(string $ssn): ?Client
    {
        $this->client = $this->clientRepository->findBySsn($ssn);
        if ($this->client) {
            $this->clientId = $this->client->id;
        }
        if (!$this->client) {
            session()->flash('ssnSearch', 'Client not found for the provided SSN.');
        }
        $this->getCities();
        $this->getClientPhoneNumbers();
        $this->getEmergencyContacts();
        $this->getIncomeTypes();
        return $this->client;
    }

    public function getCities()
    {

        $this->cities = $this->cityRepository->getAll();
    }
    public function getClientPhoneNumbers()
    {
        $this->reset(['clientPhoneNumberId', 'clientPhoneNumbers']);
        if ($this->clientId) {

            $this->clientPhoneNumbers = $this->clientPhoneNumberRepository->getAllByClientId($this->clientId);
        }
    }

    public function getRecentLivingSituations()
    {
        $this->recentLivingSituations = collect(RecentLivingSituation::cases());
    }

    public function getEmergencyContacts()
    {

        $this->emergencyContacts = $this->emergencyContactRepository->getFiltered(null, $this->clientId)
            ->when($this->emergencyContactOne, function ($query) {
                $query->where('id', '!=', $this->emergencyContactOne->id);
            })
            ->when($this->emergencyContactTwo, function ($query) {
                $query->where('id', '!=', $this->emergencyContactTwo->id);
            })
            ->get();
    }
    public function getEmergencyContactOne()
    {
        $this->validate([
            'emergencyContactId' => ['nullable', 'exists:emergency_contacts,id', Rule::requiredIf(fn() => !$this->emergencyContactOneId)],
            'emergencyContactOneId' => ['nullable', 'exists:emergency_contacts,id', Rule::requiredIf(fn() => !$this->emergencyContactId)],
        ]);

        $this->emergencyContactOne = $this->emergencyContactId ? $this->emergencyContactRepository->findById($this->emergencyContactId) : $this->emergencyContactRepository->findById($this->emergencyContactOneId);
        $this->emergencyContactOneId = $this->emergencyContactOne?->id;
        $this->reset(['emergencyContactId']);
        $this->getEmergencyContacts();
    }
    public function getEmergencyContactTwo()
    {
        $this->validate([
            'emergencyContactId' => ['nullable', 'exists:emergency_contacts,id'],
            'emergencyContactTwoId' => ['nullable', 'exists:emergency_contacts,id', Rule::requiredIf(fn() => !$this->emergencyContactId)],
        ]);
        $this->emergencyContactTwo = $this->emergencyContactId ? $this->emergencyContactRepository->findById($this->emergencyContactId) : $this->emergencyContactRepository->findById($this->emergencyContactTwoId);
        $this->emergencyContactTwoId = $this->emergencyContactTwo?->id;
        $this->reset(['emergencyContactId']);
        $this->getEmergencyContacts();
    }

    public function getClientById(int $id)
    {
        $this->client = $this->clientRepository->findById($id);
        $this->howpaSsn = $this->client?->howpa_ssn;
        $this->howpaClientNumber = $this->client?->howpa_client_number;
    }
    public function getProgramBranches()
    {
        $this->programBranches = $this->howpaContractRepository->getProgramBranches();
    }
    public function getClientServiceSpecialists()
    {
        $this->clientServiceSpecialists = $this->clientRepository->getClientServiceSpecialistsByProgram((int)config('services.programs.howpa_id'));
    }
    public function getIncomeTypes()
    {
        $this->incomeTypes = $this->incomeTypeRepository->getAll();
    }

    public function getCityDistricts()
    {
        $this->cityDistrictsFilter =   $this->cities = $this->cityDistrictRepository->getAll();
    }
    public function getCountyDistricts()
    {
        $this->countyDistrictsFilter = $this->countyDistrictRepository->getAll();
    }
    public function getCitiesFilter()
    {
        $this->citiesFilter = $this->cityRepository->getCityByDistrictId($this->filters['countyDistrictId'] ?? null);
    }
    public function getColumnsDefault()
    {
        $this->columnsSelected = collect(HowpaContractColumns::options())
            ->filter(fn($column) => ($column['default'] ?? false) === true)
            ->pluck('value')
            ->all();
    }
    public function getColumnsOptions()
    {
        $this->columns = collect(HowpaContractColumns::options())
            ->map(fn($column) => [
                'value' => $column['value'],
                'label' => $column['label'],
                'default' => $column['default'] ?? false,
            ])
            ->all();
    }
}
