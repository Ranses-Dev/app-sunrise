<?php

namespace App\Repositories;


use App\Models\HowpaContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;


interface HowpaContractRepositoryInterface
{

    public function getAll(): Collection;
    public function getFiltered(array $filters): Builder;
    public function findById(int $id): ?HowpaContract;

    public function create(array $data): HowpaContract;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
    public function getProgramBranches(): Collection;
}
