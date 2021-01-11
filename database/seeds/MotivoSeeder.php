<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MotivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Motivo')->insert([
            [
                'NombreMotivo'       => 'Cambio de Domicilio',
                'DescripcionMotivo'  => 'Cambio de Domicilio que obliga al estudiante a dar de baja temporal.',
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ],
            [
                'NombreMotivo'       => 'Enfermedad',
                'DescripcionMotivo'  => 'Motivo de salud que obliga al estudiante a dar de baja temporal.',
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ],
            [
                'NombreMotivo'       => 'Escolares',
                'DescripcionMotivo'  => 'Motivo escolar que obliga al estudiante a dar de baja definitiva.',
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ],
            [
                'NombreMotivo'       => 'Económicos',
                'DescripcionMotivo'  => 'Motivo Económico que obliga al estudiante a dar de baja temporal.',
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ],
            [
                'NombreMotivo'       => 'Laborales',
                'DescripcionMotivo'  => 'Motivo Laboral que obliga al estudiante a dar de baja temporal.',
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ],
            [
                'NombreMotivo'       => 'Personales',
                'DescripcionMotivo'  => 'Motivo Personal que obliga al estudiante a dar de baja temporal.',
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ],
            [
                'NombreMotivo'       => 'Cambio de Carrera',
                'DescripcionMotivo'  => 'Cambio de Carrera que obliga al estudiante a dar de baja definitiva.',
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ],
            [
                'NombreMotivo'       => 'Reprobar Examen de Última Oportunidad',
                'DescripcionMotivo'  => 'Motivo Escolar que obliga al estudiante a dar de baja definitiva.',
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ],
            [
                'NombreMotivo'       => 'Fallecimiento',
                'DescripcionMotivo'  => 'Motivo de causa mayor que obliga al estudiante a dar de baja definitiva.',
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ]
        ]);
    }
}
