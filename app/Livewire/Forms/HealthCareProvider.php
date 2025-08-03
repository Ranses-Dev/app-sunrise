<?php

namespace App\Livewire\Forms;


use Livewire\Form;
use App\Repositories\HealthcareProviderRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;

class HealthCareProvider extends Form
{
    public ?int $id = null;
    public ?string $name = null;
    public ?string $description = null;

    protected HealthCareProviderRepositoryInterface $healthCareProviderRepository;
    public function boot(HealthCareProviderRepositoryInterface $healthCareProviderRepository)
    {
        $this->healthCareProviderRepository = $healthCareProviderRepository;
    }
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('health_care_providers')->ignore($this->id)],
            'notes' => ['nullable', 'string'],
        ];
    }
    public function setData(?int $id = null): void
    {
        if ($id) {
            $result = $this->healthCareProviderRepository->findById($id);
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
            $this->healthCareProviderRepository->update($this->id, $data);
        } else {
            $this->healthCareProviderRepository->create($data);
        }
        $this->reset(['id', 'name', 'description']);
    }
    public function delete()
    {
        if ($this->id) {
            $this->healthCareProviderRepository->delete($this->id);
        }
    }

    public function unlinkPlans(int $id): Collection
    {
        return $this->healthCareProviderRepository->getUnlinkedHealthCareProviderPlans($id);
    }

    public function linkHealthCareProviderPlan(int $healthCareProviderId, int $planId): bool
    {
        return $this->healthCareProviderRepository->linkHealthCareProviderPlan($healthCareProviderId, $planId);
    }
    public function unlinkHealthCareProviderPlan(int $healthCareProviderId, int $planId): bool
    {
        return $this->healthCareProviderRepository->unlinkHealthCareProviderPlan($healthCareProviderId, $planId);
    }
}
