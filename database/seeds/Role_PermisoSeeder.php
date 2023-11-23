<?php

use Illuminate\Database\Seeder;

class Role_PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $permisosAcademicos = [
            // constancias
            5, 6, 7, 8, 9,
            // eventos
            13, 14, 15, 16, 17, 18, 20, 21,
            // academicos
            1, 3,
            // estudiantes
            25, 27,
            // sedes
            32, 34
        ];
        
        // y egresados
        $permisosEstudiantes = [
            // eventos
            13, 15
        ];

        $permisosDireccion = [
            // constancias
            12,
            // eventos
            24,
            // roles
            29, 30, 31,
        ];

        $permisosSecretariaAcad = [
            // constancias
            12, 
            // eventos
            24
        ];

        $permisosControlEventos = [
            13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24
        ];

        $permisosControlAcademicos = [
            1, 2, 3, 4
        ];

        $permisosControlRoles = [
            29, 30, 31
        ];

        $permisosControlSedes = [
            32, 33, 34, 35, 36
        ];

        $permisosControlConstancias = [
            5, 6, 7, 8, 9, 10, 11, 12
        ];

        $permisosControlEstudiantes = [
            25, 26, 27, 28
        ];


        $registros = [];
        
        // Permisos Académicos
        foreach ($permisosAcademicos as $permiso) {
            $registros[] = [
                'IdRole'    => 2,       // id del rol Académico
                'IdPermiso' => $permiso,
            ];
        }

        // Permisos Estudiantes
        foreach ($permisosEstudiantes as $permiso) {
            $registros[] = [
                'IdRole'    => 3,       // id del rol Estudiantes
                'IdPermiso' => $permiso,
            ];
        }

        // Permisos Egresado
        foreach ($permisosEstudiantes as $permiso) {
            $registros[] = [
                'IdRole'    => 4,      // id del rol Egresado
                'IdPermiso' => $permiso,
            ];
        }

        // Permisos Dirección
        foreach ($permisosDireccion as $permiso) {
            $registros[] = [
                'IdRole'    => 5,       // id del rol Dirección
                'IdPermiso' => $permiso,
            ];
        }

        // Permisos Secretaria Académica
        foreach ($permisosSecretariaAcad as $permiso) {
            $registros[] = [
                'IdRole'    => 6,       // id del rol Secretaria Académica
                'IdPermiso' => $permiso,
            ];
        }

        // Permisos Control Académicos
        foreach ($permisosControlAcademicos as $permiso) {
            $registros[] = [
                'IdRole'    => 7,       // id del rol Control Académicos
                'IdPermiso' => $permiso,
            ];
        }

        // Permisos Control de Constancias
        foreach ($permisosControlConstancias as $permiso) {
            $registros[] = [
                'IdRole'    => 8,      // id del rol Control de Constancias
                'IdPermiso' => $permiso,
            ];
        }

        // Permisos Control de Estudiantes
        foreach ($permisosControlEstudiantes as $permiso) {
            $registros[] = [
                'IdRole'    => 9,      // id del rol Control de Estudiantes
                'IdPermiso' => $permiso,
            ];
        }

        // Permisos Control de Eventos
        foreach ($permisosControlEventos as $permiso) {
            $registros[] = [
                'IdRole'    => 10,       // id del rol Control de Eventos
                'IdPermiso' => $permiso,
            ];
        }

        // Permisos Control de Sedes
        foreach ($permisosControlSedes as $permiso) {
            $registros[] = [
                'IdRole'    => 11,       // id del rol Control de Sedes
                'IdPermiso' => $permiso,
            ];
        }

        // Permisos Control de Roles
        foreach ($permisosControlRoles as $permiso) {
            $registros[] = [
                'IdRole'    => 12,       // id del rol Control de Roles
                'IdPermiso' => $permiso,
            ];
        }


        // insertar todos los permisso a el rol control-general
        for($i=1; $i<37; $i++) {
            $registros[] = [
                'IdRole'    => 1,
                'IdPermiso' => $i,
            ];
        }

        DB::table('Role_Permiso')->insert($registros);
    }
}
