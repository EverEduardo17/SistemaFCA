<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CohortesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Cohorte')->insert([
            [
                'NombreCohorte'   => 'S030',
                'DescripcionCohorte' => 'Cohorte de la generación 2003',
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
            [
                'NombreCohorte'   => 'S040',
                'DescripcionCohorte' => 'Cohorte de la generación 2004',
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
            [
                'NombreCohorte'   => 'S050',
                'DescripcionCohorte' => 'Cohorte de la generación 2005',
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
            [
                'NombreCohorte'   => 'S060',
                'DescripcionCohorte' => 'Cohorte de la generación 2006',
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
            [
                'NombreCohorte'   => 'S070',
                'DescripcionCohorte' => 'Cohorte de la generación 2007',
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
            [
                'NombreCohorte'   => 'S080',
                'DescripcionCohorte' => 'Cohorte de la generación 2008',
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
            [
                'NombreCohorte'   => 'S090',
                'DescripcionCohorte' => 'Cohorte de la generación 2009',
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
            [
                'NombreCohorte'   => 'S100',
                'DescripcionCohorte' => 'Cohorte de la generación 2010',
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
            [
                'NombreCohorte'   => 'S110',
                'DescripcionCohorte' => 'Cohorte de la generación 2011',
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
            [
                'NombreCohorte'   => 'S120',
                'DescripcionCohorte' => 'Cohorte de la generación 2012',
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
            [
                'NombreCohorte'   => 'S130',
                'DescripcionCohorte' => 'Cohorte de la generación 2013',
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
            [
                'NombreCohorte'   => 'S140',
                'DescripcionCohorte' => 'Cohorte de la generación 2014',
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
            [
                'NombreCohorte'   => 'S150',
                'DescripcionCohorte' => 'Cohorte de la generación 2015',
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
            [
                'NombreCohorte'   => 'S160',
                'DescripcionCohorte' => 'Cohorte de la generación 2016',
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
            [
                'NombreCohorte'   => 'S170',
                'DescripcionCohorte' => 'Cohorte de la generación 2017',
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
            [
                'NombreCohorte'   => 'S180',
                'DescripcionCohorte' => 'Cohorte de la generación 2018',
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
            [
                'NombreCohorte'   => 'S190',
                'DescripcionCohorte' => 'Cohorte de la generación 2019',
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
            [
                'NombreCohorte'   => 'S200',
                'DescripcionCohorte' => 'Cohorte de la generación 2020',
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
        ]);
    }
}
