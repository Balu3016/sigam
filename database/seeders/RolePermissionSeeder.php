<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // =====================================
        // CREACIÓN DE PERMISOS DEL SISTEMA
        // =====================================

        $permissions = [

            // Usuarios
            'usuarios.ver',
            'usuarios.crear',
            'usuarios.editar',
            'usuarios.eliminar',

            // Ciudadanos
            'ciudadanos.ver',
            'ciudadanos.crear',
            'ciudadanos.editar',
            'ciudadanos.eliminar',

            // Dependencias
            'dependencias.ver',
            'dependencias.crear',
            'dependencias.editar',
            'dependencias.eliminar',

            // Programas
            'programas.ver',
            'programas.crear',
            'programas.editar',
            'programas.eliminar',

            // Solicitudes
            'solicitudes.ver',
            'solicitudes.crear',
            'solicitudes.aprobar',
            'solicitudes.rechazar',

            // Entregas
            'entregas.ver',
            'entregas.crear',
            'entregas.editar',
            'entregas.cancelar',

            // Reportes
            'reportes.ver',
            'reportes.exportar',

            // Configuración
            'configuracion.ver',
            'configuracion.editar',

        ];


        foreach ($permissions as $permission) {

            Permission::firstOrCreate([
                'name' => $permission,
            ]);

        }


        // =====================================
        // CREACIÓN DE ROLES
        // =====================================

        $roles = [

            'Administrador',

            'Presidencia',

            'Bienestar',

            'DIF',

            'Auditor',

            'Consulta',

        ];


        foreach ($roles as $role) {

            Role::firstOrCreate([
                'name' => $role,
            ]);

        }


        // =====================================
        // ASIGNACIÓN DE PERMISOS
        // =====================================

        $admin = Role::where('name','Administrador')->first();

        $admin->givePermissionTo(
            Permission::all()
        );


        $auditor = Role::where('name','Auditor')->first();

        $auditor->givePermissionTo([
            'ciudadanos.ver',
            'dependencias.ver',
            'programas.ver',
            'solicitudes.ver',
            'entregas.ver',
            'reportes.ver',
            'reportes.exportar',
        ]);


        $consulta = Role::where('name','Consulta')->first();

        $consulta->givePermissionTo([
            'ciudadanos.ver',
            'programas.ver',
            'solicitudes.ver',
            'entregas.ver',
            'reportes.ver',
        ]);

    }
}
