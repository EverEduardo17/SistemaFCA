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
        $claves = [
            "academia-crear",
            "academia-editar",
            "academia-eliminar",

            "academico-crear",
            "academico-editar-cualquiera",
            "academico-eliminar-cualquiera",
            "academico-ver-cualquiera",
            "academico-ver-todos-cualquiera",
            "academico-editar-propio",
            "academico-eliminar-propio",
            "academico-ver-propio",
            "academico-ver-todos-propio",

            // NOTA: QUEDAN PENDIENTES LOS PERMISOS PARA LA TABLA ACADÉMICO-FECHA.

            "evento-crear",
            "evento-editar-cualquiera",
            "evento-eliminar-cualquiera",
            "evento-ver-cualquiera",
            "evento-ver-todos-cualquiera",
            "evento-editar-propio",
            "evento-eliminar-propio",
            "evento-ver-propio",
            "evento-ver-todos-propio",

            "estudiante-crear",
            "estudiante-editar-cualquiera",
            "estudiante-eliminar-cualquiera",
            "estudiante-ver-cualquiera",
            "estudiante-ver-todos-cualquiera",
            "estudiante-editar-propio",
            "estudiante-eliminar-propio",
            "estudiante-ver-propio",
            "estudiante-ver-todos-propio",

            "experienciaEducativa-crear",
            "experienciaEducativa-editar",
            "experienciaEducativa-eliminar",

            "facultad-crear",
            "facultad-editar",
            "facultad-eliminar",

            "organizador-crear",
            "organizador-editar",
            "organizador-eliminar",

            "permiso-crear",
            "permiso-editar",
            "permiso-eliminar",

            "persona-crear",
            "persona-editar-cualquiera",
            "persona-eliminar-cualquiera",
            "persona-ver-cualquiera",
            "persona-ver-todos-cualquiera",
            "persona-editar-propio",
            "persona-eliminar-propio",
            "persona-ver-propio",
            "persona-ver-todos-propio",

            "programaEducativo-crear",
            "programaEducativo-editar",
            "programaEducativo-eliminar",

            "roles-crear",
            "roles-editar",
            "roles-eliminar",

            "sedeEventos-crear",
            "sedeEventos-editar",
            "sedeEventos-eliminar",

            "tipoOrganizador-crear",
            "tipoOrganizador-editar",
            "tipoOrganizador-eliminar",

            "usuario-crear",
            "usuario-editar-cualquiera",
            "usuario-eliminar-cualquiera",
            "usuario-ver-cualquiera",
            "usuario-ver-todos-cualquiera",
            "usuario-editar-propio",
            "usuario-eliminar-propio",
            "usuario-ver-propio",
            "usuario-ver-todos-propio",
        ];

        $descripciones = [
            "Permiso para crear una academia.",
            "Permiso para editar una academia.",
            "Permiso para eliminar una academia.",

            "Permiso para crear un académico.",
            "Permiso para editar un académico creado por cualquier persona.",
            "Permiso para eliminar un académico creado por cualquier persona.",
            "Permiso para poder ver un académico creado por cualquier persona.",
            "Permiso para poder ver todos los académicos creados por cualquier persona.",
            "Permiso para editar un académico creado por mi usuario.",
            "Permiso para eliminar un académico creado por mi usuario.",
            "Permiso para poder ver un académico creado por mi usuario.",
            "Permiso para poder ver todos los académicos creados por mi usuario.",

            //!!200127-1501 NOTA: QUEDAN PENDIENTES LOS PERMISOS PARA LA TABLA ACADÉMICO-FECHA.

            "Permiso para crear un evento.",
            "Permiso para editar un evento creado por cualquier persona.",
            "Permiso para eliminar un evento creado por cualquier persona.",
            "Permiso para poder ver un evento creado por cualquier persona.",
            "Permiso para poder ver todos los eventos creados por cualquier persona.",
            "Permiso para editar un evento creado por mi usuario.",
            "Permiso para eliminar un evento creado por mi usuario.",
            "Permiso para poder ver un evento creado por mi usuario.",
            "Permiso para poder ver todos los eventos creados por mi usuario.",

            "Permiso para crear un estudiante.",
            "Permiso para editar un estudiante creado por cualquier persona.",
            "Permiso para eliminar un estudiante creado por cualquier persona.",
            "Permiso para poder ver un estudiante creado por cualquier persona.",
            "Permiso para poder ver todos los estudiantes creados por cualquier persona.",
            "Permiso para editar un estudiante creado por mi usuario.",
            "Permiso para eliminar un estudiante creado por mi usuario.",
            "Permiso para poder ver un estudiante creado por mi usuario.",
            "Permiso para poder ver todos los estudiantes creados por mi usuario.",

            "Permiso para crear una experiencia educativa.",
            "Permiso para editar una experiencia educativa.",
            "Permiso para eliminar una experiencia educativa.",

            "Permiso para crear una facultad.",
            "Permiso para editar una facultad.",
            "Permiso para eliminar una facultad.",

            "Permiso para crear un organizador.",
            "Permiso para editar un organizador.",
            "Permiso para eliminar un organizador.",

            "Permiso para crear un permiso.",
            "Permiso para editar un permiso.",
            "Permiso para eliminar un permiso.",

            "Permiso para crear datos personales",
            "Permiso para editar los datos personales creado por cualquier persona.",
            "Permiso para eliminar los datos personales creado por cualquier persona.",
            "Permiso para poder ver los datos personales creado por cualquier persona.",
            "Permiso para poder ver todos los datos personales creados por cualquier persona.",
            "Permiso para editar los datos personales de mi usuario.",
            "Permiso para eliminar los datos personales de mi usuario.",
            "Permiso para poder ver los datos personales de mi usuario.",
            "Permiso para poder ver todos los datos académicos creados por mi usuario.",

            "Permiso para crear un programa educativo.",
            "Permiso para editar un programa educativo.",
            "Permiso para eliminar un programa educativo.",

            "Permiso para crear roles.",
            "Permiso para editar roles.",
            "Permiso para eliminar roles.",

            "Permiso para crear una sede.",
            "Permiso para editar una sede.",
            "Permiso para eliminar una sede.",

            "Permiso para crear un tipo de Organizador.",
            "Permiso para editar un tipo de Organizador.",
            "Permiso para eliminar un tipo de Organizador.",


            "Permiso para crear usuarios",
            "Permiso para editar los usuarios creado por cualquier persona.",
            "Permiso para eliminar los usuarios creado por cualquier persona.",
            "Permiso para poder ver los usuarios creado por cualquier persona.",
            "Permiso para poder ver todos los usuarios creados por cualquier persona.",
            "Permiso para editar los usuarios de mi usuario.",
            "Permiso para eliminar los usuarios de mi usuario.",
            "Permiso para poder ver los usuarios de mi usuario.",
            "Permiso para poder ver todos los usuarios creados por mi usuario.",
        ];

        $registros = [];
        for($i=0; $i<count($claves); $i++){
            $registros[] = [
                'ClavePermiso'         => $claves[$i],
                'DescripcionPermiso'    => $descripciones[$i],
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ];
        }

        DB::table('Permiso')->insert($registros);
    }
}
