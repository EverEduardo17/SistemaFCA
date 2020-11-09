<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Usuario')->insert([
            [
                'IdUsuario' => 1,
                'Name'      => 'Sistema',
                'Email'     => 'sistema@local',
                'password'  => Crypt::encrypt('PcucelpduC_sistema'),
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ],
            [
                'IdUsuario' => 1001,
                'Name'      => 'jpino',
                'Email'     => 'jpino@uv.mx',
                'password'  => Crypt::encrypt('abcdefghi'),
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ],
            [
                'IdUsuario' => 1002,
                'Name'      => 'valerio',
                'Email'     => 'valerio@uv.mx',
                'password'  => Crypt::encrypt('abcdefghi'),
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ],
            [
                'IdUsuario' => 1003,
                'Name'      => 'morales',
                'Email'     => 'morales@uv.mx',
                'password'  => Crypt::encrypt('abcdefghi'),
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ],
            [
                'IdUsuario' => 1004,
                'Name'      => 'antonio',
                'Email'     => 'antonio@uv.mx',
                'password'  => Crypt::encrypt('abcdefghi'),
                'CreatedBy' => 1,
                'UpdatedBy' => 1,
            ],

        ]);

    }
}
