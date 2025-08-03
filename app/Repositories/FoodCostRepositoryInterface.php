<?php

namespace App\Repositories;


use App\Models\FoodCost;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;


interface FoodCostRepositoryInterface
{
    public function getAll(): Collection;
    public function getFiltered(string|null $search): Builder;
    public function findById(int $id): ?FoodCost;
    public function create(array $data): FoodCost;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;

}
