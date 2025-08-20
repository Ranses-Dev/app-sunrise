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
        Schema::create('howpa_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            $table->foreignId('city_id')->constrained('cities')->cascadeOnDelete();
            $table->foreignId('phone_number_id')->nullable()->constrained('client_phone_numbers')->nullOnDelete();
            $table->foreignId('program_branch_id')->constrained('program_branches')->cascadeOnDelete();
            $table->date('date');
            $table->date('re_certification_date');
            $table->foreignId('client_service_specialist_id')
                ->constrained('users')
                ->references('id')
                ->cascadeOnDelete();
            $table->integer('number_bedrooms_req')->nullable();
            $table->integer('number_bedrooms_approved')->nullable();
            $table->string('recent_living_situation');
            $table->string('recent_living_situation_notes')->nullable();
            $table->boolean('owns_real_estate')->default(false);
            $table->boolean('own_any_stock_or_bonds')->default(false);
            $table->boolean('has_savings')->default(false);
            $table->decimal('savings_balance', 10, 2)->nullable()->default(0);
            $table->boolean('has_checking_account')->default(false);
            $table->decimal('checking_avg_balance_six_months', 10, 2)->nullable()->default(0);
            $table->text('assets_notes')->nullable();
            $table->boolean('outside_support')->default(false);
            $table->text('outside_support_explanation')->nullable();
            $table->boolean('committed_fraud_or_asked_to_repay')->default(false);
            $table->text('fraud_explanation')->nullable();
            $table->boolean('has_aids')->default(false);
            $table->boolean('howpa_prior_to_2023')->default(false);
            $table->boolean('currently_receiving_other_aid')->default(false);
            $table->boolean('agreed_statements')->default(false);
            $table->foreignId('emergency_contact_one_id')->nullable()->constrained('emergency_contacts')->nullOnDelete();
            $table->foreignId('emergency_contact_two_id')->nullable()->constrained('emergency_contacts')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('howpa_contracts');
    }
};
