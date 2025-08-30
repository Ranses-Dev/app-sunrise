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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('delivery_line_1');
            $table->string('last_line')->nullable();
            $table->string('street_name')->nullable();
            $table->string('city')->nullable();
            $table->string('state_abbreviation');
            $table->string('postal_code');
            $table->string('county_name');
            $table->unique(['delivery_line_1', 'last_line', 'street_name', 'city', 'state_abbreviation', 'postal_code', 'county_name'], 'address_unique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
