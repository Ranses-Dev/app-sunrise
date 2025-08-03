<?php

namespace App\Repositories;

use App\Models\ClientFile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ClientFileRepository implements ClientFileRepositoryInterface
{
    public function getAll(): Collection
    {
        return ClientFile::all();
    }
    public function findById(int $id): ?ClientFile
    {
        return ClientFile::find($id);
    }
    public function create(array $data): ClientFile
    {
        return ClientFile::create($data);
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
    public function deleteFileIfExists(int $id): void
    {
        $model = $this->findById($id);
        if ($model) {
            $model->deleteFileIfExists();
        }
    }
    public function downloadFile(int $id): ?StreamedResponse
    {
        $client = $this->findById($id);
        if ($client) {
            return $client->downloadFileIfExists();
        }
        return null;
    }
}
