<?php

namespace App\Repositories;

use App\Models\HousingType;

use Illuminate\Database\Eloquent\Collection;


class HousingTypeRepository implements HousingTypeRepositoryInterface
{
    public function getAll(): Collection
    {
        return HousingType::all();
    }
}
