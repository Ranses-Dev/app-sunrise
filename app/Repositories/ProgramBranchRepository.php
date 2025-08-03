<?php

namespace App\Repositories;

use App\Models\ProgramBranch;
use Illuminate\Database\Eloquent\Collection;


class ProgramBranchRepository implements ProgramBranchRepositoryInterface
{
    public function getAll(): Collection
    {
        return ProgramBranch::all();
    }
    public function findById(int $id): ?ProgramBranch
    {
        return ProgramBranch::find($id);
    }
    public function create(array $data): ProgramBranch
    {
        return ProgramBranch::create($data);
    }
    public function update(int $id, array $data): bool
    {
        $identificationType = $this->findById($id);
        if ($identificationType) {
            return $identificationType->update($data);
        }
        return false;
    }
    public function delete(int $id): bool
    {
        $identificationType = $this->findById($id);
        if ($identificationType) {
            return $identificationType->delete();
        }
        return false;
    }
}
