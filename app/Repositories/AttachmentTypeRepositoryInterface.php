<?php

namespace App\Repositories;


use App\Models\AttachmentType;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface AttachmentTypeRepositoryInterface
{

    public function getAll(): Collection;

    public function findById(int $id): ?AttachmentType;

    public function create(array $data): AttachmentType;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
}
