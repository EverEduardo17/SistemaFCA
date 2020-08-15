<?php

use Illuminate\Database\Seeder;

class TipoOrganizadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('TipoOrganizador')->insert([
            [
                'NombreTipoOrganizador'      => 'RESPONSABLE',
                'DescripcionTipoOrganizador' => 'Responsable',
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ],
            [
                'NombreTipoOrganizador'      => 'COLABORADOR',
                'DescripcionTipoOrganizador' => 'Colaborador',
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ],
            [
                'NombreTipoOrganizador'      => 'OTRO',
                'DescripcionTipoOrganizador' => 'Otro',
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ],
        ]);
    }
}
