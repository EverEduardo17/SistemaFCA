<?php

use Illuminate\Database\Seeder;

class SedeEventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $registros = [
            [
                "IdSedeEvento" => 1,
                "NombreSedeEvento" => "Auditorio - Fca",
                "DescripcionSedeEvento" => "Auditorio - Fca",
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ],
            [
                "IdSedeEvento" => 2,
                "NombreSedeEvento" => "Salón 6 - Fca",
                "DescripcionSedeEvento" => "Salón 6 - Fca",
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ],
        ];
        DB::table('SedeEvento')->insert($registros);
    }
}
