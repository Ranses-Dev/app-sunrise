<?php

namespace App\Repositories;


use App\Models\CountyDistrict;
use Illuminate\Database\Eloquent\Collection;


interface CountyDistrictRepositoryInterface
{

    public function getAll(): Collection;

    public function findById(int $id): ?CountyDistrict;

    public function create(array $data): CountyDistrict;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

    public function getUnlinkedCities(int $id): Collection;
    public function linkCity(int $countyDistrictId, int $cityId): bool;
    public function unlinkCity(int $countyDistrictId, int $cityId): bool;
}
