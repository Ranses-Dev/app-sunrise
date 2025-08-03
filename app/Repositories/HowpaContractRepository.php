<?php

namespace App\Repositories;

use App\Models\HowpaContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;


class HowpaContractRepository implements HowpaContractRepositoryInterface
{
    public function getAll(): Collection
    {
        return HowpaContract::all();
    }
    public function getFiltered(string|null $search = null): Builder
    {
        return HowpaContract::with(['client', 'programBranch'])->search($search);

    }
    public function findById(int $id): ?HowpaContract
    {
        return HowpaContract::with(['client', 'programBranch'])->find($id);
    }
    public function create(array $data): HowpaContract
    {
        return HowpaContract::create($data);
    }
    public function update(int $id, array $data): bool
    {
        $howpaContract = $this->findById($id);
        if ($howpaContract) {
            return $howpaContract->update($data);
        }
        return false;
    }
    public function delete(int $id): bool
    {
        $howpaContract = $this->findById($id);
        if ($howpaContract) {
            return $howpaContract->delete();
        }
        return false;
    }
}
