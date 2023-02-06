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

        for($i=1; $i<94; $i++){
            $registros[] = [
                'IdRole'    => 2,
                'IdPermiso' => $i,
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ];
        }

        DB::table('Role_Permiso')->insert($registros);
    }
}
