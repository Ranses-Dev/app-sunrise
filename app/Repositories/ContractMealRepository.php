<?php

namespace App\Repositories;

use App\Models\ContractMeal;
use App\Models\Program;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;


class ContractMealRepository implements ContractMealRepositoryInterface
{
    public function getAll(): Collection
    {
        return ContractMeal::all();
    }
    public function getFiltered(string $search): Builder
    {
        return ContractMeal::search($search);
    }

    public function findById(int $id): ?ContractMeal
    {
        return ContractMeal::findOrFail($id);
    }
    public function create(array $data): ContractMeal
    {
        return ContractMeal::create($data);
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

    public function getProgramBranches(): Collection
    {
        return  Program::with('branches')->find(3)->branches;
    }
}
