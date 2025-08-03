<?php

namespace App\Repositories;

use App\Models\IncomeLimit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class IncomeLimitRepository implements IncomeLimitRepositoryInterface
{
    public function getAll(): Collection
    {
        return IncomeLimit::all();
    }
    public function getFiltered(array $filters): Builder
    {
        return IncomeLimit::filters($filters);
    }

    public function findById(int $id): ?IncomeLimit
    {
        return IncomeLimit::find($id);
    }
    public function create(array $data): IncomeLimit
    {
        return IncomeLimit::create($data);
    }
    public function update(int $id, array $data): bool
    {
        $model = $this->findById($id);
        if ($model) {
            return $model->update($data);
        }
        return false;
    }
    public function delete(int $id): bool
    {
        $model = $this->findById($id);
        if ($model) {
            return $model->delete();
        }
        return false;
    }
    public function getHouseholdSizes(): array
    {
        return  DB::table('income_limits')
            ->select('household_size')
            ->groupBy('household_size')
            ->pluck('household_size')->toArray();
    }
    public function percentageCategories(): array
    {
        return DB::table('income_limits')
            ->select('percentage_category')
            ->groupBy('percentage_category')
            ->pluck('percentage_category')->toArray();
    }
    public function getIncomeLimits(): array
    {
        return DB::table('income_limits')
            ->select('income_limit')
            ->groupBy('income_limit')
            ->pluck('income_limit')->toArray();
    }
}
