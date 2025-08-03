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
