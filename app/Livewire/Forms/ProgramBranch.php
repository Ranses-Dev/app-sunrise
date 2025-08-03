<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Illuminate\Validation\Rule;
use App\Repositories\ProgramBranchRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class ProgramBranch extends Form
{
    public ?int $id = null;
    public ?int $programId = null;
    public ?string $name = null;
    public ?string $description = null;
    public Collection $programs;


    protected ProgramBranchRepositoryInterface $programBranchRepository;
    public function boot(ProgramBranchRepositoryInterface $programBranchRepository)
    {

        $this->programBranchRepository = $programBranchRepository;
    }
    public function rules(): array
    {
        return [
            'programId' => ['required', 'integer', Rule::exists('programs', 'id')],
            'name' => ['required', 'string', 'max:255', Rule::unique('program_branches')->ignore($this->id)],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }
    public function messages(): array
    {
        return [
            'programId.required' => __('Program is required'),
            'programId.integer' => __('Program is required'),
            'programId.exists' => __('Program does not exist'),
            'name.required' => __('Name is required'),
            'name.string' => __('Name must be a string'),
            'name.max' => __('Name must not exceed 255 characters'),
            'name.unique' => __('Name already exists'),
            'description.string' => __('Description must be a string'),
            'description.max' => __('Description must not exceed 255 characters'),
        ];

    }
    public function setData(?int $id = null): void
    {
        if ($id) {
            $result = $this->programBranchRepository->findById($id);
            if ($result) {
                $this->id = $result->id;
                $this->programId = $result->program_id;
                $this->name = $result->name;
                $this->description = $result->description;
            }
        }
    }
    public function save()
    {
        $this->validate($this->rules(), $this->messages());
        $data = [
            'program_id' => $this->programId,
            'name' => $this->name,
            'description' => $this->description,
        ];
        if ($this->id) {
            $this->programBranchRepository->update($this->id, $data);
        } else {
            $this->programBranchRepository->create($data);
        }
        $this->resetForm();
    }
    public function resetForm()
    {
        $this->reset([
            'id',
            'programId',
            'name',
            'description',
        ]);
    }
    public function delete()
    {
        if ($this->id) {
            $this->programBranchRepository->delete($this->id);
        }
    }

}
