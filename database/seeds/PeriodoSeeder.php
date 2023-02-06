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

            [
                'NombrePeriodo'          => 'Agosto 2002 - Enero 2003',
                'FechaInicioPeriodo'     => new DateTime("2002-08-01"),
                'FechaFinPeriodo'        => new DateTime("2003-01-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Febrero - Julio 2003',
                'FechaInicioPeriodo'     => new DateTime("2003-02-01"),
                'FechaFinPeriodo'        => new DateTime("2003-07-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Agosto 2003 - Enero 2004',
                'FechaInicioPeriodo'     => new DateTime("2003-08-01"),
                'FechaFinPeriodo'        => new DateTime("2004-01-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Febrero - Julio 2004',
                'FechaInicioPeriodo'     => new DateTime("2004-02-01"),
                'FechaFinPeriodo'        => new DateTime("2004-07-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Agosto 2004 - Enero 2005',
                'FechaInicioPeriodo'     => new DateTime("2004-08-01"),
                'FechaFinPeriodo'        => new DateTime("2005-01-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Febrero - Julio 2005',
                'FechaInicioPeriodo'     => new DateTime("2005-02-01"),
                'FechaFinPeriodo'        => new DateTime("2005-07-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Agosto 2005 - Enero 2006',
                'FechaInicioPeriodo'     => new DateTime("2005-08-01"),
                'FechaFinPeriodo'        => new DateTime("2006-01-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Febrero - Julio 2006',
                'FechaInicioPeriodo'     => new DateTime("2006-02-01"),
                'FechaFinPeriodo'        => new DateTime("2006-07-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Agosto 2006 - Enero 2007',
                'FechaInicioPeriodo'     => new DateTime("2006-08-01"),
                'FechaFinPeriodo'        => new DateTime("2007-01-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Febrero - Julio 2007',
                'FechaInicioPeriodo'     => new DateTime("2007-02-01"),
                'FechaFinPeriodo'        => new DateTime("2007-07-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Agosto 2007 - Enero 2008',
                'FechaInicioPeriodo'     => new DateTime("2007-08-01"),
                'FechaFinPeriodo'        => new DateTime("2008-01-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Febrero - Julio 2008',
                'FechaInicioPeriodo'     => new DateTime("2008-02-01"),
                'FechaFinPeriodo'        => new DateTime("2008-07-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Agosto 2008 - Enero 2009',
                'FechaInicioPeriodo'     => new DateTime("2008-08-01"),
                'FechaFinPeriodo'        => new DateTime("2009-01-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Febrero - Julio 2009',
                'FechaInicioPeriodo'     => new DateTime("2009-02-01"),
                'FechaFinPeriodo'        => new DateTime("2009-07-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Agosto 2009 - Enero 2010',
                'FechaInicioPeriodo'     => new DateTime("2009-08-01"),
                'FechaFinPeriodo'        => new DateTime("2010-01-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Febrero - Julio 2010',
                'FechaInicioPeriodo'     => new DateTime("2010-02-01"),
                'FechaFinPeriodo'        => new DateTime("2010-07-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Agosto 2010 - Enero 2011',
                'FechaInicioPeriodo'     => new DateTime("2010-08-01"),
                'FechaFinPeriodo'        => new DateTime("2011-01-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Febrero - Julio 2011',
                'FechaInicioPeriodo'     => new DateTime("2011-02-01"),
                'FechaFinPeriodo'        => new DateTime("2011-07-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Agosto 2011 - Enero 2012',
                'FechaInicioPeriodo'     => new DateTime("2011-08-01"),
                'FechaFinPeriodo'        => new DateTime("2012-01-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Febrero - Julio 2012',
                'FechaInicioPeriodo'     => new DateTime("2012-02-01"),
                'FechaFinPeriodo'        => new DateTime("2012-07-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Agosto 2012 - Enero 2013',
                'FechaInicioPeriodo'     => new DateTime("2012-08-01"),
                'FechaFinPeriodo'        => new DateTime("2013-01-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Febrero - Julio 2013',
                'FechaInicioPeriodo'     => new DateTime("2013-02-01"),
                'FechaFinPeriodo'        => new DateTime("2013-07-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Agosto 2013 - Enero 2014',
                'FechaInicioPeriodo'     => new DateTime("2013-08-01"),
                'FechaFinPeriodo'        => new DateTime("2014-01-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Febrero - Julio 2014',
                'FechaInicioPeriodo'     => new DateTime("2014-02-01"),
                'FechaFinPeriodo'        => new DateTime("2014-07-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Agosto 2014 - Enero 2015',
                'FechaInicioPeriodo'     => new DateTime("2014-08-01"),
                'FechaFinPeriodo'        => new DateTime("2015-01-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Febrero - Julio 2015',
                'FechaInicioPeriodo'     => new DateTime("2015-02-01"),
                'FechaFinPeriodo'        => new DateTime("2015-07-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Agosto 2015 - Enero 2016',
                'FechaInicioPeriodo'     => new DateTime("2015-08-01"),
                'FechaFinPeriodo'        => new DateTime("2016-01-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Febrero - Julio 2016',
                'FechaInicioPeriodo'     => new DateTime("2016-02-01"),
                'FechaFinPeriodo'        => new DateTime("2016-07-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Agosto 2016 - Enero 2017',
                'FechaInicioPeriodo'     => new DateTime("2016-08-01"),
                'FechaFinPeriodo'        => new DateTime("2017-01-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Febrero - Julio 2017',
                'FechaInicioPeriodo'     => new DateTime("2017-02-01"),
                'FechaFinPeriodo'        => new DateTime("2017-07-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Agosto 2017 - Enero 2018',
                'FechaInicioPeriodo'     => new DateTime("2017-08-01"),
                'FechaFinPeriodo'        => new DateTime("2018-01-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Febrero - Julio 2018',
                'FechaInicioPeriodo'     => new DateTime("2018-02-01"),
                'FechaFinPeriodo'        => new DateTime("2018-07-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Agosto 2018 - Enero 2019',
                'FechaInicioPeriodo'     => new DateTime("2018-08-01"),
                'FechaFinPeriodo'        => new DateTime("2019-01-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Febrero - Julio 2019',
                'FechaInicioPeriodo'     => new DateTime("2019-02-01"),
                'FechaFinPeriodo'        => new DateTime("2019-07-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],
            [
                'NombrePeriodo'          => 'Agosto 2019 - Enero 2020',
                'FechaInicioPeriodo'     => new DateTime("2019-08-01"),
                'FechaFinPeriodo'        => new DateTime("2020-01-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'      => 'Febrero - Agosto 2020',
                'FechaInicioPeriodo'    => new DateTime("2020-02-01"),
                'FechaFinPeriodo'       => new DateTime("2020-08-31"),
                'ActualPeriodo'         => false,
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
            [
                'NombrePeriodo'      => 'Septiembre 2020 - Febrero 2021',
                'FechaInicioPeriodo'    => new DateTime("2020-09-01"),
                'FechaFinPeriodo'       => new DateTime("2021-01-31"),
                'ActualPeriodo'         => false,
                'CreatedBy'             => 1,
                'UpdatedBy'             => 1,
            ],
            
            [
                'NombrePeriodo'          => 'Febrero - Julio 2021',
                'FechaInicioPeriodo'     => new DateTime("2021-02-01"),
                'FechaFinPeriodo'        => new DateTime("2021-07-31"),
                'ActualPeriodo'          => true,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],

            [
                'NombrePeriodo'          => 'Agosto 2021 - Enero 2022',
                'FechaInicioPeriodo'     => new DateTime("2021-08-01"),
                'FechaFinPeriodo'        => new DateTime("2022-01-31"),
                'ActualPeriodo'          => false,
                'CreatedBy'              => 1,
                'UpdatedBy'              => 1,
            ],


        ]);
    }
}
