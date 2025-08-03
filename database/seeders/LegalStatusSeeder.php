<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LegalStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('legal_statuses')->insert([
            ['name' => 'Citizen'],
            ['name' => 'Permanent Resident'],
            ['name' => 'Work Permit'],
        ]);
    }
}
