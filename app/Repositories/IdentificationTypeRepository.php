<?php

namespace App\Repositories;

use App\Models\IdentificationType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class IdentificationTypeRepository implements IdentificationTypeRepositoryInterface
{
    public function getAll(): Collection
    {
        return IdentificationType::all();
    }
    public function getIdByName(string $name): ?int
    {
        return  IdentificationType::where('name', $name)->first() ?? null;
    }
    public function findById(int $id): ?IdentificationType
    {
        return IdentificationType::find($id);
    }
    public function create(array $data): IdentificationType
    {
        return IdentificationType::create($data);
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
