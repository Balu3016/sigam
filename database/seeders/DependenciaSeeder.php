<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dependencia;

class DependenciaSeeder extends Seeder
{
    public function run(): void
    {
        $dependencias = [
            ['nombre' => 'Dirección de Desarrollo Social', 'siglas' => 'DDS', 'activo' => true],
            ['nombre' => 'Sistema Municipal DIF', 'siglas' => 'DIF', 'activo' => true],
            ['nombre' => 'Dirección de Seguridad Pública y Tránsito', 'siglas' => 'DSPT', 'activo' => true],
            ['nombre' => 'Dirección de Educación y Cultura', 'siglas' => 'DEC', 'activo' => true],
        ];

        foreach ($dependencias as $dep) {
            Dependencia::firstOrCreate(['nombre' => $dep['nombre']], $dep);
        }
    }
}