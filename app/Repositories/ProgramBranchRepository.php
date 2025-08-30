<?php

namespace App\Repositories;

use App\Models\ProgramBranch;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

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
        $programBranch = $this->findById($id);
        if ($programBranch) {
            return $programBranch->update($data);
        }
        return false;
    }
    public function delete(int $id): bool
    {
        $programBranch = $this->findById($id);
        if ($programBranch) {
            return $programBranch->delete();
        }
        return false;
    }

    public function getHowpaBranches(): Collection
    {
        return ProgramBranch::whereHas('program', function ($q) {
            $q->where('id', (int)config('services.programs.inspection_id'));
        })->get();
    }
}
