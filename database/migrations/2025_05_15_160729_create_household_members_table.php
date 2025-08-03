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
        Schema::create('household_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->date('dob');
            $table->string('ssn');
            $table->string('ssn_hash')->nullable()->index();
            $table->unsignedBigInteger('gender_id');
            $table->unsignedBigInteger('household_relation_type_id');
            $table->unsignedBigInteger('ethnicity_id');
            $table->decimal('income', 10, 2)->default(0);
            $table->foreign('client_id')->references('id')->on('clients')->cascadeOnDelete();
            $table->foreign('gender_id')->references('id')->on('genders')->cascadeOnDelete();
            $table->foreign('household_relation_type_id')->references('id')->on('household_relation_types')->cascadeOnDelete();
            $table->foreign('ethnicity_id')->references('id')->on('ethnicities')->cascadeOnDelete();
            $table->boolean('hiv_aids_status')->default(false);
            $table->boolean('hispanic')->default(false);
            $table->unique(['client_id', 'ssn']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('household_members');
    }
};
