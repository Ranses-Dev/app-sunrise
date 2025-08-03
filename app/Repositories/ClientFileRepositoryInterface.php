<?php

namespace App\Repositories;


use App\Models\ClientFile;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface ClientFileRepositoryInterface
{

    public function getAll(): Collection;

    public function findById(int $id): ?ClientFile;

    public function create(array $data): ClientFile;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

    public function deleteFileIfExists(int $id): void;
    public function downloadFile(int $id): ?StreamedResponse;
}
