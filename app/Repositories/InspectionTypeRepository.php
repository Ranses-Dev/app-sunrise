<?php

namespace App\Repositories;

use App\Models\InspectionType;
use Illuminate\Database\Eloquent\Collection;


class InspectionTypeRepository implements InspectionTypeRepositoryInterface
{
    public function getAll(): Collection
    {
        return InspectionType::all();
    }
}
