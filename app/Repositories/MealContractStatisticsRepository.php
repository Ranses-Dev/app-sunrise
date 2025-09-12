<?php

namespace App\Repositories;

use App\Models\MealContractStatistics as MealContractStatisticsModel;
use App\Traits\ConvertFormatCurrency;
use Carbon\Carbon;


class MealContractStatisticsRepository implements MealContractStatisticsRepositoryInterface
{
    use ConvertFormatCurrency;

    public function getStatisticsForToday(): array
    {
        $today = Carbon::today();

        $stats = MealContractStatisticsModel::query()
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
            ]);

        if (!$stats) {
            return [];
        }
        $data = $stats->toArray();
        $totals = [
            'daily_total'   => ($data['delivery_cost'] ?? 0) + ($data['food_cost'] ?? 0) + ($data['program_delivery_cost'] ?? 0),
            'weekly_total'  => ($data['weekly_delivery_cost'] ?? 0) + ($data['weekly_food_cost'] ?? 0) + ($data['weekly_program_delivery_cost'] ?? 0),
            'monthly_total' => ($data['monthly_delivery_cost'] ?? 0) + ($data['monthly_food_cost'] ?? 0) + ($data['monthly_program_delivery_cost'] ?? 0),
            'yearly_total'  => ($data['yearly_delivery_cost'] ?? 0) + ($data['yearly_food_cost'] ?? 0) + ($data['yearly_program_delivery_cost'] ?? 0),
        ];


        return collect(array_merge($stats->toArray(), $totals))->map(function ($value) {
            return (string)$this->convertToCurrencyFormat($value);
        })->toArray();
    }
}
