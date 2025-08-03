<?php

namespace App\Repositories;

use App\Models\Ethnicity;
use Illuminate\Database\Eloquent\Collection;


class EthnicityRepository implements EthnicityRepositoryInterface
{
    public function getAll(): Collection
    {
        return Ethnicity::all();
    }
    public function findById(int $id): ?Ethnicity
    {
        return Ethnicity::find($id);
    }
    public function create(array $data): Ethnicity
    {
        return Ethnicity::create($data);
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
