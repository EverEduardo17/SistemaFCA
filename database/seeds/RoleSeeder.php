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
 
        $roles = [
            [
                "ClaveRole" => "CONTROL-GÉNERAL",
                "DescripcionRole" => "Encargado de supervisar y controlar aspectos generales del sistema.",
            ],
            [
                "ClaveRole" => "ACÁDEMICO",
                "DescripcionRole" => "Se ocupa de cuestiones académicas y educativas.",
            ],
            [
                "ClaveRole" => "ESTUDIANTE",
                "DescripcionRole" => "Representa a los estudiantes matriculados.",
            ],
            [
                "ClaveRole" => "EGRESADO",
                "DescripcionRole" => "Representa a aquellos estudiantes que han completado sus estudios.",
            ],
            [
                "ClaveRole" => "DIRECCIÓN",
                "DescripcionRole" => "Responsable de la dirección estratégica y toma de decisiones.",
            ],
            [
                "ClaveRole" => "SECRETARIA-ACADÉMICA",
                "DescripcionRole" => "Encargada de tareas administrativas y de oficina.",
            ],
            [
                "ClaveRole" => "CONTROL-ACADÉMICOS",
                "DescripcionRole" => "Supervisa y gestiona asuntos académicos específicos.",
            ],
            [
                "ClaveRole" => "CONTROL-CONSTANCIAS",
                "DescripcionRole" => "Gestiona la emisión de constancias y certificaciones.",
            ],
            [
                "ClaveRole" => "CONTROL-ESTUDIANTES",
                "DescripcionRole" => "Supervisa la información y actividades relacionadas con los estudiantes.",
            ],
            [
                "ClaveRole" => "CONTROL-EVENTOS",
                "DescripcionRole" => "Maneja la planificación y ejecución de eventos.",
            ],
            [
                "ClaveRole" => "CONTROL-SEDES",
                "DescripcionRole" => "Maneja la información y funciones específicas de las sedes o campus.",
            ],
            [
                "ClaveRole" => "CONTROL-ROLES",
                "DescripcionRole" => "Crear roles nuevos y asignarle permisos a esos roles",
            ],
        ];


        DB::table('Role')->insert($roles);
    }
}
