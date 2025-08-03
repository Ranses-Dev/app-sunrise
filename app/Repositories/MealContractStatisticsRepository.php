<?php

namespace App\Repositories;

use App\Models\MealContractStatistics as MealContractStatisticsModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;


class MealContractStatisticsRepository implements MealContractStatisticsRepositoryInterface
{

    public function getStatisticsForToday(): array
    {
        $today = Carbon::today();
        return MealContractStatisticsModel::query()
            ->where('date', $today)
            ->first([
                'delivery_cost',
                'food_cost',
                'program_delivery_cost',

                'weekly_food_cost',
                'weekly_delivery_cost',
                'weekly_program_delivery_cost',

                'monthly_food_cost',
                'monthly_delivery_cost',
                'monthly_program_delivery_cost',

                'yearly_food_cost',
                'yearly_program_delivery_cost',
                'yearly_delivery_cost',
            ])?->toArray() ?? [];
    }
}
