<?php

namespace App\Repositories;

use App\Models\CityDistrict;
use Illuminate\Database\Eloquent\Collection;


class CityDistrictRepository implements CityDistrictRepositoryInterface
{
    public function getAll(): Collection
    {
        return CityDistrict::all();
    }
    public function findById(int $id): ?CityDistrict
    {
        return CityDistrict::find($id);
    }
    public function create(array $data): CityDistrict
    {
        return CityDistrict::create($data);
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
