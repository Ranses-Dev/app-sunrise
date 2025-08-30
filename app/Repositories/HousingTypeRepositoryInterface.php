<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;


interface HousingTypeRepositoryInterface
{
    public function getAll(): Collection;
}
