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
                'NombreModalidad'         => 'Tésis',
                'DescripcionModalidad' => 'Titulación por modalidad de tésis',
                'TipoModalidad'         => 'Titulación',
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ],
            [
                'NombreModalidad'         => 'Definitiva',
                'DescripcionModalidad' => 'Ingreso por lugares disponibles.',
                'TipoModalidad'         => 'Titulación',
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ],
        ]);
    }
}
