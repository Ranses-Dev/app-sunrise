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
        Schema::create('healthcare_provider_healthcare_provider_plan', function (Blueprint $table) {
            $table->unsignedBigInteger('healthcare_provider_id');
            $table->unsignedBigInteger('healthcare_provider_plan_id');
            $table->foreign('healthcare_provider_id', 'fk_provider_plan_provider')
                ->references('id')
                ->on('healthcare_providers')
                ->cascadeOnDelete();
            $table->foreign('healthcare_provider_plan_id', 'fk_provider_plan_plan')
                ->references('id')
                ->on('healthcare_provider_plans')
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('healthcare_provider_healthcare_provider_plan');
    }
};
