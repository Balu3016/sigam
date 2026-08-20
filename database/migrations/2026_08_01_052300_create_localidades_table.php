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
        Schema::create('localidades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->enum('tipo', [
                'cabecera',
                'barrio',
                'delegacion',
                'colonia',
                'ejido',
                'rancheria'
            ]);
            $table->string('codigo_postal', 5)->nullable();
            $table->enum('clasificacion_zonal', [
                'urbana',
                'semiurbana',
                'rural'
            ]);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('localidades');
    }
};