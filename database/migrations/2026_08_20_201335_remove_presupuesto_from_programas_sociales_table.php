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
    Schema::table('programas_sociales', function (Blueprint $table) {
        if (Schema::hasColumn('programas_sociales', 'presupuesto')) {
            $table->dropColumn('presupuesto');
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programas_sociales', function (Blueprint $table) {
            $table->decimal('presupuesto', 12, 2)->nullable();
        });
    }
};