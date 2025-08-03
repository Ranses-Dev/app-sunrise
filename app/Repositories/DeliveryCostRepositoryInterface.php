<?php

namespace App\Repositories;


use App\Models\DeliveryCost;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;


interface DeliveryCostRepositoryInterface
{
    public function getAll(): Collection;
    public function getFiltered(string|null $filters): Builder;
    public function findById(int $id): ?DeliveryCost;
    public function create(array $data): DeliveryCost;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;

}
