<?php

namespace App\Repositories;

use App\Models\FoodCost;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;


class FoodCostRepository implements FoodCostRepositoryInterface
{
    public function getAll(): Collection
    {
        return FoodCost::all();
    }
    public function getFiltered(string|null $search): Builder
    {
        return FoodCost::filters($search);
    }

    public function findById(int $id): ?FoodCost
    {
        return FoodCost::findOrFail($id);
    }
    public function create(array $data): FoodCost
    {
        return FoodCost::create($data);
    }
    public function update(int $id, array $data): bool
    {
        $model = $this->findById($id);
        if ($model) {
            return $model->update($data);
        }
        return false;
    }
    public function delete(int $id): bool
    {
        $model = $this->findById($id);
        if ($model) {
            return $model->delete();
        }
        return false;
    }
}
