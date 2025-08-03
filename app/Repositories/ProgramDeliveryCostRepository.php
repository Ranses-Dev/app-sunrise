<?php

namespace App\Repositories;

use App\Models\ProgramDeliveryCost;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;


class ProgramDeliveryCostRepository implements ProgramDeliveryCostRepositoryInterface
{
    public function getAll(): Collection
    {
        return ProgramDeliveryCost::all();
    }
    public function getFiltered(string|null $search): Builder
    {
        return ProgramDeliveryCost::search($search);
    }

    public function findById(int $id): ?ProgramDeliveryCost
    {
        return ProgramDeliveryCost::findOrFail($id);
    }
    public function create(array $data): ProgramDeliveryCost
    {
        return ProgramDeliveryCost::create($data);
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
