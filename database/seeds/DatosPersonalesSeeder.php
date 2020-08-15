<?php

use Illuminate\Database\Seeder;

class DatosPersonalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('DatosPersonales')->insert([
            [
                'IdDatosPersonales'              => 1001,
                'NombreDatosPersonales'          => 'Javier',
                'ApellidoPaternoDatosPersonales' => 'Pino',
                'ApellidoMaternoDatosPersonales' => 'Herrera',
                'IdUsuario'             => 1001,
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
            [
                'IdDatosPersonales'              => 1002,
                'NombreDatosPersonales'          => 'Bnombre',
                'ApellidoPaternoDatosPersonales' => 'Bpaterno',
                'ApellidoMaternoDatosPersonales' => 'Bmaterno',
                'IdUsuario'             => 1002,
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
            [
                'IdDatosPersonales'              => 1003,
                'NombreDatosPersonales'          => 'Cnombre',
                'ApellidoPaternoDatosPersonales' => 'Cpaterno',
                'ApellidoMaternoDatosPersonales' => 'Cmaterno',
                'IdUsuario'             => 1003,
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
            [
                'IdDatosPersonales'              => 1004,
                'NombreDatosPersonales'          => 'Cnombre',
                'ApellidoPaternoDatosPersonales' => 'Cpaterno',
                'ApellidoMaternoDatosPersonales' => 'Cmaterno',
                'IdUsuario'             => 1004,
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
        ]);
    }
}
