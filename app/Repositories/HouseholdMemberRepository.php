<?php

namespace App\Repositories;

use App\Models\HouseholdMember;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;


class HouseholdMemberRepository implements HouseholdMemberRepositoryInterface
{
    public function getAll(): Collection
    {
        return HouseholdMember::all();
    }
    public function getFiltered(int|null $clientId, string $search): Builder
    {
        return HouseholdMember::search($search)->where('client_id', $clientId);
    }
    public function findById(int $id): ?HouseholdMember
    {
        return HouseholdMember::find($id);
    }
    public function create(array $data): HouseholdMember
    {
        return HouseholdMember::create($data);
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
    public function validateUniqueSSN(string $ssn, int $clientId, ?int $id = null): bool
    {
        $hash = hash('sha256', $ssn);
        $query = HouseholdMember::where('ssn_hash', $hash)->where('client_id', $clientId);
        if ($id) {
            $query->where('id', '!=', $id);
        }
        return $query->exists() ? false : true;
    }
}
