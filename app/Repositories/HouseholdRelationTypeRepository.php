<?php

namespace App\Repositories;

use App\Models\HouseholdRelationType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;


class HouseholdRelationTypeRepository implements HouseholdRelationTypeRepositoryInterface
{
    public function getAll(): Collection
    {
        return HouseholdRelationType::all();
    }
    public function getFiltered(string $search): Builder
    {
        return HouseholdRelationType::search($search);
    }

    public function findById(int $id): ?HouseholdRelationType
    {
        return HouseholdRelationType::find($id);
    }
    public function create(array $data): HouseholdRelationType
    {
        return HouseholdRelationType::create($data);
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
