<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacultadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Facultad')->insert([
            'NombreFacultad'    => 'Facultad de Contaduría y Administración',
            'ClaveFacultad'     => '51301',
            'CreatedBy' => 1,
            'UpdatedBy' => 1,
        ]);
    }
}
