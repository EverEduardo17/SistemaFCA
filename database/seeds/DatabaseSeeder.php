<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsuarioSeeder::class);
        $this->call(AcademicoSeeder::class);
        $this->call(DatosPersonalesSeeder::class);

        $this->call(RoleSeeder::class);
        $this->call(PermisoSeeder::class);
        /* Relaciones Role_Permiso */


        $this->call(FacultadSeeder::class);
        $this->call(PeriodoSeeder::class);
        $this->call(ProgramaEducativoSeeder::class);
        $this->call(SedeEventoSeeder::class);

        $this->call(TipoDocumentoSeeder::class);
        $this->call(TipoOrganizadorSeeder::class);
    }
}
