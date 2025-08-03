<?php

namespace App\Repositories;

use App\Models\City;
use App\Models\CountyDistrict;
use Illuminate\Database\Eloquent\Collection;


class CountyDistrictRepository implements CountyDistrictRepositoryInterface
{
    public function getAll(): Collection
    {
        return CountyDistrict::all();
    }
    public function findById(int $id): ?CountyDistrict
    {
        return CountyDistrict::find($id);
    }
    public function create(array $data): CountyDistrict
    {
        return CountyDistrict::create($data);
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

    public function getUnlinkedCities(int $id): Collection
    {
        return City::whereDoesntHave('districts', function ($query) use ($id) {
            $query->where('county_district_id', $id);
        })->get();
    }
    public function linkCity(int $countyDistrictId, int $cityId): bool
    {
        $countyDistrict = $this->findById($countyDistrictId);
        if ($countyDistrict) {
            $countyDistrict->cities()->attach($cityId);
            return true;
        }
        return false;
    }
    public function unlinkCity(int $countyDistrictId, int $cityId): bool
    {

        $countyDistrict = $this->findById($countyDistrictId);
        if ($countyDistrict) {
            $countyDistrict->cities()->detach($cityId);
            return true;
        }
        return false;
    }
}
