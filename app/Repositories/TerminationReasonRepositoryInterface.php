<?php

namespace App\Repositories;


use App\Models\TerminationReason;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;


interface TerminationReasonRepositoryInterface
{
    public function getAll(): Collection;
    public function getFiltered(string|null $search): Builder;
    public function findById(int $id): ?TerminationReason;
    public function create(array $data): TerminationReason;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;

}
