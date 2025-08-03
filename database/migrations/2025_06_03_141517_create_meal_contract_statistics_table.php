<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('meal_contract_statistics', function (Blueprint $table) {
            $table->id();
            $table->date('date')->comment('The date of this daily record');
            // Daily totals
            $table->decimal('delivery_cost', 10, 2)->default(0);
            $table->decimal('food_cost', 10, 2)->default(0);
            $table->decimal('program_delivery_cost', 10, 2)->default(0);
            // Weekly accumulated (up to that day)
            $table->decimal('weekly_delivery_cost', 10, 2)->default(0);
            $table->decimal('weekly_food_cost', 10, 2)->default(0);
            $table->decimal('weekly_program_delivery_cost', 10, 2)->default(0);
            // Monthly accumulated (up to that day)
            $table->decimal('monthly_delivery_cost', 10, 2)->default(0);
            $table->decimal('monthly_food_cost', 10, 2)->default(0);
            $table->decimal('monthly_program_delivery_cost', 10, 2)->default(0);
            // Yearly accumulated (up to that day)
            $table->decimal('yearly_delivery_cost', 10, 2)->default(0);
            $table->decimal('yearly_food_cost', 10, 2)->default(0);
            $table->decimal('yearly_program_delivery_cost', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_contract_statistics');
    }
};
