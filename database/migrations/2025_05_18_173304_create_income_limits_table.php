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
        Schema::create('income_limits', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('percentage_category');
            $table->unsignedTinyInteger('household_size')->default(1);
            $table->decimal('income_limit', 10, 2)->default(0);
            $table->unique(['household_size','income_limit']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('income_limits');
    }
};
