<?php

namespace App\Repositories;


use App\Models\EmergencyContact;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;


interface EmergencyContactRepositoryInterface
{

    public function getAll(): Collection;

    public function getFiltered(string|null $search,int $clientId): Builder;

    public function findById(int $id): ?EmergencyContact;

    public function create(array $data): EmergencyContact;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
}
