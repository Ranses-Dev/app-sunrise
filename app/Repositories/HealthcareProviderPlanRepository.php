<?php

namespace App\Repositories;

use App\Models\HealthcareProvider;
use App\Models\HealthcareProviderPlan;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class HealthcareProviderPlanRepository implements HealthcareProviderPlanRepositoryInterface
{
    public function getAll(): Collection
    {
        return HealthcareProviderPlan::all();
    }
    public function findById(int $id): ?HealthcareProviderPlan
    {
        return HealthcareProviderPlan::find($id);
    }
    public function create(array $data): HealthcareProviderPlan
    {
        return HealthcareProviderPlan::create($data);
    }
    public function update(int $id, array $data): bool
    {
        $identificationType = $this->findById($id);
        if ($identificationType) {
            return $identificationType->update($data);
        }
        return false;
    }
    public function delete(int $id): bool
    {
        $identificationType = $this->findById($id);
        if ($identificationType) {
            return $identificationType->delete();
        }
        return false;
    }

    public function getByHealthcareProviderId(?int $healthcareProviderId): Collection
    {
        return HealthcareProvider::with('plans')->find($healthcareProviderId)?->plans()?->get(['id', 'name'])?? new Collection();
    }
}
