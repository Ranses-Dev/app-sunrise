<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('dob');
            $table->string('ssn');
            $table->string('ssn_hash')->nullable()->index();
            $table->string('howpa_ssn')->nullable();
            $table->string('howpa_ssn_hash')->nullable();
            $table->string('client_number')->unique();
            $table->string('howpa_client_number')->nullable()->unique();
            $table->string('meal_client_number')->nullable()->unique();
            $table->date('effective_date')->nullable();
            $table->unsignedBigInteger('legal_status_id');
            $table->unsignedBigInteger('identification_type_id');
            $table->string('identification_number')->unique();
            $table->date('identification_expiration_date')->nullable();
            $table->string('identification_picture');
            $table->foreignId('address_id')->constrained('addresses')->cascadeOnDelete();
            $table->unsignedBigInteger('city_district_id')->nullable();
            $table->unsignedBigInteger('county_district_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->string('email')->unique()->nullable();
            $table->decimal('income', 10, 2)->default(0);
            $table->unsignedBigInteger('gender_id');
            $table->boolean('is_deceased')->default(false);
            $table->unsignedBigInteger('ethnicity_id');
            $table->unsignedBigInteger('healthcare_provider_id');
            $table->unsignedBigInteger('healthcare_provider_plan_id')->nullable();
            $table->decimal('monthly_client_payment_portion', 10, 2)->default(0);
            $table->foreign('county_district_id')->references('id')->on('county_districts')->nullOnDelete();
            $table->foreign('city_district_id')->references('id')->on('city_districts')->nullOnDelete();
            $table->foreign('city_id')->references('id')->on('cities')->nullOnDelete();
            $table->foreign('healthcare_provider_id')->references('id')->on('healthcare_providers')->cascadeOnDelete();
            $table->foreign('healthcare_provider_plan_id')->references('id')->on('healthcare_provider_plans')->nullOnDelete();
            $table->foreign('ethnicity_id')->references('id')->on('ethnicities')->cascadeOnDelete();
            $table->foreign('gender_id')->references('id')->on('genders')->cascadeOnDelete();
            $table->foreign('identification_type_id')->references('id')->on('identification_types')->cascadeOnDelete();
            $table->foreign('legal_status_id')->references('id')->on('legal_statuses')->cascadeOnDelete();
            $table->foreignId('housing_status_id')->nullable()->constrained('housing_statuses')->nullOnDelete();
            $table->unique(['identification_type_id', 'identification_number']);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
