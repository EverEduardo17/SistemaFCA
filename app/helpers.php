<?php
    function formatearDateTime($date, $time){
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
