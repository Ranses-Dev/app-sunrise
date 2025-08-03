<?php

namespace App\Livewire\Forms;

use App\Repositories\LegalStatusRepositoryInterface;
use Illuminate\Validation\Rule;
use Livewire\Form;

class LegalStatus extends Form
{
    public ?int $id = null;
    public ?string $name = null;
    public ?string $description = null;

    protected LegalStatusRepositoryInterface $legalStatusRepository;
    public function boot(LegalStatusRepositoryInterface $legalStatusRepository)
    {
        $this->legalStatusRepository = $legalStatusRepository;
    }

    public function rules(): array
    {

        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('legal_statuses')->ignore($this->id)],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function setData(?int $id = null): void
    {
        if ($id) {
            $result = $this->legalStatusRepository->findById($id);
            if ($result) {
                $this->id = $result->id;
                $this->name = $result->name;
                $this->description = $result->description;
            }
        }
    }
    public function save()
    {
        $this->validate();
        $data = [
            'name' => $this->name,
            'description' => $this->description,
        ];
        if ($this->id) {
            $this->legalStatusRepository->update($this->id, $data);
        } else {
            $this->legalStatusRepository->create($data);
        }
        $this->reset(['id', 'name', 'description']);
    }
    public function delete()
    {
        if ($this->id) {
            $this->legalStatusRepository->delete($this->id);
        }
    }

}
