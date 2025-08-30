<?php

namespace App\Repositories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;


interface AddressRepositoryInterface
{

    public function getAll(): Collection;

    public function getCitiesRegistered(): Collection;
    public function getStatesRegistered(): Collection;
    public function getCountiesRegistered(): Collection;
    public function getFiltered(array $filters): Builder;

    public function findById(int $id): ?Address;

    public function create(array $data): Address;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
    public function addressExists(array $data, int|null $id = null): bool;
}
