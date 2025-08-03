<?php

namespace App\Repositories;

use App\Models\Gender;
use Illuminate\Database\Eloquent\Collection;


class GenderRepository implements GenderRepositoryInterface
{
    public function getAll(): Collection
    {
        return Gender::all();
    }
    public function findById(int $id): ?Gender
    {
        return Gender::find($id);
    }
    public function create(array $data): Gender
    {
        return Gender::create($data);
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
