<?php

namespace App\Livewire\Forms;

use App\Repositories\IdentificationTypeRepositoryInterface;
use Illuminate\Validation\Rule;
use Livewire\Form;

class IdentificationType extends Form
{
    public ?int $id = null;
    public ?string $name = null;
    public ?string $description = null;
    protected IdentificationTypeRepositoryInterface $identificationTypeRepository;
    public function boot(IdentificationTypeRepositoryInterface $identificationTypeRepository)
    {
        $this->identificationTypeRepository = $identificationTypeRepository;
    }
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('identification_types')->ignore($this->id)],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function setData(?int $id = null): void
    {
        if ($id) {
            $result = $this->identificationTypeRepository->findById($id);
            if ($result) {
                $this->id = $result->id;
                $this->name = $result->name;
                $this->description = $result->description;
            }
        }
    }
    public function store()
    {
        $this->validate();
        $data = [
            'name' => $this->name,
            'description' => $this->description,
        ];
        if ($this->id) {
            $this->identificationTypeRepository->update($this->id, $data);
        } else {
            $this->identificationTypeRepository->create($data);
        }
        $this->resetForm();
    }

    public function update()
    {
        $this->validate();
        $data = [
            'name' => $this->name,
            'description' => $this->description,
        ];
        if ($this->id) {
            $this->identificationTypeRepository->update($this->id, $data);
        }
        $this->resetForm();
    }

    public function delete()
    {
        if ($this->id) {
            $this->identificationTypeRepository->delete($this->id);
        }
    }
    public function resetForm()
    {
        $this->reset([
            'id',
            'name',
            'description',
        ]);

    }
}
