<?php

namespace App\Repositories;


use App\Models\IncomeLimit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;


interface IncomeLimitRepositoryInterface
{
    public function getAll(): Collection;
    public function getFiltered(array $filters): Builder;
    public function findById(int $id): ?IncomeLimit;
    public function create(array $data): IncomeLimit;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function getHouseholdSizes(): array;
    public function percentageCategories(): array;
    public function getIncomeLimits(): array;
}
