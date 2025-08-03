<?php

namespace App\Jobs;

use App\Models\MealContractStatistics;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CalculateYearlyMealStats implements ShouldQueue
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
        $startOfYear = $today->copy()->startOfYear();
        $endOfYear = $today->copy()->endOfYear();
        $yearlyTotals = MealContractStatistics::query()
            ->whereBetween('date', [$startOfYear, $endOfYear])
            ->selectRaw('SUM(delivery_cost) as yearly_delivery_cost,SUM(food_cost) as yearly_food_cost,SUM(program_delivery_cost) as yearly_program_delivery_cost')
            ->first()?->toArray();
        MealContractStatistics::updateOrCreate(
            ['date' => $today],
            [
                'yearly_delivery_cost' => $yearlyTotals['yearly_delivery_cost'] ?? 0,
                'yearly_food_cost' => $yearlyTotals['yearly_food_cost'] ?? 0,
                'yearly_program_delivery_cost' => $yearlyTotals['yearly_program_delivery_cost'] ?? 0,
            ]
        );
    }
}
