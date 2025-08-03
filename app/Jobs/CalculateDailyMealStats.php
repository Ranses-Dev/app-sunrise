<?php

namespace App\Jobs;

use App\Models\ContractMeal;
use App\Models\MealContractStatistics;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class CalculateDailyMealStats implements ShouldQueue
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
        $dayTotals = ContractMeal::query()
            ->join('delivery_costs', 'contract_meals.delivery_cost_id', '=', 'delivery_costs.id')
            ->join('food_costs', 'contract_meals.food_cost_id', '=', 'food_costs.id')
            ->join('program_delivery_costs', 'contract_meals.program_delivery_cost_id', '=', 'program_delivery_costs.id')
            ->where('contract_meals.is_active', true)
            ->selectRaw('SUM(delivery_costs.cost) as delivery_cost,SUM(food_costs.cost) as food_cost,SUM(program_delivery_costs.cost) as program_delivery_cost')
            ->first()?->toArray();
        MealContractStatistics::updateOrCreate(
            ['date' => $today],
            [
                'delivery_cost' => $dayTotals['delivery_cost'] ?? 0,
                'food_cost' => $dayTotals['food_cost'] ?? 0,
                'program_delivery_cost' => $dayTotals['program_delivery_cost'] ?? 0,
            ]
        );
    }
}
