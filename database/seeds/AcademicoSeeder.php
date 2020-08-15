<?php

use Illuminate\Database\Seeder;

class AcademicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Academico')->insert([
            [
                'IdAcademico'           => 1001,
                'NoPersonalAcademico'   => '50564',
                'RfcAcademico'          => 'PIHJ850403NFA',
                'IdUsuario'             => 1001,
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
            [
                'IdAcademico'           => 1002,
                'NoPersonalAcademico'   => '51002',
                'RfcAcademico'          => 'XAXX010101002',
                'IdUsuario'             => 1002,
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
            [
                'IdAcademico'           => 1003,
                'NoPersonalAcademico'   => '51003',
                'RfcAcademico'          => 'XAXX010101003',
                'IdUsuario'             => 1003,
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
            [
                'IdAcademico'           => 1004,
                'NoPersonalAcademico'   => '51004',
                'RfcAcademico'          => 'XAXX010101004',
                'IdUsuario'             => 1004,
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
        ]);
    }
}
