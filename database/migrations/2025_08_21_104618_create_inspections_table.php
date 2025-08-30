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
        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_branch_id')->constrained('program_branches')->cascadeOnDelete();
            $table->foreignId('address_id')->constrained('addresses')->cascadeOnDelete();
            $table->date('inspection_requested_date')->nullable();
            $table->boolean('inspection_requested_incomplete')->default(false);
            $table->text('inspection_requested_incomplete_notes')->nullable();
            $table->boolean('inspection_requested_not_scheduled')->default(false);
            $table->text('inspection_requested_not_scheduled_notes')->nullable();
            $table->date('inspection_requested_scheduled_date')->nullable();
            $table->string('landlord_name')->nullable();
            $table->string('landlord_contact_information')->nullable();
            $table->foreignId('landlord_address_id')->nullable()->constrained('addresses')->nullOnDelete();
            $table->foreignId('landlord_howpa_id')->nullable()->constrained('clients')->nullOnDelete();
            $table->string('tenant_name')->nullable();
            $table->foreignId('tenant_howpa_id')->nullable()->constrained('clients')->nullOnDelete();
            $table->string('tenant_contact_information')->nullable();
            $table->foreignId('tenant_address_id')->nullable()->constrained('addresses')->nullOnDelete();
            $table->foreignId('housing_type_id')->constrained('housing_types')->cascadeOnDelete();
            $table->integer('number_of_bedrooms');
            $table->foreignId('housing_inspector_id')->constrained('users')->cascadeOnDelete();
            $table->string('inspection_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
