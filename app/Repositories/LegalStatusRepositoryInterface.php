<?php

namespace App\Repositories;

use App\Models\LegalStatus;
use Illuminate\Database\Eloquent\Collection;


interface LegalStatusRepositoryInterface
{

    public function getAll(): Collection;

    public function findById(int $id): ?LegalStatus;

    public function create(array $data): LegalStatus;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

}
