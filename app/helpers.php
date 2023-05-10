<?php
    use App\Models\Evento_Fecha_Sede;
    use App\Models\FechaEvento;
    use Carbon\Carbon;
    use Illuminate\Support\Collection;

    function formatearDateTime($date, $time) {
        $fecha = explode( '/', $date );
        $hora  = explode( ' ', $time );
        $PM          = strcmp ( 'PM', mb_strtoupper( $hora[1] ) ) == 0;
        $hora  = explode( ':', $hora[0] );
        if( $PM && $hora[0] != 12){
            $hora[0] += 12;
        }
        $fecha = sprintf("%d-%d-%d %d:%d", $fecha[2], $fecha[1], $fecha[0], $hora[0], $hora[1] );

        return $fecha;
    }

    function formatearDate($date) {
        $fecha = explode( '/', $date );
        $fecha = sprintf("%d-%d-%d", $fecha[2], $fecha[1], $fecha[0]);
        
        return $fecha;
    }

    function printDate($date) {
        if ($date === null) {
            return null;
        }
    
        $fecha = explode('-', $date);
        $dia = sprintf("%02d", $fecha[2]);
        $mes = sprintf("%02d", $fecha[1]);
        $anio = sprintf("%d", $fecha[0]);
    
        return "$dia/$mes/$anio";
    }

    function formatearTime($time){
        $hora  = explode( ' ', $time );
        $PM          = strcmp ( 'PM', mb_strtoupper( $hora[1] ) ) == 0;
        $hora  = explode( ':', $hora[0] );
        if( $PM && $hora[0] != 12){
            $hora[0] += 12;
        }

        if($hora[1]<10){
            $hora = sprintf("%d0%d", $hora[0], $hora[1] );
        } else {
            $hora = sprintf("%d%d", $hora[0], $hora[1] );
        }

        return $hora;
    }

    function validarFecha($fechaActual, $vigencia) {
        $fechaActualCarbon = Carbon::parse($fechaActual);

        if ($vigencia === null) {
            return "Esta constancia es vigente";
        }

        $vigenciaCarbon = Carbon::parse($vigencia);

        if ($fechaActualCarbon <= $vigenciaCarbon) {
            return "Esta constancia es vigente hasta el: " . printDate($vigencia);
        } else {
            return "Esta constancia expiró el: " . printDate($vigencia);
        }
    }

    function conflicto($fecha_evento) {
        $fecha_evento = Evento_Fecha_Sede::with('evento', 'fechaEvento')->findOrFail($fecha_evento);
        if($fecha_evento->evento->EstadoEvento == "APROBADO"){
            return "APROBADO";
        }
        $fecha = $fecha_evento->fechaEvento;
        $fechas = FechaEvento::where('IdFechaEvento', '!=', $fecha->IdFechaEvento)
            ->where(function($q) use ($fecha) {
                $q->whereBetween('InicioFechaEvento', [$fecha->InicioFechaEvento, $fecha->FinFechaEvento])
                ->orWhereBetween('FinFechaEvento', [$fecha->InicioFechaEvento, $fecha->FinFechaEvento]);
            })->get();
        $confictos =  new Collection();
        foreach ($fechas as $fecha) {
            if($fecha->evento_fecha_sede->IdSedeEvento == $fecha_evento->IdSedeEvento){
                $confictos->push(
                    array(
                        "id" => $fecha->even->IdEvento,
                        "evento" => $fecha->even->NombreEvento
                    )
                );
            }
        }
        $confictos->all();
        return $confictos;
    }

