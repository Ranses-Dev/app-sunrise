<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('howpa_contracts', function (Blueprint $table) {
            $table->date('enrollment_day')
                ->default(DB::raw('CURRENT_DATE')); // cámbialo según la columna después de la cual quieras insertarla
        });
        DB::table('howpa_contracts')
            ->whereNull('enrollment_day')
            ->update(['enrollment_day' => now()->toDateString()]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('howpa_contracts', function (Blueprint $table) {
            $table->dropColumn('enrollment_day');
        });
    }
};
