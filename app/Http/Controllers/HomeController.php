<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $colores = [ "#00A639", "#0D47A1" ];
        $opciones = [
            [
                "titulo" => "Eventos",
                "background" => $colores[0],
                "enlace" => "eventos",
                "operaciones" => [
                    ["titulo" => "Nuevo Evento", "enlace" => "create"],
                    ["titulo" => "Ver Eventos", "enlace" => ""],
                    ["titulo" => "Mis Eventos", "enlace" => "mis-eventos"],
                ]
            ],

            [
                "titulo" => "Académicos",
                "background" => $colores[1],
                "enlace" => "academicos",
                "operaciones" => [
                    ["titulo" => "Nuevo Académico", "enlace" => "nuevo"],
                    ["titulo" => "Ver Académicos", "enlace" => ""],
                ]
            ],

            [
                "titulo" => "Sedes de los Eventos",
                "background" => $colores[0],
                "enlace" => "sede-eventos",
                "operaciones" => [
                    ["titulo" => "Nueva Sede de Evento", "enlace" => "nuevo"],
                    ["titulo" => "Ver Sedes de Eventos", "enlace" => ""],
                ]
            ],

            [
                "titulo" => "Organizadores",
                "background" => $colores[1],
                "enlace" => "organizadores",
                "operaciones" => [
                    ["titulo" => "Nuevo Organizador", "enlace" => "nuevo"],
                    ["titulo" => "Ver Organizadores", "enlace" => ""],
                ]
            ],

            [
                "titulo" => "Tipos de Organizadores",
                "background" => $colores[0],
                "enlace" => "tipos-organizadores",
                "operaciones" => [
                    ["titulo" => "Nuevo Tipo de Organizador", "enlace" => "nuevo"],
                    ["titulo" => "Ver Tipos de Organizadores", "enlace" => ""],
                ]
            ],

            [
                "titulo" => "Facultades",
                "background" => $colores[1],
                "enlace" => "facultades",
                "operaciones" => [
                    ["titulo" => "Nueva Facultad", "enlace" => "create"],
                    ["titulo" => "Ver Facultades", "enlace" => ""],
                ]
            ],

            [
                "titulo" => "Academinas",
                "background" => $colores[0],
                "enlace" => "academias",
                "operaciones" => [
                    ["titulo" => "Nueva Academia", "enlace" => "create"],
                    ["titulo" => "Ver Academia", "enlace" => ""],
                ]
            ]
        ];

        return view("Home", ['opciones'=>$opciones]);
    }
}
