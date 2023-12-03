<?php
    use App\Models\Evento_Fecha_Sede;
    use App\Models\FechaEvento;
    use Carbon\Carbon;
    use Illuminate\Support\Collection;

    /**
     * Recibe una fecha y una hora para adaptarla a la sintaxis MySQL datetime
     * 
     * @param string $date fecha formato DD/MM/YYYY
     * @param string $time hora formato H:MM AM/PM
     * @return string fecha formato YYYY-MM-DD HH:MI
     */
    function formatearDateTime($date, $time) 
    {
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

    /**
     * Recibe una fecha en formato DD/MM/YYYY y la adapta al formato que SQL usa
     * 
     * @param string $date
     * @return string fecha formato YYYY-MM-DD
     */
    function formatearDate($date) 
    {
        $fecha = explode( '/', $date );
        $fecha = sprintf("%d-%d-%d", $fecha[2], $fecha[1], $fecha[0]);
        
        return $fecha;
    }

    /**
     * Recibe una fecha en formato YYYY-MM-DD y la retorna en DD/MM/YYYY
     * Si la fecha dada es nula, retorna null
     * 
     * @param string $date
     * @return string|null fecha en formato DD/MM/YYYY
     */
    function printDate($date) 
    {
        if ($date === null) {
            return null;
        }
    
        $fecha = explode('-', $date);
        $dia = sprintf("%02d", $fecha[2]);
        $mes = sprintf("%02d", $fecha[1]);
        $anio = sprintf("%d", $fecha[0]);
    
        return "$dia/$mes/$anio";
    }

    /**
     * Convierte datetime a formato DD/MM/YYYY HH:MM AM/PM
     *
     * @param string $datetime La fecha y hora a imprimir.
     * @return string La fecha y hora en formato DD/MM/YYYY HH:MM AM/PM.
     */
    function printDateTime($datetime)
    {
        $datetime = DateTime::createFromFormat('Y-m-d H:i:s', $datetime);
        $formatted_datetime = $datetime->format('d/m/Y h:i A');
        
        return $formatted_datetime;
    }

    /**
     * Recibe una hora en formato AM/PM y la vuelve a formato 24H
     * 
     * @param string $time
     * @return string hora en formato H:MI
     */
    function formatearTime($time) 
    {
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

    /**
     * Valida que una constancia siga siendo vigente
     * Este metodo se usa para imprimir un mensaje en la vista de la constancia
     * 
     * @param mixed $fechaActual
     * @param mixed $vigencia fecha en la que vence la constancia
     * @return string
     */
    function validarFecha($fechaActual, $vigencia) 
    {
        $fechaActualCarbon = Carbon::parse($fechaActual);

        if ($vigencia === null) {
            return "Esta constancia es vigente";
        }

        $vigenciaCarbon = Carbon::parse($vigencia);

        if ($fechaActualCarbon <= $vigenciaCarbon) {
            return "Esta constancia es vigente hasta el: " . printDate($vigencia);
        }
        
        return "Esta constancia expiró el: " . printDate($vigencia);
    }

    /**
     * Este método maneja conflictos de fechas en eventos.
     * 
     * Primero, intenta encontrar un evento con el ID proporcionado. Si el evento no se encuentra, se lanza una excepción.
     * Luego, comprueba si el estado del evento es "APROBADO". Si es así, devuelve la cadena "APROBADO".
     * Si el estado del evento no es "APROBADO", busca otras fechas de eventos que puedan tener conflictos con la fecha del evento actual.
     * Finalmente, devuelve una colección de eventos conflictivos. Cada evento conflictivo en la colección tiene un `id` y un `evento`.
     *
     * @param mixed $fecha_evento El ID del evento a comprobar.
     * @return Collection|string Una colección de eventos conflictivos o la cadena "APROBADO" si el estado del evento es "APROBADO".
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si no se puede encontrar un evento con el ID proporcionado.
     */
    function conflicto($fecha_evento) 
    {
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

    /**
     * Envoltorio para obtener el año actual
     * 
     * @return int El año actual
     */
    function getYear() 
    {
        return Carbon::now()->year;
    }

    /**
     * Capitaliza la primera letra de cada palabra en un string.
     *
     * @param string $string El string a capitalizar.
     * @return string El string capitalizado.
     */
    function capitalizeFirst(string|null $string) 
    {
        if ($string === null) {
            return '';
        }

        return ucwords(strtolower($string));
    }

