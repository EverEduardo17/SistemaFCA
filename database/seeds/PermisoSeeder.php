<?php

use Illuminate\Database\Seeder;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $permisos = [
            [
                "ClavePermiso" => "academicos-listar", 
                "DescripcionPermiso" => "Listar academicos"
            ],
            [
                "ClavePermiso" => "academicos-crear", 
                "DescripcionPermiso" => "El academico puede crear dependiendo el modulo en el que se encuentre"
            ],
            [
                "ClavePermiso" => "academicos-detalles", 
                "DescripcionPermiso" => "Se puede ver los detalles de lo que se seleccione"
            ],
            [
                "ClavePermiso" => "academicos-eliminar", 
                "DescripcionPermiso" => "El academico puede eliminar"
            ],


            [
                "ClavePermiso" => "constancias-listar", 
                "DescripcionPermiso" => "Listar constancias"
            ],
            [
                "ClavePermiso" => "constancias-crear", 
                "DescripcionPermiso" => "Crear constancias"
            ],
            [
                "ClavePermiso" => "constancias-detalles", 
                "DescripcionPermiso" => "Ver informacion de las constancias"
            ],
            [
                "ClavePermiso" => "constancias-editar-propio", 
                "DescripcionPermiso" => "Editar las constancias que creaste constancias"
            ],
            [
                "ClavePermiso" => "constancias-eliminar-propio", 
                "DescripcionPermiso" => "Eliminar las constancias que creaste constancias"
            ],
            [
                "ClavePermiso" => "constancias-editar-cualquiera", 
                "DescripcionPermiso" => "Editar cualquier constancia sin importar el creador"
            ],
            [
                "ClavePermiso" => "constancias-eliminar-cualquiera", 
                "DescripcionPermiso" => "Eliminar cualquier constancia sin importar el creador"
            ],
            [
                "ClavePermiso" => "constancias-aprobar-rechazar", 
                "DescripcionPermiso" => "Poder aprobar o rechazar constancias"
            ],


            [
                "ClavePermiso" => "eventos-listar", 
                "DescripcionPermiso" => "Listar eventos"
            ],
            [
                "ClavePermiso" => "eventos-crear", 
                "DescripcionPermiso" => "Crear un evento"
            ],
            [
                "ClavePermiso" => "eventos-detalles", 
                "DescripcionPermiso" => "Ver los detalles del evento"
            ],
            [
                "ClavePermiso" => "eventos-registrar-participantes", 
                "DescripcionPermiso" => "Se pueden registrar los participantes del evento"
            ],
            [
                "ClavePermiso" => "eventos-editar-propio", 
                "DescripcionPermiso" => "Se pueden editar los eventos propios del usuario"
            ],
            [
                "ClavePermiso" => "eventos-eliminar-propio", 
                "DescripcionPermiso" => "Se pueden eliminar los eventos propios del usuario"
            ],
            [
                "ClavePermiso" => "eventos-vincular-constancias", 
                "DescripcionPermiso" => "Se vinculan constancias a eventos que no sean propio del usuario"
            ],
            [
                "ClavePermiso" => "eventos-vincular-constancias-propias", 
                "DescripcionPermiso" => "Se vinculan constancias a eventos que son propio del usuario"
            ],
            [
                "ClavePermiso" => "eventos-ver-participantes", 
                "DescripcionPermiso" => "El usuario puede ver los participantes"
            ],
            [
                "ClavePermiso" => "eventos-editar-cualquiera", 
                "DescripcionPermiso" => "Se pueden editar cualquiera de los eventos que se encuentren"
            ],
            [
                "ClavePermiso" => "eventos-eliminar-cualquiera", 
                "DescripcionPermiso" => "Se pueden eliminar cualquiera de los eventos que se encuentren"
            ],
            [
                "ClavePermiso" => "eventos-aprobar-rechazar", 
                "DescripcionPermiso" => "Se pueden aprobar o rechazar los eventos"
            ],


            [
                "ClavePermiso" => "estudiantes-listar", 
                "DescripcionPermiso" => "Listar estudiantes"
            ],
            [
                "ClavePermiso" => "estudiantes-crear", 
                "DescripcionPermiso" => "Crear estudiante"
            ],
            [
                "ClavePermiso" => "estudiantes-detalles", 
                "DescripcionPermiso" => "Detalles estudiante"
            ],
            [
                "ClavePermiso" => "estudiantes-eliminar", 
                "DescripcionPermiso" => "Eliminar estudiante"
            ],


            [
                "ClavePermiso" => "roles-listar", 
                "DescripcionPermiso" => "Rol listar"
            ],
            [
                "ClavePermiso" => "roles-crear", 
                "DescripcionPermiso" => "Rol crear"
            ],
            [
                "ClavePermiso" => "roles-eliminar", 
                "DescripcionPermiso" => "Rol eliminar"
            ],


            [
                "ClavePermiso" => "sedes-listar", 
                "DescripcionPermiso" => "Listar sedes"
            ],
            [
                "ClavePermiso" => "sedes-crear", 
                "DescripcionPermiso" => "Crear sedes"
            ],
            [
                "ClavePermiso" => "sedes-detalles", 
                "DescripcionPermiso" => "Ver detalles de los sedes"
            ],
            [
                "ClavePermiso" => "sedes-editar", 
                "DescripcionPermiso" => "Editar sedes"
            ],
            [
                "ClavePermiso" => "sedes-eliminar", 
                "DescripcionPermiso" => "Eliminar sedes"
            ],
        ];

        DB::table('Permiso')->insert($permisos);
    }
}
