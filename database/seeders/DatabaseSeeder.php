<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            EthnicitySeeder::class,
            GenderSeeder::class,
            HealthcareProviderSeeder::class,
            HealthcareProviderPlanSeeder::class,
            IdentificationTypeSeeder::class,
            LegalStatusSeeder::class,
            MonthlyAssistancePaymentSeeder::class,
            ProgramSeeder::class,
            CityDistrictSeeder::class,
            CountyDistrictSeeder::class,
            CitySeeder::class,
            IncomeLimitSeeder::class,
            AttachmentTypeSeeder::class,
            HouseholdRelationTypeSeeder::class,
            TerminationReasonSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            MealContractTypeSeeder::class,
            DeliveryCostSeeder::class,
            FoodCostSeeder::class,
            ProgramDeliveryCostSeeder::class
        ]);
        $usersData = [
            [
                'name' => 'admin',
                'email' => 'abel.monzon@911dc.us',
            ],
            [
                'name' => 'ranses',
                'email' => 'ransessanchez1506@gmail.com',
            ],
            [
                'name' => 'test',
                'email' => 'test@example.com',
            ]
        ];
        foreach ($usersData as $userData) {
            $user = User::factory()->create($userData);
            $user->assignRole('Admin');
        }
    }
}
