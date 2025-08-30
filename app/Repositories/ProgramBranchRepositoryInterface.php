<?php

namespace App\Repositories;

use App\Models\ProgramBranch;
use Illuminate\Database\Eloquent\Collection;


interface ProgramBranchRepositoryInterface
{

    public function getAll(): Collection;

    public function findById(int $id): ?ProgramBranch;

    public function create(array $data): ProgramBranch;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

    public function getHowpaBranches(): Collection;
}
