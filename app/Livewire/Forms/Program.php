<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Repositories\ProgramRepositoryInterface;
use Illuminate\Validation\Rule;

class Program extends Form
{
    public ?int $id = null;
    public ?string $name = null;
    public ?string $description = null;

    protected ProgramRepositoryInterface $programRepository;
    public function boot(ProgramRepositoryInterface $programRepository)
    {
        $this->programRepository = $programRepository;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('programs')->ignore($this->id)],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function setData(?int $id = null): void
    {
        if ($id) {
            $result = $this->programRepository->findById($id);
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
            $this->programRepository->update($this->id, $data);
        } else {
            $this->programRepository->create($data);
        }
        $this->resetForm();

    }
    public function delete()
    {
        if ($this->id) {
            $this->programRepository->delete($this->id);
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
