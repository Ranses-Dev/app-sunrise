<?php

namespace App\Repositories;

use App\Models\LegalStatus;
use Illuminate\Database\Eloquent\Collection;


class LegalStatusRepository implements LegalStatusRepositoryInterface
{
    public function getAll(): Collection
    {
        return LegalStatus::all();
    }
    public function findById(int $id): ?LegalStatus
    {
        return LegalStatus::find($id);
    }
    public function create(array $data): LegalStatus
    {
        return LegalStatus::create($data);
    }
    public function update(int $id, array $data): bool
    {
        $identificationType = $this->findById($id);
        if ($identificationType) {
            return $identificationType->update($data);
        }
        return false;
    }
    public function delete(int $id): bool
    {
        $identificationType = $this->findById($id);
        if ($identificationType) {
            return $identificationType->delete();
        }
        return false;
    }
}
