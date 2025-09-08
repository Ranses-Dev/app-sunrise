<?php

namespace App\Repositories;


use App\Models\Ethnicity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;


interface EthnicityRepositoryInterface
{

    public function getAll(): Collection;

    public function findById(int $id): ?Ethnicity;

    public function create(array $data): Ethnicity;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

    public function getEthnicitiesWithClientCount(): Builder;
}
