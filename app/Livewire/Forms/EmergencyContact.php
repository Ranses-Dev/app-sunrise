<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Collection;
use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Repositories\EmergencyContactRepositoryInterface;
use App\Repositories\HouseholdRelationTypeRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class EmergencyContact extends Form
{
    use WithPagination, WithoutUrlPagination;
    public ?int $id = null;
    public ?int $clientId = null;
    public ?int $householdRelationTypeId = null;
    public ?string $name = null;
    public ?string $address = null;
    public ?string $phoneNumber = null;
    public ?Collection $relationTypes = null;
    public string $search = '';

    protected EmergencyContactRepositoryInterface $emergencyContactRepository;
    protected HouseholdRelationTypeRepositoryInterface $householdRelationTypeRepository;
    public function boot()
    {
        $this->emergencyContactRepository = app(EmergencyContactRepositoryInterface::class);
        $this->householdRelationTypeRepository = app(HouseholdRelationTypeRepositoryInterface::class);
    }
    public function rules(): array
    {
        return [
            'clientId' => ['required', 'exists:clients,id'],
            'householdRelationTypeId' => ['required', 'exists:household_relation_types,id'],
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'phoneNumber' => ['required', 'string', 'max:20', Rule::unique('emergency_contacts','phone_number')->ignore($this->id)->where(function ($query) {
                return $query->where('client_id', $this->clientId);
            })],
        ];
    }
    public function messages(): array
    {
        return [
            'clientId.required' => 'The client field is required.',
            'householdRelationTypeId.required' => 'The relation type field is required.',
            'name.required' => 'The name field is required.',
            'address.required' => 'The address field is required.',
            'phoneNumber.unique' => 'This phone number already exists for the selected client.',
        ];
    }
    public function setData(?int $id = null): void
    {
        if ($id) {
            $result = $this->emergencyContactRepository->findById($id);
            if ($result) {
                $this->id = $result->id;
                $this->clientId = $result->client_id;
                $this->relationTypes = $this->householdRelationTypeRepository->getAll();
                $this->householdRelationTypeId = $result->household_relation_type_id;
                $this->name = $result->name;
                $this->address = $result->address;
                $this->phoneNumber = $result->phone_number;
            }
        }
        $this->relationTypes = $this->householdRelationTypeRepository->getAll();
    }

    public function save()
    {
        $this->validate($this->rules(), $this->messages());
        $data = [
            'client_id' => $this->clientId,
            'household_relation_type_id' => $this->householdRelationTypeId,
            'name' => $this->name,
            'address' => $this->address,
            'phone_number' => $this->phoneNumber,
        ];
        if ($this->id) {
            $this->emergencyContactRepository->update($this->id, $data);
        } else {
            $this->emergencyContactRepository->create($data);
        }
        $this->reset(['id',  'householdRelationTypeId', 'name', 'address', 'phoneNumber']);
    }
    public function delete()
    {
        if ($this->id) {
            $this->emergencyContactRepository->delete($this->id);
        }
    }
    public function getRelationTypesProperty()
    {
        $this->relationTypes = $this->householdRelationTypeRepository->getAll();
    }
    #[Computed]
    public function records(): LengthAwarePaginator
    {
        return $this->emergencyContactRepository->getFiltered($this->search, $this->clientId)
            ->with(['householdRelationType'])
            ->paginate(pageName: 'pages-emergency-contacts');
    }
}
