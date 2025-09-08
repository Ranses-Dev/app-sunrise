<?php

namespace App\Repositories;

use App\Models\IncomeType;
use Illuminate\Database\Eloquent\Collection;


class IncomeTypeRepository implements IncomeTypeRepositoryInterface
{
    public function getAll(): Collection
    {
        return IncomeType::all();
    }
    public function findById(int $id): ?IncomeType
    {
        return IncomeType::find($id);
    }
    public function create(array $data): IncomeType
    {
        return IncomeType::create($data);
    }
    public function update(int $id, array $data): bool
    {
        $incomeType = $this->findById($id);
        if ($incomeType) {
            return $incomeType->update($data);
        }
        return false;
    }
    public function delete(int $id): bool
    {
        $incomeType = $this->findById($id);
        if ($incomeType) {
            return $incomeType->delete();
        }
        return false;
    }
}
