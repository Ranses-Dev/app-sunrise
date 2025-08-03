<?php

namespace App\Repositories;

use App\Models\TerminationReason;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;


class TerminationReasonRepository implements TerminationReasonRepositoryInterface
{
    public function getAll(): Collection
    {
        return TerminationReason::all();
    }
    public function getFiltered(string|null $search): Builder
    {
        return TerminationReason::search($search);
    }

    public function findById(int $id): ?TerminationReason
    {
        return TerminationReason::findOrFail($id);
    }
    public function create(array $data): TerminationReason
    {
        return TerminationReason::create($data);
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
