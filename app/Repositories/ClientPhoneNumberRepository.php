<?php

namespace App\Repositories;

use App\Models\ClientPhoneNumber;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;


class ClientPhoneNumberRepository implements ClientPhoneNumberRepositoryInterface
{
    public function getAll(): Collection
    {
        return ClientPhoneNumber::all();
    }
    public function getAllByClientId(int $clientId): Collection
    {
        return ClientPhoneNumber::where('client_id', $clientId)->get();
    }
    public function getFiltered(string $search): Builder
    {
        return ClientPhoneNumber::search($search);
    }
    public function findById(int $id): ?ClientPhoneNumber
    {
        return ClientPhoneNumber::find($id);
    }
    public function create(array $data): ClientPhoneNumber
    {
        return ClientPhoneNumber::create($data);
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
}
