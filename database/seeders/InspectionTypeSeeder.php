<?php

namespace Database\Seeders;

use App\Models\InspectionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InspectionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inspectionTypes = [
            ['name' => 'INITIAL', 'description' => 'Initial inspection of the property'],
            ['name' => 'ANNUAL', 'description' => 'Annual inspection to ensure compliance'],
            ['name' => 'QUALITY', 'description' => 'Quality inspection'],
            ['name' => 'ABATEMENT', 'description' => 'Abatement inspection'],
            ['name' => 'EMERGENCY', 'description' => 'Emergency inspection'],
            ['name' => 'SPECIAL', 'description' => 'Special inspection'],
            ['name' => 'AFFORDABILITY', 'description' => 'Affordability inspection'],
            ['name' => 'RE-INSPECTION', 'description' => 'Re-inspection after initial findings'],
            ['name' => 'MOVED OUT', 'description' => 'Inspection after move out'],
            ['name' => 'COMPLIANCE', 'description' => 'Compliance inspection'],
            ['name' => 'COMPLAINT', 'description' => 'Complaint inspection'],
            ['name' => 'OTHER', 'description' => 'Other type of inspection'],
        ];


        foreach ($inspectionTypes as $type) {
            InspectionType::firstOrCreate($type);
        }
    }
}
