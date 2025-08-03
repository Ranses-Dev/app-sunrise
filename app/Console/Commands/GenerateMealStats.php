<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CalculateDailyMealStats;
use App\Jobs\CalculateWeeklyMealStats;
use App\Jobs\CalculateMonthlyMealStats;
use App\Jobs\CalculateYearlyMealStats;

class GenerateMealStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-meal-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Dispatching jobs for meal statistics...');
        CalculateDailyMealStats::dispatch();
        CalculateWeeklyMealStats::dispatch();
        CalculateMonthlyMealStats::dispatch();
        CalculateYearlyMealStats::dispatch();
        $this->info('Jobs dispatched successfully.');
    }
}
