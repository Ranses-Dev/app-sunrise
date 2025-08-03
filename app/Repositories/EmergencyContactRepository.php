<?php

namespace App\Repositories;

use App\Models\EmergencyContact;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;


class EmergencyContactRepository implements EmergencyContactRepositoryInterface
{
    public function getAll(): Collection
    {
        return EmergencyContact::all();
    }
    public function getFiltered(string|null $search, int $clientId): Builder
    {
        return EmergencyContact::search($search)->where('client_id', $clientId);
    }
    public function findById(int $id): ?EmergencyContact
    {
        return EmergencyContact::with(['householdRelationType'])->find($id);
    }
    public function create(array $data): EmergencyContact
    {
        return EmergencyContact::create($data);
    }
    public function update(int $id, array $data): bool
    {
        $emergencyContact = $this->findById($id);
        if ($emergencyContact) {
            return $emergencyContact->update($data);
        }
        return false;
    }
    public function delete(int $id): bool
    {
        $emergencyContact = $this->findById($id);
        if ($emergencyContact) {
            return $emergencyContact->delete();
        }
        return false;
    }
}
