<?php

namespace App\Livewire\Forms;


use Livewire\Form;
use App\Repositories\EthnicityRepositoryInterface;
use Illuminate\Validation\Rule;

class Ethnicity extends Form
{
    public ?int $id = null;
    public ?string $name = null;
    protected EthnicityRepositoryInterface $ethnicityRepository;
    public function boot(EthnicityRepositoryInterface $ethnicityRepository)
    {
        $this->ethnicityRepository = $ethnicityRepository;
    }
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('ethnicities')->ignore($this->id)],
        ];
    }
    public function setData(?int $id = null): void
    {
        if ($id) {
            $result = $this->ethnicityRepository->findById($id);
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
            $this->ethnicityRepository->update($this->id, $data);
        } else {
            $this->ethnicityRepository->create($data);
        }
        $this->reset(['id', 'name']);

    }
    public function delete()
    {
        if ($this->id) {
            $this->ethnicityRepository->delete($this->id);
        }
    }
}
