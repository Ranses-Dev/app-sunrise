<?php

namespace App\Repositories;

use App\Models\Program;
use Illuminate\Database\Eloquent\Collection;


class ProgramRepository implements ProgramRepositoryInterface
{
    public function getAll(): Collection
    {
        return Program::all();
    }
    public function findById(int $id): ?Program
    {
        return Program::find($id);
    }
    public function create(array $data): Program
    {
        return Program::create($data);
    }
    public function update(int $id, array $data): bool
    {
        $program = $this->findById($id);
        if ($program) {
            return $program->update($data);
        }
        return false;
    }
    public function delete(int $id): bool
    {
        $program = $this->findById($id);
        if ($program) {
            return $program->delete();
        }
        return false;
    }
}
