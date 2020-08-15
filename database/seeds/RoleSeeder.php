<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $claves = [
            "ADMINISTRADOR",
            "CONTROL-GENERAL",
            "CONTROL-EVENTOS",
            "ACADEMICO",
            "ESTUDIANTE"
        ];

        $descripciones = [
            "Rol de Administrador dentro del Sistema.",
            "Rol que permite el Control General dentro del Sistema.",
            "Rol que permite el Control de Eventos dentro del Sistema.",
            "Rol de Académico dentro del sistema.",
            "Rol de Estudiante dentro del sistema."
        ];

        $registros = [];
        for($i=0; $i<count($claves); $i++){
            $registros[] = [
                'ClaveRole'         => $claves[$i],
                'DescripcionRole'    => $descripciones[$i],
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ];
        }

        DB::table('Role')->insert($registros);
    }
}
