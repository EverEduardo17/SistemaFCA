<?php

use Illuminate\Database\Seeder;

class Role_PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $relaciones = [
            [3,13],
            [3,14],
            [3,15],
            [3,16],
            [3,17],
            [5,16],
            [5,17],
            [4,13],
            [4,16],
            [4,17],
            [4,18],
            [4,19],
            [4,20],
            [4,21],
        ];
        $registros=[];
        foreach($relaciones as $registro){
            $registros[] = [
                'IdRole'    => $registro[0],
                'IdPermiso' => $registro[1],
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ];
        }

        DB::table('Role_Permiso')->insert($registros);
    }
}
