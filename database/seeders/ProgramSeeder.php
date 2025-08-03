<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            1 => [
                'name' => 'HOWPA',
                'branches' => [
                    1 => 'LONG TERM',
                    2 => 'SHORT TERM',
                    3 => 'INSP'
                ]
            ],
            2 => ['name' => 'INSPECTIONS', 'branches' => [
                4 => 'HOPWA',
                5 => 'HQS'
            ]],
            3 => ['name' => 'MEALS', 'branches' => [
                6 => 'API',
                7 => 'MIAMI GARDENS',
                8 => 'PUBLIC SERVICE',
                9 => 'OTHERS'
            ]],
            4 => ['name' => 'RENTAL', 'branches' => [
                10 => 'SRAP',
                11 => 'OTHERS'
            ]],
        ];

        foreach ($programs as $id => $data) {
            DB::table('programs')->insert([
                'id' => $id,
                'name' => $data['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($data['branches'] as $branchIndex => $branchName) {
                DB::table('program_branches')->insert([
                    'id' => $branchIndex,
                    'program_id' => $id,
                    'name' => $branchName,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
