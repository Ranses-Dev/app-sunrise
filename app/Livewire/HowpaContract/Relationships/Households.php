<?php

namespace App\Livewire\HowpaContract\Relationships;

use App\Enums\CrudMessages;
use App\Models\Client;
use Livewire\Component;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Repositories\HouseholdMemberRepositoryInterface;
use App\Repositories\GenderRepositoryInterface;
use App\Repositories\HouseholdRelationTypeRepositoryInterface;
use App\Repositories\EthnicityRepositoryInterface;
use Flux\Flux;
use Illuminate\Support\Collection;

class Households extends Component
{
    use WithoutUrlPagination, WithPagination;
    public string|int|null $clientId = null;
    public string $search = '';
    public int|null $householdId = null;
    public Collection $genders;
    public Collection $householdRelationTypes;
    public Collection $ethnicities;

    public int|null $genderId = null;
    public int|null $householdRelationTypeId = null;
    public int|null $ethnicityId = null;
    public string $firstName = '';
    public string $lastName = '';
    public ?string $ssn = '';
    public string $dateOfBirth = '';
    public bool $hivStatus = false;
    public bool $hispanic = false;
    public bool $showEditModal = false;
    protected HouseholdMemberRepositoryInterface $householdMemberRepository;
    protected GenderRepositoryInterface $genderRepository;
    protected HouseholdRelationTypeRepositoryInterface $householdRelationTypeRepository;
    protected EthnicityRepositoryInterface $ethnicityRepository;
    public function boot()
    {
        $this->householdMemberRepository = app(HouseholdMemberRepositoryInterface::class);
        $this->genderRepository = app(GenderRepositoryInterface::class);
        $this->householdRelationTypeRepository = app(HouseholdRelationTypeRepositoryInterface::class);
        $this->ethnicityRepository = app(EthnicityRepositoryInterface::class);
    }

    public function mount(int|null|string $clientId = null)
    {
        $this->clientId = (int) $clientId;
    }

    public function render()
    {
        return view('livewire.howpa-contract.relationships.households');
    }
    #[Computed]
    public function records(): LengthAwarePaginator
    {
        return $this->householdMemberRepository->getFiltered($this->clientId, $this->search)
            ->paginate(pageName: 'households-page');
    }

    public function getGenders()
    {
        $this->genders = $this->genderRepository->getAll();
    }
    public function getHouseholdRelationTypes()
    {
        $this->householdRelationTypes = $this->householdRelationTypeRepository->getAll();
    }
    public function getEthnicities()
    {
        $this->ethnicities = $this->ethnicityRepository->getAll();
    }
    public function edit(int $id)
    {
        $householdMember = $this->householdMemberRepository->findById($id);
        if ($householdMember) {
            $this->householdId = $householdMember->id;
            $this->firstName = $householdMember->first_name;
            $this->lastName = $householdMember->last_name;
            $this->ssn = $householdMember->ssn;
            $this->dateOfBirth = $householdMember->dob;
            $this->getGenders();
            $this->getHouseholdRelationTypes();
            $this->getEthnicities();
            $this->genderId = $householdMember->gender_id;
            $this->householdRelationTypeId = $householdMember->household_relation_type_id;
            $this->ethnicityId = $householdMember->ethnicity_id;
            $this->hivStatus = $householdMember->hiv_aids_status;
            $this->hispanic = $householdMember->hispanic;
            $this->showEditModal = true;
        }
    }
    public function save()
    {
        $this->validate([
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'ssn' => ['required', 'string', 'regex:/^\d{3}-?\d{2}-?\d{4}$/', function ($attribute, $value) {
                if (strlen($value) !== 11 || !preg_match('/^\d{3}-\d{2}-\d{4}$/', $value)) {
                    $this->addError($attribute, 'The SSN must be in the format XXX-XX-XXXX.');
                }
                $validate = $this->householdMemberRepository->validateUniqueSSN($value, $this->clientId, $this->householdId);
                if (!$validate) {
                    $this->addError($attribute, 'The SSN must be unique for the house hold and client.');
                }
            }],
            'dateOfBirth' => ['nullable', 'date'],
            'genderId' => ['required', 'integer', 'exists:genders,id'],
            'householdRelationTypeId' => ['required', 'integer', 'exists:household_relation_types,id'],
            'ethnicityId' => ['required', 'integer', 'exists:ethnicities,id'],
            'hivStatus' => ['boolean'],
            'hispanic' => ['boolean'],
        ], [
            'firstName.required' => 'First name is required.',
            'lastName.required' => 'Last name is required.',
            'ssn.regex' => 'SSN must be in the format 999-99-9999.',
            'dateOfBirth.date' => 'Date of birth must be a valid date.',
            'genderId.required' => 'Gender is required.',
            'householdRelationTypeId.required' => 'Relationship is required.',
            'ethnicityId.required' => 'Race is required.',
        ]);

        $householdMember = $this->householdMemberRepository->findById($this->householdId);
        if ($householdMember) {
            $this->householdMemberRepository->update($this->householdId, [
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'ssn' => $this->ssn,
                'dob' => $this->dateOfBirth,
                'gender_id' => $this->genderId,
                'household_relation_type_id' => $this->householdRelationTypeId,
                'ethnicity_id' => $this->ethnicityId,
                'hiv_aids_status' => $this->hivStatus,
                'hispanic' => $this->hispanic,
            ]);
        }
        Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::UPDATE_SUCCESS->value));
        $this->closeEditModal();
    }

    public function closeEditModal()
    {

        $this->reset([
            'householdId',
            'firstName',
            'lastName',
            'ssn',
            'dateOfBirth',
            'genderId',
            'householdRelationTypeId',
            'ethnicityId',
            'hivStatus',
            'hispanic',
        ]);
        $this->showEditModal = false;
    }
}
