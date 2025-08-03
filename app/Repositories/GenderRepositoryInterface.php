<?php

namespace App\Repositories;


use App\Models\Gender;
use Illuminate\Database\Eloquent\Collection;


interface GenderRepositoryInterface
{

    public function getAll(): Collection;

    public function findById(int $id): ?Gender;

    public function create(array $data): Gender;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

}
