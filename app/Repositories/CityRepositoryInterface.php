<?php

namespace App\Repositories;


use App\Models\City;
use Illuminate\Database\Eloquent\Collection;


interface CityRepositoryInterface
{

    public function getAll(): Collection;

    public function findById(int $id): ?City;

    public function create(array $data): City;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
    public function getCityByDistrictId(int|string|null $districtId): Collection;

   
}
