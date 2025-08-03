<?php

namespace App\Repositories;

 
use App\Models\Program;
use Illuminate\Database\Eloquent\Collection;


interface ProgramRepositoryInterface
{

    public function getAll(): Collection;

    public function findById(int $id): ?Program;

    public function create(array $data): Program;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

}
