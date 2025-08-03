<?php

namespace App\Repositories;

use App\Models\IdentificationType;
use Illuminate\Database\Eloquent\Collection;

interface IdentificationTypeRepositoryInterface
{

    public function getAll(): Collection;

    public function findById(int $id): ?IdentificationType;

    public function getIdByName(string $name): ?int;

    public function create(array $data): IdentificationType;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
}
