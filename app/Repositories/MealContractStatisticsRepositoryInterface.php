<?php

namespace App\Repositories;


use App\Models\MealContractStatistics;
use Illuminate\Database\Eloquent\Collection;


interface MealContractStatisticsRepositoryInterface
{
    public function getStatisticsForToday(): array;
}
