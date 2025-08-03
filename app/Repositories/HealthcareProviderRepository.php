<?php

namespace App\Repositories;

use App\Models\HealthcareProvider;
use App\Models\HealthcareProviderPlan;
use Illuminate\Database\Eloquent\Collection;


class HealthcareProviderRepository implements HealthcareProviderRepositoryInterface
{
    public function getAll(): Collection
    {
        return HealthcareProvider::all();
    }
    public function findById(int $id): ?HealthcareProvider
    {
        return HealthcareProvider::findOrFail($id);
    }
    public function create(array $data): HealthcareProvider
    {
        return HealthcareProvider::create($data);
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
    public function getUnlinkedHealthcareProviderPlans($id): Collection
    {
        return HealthcareProviderPlan::whereDoesntHave('providers', function ($query) use ($id) {
            $query->where('healthcare_provider_id', $id);
        })->get();
    }

    public function getLinkedHealthcareProviderPlans($id): Collection
    {
        return HealthcareProviderPlan::whereHas('providers', function ($query) use ($id) {
            $query->where('healthcare_provider_id', $id);
        })->get();
    }

    public function linkHealthcareProviderPlan(int $healthcareProviderId, int $planId): bool
    {
        $healthcareProvider = $this->findById($healthcareProviderId);
        if ($healthcareProvider) {
            $healthcareProvider->plans()->attach($planId);
            return true;
        }
        return false;
    }

    public function unlinkHealthcareProviderPlan(int $healthcareProviderId, int $planId): bool
    {
        $healthcareProvider = $this->findById($healthcareProviderId);
        if ($healthcareProvider) {
            $healthcareProvider->plans()->detach($planId);
            return true;
        }
        return false;
    }

    public function hasPlans(int $id): bool
    {
        $healthcareProvider = $this->findById($id);
        if ($healthcareProvider) {
            return $healthcareProvider->plans()->exists();
        }
        return false;
    }
}
