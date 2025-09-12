<?php

namespace App\Jobs;

use App\Models\MealContractStatistics;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CalculateMonthlyMealStats implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $today = Carbon::today();
        $startOfMonth = $today->copy()->startOfMonth();
        $endOfMonth = $today->copy()->endOfMonth();
        $weekDay = (string)$today->copy()->isoWeekday();
        $monthlyTotals = MealContractStatistics::query()
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->selectRaw('
        SUM(delivery_cost) as monthly_delivery_cost,
        SUM(food_cost) as monthly_food_cost,
        SUM(program_delivery_cost) as monthly_program_delivery_cost
    ')->whereJsonContains("delivery_days", $weekDay)
            ->first()?->toArray();
        MealContractStatistics::updateOrCreate(
            ['date' => $today],
            [
                'monthly_delivery_cost' => $monthlyTotals['monthly_delivery_cost'] ?? 0,
                'monthly_food_cost' => $monthlyTotals['monthly_food_cost'] ?? 0,
                'monthly_program_delivery_cost' => $monthlyTotals['monthly_program_delivery_cost'] ?? 0,
            ]
        );
    }
}
