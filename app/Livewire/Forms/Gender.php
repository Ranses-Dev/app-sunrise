<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Repositories\GenderRepositoryInterface;
use Illuminate\Validation\Rule;

class Gender extends Form
{
    public ?int $id = null;
    public ?string $name = null;
    protected GenderRepositoryInterface $genderRepository;
    public function boot(GenderRepositoryInterface $genderRepository)
    {
        $this->genderRepository = $genderRepository;
    }
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('genders', 'name')->ignore($this->id)],
        ];
    }
    public function setData(?int $id = null): void
    {
        if ($id) {
            $result = $this->genderRepository->findById($id);
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
            $this->genderRepository->update($this->id, $data);
        } else {
            $this->genderRepository->create($data);
        }
        $this->reset(['id', 'name']);
    }
    public function delete()
    {
        if ($this->id) {
            $this->genderRepository->delete($this->id);
        }
    }

}
