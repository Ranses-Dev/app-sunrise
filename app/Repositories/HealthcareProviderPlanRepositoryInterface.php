<?php

namespace App\Repositories;


use App\Models\HealthcareProviderPlan;
use Illuminate\Database\Eloquent\Collection;


interface HealthcareProviderPlanRepositoryInterface
{

    public function getAll(): Collection;

    public function findById(int $id): ?HealthcareProviderPlan;

    public function create(array $data): HealthcareProviderPlan;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

    public function getByHealthcareProviderId(?int $healthcareProviderId): Collection;
}
