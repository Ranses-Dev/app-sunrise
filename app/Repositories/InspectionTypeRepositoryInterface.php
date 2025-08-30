<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;


interface InspectionTypeRepositoryInterface
{
    public function getAll(): Collection;
}
