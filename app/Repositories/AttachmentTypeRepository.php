<?php

namespace App\Repositories;

use App\Models\AttachmentType;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AttachmentTypeRepository implements AttachmentTypeRepositoryInterface
{
    public function getAll(): Collection
    {
        return AttachmentType::all();
    }
    public function findById(int $id): ?AttachmentType
    {
        return AttachmentType::find($id);
    }
    public function create(array $data): AttachmentType
    {
        return AttachmentType::create($data);
    }
    public function update(int $id, array $data): bool
    {
        $client = $this->findById($id);
        if ($client) {
            return $client->update($data);
        }
        return false;
    }
    public function delete(int $id): bool
    {
        $client = $this->findById($id);
        if ($client) {
            return $client->delete();
        }
        return false;
    }







}
