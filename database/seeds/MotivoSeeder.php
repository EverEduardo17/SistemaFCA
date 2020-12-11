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
                'NombreMotivo'       => 'Económico',
                'DescripcionModalidad'  => 'Motivo Económico que obliga al estudiante a dar de baja.',
                'TipoModalidad'         => 'Entrada',
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ]
        ]);
    }
}
