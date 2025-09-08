<?php

namespace App\Repositories;

use App\Models\IncomeType;
use Illuminate\Database\Eloquent\Collection;


interface IncomeTypeRepositoryInterface
{

    public function getAll(): Collection;

    public function findById(int $id): ?IncomeType;

    public function create(array $data): IncomeType;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

}
