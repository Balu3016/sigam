<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entregas', function (Blueprint $table) {
            $table->id();
            
            // Relaciones
            $table->foreignId('beneficiario_id')->constrained('beneficiarios')->onDelete('cascade');
            $table->foreignId('programa_social_id')->constrained('programas_sociales')->onDelete('cascade');
            $table->foreignId('localidad_id')->nullable()->constrained('localidades')->onDelete('set null'); // Captura rápida de georeferenciación
            
            // Detalle de la Entrega
            $table->date('fecha_entrega');
            $table->integer('cantidad')->default(1);
            $table->string('folio_acta', 50)->nullable()->comment('Número de folio o recibo firmado');
            $table->enum('estatus', ['entregado', 'pendiente', 'cancelado'])->default('entregado');
            $table->text('observaciones')->nullable();

            // Auditoría de usuario que registró la entrega
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entregas');
    }
};