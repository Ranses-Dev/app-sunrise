<?php

namespace App\Livewire\Forms;

use App\Repositories\HealthcareProviderPlanRepositoryInterface;
use Illuminate\Validation\Rule;
use Livewire\Form;

class HealthcareProviderPlan extends Form
{
    public ?int $id = null;
    public ?string $name = null;
    public ?string $description = null;

    protected HealthcareProviderPlanRepositoryInterface $healthcareProviderPlanRepository;

    public function boot(HealthcareProviderPlanRepositoryInterface $healthcareProviderPlanRepository)
    {
        $this->healthcareProviderPlanRepository = $healthcareProviderPlanRepository;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('healthcare_provider_plans')->ignore($this->id)],
            'description' => ['nullable', 'string'],
        ];
    }

    public function setData(?int $id = null): void
    {
        if ($id) {
            $result = $this->healthcareProviderPlanRepository->findById($id);
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
            $this->healthcareProviderPlanRepository->update($this->id, $data);
        } else {
            $this->healthcareProviderPlanRepository->create($data);
        }
        $this->reset(['id', 'name', 'description']);
    }

    public function delete()
    {
        if ($this->id) {
            $this->healthcareProviderPlanRepository->delete($this->id);
        }
    }
}
