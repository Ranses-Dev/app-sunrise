<?php

namespace App\Repositories;


use App\Models\HousingStatus;
use Illuminate\Database\Eloquent\Collection;


interface HousingStatusRepositoryInterface
{

    public function getAll(): Collection;

    public function findById(int $id): ?HousingStatus;

    public function create(array $data): HousingStatus;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

}
