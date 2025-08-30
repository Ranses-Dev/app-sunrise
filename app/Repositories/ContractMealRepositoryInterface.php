<?php

namespace App\Repositories;


use App\Models\ContractMeal;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;


interface ContractMealRepositoryInterface
{
    public function getAll(): Collection;
    public function getFiltered(array $filters): Builder;
    public function findById(int $id): ?ContractMeal;
    public function create(array $data): ContractMeal;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function getProgramBranches(): Collection;
}
