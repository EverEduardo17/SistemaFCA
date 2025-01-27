<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Esta clase se encarga de iniciar los Seeders
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsuarioSeeder::class);
        // $this->call(AcademicoSeeder::class);
        // $this->call(DatosPersonalesSeeder::class);

        $this->call(RoleSeeder::class);
        $this->call(PermisoSeeder::class);
        $this->call(Role_PermisoSeeder::class);
        /* Relaciones Role_Permiso */


        // $this->call(FacultadSeeder::class);
        // $this->call(PeriodoSeeder::class);
        // $this->call(SedeEventoSeeder::class);

        // $this->call(TipoDocumentoSeeder::class);
        // $this->call(TipoOrganizadorSeeder::class);

        /*Módulo Control Academico*/
        // $this->call(ProgramaEducativoSeeder::class);
        // $this->call(CohortesSeeder::class);
        // $this->call(ModalidadSeeder::class);
        // $this->call(MotivoSeeder::class);
    }
}
