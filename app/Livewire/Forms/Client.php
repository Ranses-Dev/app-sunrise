<?php

namespace App\Livewire\Forms;


use App\Enums\PaymentFrequency;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Form;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;
use Illuminate\Support\Carbon;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use App\Repositories\ClientRepositoryInterface as ClientRepository;
use App\Repositories\LegalStatusRepositoryInterface as LegalStatusRepository;
use App\Repositories\IdentificationTypeRepositoryInterface as IdentificationTypeRepository;
use App\Repositories\CityDistrictRepositoryInterface as CityDistrictRepository;
use App\Repositories\CountyDistrictRepositoryInterface as CountyDistrictRepository;
use App\Repositories\CityRepositoryInterface as CityRepository;
use App\Repositories\HealthcareProviderRepositoryInterface as HealthcareProviderRepository;
use App\Repositories\HealthcareProviderPlanRepositoryInterface as HealthcareProviderPlanRepository;
use App\Repositories\GenderRepositoryInterface as GenderRepository;
use App\Repositories\EthnicityRepositoryInterface as EthnicityRepository;
use App\Repositories\HousingStatusRepositoryInterface as HousingStatusRepository;
use App\Repositories\AddressRepositoryInterface as AddressRepository;
use App\Traits\ImageHandler;
use App\Repositories\IncomeTypeRepositoryInterface as IncomeTypeRepository;
use App\Enums\ClientColumns;

class Client extends Form
{
    use WithFileUploads, ImageHandler;
    public ?int $id = null;
    public ?string $firstName = null;
    public ?string $lastName = null;
    public ?string $dob = null;
    public ?string $effectiveDate = null;
    public ?string $ssn = null;
    public ?int $legalStatusId = null;
    public ?int $identificationTypeId = null;
    public ?string $identificationNumber = null;
    public ?string $identificationExpirationDate = null;
    public ?string $identificationPictureBase64 = null;
    public  $identificationPicture = null;
    public ?string $identificationPictureName = "";
    public ?int $cityDistrictId = null;
    public ?int $countyDistrictId = null;
    public ?int $cityId = null;
    public ?string $email = null;
    public ?int $genderId = null;
    public ?float $income = null;
    public ?int $ethnicityId = null;
    public ?int $healthcareProviderId = null;
    public ?int $healthcareProviderPlanId = null;
    public ?int $housingStatusId = null;
    public ?int $incomeTypeId = null;
    public ?string $clientNumber = null;
    public ?bool $existsFileIdentificationCard = null;
    public bool $isDeceased = false;
    public bool $hispanic = false;
    protected ClientRepository $clientRepository;
    protected LegalStatusRepository $legalStatusRepository;
    protected IdentificationTypeRepository $identificationTypeRepository;
    protected CityDistrictRepository $cityDistrictRepository;
    protected CountyDistrictRepository $countyDistrictRepository;
    protected CityRepository $cityRepository;
    protected HealthcareProviderRepository $healthcareProviderRepository;
    protected HealthcareProviderPlanRepository $healthcareProviderPlanRepository;
    protected GenderRepository $genderRepository;
    protected EthnicityRepository $ethnicityRepository;
    protected HousingStatusRepository $housingStatusRepository;
    protected AddressRepository $addressRepository;
    protected IncomeTypeRepository $incomeTypeRepository;
    public $statuses = null;
    public $identificationTypes = null;
    public $cityDistricts = null;
    public $countyDistricts = null;
    public $cities = null;
    public $citiesFiltered = null;
    public $healthcareProviders = null;
    public $healthcareProviderPlans = null;
    public $genders = null;
    public $ethnicities = null;
    public $housingStatuses = null;
    public $incomeTypes = null;


    //For Address
    public ?int $addressId = null;
    public ?string $addressFormatted = null;
    public ?string $addressPostalCode = null;
    public ?string $addressCountyName = null;
    public ?string $addressCityName = null;
    public ?string $addressStateAbbreviation = null;

    //For Payments
    public bool $editAddPayment = false;
    public array $paymentAmounts = [];
    public  float|null $paymentAmount = 0;
    public string|null $frequencyPayment = null;

    //Filters
    public array $filters = [
        'search' => '',
        'legal_status_id' => '',
        'identification_type_id' => '',
        'ethnicity_id' => '',
        'healthcare_provider_id' => '',
        'gender_id' => '',
        'income_type_id' => '',
        'has_howpa' => false,
        'has_meals' => false,
        'from_age' => null,
        'to_age' => null,
        'city_district_id' => null,
        'countyDistrictId' => null,
        'city_id' => null,
        'hispanic' => null,
        'isDeceased' => null

    ];
    public array $columnsSelected = [];
    public array $columns = [];

    public function boot()
    {
        $this->clientRepository = app(ClientRepository::class);
        $this->legalStatusRepository = app(LegalStatusRepository::class);
        $this->identificationTypeRepository = app(IdentificationTypeRepository::class);
        $this->cityDistrictRepository = app(CityDistrictRepository::class);
        $this->countyDistrictRepository = app(CountyDistrictRepository::class);
        $this->cityRepository = app(CityRepository::class);
        $this->healthcareProviderRepository = app(HealthcareProviderRepository::class);
        $this->healthcareProviderPlanRepository = app(HealthcareProviderPlanRepository::class);
        $this->genderRepository = app(GenderRepository::class);
        $this->ethnicityRepository = app(EthnicityRepository::class);
        $this->housingStatusRepository = app(HousingStatusRepository::class);
        $this->addressRepository = app(AddressRepository::class);
        $this->incomeTypeRepository = app(IncomeTypeRepository::class);
    }

    public function rules(): array
    {
        return [
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'dob' => ['required', 'date', 'before:today'],
            'effectiveDate' => ['required', 'date', 'after_or_equal:dob', 'before_or_equal:today'],
            'ssn' => ['required', 'string', 'regex:/^\d{4}$/'],
            'paymentAmounts' => ['nullable', 'array', function ($attribute, $value) {
                if ($this->editAddPayment && empty($value)) {
                    $this->addError($attribute, 'The payments amount field is required when adding a payment.');
                } else {
                    foreach ($value as $amount) {
                        if (!is_numeric($amount) || $amount <= 0) {
                            $this->addError($attribute, 'Each payment amount must be a positive number.');
                        }
                    }
                }
            }],
            'frequencyPayment' => ['nullable', 'string', Rule::requiredIf($this->editAddPayment), Rule::in(PaymentFrequency::values())],
            'legalStatusId' => ['required', 'exists:legal_statuses,id'],
            'identificationTypeId' => ['required', 'exists:identification_types,id'],
            'identificationNumber' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) {
                if (filled($this->identificationTypeId) && filled($value)) {
                    if ($this->clientRepository->clientExistsByIdentification($this->identificationTypeId, $value, $this->id)) {
                        $fail('The identification number has already been taken for the selected identification type.');
                    }
                } else {
                    $fail('The identification type and identification number are required.');
                }
            }],
            'identificationExpirationDate' => [
                'required',
                'nullable',
                'date',
            ],
            'identificationPicture' => [
                'nullable',
                'file',
                'max:4096',
                'mimes:jpeg,png,jpg,pdf',
                new RequiredIf(fn(): bool => empty($this->identificationPictureBase64) && !$this->id)
            ],
            'identificationPictureBase64' => [
                new RequiredIf(fn(): bool => $this->identificationPicture === null && !$this->id),
                'nullable',
                'string'

            ],
            'cityDistrictId' => ['nullable', 'exists:city_districts,id'],
            'countyDistrictId' => ['nullable', Rule::requiredIf(fn(): bool => empty($this->cityDistrictId)), 'exists:county_districts,id'],
            'cityId' => [
                Rule::requiredIf(fn(): bool => !empty($this->countyDistrictId)),
                'nullable',
                'exists:cities,id',
            ],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('clients', 'email')->ignore($this->id)],
            'genderId' => ['required', 'exists:genders,id'],
            'ethnicityId' => ['required', 'exists:ethnicities,id'],
            'healthcareProviderId' => ['required', 'exists:healthcare_providers,id'],
            'healthcareProviderPlanId' => [
                new RequiredIf(fn(): bool => $this->healthcareProviderId && $this->healthcareProviderRepository->hasPlans($this->healthcareProviderId)),
                'nullable',
                'exists:healthcare_provider_plans,id',
            ],
            'housingStatusId' => ['nullable', 'exists:housing_statuses,id'],
            'addressId' => ['required', 'exists:addresses,id'],
            'hispanic' => ['required', 'boolean'],
            'isDeceased' => ['required', 'boolean'],
            'incomeTypeId' => ['nullable', 'exists:income_types,id']

        ];
    }
    public function messages(): array
    {
        return [
            'identificationNumber.unique' => 'The identification number has already been taken.',
            'email.unique' => 'The email has already been taken.',
            'identificationPictureBase64.required' => 'The identification picture is required.',
            'identificationPictureBase64.string' => 'The identification picture must be a string.',
            'identificationPictureBase64.max' => 'The identification picture must not be greater than 2048 characters.',
            'identificationPictureBase64.image' => 'The identification picture must be an image.',
            'identificationPictureBase64.file' => 'The identification picture must be a file.',
            'identificationPictureBase64.mimes' => 'The identification picture must be a file of type: jpeg, png, jpg.',
            'identificationPictureBase64.required_if' => 'The identification picture is required when the file is not uploaded.',
            'identificationPicture.image' => 'The identification picture must be an image.',
            'identificationPicture.max' => 'The identification picture must not be greater than 2048 kilobytes.',
            'identificationPicture.mimes' => 'The identification picture must be a file of type: jpeg, png, jpg.',
            'identificationPicture.required_if' => 'The  identification picture is required.',
            'effectiveDate.required' => 'The effective date is required.',
            'effectiveDate.date' => 'The effective date must be a valid date.',
            'effectiveDate.after_or_equal' => 'The effective date must be after or equal to the date of birth.',
            'effectiveDate.before' => 'The effective date must be before today.',
            'housingStatusId.exists' => 'The selected housing status is invalid.',
            'addressId.exists' => 'The selected address is invalid.',
            'addressId.required' => 'The address is required.',
            'incomeTypeId.exists' => 'The selected income type is invalid.',
        ];
    }

    public function setData(?int $id = null): void
    {
        if ($id) {
            $result = $this->clientRepository->findById($id);
            if ($result) {
                $this->id = $result->id;
                $this->firstName = $result->first_name;
                $this->lastName = $result->last_name;
                $this->dob = $result->dob ? Carbon::parse($result->dob)->format('Y-m-d') : null;
                $this->ssn = $result->ssn;
                $this->legalStatusId = $result->legal_status_id;
                $this->identificationTypeId = $result->identification_type_id;
                $this->identificationNumber = $result->identification_number;
                $this->identificationExpirationDate = $result->identification_expiration_date ? Carbon::parse($result->identification_expiration_date)->format('Y-m-d') : null;
                $this->cityDistrictId = $result->city_district_id;
                $this->countyDistrictId = $result->county_district_id;
                $this->cityId = $result->city_id;
                $this->email = $result->email;
                $this->genderId = $result->gender_id;
                $this->ethnicityId = $result->ethnicity_id;
                $this->hispanic = $result->hispanic;
                $this->isDeceased = $result->is_deceased;
                $this->healthcareProviderId = $result->healthcare_provider_id;
                $this->getHealthcareProviderPlans();
                $this->healthcareProviderPlanId = $result->healthcare_provider_plan_id;
                $this->existsFileIdentificationCard = $this->clientRepository->existsFile($id);
                if ($result->frequency_payment && !empty($result->payment_amounts)) {
                    $this->editAddPayment = true;
                    $this->frequencyPayment = $result->frequency_payment;
                    $this->paymentAmounts = $result->payment_amounts;
                }
                $this->clientNumber = $result->client_number;
                $this->getHousingStatuses();
                $this->housingStatusId = $result->housing_status_id;
                $this->effectiveDate = $result->effective_date ? Carbon::parse($result->effective_date)->format('Y-m-d') : null;
                $this->addressId = $result->address_id;
                $this->getAddressById();
                $this->getIncomeTypes();
                $this->incomeTypeId = $result->income_type_id;
            }
        }
    }

    public function save()
    {

        $uuid = Str::uuid();
        $this->validate($this->rules(), $this->messages());
        $data = [
            'address_id' => $this->addressId,
            'city_district_id' => $this->cityDistrictId,
            'city_id' => $this->cityId,
            'county_district_id' => $this->countyDistrictId,
            'dob' => $this->dob,
            'effective_date' => $this->effectiveDate,
            'email' => $this->email,
            'ethnicity_id' => $this->ethnicityId,
            'first_name' => $this->firstName,
            'frequency_payment' => $this->frequencyPayment,
            'gender_id' => $this->genderId,
            'healthcare_provider_id' => $this->healthcareProviderId,
            'healthcare_provider_plan_id' => $this->healthcareProviderPlanId,
            'housing_status_id' => $this->housingStatusId,
            'identification_expiration_date' => $this->identificationExpirationDate,
            'identification_number' => $this->identificationNumber,
            'identification_type_id' => $this->identificationTypeId,
            'last_name' => $this->lastName,
            'legal_status_id' => $this->legalStatusId,
            'payment_amounts' => $this->paymentAmounts,
            'ssn' => $this->ssn,
            'is_deceased' => $this->isDeceased,
            'hispanic' => $this->hispanic,
            'income_type_id' => $this->incomeTypeId

        ];

        if ($this->id) {
            if ($this->identificationPictureBase64 || $this->identificationPicture) {
                $this->clientRepository->deleteIdentificationCardFile($this->id);
            }
            if ($this->identificationPictureBase64) {
                $name = $this->saveBase64Image($this->identificationPictureBase64, 'clients');
                if ($name) {
                    $data['identification_picture'] = $name;
                }
            } elseif ($this->identificationPicture) {
                $name = $uuid . '.' . $this->identificationPicture->getClientOriginalExtension();
                $this->identificationPicture->storeAs(path: 'clients', name: $name, options: 'local');
                $data['identification_picture'] =  $name;
            }
            $this->clientRepository->update($this->id, $data);
        } else {
            if ($this->identificationPictureBase64) {
                $name = $this->saveBase64Image($this->identificationPictureBase64, 'clients');
                if ($name) {
                    $data['identification_picture'] = $name;
                }
            } elseif ($this->identificationPicture) {

                $name = $uuid . '.' . $this->identificationPicture->getClientOriginalExtension();
                $this->identificationPicture->storeAs(path: 'clients', name: $name, options: 'local');
                $data['identification_picture'] =  $name;
            }
            $this->clientRepository->create($data);
        }
        $this->reset([
            'addressId',
            'cityDistrictId',
            'cityId',
            'countyDistrictId',
            'dob',
            'editAddPayment',
            'effectiveDate',
            'email',
            'firstName',
            'frequencyPayment',
            'genderId',
            'housingStatusId',
            'id',
            'identificationExpirationDate',
            'identificationNumber',
            'identificationPictureBase64',
            'identificationTypeId',
            'lastName',
            'legalStatusId',
            'paymentAmount',
            'paymentAmounts',
            'ssn',
            'zipCode',
            'isDeceased',
            'hispanic'
        ]);
    }
    public function delete()
    {
        if ($this->id) {
            $this->clientRepository->delete($this->id);
        }
    }
    public function getLegalStatuses()
    {
        $this->statuses = $this->legalStatusRepository->getAll();
    }
    public function getIdentificationTypes()
    {
        $this->identificationTypes = $this->identificationTypeRepository->getAll();
    }
    public function getCityDistricts()
    {
        $this->cityDistricts =   $this->cities = $this->cityDistrictRepository->getAll();
    }
    public function getCountyDistricts()
    {
        $this->countyDistricts = $this->countyDistrictRepository->getAll();
    }
    public function getCities()
    {
        $this->cities = $this->cityRepository->getCityByDistrictId($this->countyDistrictId);
    }

    public function getCitiesFiltered()
    {
        $this->citiesFiltered = $this->cityRepository->getCityByDistrictId($this->filters['countyDistrictId']);
    }
    public function getHealthcareProviders()
    {
        $this->healthcareProviders = $this->healthcareProviderRepository->getAll();
    }
    public function getHealthcareProviderPlans()
    {
        $this->healthcareProviderPlans = $this->healthcareProviderPlanRepository->getByHealthcareProviderId($this->healthcareProviderId);
    }
    public function getGenders()
    {
        $this->genders = $this->genderRepository->getAll();
    }

    public function getEthnicities()
    {
        $this->ethnicities = $this->ethnicityRepository->getAll();
    }
    public function addPayment()
    {
        $this->validate([
            'frequencyPayment' => ['required', 'string', Rule::in(\App\Enums\PaymentFrequency::values())],
            'paymentAmount' => ['required', 'numeric', 'min:1'],
        ]);

        $this->paymentAmounts[] = $this->paymentAmount;
        $this->paymentAmount = 0;
    }
    public function deletePayment(float $amount)
    {
        if (($key = array_search($amount, $this->paymentAmounts)) !== false) {
            unset($this->paymentAmounts[$key]);
        }
    }

    public function getHousingStatuses()
    {
        $this->housingStatuses = $this->housingStatusRepository->getAll();
    }

    public function getAddressById()
    {
        $this->reset(['addressFormatted', 'addressPostalCode', 'addressCountyName', 'addressCityName', 'stateAbbreviation']);
        if ($this->addressId && $address = $this->addressRepository->findById($this->addressId)) {
            $this->addressFormatted = $address->address_formatted;
            $this->addressPostalCode = $address->postal_code;
            $this->addressCountyName = $address->county_name;
            $this->addressCityName = $address->city;
            $this->addressStateAbbreviation = $address->state_abbreviation;
        }
    }
    public function getIncomeTypes()
    {
        $this->incomeTypes = $this->incomeTypeRepository->getAll();
    }

    #[Computed]

    public function results(): LengthAwarePaginator
    {
        return $this->clientRepository->getFiltered($this->filters)->paginate(pageName: 'clients-page');
    }

    public function getColumnsDefault()
    {
        $this->columnsSelected = collect(ClientColumns::options())
            ->filter(fn($column) => ($column['default'] ?? false) === true)
            ->pluck('value')
            ->all();
    }
    public function getColumnsOptions()
    {
        $this->columns = collect(ClientColumns::options())
            ->map(fn($column) => [
                'value' => $column['value'],
                'label' => $column['label'],
                'default' => $column['default'] ?? false,
            ])
            ->all();
    }

    public function resetFilters()
    {
        $this->filters = [
            'search' => '',
            'legal_status_id' => '',
            'identification_type_id' => '',
            'ethnicity_id' => '',
            'healthcare_provider_id' => '',
            'gender_id' => '',
            'income_type_id' => '',
            'has_howpa' => false,
            'has_meals' => false,
            'from_age' => null,
            'to_age' => null,
            'city_district_id' => null,
            'countyDistrictId' => null,
            'city_id' => null,
            'hispanic' => null,
            'isDeceased' => null
        ];
    }
}
