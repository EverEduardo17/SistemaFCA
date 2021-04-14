<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramaEducativoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $idFCA = DB::table('Facultad')
            ->where('NombreFacultad', 'Facultad de Contaduría y Administración')->value('IdFacultad');
        DB::table('Programa_Educativo')->insert([
            [
                'IdFacultad'                => $idFCA,
                'NombreProgramaEducativo'   => 'Licenciatura en Administración',
                'AcronimoProgramaEducativo' => 'LA',
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
            [
                'IdFacultad'                => $idFCA,
                'NombreProgramaEducativo'   => 'Licenciatura en Contaduría',
                'AcronimoProgramaEducativo' => 'LC',
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
            [
                'IdFacultad'                => $idFCA,
                'NombreProgramaEducativo'   => 'Licenciatura en Gestión y Dirección de Negocios',
                'AcronimoProgramaEducativo' => 'LGDN',
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
            [
                'IdFacultad'                => $idFCA,
                'NombreProgramaEducativo'   => 'Licenciatura en Ingeniería de Software',
                'AcronimoProgramaEducativo' => 'LIS',
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
            [
                'IdFacultad'                => $idFCA,
                'NombreProgramaEducativo'   => 'Licenciatura en Sistemas Computacionales Administrativos',
                'AcronimoProgramaEducativo' => 'LSCA',
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
        ]);
    }
}
