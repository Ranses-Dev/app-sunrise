<?php

namespace App\Repositories;


use App\Models\HouseholdMember;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;


interface HouseholdMemberRepositoryInterface
{

    public function getAll(): Collection;
    public function getFiltered(int|null $clientId, string $search): Builder;

    public function findById(int $id): ?HouseholdMember;

    public function create(array $data): HouseholdMember;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

    public function validateUniqueSSN(string $ssn, int $clientId, ?int $id = null): bool;
}
