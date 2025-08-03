<?php

namespace App\Repositories;


use App\Models\HealthcareProvider;
use Illuminate\Database\Eloquent\Collection;


interface HealthcareProviderRepositoryInterface
{

    public function getAll(): Collection;

    public function findById(int $id): ?HealthcareProvider;

    public function create(array $data): HealthcareProvider;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
    public function getUnlinkedHealthCareProviderPlans(int $id): Collection;
    public function linkHealthCareProviderPlan(int $healthCareProviderId, int $planId): bool;
    public function unlinkHealthCareProviderPlan(int $healthCareProviderId, int $planId): bool;
    public function hasPlans(int $id): bool;
}
