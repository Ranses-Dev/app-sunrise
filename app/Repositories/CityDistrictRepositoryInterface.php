<?php

namespace App\Repositories;


use App\Models\CityDistrict;
use Illuminate\Database\Eloquent\Collection;


interface CityDistrictRepositoryInterface
{

    public function getAll(): Collection;

    public function findById(int $id): ?CityDistrict;

    public function create(array $data): CityDistrict;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

}
