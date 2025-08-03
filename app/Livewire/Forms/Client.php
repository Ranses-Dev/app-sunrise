<?php

namespace App\Livewire\Forms;


use App\Enums\PaymentFrequency;
use Livewire\Form;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;
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
use App\Traits\ImageHandler;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;


class Client extends Form
{
    use WithFileUploads, ImageHandler;
    public ?int $id = null;
    public ?string $firstName = null;
    public ?string $lastName = null;
    public ?string $dob = null;
    public ?string $ssn = null;
    public ?string $clientNumber = null;
    public ?int $legalStatusId = null;
    public ?int $identificationTypeId = null;
    public ?string $identificationNumber = null;
    public ?string $identificationExpirationDate = null;
    public ?string $identificationPictureBase64 = null;
    public  $identificationPicture = null;
    public ?string $identificationPictureName = "";
    public ?string $address = null;
    public ?string $zipCode = null;
    public ?int $cityDistrictId = null;
    public ?int $countyDistrictId = null;
    public ?int $cityId = null;
    public ?string $email = null;
    public ?int $genderId = null;
    public ?float $income = null;
    public ?int $ethnicityId = null;
    public ?int $healthcareProviderId = null;
    public ?int $healthcareProviderPlanId = null;

    public ?bool $existsFileIdentificationCard = null;
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
    public $statuses = null;
    public $identificationTypes = null;
    public $cityDistricts = null;
    public $countyDistricts = null;
    public $cities = null;
    public $healthcareProviders = null;
    public $healthcareProviderPlans = null;
    public $genders = null;
    public $ethnicities = null;

    //For Payments
    public bool $editAddPayment = false;
    public array $paymentAmounts = [];
    public  float|null $paymentAmount = 0;
    public string|null $frequencyPayment = null;


    public function boot(
        ClientRepository $clientRepository,
        LegalStatusRepository $legalStatusRepository,
        IdentificationTypeRepository $identificationTypeRepository,
        CityDistrictRepository $cityDistrictRepository,
        CountyDistrictRepository $countyDistrictRepository,
        CityRepository $cityRepository,
        HealthcareProviderRepository $healthcareProviderRepository,
        HealthcareProviderPlanRepository $healthcareProviderPlanRepository,
        GenderRepository $genderRepository,
        EthnicityRepository $ethnicityRepository
    ) {
        $this->clientRepository = $clientRepository;
        $this->legalStatusRepository = $legalStatusRepository;
        $this->identificationTypeRepository = $identificationTypeRepository;
        $this->cityDistrictRepository = $cityDistrictRepository;
        $this->countyDistrictRepository = $countyDistrictRepository;
        $this->cityRepository = $cityRepository;
        $this->healthcareProviderRepository = $healthcareProviderRepository;
        $this->healthcareProviderPlanRepository = $healthcareProviderPlanRepository;
        $this->genderRepository = $genderRepository;
        $this->ethnicityRepository = $ethnicityRepository;
    }

    public function rules(): array
    {
        return [
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'dob' => ['required', 'date', 'before:today'],
            'ssn' => ['required', 'string', 'regex:/^\d{3}-?\d{2}-?\d{4}$/'],
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
            'clientNumber' => ['required', 'string', 'max:255', Rule::unique('clients', 'client_number')->ignore($this->id)],
            'legalStatusId' => ['required', 'exists:legal_statuses,id'],
            'identificationTypeId' => ['required', 'exists:identification_types,id'],
            'identificationNumber' => ['required', 'string', 'max:255', Rule::unique('clients', 'identification_number')->ignore($this->id)],
            'identificationExpirationDate' => [
                'required',
                'nullable',
                'date',
            ],
            'identificationPicture' => [
                'nullable',
                'file',
                'max:2048',
                'mimes:jpeg,png,jpg,pdf',
                new RequiredIf(fn(): bool => empty($this->identificationPictureBase64) && !$this->id)
            ],
            'identificationPictureBase64' => [
                new RequiredIf(fn(): bool => $this->identificationPicture === null && !$this->id),
                'nullable',
                'string'

            ],
            'address' => ['required', 'string', 'max:255'],
            'zipCode' => ['required', 'string', 'regex:/^\d{5}(-\d{4})?$/', 'max:10'],
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

        ];
    }
    public function messages(): array
    {
        return [
            'clientNumber.unique' => 'The client number has already been taken.',
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
                $this->clientNumber = $result->client_number;
                $this->legalStatusId = $result->legal_status_id;
                $this->identificationTypeId = $result->identification_type_id;
                $this->identificationNumber = $result->identification_number;
                $this->identificationExpirationDate = $result->identification_expiration_date ? Carbon::parse($result->identification_expiration_date)->format('Y-m-d') : null;
                $this->address = $result->address;
                $this->zipCode = $result->zip_code;
                $this->cityDistrictId = $result->city_district_id;
                $this->countyDistrictId = $result->county_district_id;
                $this->cityId = $result->city_id;
                $this->email = $result->email;
                $this->genderId = $result->gender_id;
                $this->ethnicityId = $result->ethnicity_id;
                $this->healthcareProviderId = $result->healthcare_provider_id;
                $this->getHealthcareProviderPlans();
                $this->healthcareProviderPlanId = $result->healthcare_provider_plan_id;
                $this->existsFileIdentificationCard = $this->clientRepository->existsFile($id);
                if ($result->frequency_payment && !empty($result->payment_amounts)) {
                    $this->editAddPayment = true;
                    $this->frequencyPayment = $result->frequency_payment;
                    $this->paymentAmounts = $result->payment_amounts;
                }
            }
        }
    }

    public function save()
    {

        $uuid = Str::uuid();
        $this->validate($this->rules(), $this->messages());
        $data = [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'dob' => $this->dob,
            'ssn' => $this->ssn,
            'client_number' => $this->clientNumber,
            'legal_status_id' => $this->legalStatusId,
            'identification_type_id' => $this->identificationTypeId,
            'identification_number' => $this->identificationNumber,
            'identification_expiration_date' => $this->identificationExpirationDate,
            'address' => $this->address,
            'zip_code' => $this->zipCode,
            'city_district_id' => $this->cityDistrictId,
            'county_district_id' => $this->countyDistrictId,
            'city_id' => $this->cityId,
            'email' => $this->email,
            'gender_id' => $this->genderId,
            'ethnicity_id' => $this->ethnicityId,
            'healthcare_provider_id' => $this->healthcareProviderId,
            'healthcare_provider_plan_id' => $this->healthcareProviderPlanId,
            'frequency_payment' => $this->frequencyPayment,
            'payment_amounts' => $this->paymentAmounts,
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
            'id',
            'firstName',
            'lastName',
            'dob',
            'ssn',
            'clientNumber',
            'legalStatusId',
            'identificationTypeId',
            'identificationNumber',
            'identificationExpirationDate',
            'identificationPictureBase64',
            'address',
            'zipCode',
            'cityDistrictId',
            'countyDistrictId',
            'cityId',
            'email',
            'genderId',
            'frequencyPayment',
            'paymentAmounts',
            'editAddPayment',
            'paymentAmount'
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
}
