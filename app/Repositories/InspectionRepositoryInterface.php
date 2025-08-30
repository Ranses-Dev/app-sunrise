<?php

namespace App\Repositories;


use App\Models\Inspection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;


interface InspectionRepositoryInterface
{

    public function getAll(): Collection;

    public function findById(int $id): ?Inspection;
    public function getFiltered(array $filters = []): Builder;

    public function create(array $data): Inspection;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
}
