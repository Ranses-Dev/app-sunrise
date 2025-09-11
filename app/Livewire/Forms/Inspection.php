<?php

namespace App\Livewire\Forms;

use App\Enums\CrudMessages;
use App\Enums\InspectionStatus;
use Livewire\Form;
use Illuminate\Database\Eloquent\Collection;
use Flux\Flux;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use App\Repositories\AddressRepositoryInterface as AddressRepository;
use App\Repositories\InspectionRepositoryInterface as InspectionRepository;
use App\Repositories\ClientRepositoryInterface as ClientRepository;
use App\Repositories\ProgramBranchRepositoryInterface as ProgramBranchRepository;
use App\Repositories\HousingTypeRepositoryInterface as HousingTypeRepository;
use App\Repositories\UserRepositoryInterface as UserRepository;
use App\Enums\InspectionColumns;
use Illuminate\Support\Facades\Log;

class Inspection extends Form
{
    const EXISTS_ADDRESS = 'exists:addresses,id';
    public ?int $id = null;
    public ?int $programBranchId = null;
    public ?int $addressId = null;
    public ?string $addressFormatted = null;
    public ?string $addressCity = null;
    public ?string $addressState = null;
    public ?string $addressPostalCode = null;
    public ?string $addressCounty = null;
    public ?string $inspectionRequestedDate = null;
    public ?bool $inspectionRequestedIncomplete = false;
    public ?string $inspectionRequestedIncompleteNotes = null;
    public ?bool $inspectionRequestedNotScheduled = false;
    public ?string $inspectionRequestedNotScheduledNotes = null;
    public ?string $inspectionRequestedScheduledDate = null;
    public ?string $landlordName = null;
    public ?string $landlordContactInformation = null;
    public ?int $landlordAddressId = null;
    public ?int $landlordHowpaId = null;
    public ?string $tenantName = null;
    public ?int $tenantHowpaId = null;
    public ?string $tenantContactInformation = null;
    public ?int $tenantAddressId = null;
    public ?int $housingTypeId = null;
    public ?int $numberOfBedrooms = null;
    public ?int $housingInspectorId = null;
    public ?string $inspectionStatus = null;
    public  $inspectionStatuses = null;
    public ?string $inspectionAddressFormatted = "";
    public ?string $inspectionCity = "";
    public ?string $inspectionPostalCode = "";
    public ?string $inspectionCountyName = "";
    public ?string $inspectionStateAbbreviation = "";

    public ?string $landlordAddressFormatted = "";
    public ?string $landlordCity = "";
    public ?string $landlordPostalCode = "";
    public ?string $landlordCountyName = "";
    public ?string $landlordStateAbbreviation = "";

    public ?string $tenantAddressFormatted = "";
    public ?string $tenantCity = "";
    public ?string $tenantPostalCode = "";
    public ?string $tenantCountyName = "";
    public ?string $tenantStateAbbreviation = "";
    public int|null $howpaId = null;

    public ?Collection $programBranches = null;

    public ?Collection $housingTypes = null;
    public ?Collection $clientsHowpa = null;
    public $users = null;
    public array $filters = [
        'search' => null,
        'programBranchId' => null,
        'addressId' => null,
        'inspectionRequestedDateRange' => [],
        'inspectionRequestedIncomplete' => false,
        'inspectionRequestedNotScheduled' => false,
        'inspectionRequestedScheduledRange' => null,
        'housingTypeId' => null,
        'numberOfBedroomsRange' => null,
        'inspectionStatus' => null,
        'housingInspectorId' => null,
    ];
    public array $columnsSelected = [];
    public array $columns = [];

    protected InspectionRepository $inspectionRepository;
    protected AddressRepository $addressRepository;
    protected ClientRepository $clientRepository;
    protected ProgramBranchRepository $programBranchRepository;
    protected HousingTypeRepository $housingTypeRepository;
    protected UserRepository $userRepository;

    public function boot()
    {
        $this->inspectionRepository = app(InspectionRepository::class);
        $this->addressRepository = app(AddressRepository::class);
        $this->clientRepository = app(ClientRepository::class);
        $this->programBranchRepository = app(ProgramBranchRepository::class);
        $this->housingTypeRepository = app(HousingTypeRepository::class);
        $this->userRepository = app(UserRepository::class);
        $this->howpaId = (int) config('services.programs.howpa_id');
    }

    public function rules(): array
    {

        return [
            'programBranchId' => ['required', Rule::exists('program_branches', 'id')],
            'addressId' => ['required', self::EXISTS_ADDRESS],

            'inspectionRequestedDate' => ['required', 'date'],
            'inspectionRequestedIncomplete' => ['required', 'boolean'],

            'inspectionRequestedIncompleteNotes' => [
                'nullable',
                'string',
                'required_if:inspectionRequestedIncomplete,true',
                'prohibited_if:inspectionRequestedIncomplete,false',
            ],

            'inspectionRequestedNotScheduled' => ['required', 'boolean'],
            'inspectionRequestedNotScheduledNotes' => ['nullable', 'min:10', 'string', 'required_if:inspectionRequestedNotScheduled,true', 'prohibited_if:inspectionRequestedNotScheduled,false'],
            'inspectionRequestedScheduledDate' => ['nullable', 'date', 'required_if:inspectionRequestedNotScheduled,false', 'prohibited_if:inspectionRequestedNotScheduled,true'],

            'landlordName' => ['nullable', 'string'],
            'landlordContactInformation' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    $isEmail = filter_var($value, FILTER_VALIDATE_EMAIL);
                    $isPhone = preg_match('/^\+?[0-9]{7,15}$/', $value);
                    if (! $isEmail && ! $isPhone) {
                        $fail("The field must be a valid email address or a valid phone number.");
                    }
                }
            ],

            'landlordAddressId' => ['nullable', self::EXISTS_ADDRESS],
            'landlordHowpaId' => ['nullable', 'exists:clients,id', 'prohibited_unless:programBranchId,7'],

            'tenantName' => ['nullable', 'string'],
            'tenantHowpaId' => ['nullable', 'exists:clients,id', 'prohibited_unless:programBranchId,7'],
            'tenantContactInformation' => ['nullable', 'string'],
            'tenantAddressId' => ['nullable', self::EXISTS_ADDRESS, function ($attribute, $value, $fail) {
                if ($value && $value !== $this->addressId) {
                    $fail("The tenant Address ID field must be the same as the inspection address selected.");
                }
            }],

            'housingTypeId' => ['nullable', 'exists:housing_types,id'],
            'numberOfBedrooms' => ['required', 'integer', 'min:1'],
            'housingInspectorId' => ['nullable', 'exists:users,id'],
            'inspectionStatus' => ['nullable', 'string', Rule::in(array_column(InspectionStatus::cases(), 'value'))],
        ];
    }
    public function messages(): array
    {
        return [
            'programBranchId.required' => 'The program branch field is required.',
            'programBranchId.exists' => 'The selected program branch is invalid.',
            'addressId.required' => 'The address field is required.',
            'addressId.exists' => 'The selected address is invalid.',
            'inspectionRequestedDate.required' => 'The inspection requested date field is required.',
            'inspectionRequestedDate.date' => 'The inspection requested date must be a valid date.',
            'inspectionRequestedIncomplete.required' => 'The inspection requested incomplete field is required.',
            'inspectionRequestedIncomplete.boolean' => 'The inspection requested incomplete field must be true or false.',
            'inspectionRequestedIncompleteNotes.string' => 'The inspection requested incomplete notes must be a string.',
            'inspectionRequestedNotScheduled.required' => 'The inspection requested not scheduled field is required.',
            'inspectionRequestedNotScheduled.boolean' => 'The inspection requested not scheduled field must be true or false.',
            'inspectionRequestedNotScheduledNotes.string' => 'The inspection requested not scheduled notes must be a string.',
            'inspectionRequestedScheduledDate.date' => 'The inspection requested scheduled date must be a valid date.',
            'landlordName.string' => 'The landlord name must be a string.',
            'landlordContactInformation.string' => 'The landlord contact information must be a string.',
            'landlordAddressId.exists' => 'The selected landlord address is invalid.',
            'landlordHowpaId.exists' => 'The selected landlord howpa is invalid.',
            'tenantName.string' => 'The tenant name must be a string.',
            'tenantHowpaId.exists' => 'The selected tenant howpa is invalid.',
            'tenantContactInformation.string' => 'The tenant contact information must be a string.',
            'tenantAddressId.exists' => 'The selected tenant address is invalid.',
            'housingTypeId.exists' => 'The selected housing type is invalid.',
            'numberOfBedrooms.integer' => 'The number of bedrooms must be an integer.',
            'housingInspectorId.exists' => 'The selected housing inspector is invalid.',
            'inspectionStatusPassed.boolean' => 'The inspection status passed field must be true or false.',
        ];
    }

    public function save()
    {

        $this->validate($this->rules(), $this->messages());
        $data = [
            'program_branch_id' => $this->programBranchId,
            'address_id' => $this->addressId,
            'inspection_requested_date' => $this->inspectionRequestedDate,
            'inspection_requested_incomplete' => $this->inspectionRequestedIncomplete,
            'inspection_requested_incomplete_notes' => $this->inspectionRequestedIncompleteNotes,
            'inspection_requested_not_scheduled' => $this->inspectionRequestedNotScheduled,
            'inspection_requested_not_scheduled_notes' => $this->inspectionRequestedNotScheduledNotes,
            'inspection_requested_scheduled_date' => $this->inspectionRequestedScheduledDate,
            'landlord_name' => $this->landlordName,
            'landlord_contact_information' => $this->landlordContactInformation,
            'landlord_address_id' => $this->landlordAddressId,
            'landlord_howpa_id' => $this->landlordHowpaId,
            'tenant_name' => $this->tenantName,
            'tenant_howpa_id' => $this->tenantHowpaId,
            'tenant_contact_information' => $this->tenantContactInformation,
            'tenant_address_id' => $this->tenantAddressId,
            'housing_type_id' => $this->housingTypeId,
            'number_of_bedrooms' => $this->numberOfBedrooms,
            'housing_inspector_id' => $this->housingInspectorId,
            'inspection_status' => $this->inspectionStatus,
        ];
        if ($this->id) {
            $this->inspectionRepository->update($this->id, $data);
            Flux::toast(variant: 'success', position: 'top-right', text: CrudMessages::UPDATE_SUCCESS->value);
        } else {
            $this->inspectionRepository->create($data);
            Flux::toast(variant: 'success', position: 'top-right', text: CrudMessages::CREATE_SUCCESS->value);
        }
    }
    public function setData()
    {
        if ($this->id && $inspection = $this->inspectionRepository->findById($this->id)) {
            $this->programBranchId = $inspection->program_branch_id;
            $this->addressId = $inspection->address_id;
            $this->getInspectionAddressById();
            $this->getProgramBranches();
            $this->programBranchId = $inspection->program_branch_id;
            $this->inspectionRequestedDate = $inspection->inspection_requested_date?->format('Y-m-d');
            $this->inspectionRequestedIncomplete = $inspection->inspection_requested_incomplete;
            $this->inspectionRequestedIncompleteNotes = $inspection->inspection_requested_incomplete_notes;
            $this->inspectionRequestedNotScheduled = $inspection->inspection_requested_not_scheduled;
            $this->inspectionRequestedNotScheduledNotes = $inspection->inspection_requested_not_scheduled_notes;
            $this->inspectionRequestedScheduledDate = $inspection->inspection_requested_scheduled_date?->format('Y-m-d');
            $this->landlordName = $inspection->landlord_name;
            $this->landlordContactInformation = $inspection->landlord_contact_information;
            $this->landlordAddressId = $inspection->landlord_address_id;
            $this->landlordHowpaId = $inspection->landlord_howpa_id;
            $this->getLandlordAddressById();
            $this->tenantName = $inspection->tenant_name;
            $this->tenantHowpaId = $inspection->tenant_howpa_id;
            $this->tenantContactInformation = $inspection->tenant_contact_information;
            $this->tenantAddressId = $inspection->tenant_address_id;
            $this->getTenantAddressById();
            $this->getHousingTypes();
            $this->housingTypeId = $inspection->housing_type_id;
            $this->numberOfBedrooms = $inspection->number_of_bedrooms;
            $this->getUsers();
            $this->housingInspectorId = $inspection->housing_inspector_id;
            $this->getStatuses();
            $this->inspectionStatus = $inspection->inspection_status?->value;
        }
    }
    public function getProgramBranches()
    {
        $this->programBranches = $this->programBranchRepository->getHowpaBranches();
    }
    public function getInspectionAddressById()
    {

        $this->reset([
            'inspectionAddressFormatted' => "",
            'inspectionCity' => "",
            'inspectionPostalCode' => "",
            'inspectionCountyName' => "",
            'inspectionStateAbbreviation' => "",
        ]);
        if ($this->addressId && $address = $this->addressRepository->findById($this->addressId)) {
            $this->inspectionAddressFormatted = $address->address_formatted;
            $this->inspectionCity = $address->city;
            $this->inspectionPostalCode = $address->postal_code;
            $this->inspectionCountyName = $address->county_name;
            $this->inspectionStateAbbreviation = $address->state_abbreviation;
        }
    }

    public function getLandlordAddressById()
    {
        $this->reset([
            'landlordAddressFormatted' => "",
        ]);
        if ($this->landlordAddressId && $address = $this->addressRepository->findById($this->landlordAddressId)) {
            $this->landlordAddressFormatted = $address->address_formatted;
        }
    }

    public function getTenantAddressById()
    {
        $this->reset([
            'tenantAddressFormatted' => ""
        ]);
        if ($this->tenantAddressId && $address = $this->addressRepository->findById($this->tenantAddressId)) {
            $this->tenantAddressFormatted = $address->address_formatted;
        }
    }

    public function getHousingTypes()
    {
        $this->housingTypes = $this->housingTypeRepository->getAll();
    }

    public function getClientsHowpa()
    {
        $this->clientsHowpa = $this->clientRepository->getHowpaClientsWithContractActive();
    }
    public function getUsers()
    {
        $this->users = $this->clientRepository->getClientServiceSpecialistsByProgram((int)config('services.programs.inspection_id'));
    }

    #[Computed]
    public function results(): LengthAwarePaginator
    {
        return $this->inspectionRepository->getFiltered($this->filters)->paginate(pageName: 'inspections-page');
    }

    public function delete()
    {
        if ($this->id) {
            $this->inspectionRepository->delete($this->id);
        }
    }

    public function getStatuses()
    {
        $this->inspectionStatuses = collect(InspectionStatus::cases());
    }

    #[Computed]
    public function showButtonsSelectClientsFromHowpa(): bool
    {

        return $this->programBranchId === (int)config('services.program_branches.howpas_id');
    }

    public function getLandlordById()
    {
        $this->reset([
            'landlordName' => "",
            'landlordHowpaId' => "",
            'landlordContactInformation' => "",
            'landlordAddressId' => "",
        ]);
        if ($this->landlordHowpaId && $landlord = $this->clientRepository->findById($this->landlordHowpaId)) {
            $this->landlordName = $landlord->full_name;
            $this->landlordHowpaId = $landlord->id;
            $this->landlordContactInformation = $landlord->email;
            $this->landlordAddressId = $landlord->address_id;
            $this->getLandlordAddressById();
               }
    }
    public function getTenantById()
    {
        $this->reset([
            'tenantName' => "",
            'tenantHowpaId' => "",
            'tenantContactInformation' => "",
            'tenantAddressId' => "",
        ]);
        if ($this->tenantHowpaId && $tenant = $this->clientRepository->findById($this->tenantHowpaId)) {
            $this->tenantName = $tenant->full_name;
            $this->tenantHowpaId = $tenant->id;
            $this->tenantContactInformation = $tenant->email;
            $this->tenantAddressId = $tenant->address_id;
            $this->getTenantAddressById();
        }
    }
    public function resetFilters()
    {
        $this->reset([
            'filters.search',
            'filters.programBranchId',
            'filters.housingInspectorId',
            'filters.inspectionRequestedDateRange',
            'filters.inspectionRequestedScheduledRange',
            'filters.inspectionRequestedIncomplete',
            'filters.inspectionRequestedNotScheduled',
            'filters.inspectionStatus',
        ]);
    }
    public function getColumnsDefault()
    {
        $this->columnsSelected = collect(InspectionColumns::options())
            ->filter(fn($column) => ($column['default'] ?? false) === true)
            ->pluck('value')
            ->all();
    }
    public function getColumnsOptions()
    {
        $this->columns = collect(InspectionColumns::options())
            ->map(fn($column) => [
                'value' => $column['value'],
                'label' => $column['label'],
                'default' => $column['default'] ?? false,
            ])
            ->all();
    }
}
