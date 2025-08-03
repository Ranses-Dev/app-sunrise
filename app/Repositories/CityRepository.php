<?php

namespace App\Repositories;

use App\Models\City;
use App\Models\CountyDistrict;
use Illuminate\Database\Eloquent\Collection;


class CityRepository implements CityRepositoryInterface
{
    public function getAll(): Collection
    {
        return City::all();
    }
    public function findById(int $id): ?City
    {
        return City::find($id);
    }
    public function create(array $data): City
    {
        return City::create($data);
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
    public function getCityByDistrictId(int|string|null $districtId): Collection
    {
        return CountyDistrict::with('cities')->find($districtId)?->cities()->get(['cities.id', 'cities.name']) ?? new Collection();
    }
}
