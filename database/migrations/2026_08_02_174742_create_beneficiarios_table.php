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
        Schema::create('beneficiarios', function (Blueprint $table) {
            $table->id();
            $table->string('curp', 18)->unique()->comment('Llave única del ciudadano para control interdependencias');
            $table->string('nombre', 100)->comment('Nombre(s) del beneficiario');
            $table->string('primer_apellido', 100)->comment('Primer apellido / Paterno');
            $table->string('segundo_apellido', 100)->nullable()->comment('Segundo apellido / Materno');
            $table->enum('genero', ['M', 'F', 'Otro'])->comment('Género del ciudadano');
            $table->date('fecha_nacimiento')->nullable()->comment('Fecha de nacimiento');
            $table->string('telefono', 15)->nullable()->comment('Teléfono de contacto');
            $table->string('email', 150)->nullable()->comment('Correo electrónico opcional');
            $table->text('direccion')->nullable()->comment('Calle y número exterior/interior');
            
            // Relación con el Catálogo Territorial de Localidades
            $table->foreignId('localidad_id')
                  ->constrained('localidades')
                  ->onDelete('cascade')
                  ->comment('Localidad o delegación de residencia');

            $table->enum('estatus_socioeconomico', [
                'vulnerable', 
                'pobreza_moderada', 
                'pobreza_extrema', 
                'general'
            ])->default('vulnerable')->comment('Priorización socioeconómica');

            $table->boolean('activo')->default(true)->comment('Borrado lógico SIGAM');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiarios');
    }
};