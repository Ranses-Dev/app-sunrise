<?php

namespace App\Livewire\Forms;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Form;
use App\Repositories\HouseholdRelationTypeRepositoryInterface;
use Illuminate\Validation\Rule;

class HouseholdRelationType extends Form
{
    public ?int $id = null;
    public ?string $name = null;
    protected HouseholdRelationTypeRepositoryInterface $householdRelationTypeRepository;

    public function boot(HouseholdRelationTypeRepositoryInterface $householdRelationTypeRepository)
    {
        $this->householdRelationTypeRepository = $householdRelationTypeRepository;
    }
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('household_relation_types', 'name')->ignore($this->id)],
        ];
    }
    public function setData(?int $id = null): void
    {
        if ($id) {
            $result = $this->householdRelationTypeRepository->findById($id);
            if ($result) {
                $this->id = $result->id;
                $this->name = $result->name;
            }
        }
    }
    public function save()
    {
        $this->validate();
        $data = [
            'name' => $this->name,
        ];
        if ($this->id) {
            $this->householdRelationTypeRepository->update($this->id, $data);
        } else {
            $this->householdRelationTypeRepository->create($data);
        }
        $this->reset(['id', 'name']);
    }
    public function delete()
    {
        if ($this->id) {
            $this->householdRelationTypeRepository->delete($this->id);
        }
    }

    public function getFiltered(string $search): LengthAwarePaginator
    {
        return $this->householdRelationTypeRepository->getFiltered($search)
            ->paginate(pageName: 'household-relation-types-page');
    }
}
