<?php

namespace App\Repositories;


use App\Models\ClientPhoneNumber;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;


interface ClientPhoneNumberRepositoryInterface
{

    public function getAll(): Collection;
    public function getAllByClientId(int $clientId): Collection;
    public function getFiltered(string $search): Builder;

    public function findById(int $id): ?ClientPhoneNumber;

    public function create(array $data): ClientPhoneNumber;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
}
