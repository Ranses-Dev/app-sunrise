<?php

namespace App\Repositories;


use App\Models\ProgramDeliveryCost;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;


interface ProgramDeliveryCostRepositoryInterface
{
    public function getAll(): Collection;
    public function getFiltered(string|null $search): Builder;
    public function findById(int $id): ?ProgramDeliveryCost;
    public function create(array $data): ProgramDeliveryCost;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;

}
