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
        Schema::create('contract_meals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->cascadeOnDelete();
            $table->unsignedBigInteger('client_service_specialist_id');
            $table->foreign('client_service_specialist_id')
                ->on('users')
                ->references('id')
                ->cascadeOnDelete();
            $table->string('code');
            $table->unsignedBigInteger('program_id');
            $table->foreign('program_id')
                ->references('id')
                ->on('programs')
                ->cascadeOnDelete();
            $table->unsignedBigInteger('program_branch_id');
            $table->foreign('program_branch_id')
                ->references('id')
                ->on('program_branches')
                ->cascadeOnDelete();
            $table->unsignedBigInteger('delivery_cost_id');
            $table->foreign('delivery_cost_id')
                ->references('id')
                ->on('delivery_costs')
                ->cascadeOnDelete();
            $table->unsignedBigInteger('food_cost_id');
            $table->foreign('food_cost_id')
                ->references('id')
                ->on('food_costs')
                ->cascadeOnDelete();
            $table->unsignedBigInteger('program_delivery_cost_id');
            $table->foreign('program_delivery_cost_id')
                ->references('id')
                ->on('program_delivery_costs')
                ->cascadeOnDelete();
            $table->unsignedBigInteger('termination_reason_id')
                ->nullable();
            $table->foreign('termination_reason_id')
                ->references('id')
                ->on('termination_reasons')
                ->nullOnDelete();
            $table->boolean('is_active')
                ->default(true);
            $table->date('recertification_date')
                ->nullable();
            $table->text('notes')
                ->nullable();
            $table->unique(['client_id', 'program_branch_id', 'recertification_date'], 'unique_contract_meal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_meals');
    }
};
