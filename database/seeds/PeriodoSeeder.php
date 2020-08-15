<?php

use Illuminate\Database\Seeder;

class PeriodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Periodo')->insert([
            'NombrePeriodo'         => 'FEBRERO - JULIO 2020',
            'FechaInicioPeriodo'    => new DateTime("2020-02-01"),
            'FechaFinPeriodo'       => new DateTime("2020-07-31"),
            'ActualPeriodo'       => true,
            'CreatedBy' => 1,
            'UpdatedBy' => 1,
        ]);
    }
}
