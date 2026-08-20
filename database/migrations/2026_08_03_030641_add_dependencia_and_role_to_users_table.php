<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('dependencia_id')
                  ->nullable()
                  ->after('email')
                  ->constrained('dependencias')
                  ->nullOnDelete();

            $table->enum('role', ['admin', 'supervisor', 'capturista'])
                  ->default('capturista')
                  ->after('dependencia_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
    $table->foreignId('dependencia_id')->nullable()->constrained('dependencias');
    $table->string('role')->default('capturista');
});
    }
};