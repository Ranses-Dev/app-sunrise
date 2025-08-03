<?php

namespace App\Repositories;

use App\Models\DeliveryCost;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;


class DeliveryCostRepository implements DeliveryCostRepositoryInterface
{
    public function getAll(): Collection
    {
        return DeliveryCost::all();
    }
    public function getFiltered(string|null $search): Builder
    {
        return DeliveryCost::search($search);
    }

    public function findById(int $id): ?DeliveryCost
    {
        return DeliveryCost::findOrFail($id);
    }
    public function create(array $data): DeliveryCost
    {
        return DeliveryCost::create($data);
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
