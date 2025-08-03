<?php

namespace App\Jobs;

use App\Models\MealContractStatistics;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CalculateWeeklyMealStats implements ShouldQueue
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
        $startOfWeek = $today->copy()->startOfWeek();
        $endOfWeek = $today->copy()->endOfWeek();

        $weeklyTotals = MealContractStatistics::query()
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->selectRaw('
        SUM(delivery_cost) as weekly_delivery_cost,
        SUM(food_cost) as weekly_food_cost,
        SUM(program_delivery_cost) as weekly_program_delivery_cost
    ')
            ->first()?->toArray();

        MealContractStatistics::updateOrCreate(
            ['date' => $today],
            [
                'weekly_delivery_cost' => $weeklyTotals['weekly_delivery_cost'] ?? 0,
                'weekly_food_cost' => $weeklyTotals['weekly_food_cost'] ?? 0,
                'weekly_program_delivery_cost' => $weeklyTotals['weekly_program_delivery_cost'] ?? 0,
            ]
        );
    }
}
