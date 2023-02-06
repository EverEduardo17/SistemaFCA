<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModalidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Modalidad')->insert([
            [
                'NombreModalidad'       => 'Primera Lista',
                'DescripcionModalidad'  => 'Ingreso por examen aprobado en primera lista.',
                'TipoModalidad'         => 'Entrada',
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ],
            [
                'NombreModalidad'         => 'Corrimiento',
                'DescripcionModalidad' => 'Ingreso por disponibilidad de lugares de ingreso.',
                'TipoModalidad'         => 'Entrada',
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ],
            [
                'NombreModalidad'         => 'Equivalencia',
                'DescripcionModalidad' => 'Ingreso por equivalencia proveniente de otro Programa Educativo.',
                'TipoModalidad'         => 'Entrada',
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ],
            [
                'NombreModalidad'         => 'Traslado',
                'DescripcionModalidad' => 'Ingreso por cambio proveniente de otra facultad.',
                'TipoModalidad'         => 'Entrada',
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ],
            
            [
                'NombreModalidad'         => 'Vacante',
                'DescripcionModalidad' => 'Ingreso por lugares disponibles.',
                'TipoModalidad'         => 'Entrada',
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ],
            [
                'NombreModalidad'         => 'Tesis',
                'DescripcionModalidad' => 'Titulación por modalidad de tesis',
                'TipoModalidad'         => 'Titulación',
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ],
            [
                'NombreModalidad'         => 'Tesina',
                'DescripcionModalidad' => 'Titulación por modalidad de tesina',
                'TipoModalidad'         => 'Titulación',
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ],
            [
                'NombreModalidad'         => 'Monografía',
                'DescripcionModalidad' => 'Titulación por modalidad de monografía',
                'TipoModalidad'         => 'Titulación',
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ],
            [
                'NombreModalidad'         => 'Examen CENEVAL',
                'DescripcionModalidad' => 'Titulación por modalidad de examen CENEVAL',
                'TipoModalidad'         => 'Titulación',
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ],
            [
                'NombreModalidad'         => 'Promedio',
                'DescripcionModalidad' => 'Titulación por modalidad de promedio',
                'TipoModalidad'         => 'Titulación',
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ],
            [
                'NombreModalidad'         => 'Trabajo Práctico',
                'DescripcionModalidad' => 'Titulación por modalidad de trabajo práctico',
                'TipoModalidad'         => 'Titulación',
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ],
            
        ]);
    }
}
