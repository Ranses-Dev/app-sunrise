<?php

namespace App\Repositories;


use App\Models\HouseholdRelationType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;


interface HouseholdRelationTypeRepositoryInterface
{

    public function getAll(): Collection;
    public function getFiltered(string $search): Builder;

    public function findById(int $id): ?HouseholdRelationType;

    public function create(array $data): HouseholdRelationType;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

}
