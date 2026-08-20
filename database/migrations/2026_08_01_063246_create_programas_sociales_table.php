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
        Schema::create('programas_sociales', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20)->unique()->comment('Clave institucional del programa');
            $table->string('nombre', 150)->comment('Nombre del programa social');
            $table->text('descripcion')->nullable()->comment('Objetivo y descripción breve');
            $table->enum('categoria', [
                'alimentario', 
                'economico', 
                'educativo', 
                'salud', 
                'vivienda', 
                'infraestructura'
            ])->comment('Categoría del programa');
            $table->decimal('presupuesto_anual', 12, 2)->nullable()->comment('Monto total presupuestado');
            $table->enum('tipo_apoyo', ['monetario', 'especie', 'servicio'])->comment('Modalidad del beneficio');
            $table->enum('periodicidad', ['unico', 'mensual', 'bimensual', 'trimestral', 'anual'])->comment('Frecuencia del apoyo');
            $table->json('requisitos')->nullable()->comment('Lista de requisitos documentales en JSON');
            $table->boolean('activo')->default(true)->comment('Borrado lógico SIGAM');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programas_sociales');
    }
};