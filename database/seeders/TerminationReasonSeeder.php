<?php

namespace Database\Seeders;

use App\Models\TerminationReason;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TerminationReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reasons = [
            'Does not want to participate (date)',
            'Over Income',
            'Died (date)',
            'Moved outside Program Areas (date)',
        ];

        foreach ($reasons as $reason) {
            TerminationReason::firstOrCreate(['name' => $reason]);
        }
    }
}
