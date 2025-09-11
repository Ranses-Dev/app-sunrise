<?php

namespace App\Repositories;

use App\Models\City;
use App\Models\CountyDistrict;
use App\Models\Inspection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;


class InspectionRepository implements InspectionRepositoryInterface
{
    public function getAll(): Collection
    {
        return Inspection::all();
    }
    public function findById(int $id): ?Inspection
    {
        return Inspection::find($id);
    }

     public function getFiltered(array $filters = []): Builder{
           return Inspection::search($filters);

}
    public function create(array $data): Inspection
    {
        return Inspection::create($data);
    }
    public function update(int $id, array $data): bool
    {
        $inspection = $this->findById($id);
        if ($inspection) {
            return $inspection->update($data);
        }
        return false;
    }
    public function delete(int $id): bool
    {
        $inspection = $this->findById($id);
        if ($inspection) {
            return $inspection->delete();
        }
        return false;
    }
}
