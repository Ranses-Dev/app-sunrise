<?php

namespace App\Repositories;

use App\Models\HousingStatus;
use Illuminate\Database\Eloquent\Collection;


class HousingStatusRepository implements HousingStatusRepositoryInterface
{
    public function getAll(): Collection
    {
        return HousingStatus::all();
    }
    public function findById(int $id): ?HousingStatus
    {
        return HousingStatus::find($id);
    }
    public function create(array $data): HousingStatus
    {
        return HousingStatus::create($data);
    }
    public function update(int $id, array $data): bool
    {
        $housingStatus = $this->findById($id);
        if ($housingStatus) {
            return $housingStatus->update($data);
        }
        return false;
    }
    public function delete(int $id): bool
    {
        $program = $this->findById($id);
        if ($program) {
            return $program->delete();
        }
        return false;
    }
}
