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
        $city = $this->findById($id);
        if ($city) {
            return $city->update($data);
        }
        return false;
    }
    public function delete(int $id): bool
    {
        $city = $this->findById($id);
        if ($city) {
            return $city->delete();
        }
        return false;
    }
    public function getCityByDistrictId(int|string|null $districtId): Collection
    {
        return CountyDistrict::with('cities')->find($districtId)?->cities()->get(['cities.id', 'cities.name']) ?? new Collection();
    }
}
