<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $nombreCohorte = DB::table('Cohorte')->orderBy('IdCohorte', 'desc')->value('NombreCohorte');
        $colores = ["#00A639", "#0D47A1"];
        $opciones = [
            [
                "titulo" => "Eventos",
                "background" => $colores[0],
                "enlace" => "eventos",
                "operaciones" => [
                    ["titulo" => "Nuevo Evento", "enlace" => "create"],
                    ["titulo" => "Ver Eventos", "enlace" => ""],
                ]
            ],

            [
                "titulo" => "Académicos",
                "background" => $colores[1],
                "enlace" => "academicos",
                "operaciones" => [
                    ["titulo" => "Nuevo Académico", "enlace" => "create"],
                    ["titulo" => "Ver Académicos", "enlace" => ""],
                ]
            ],

            [
                "titulo" => "Sedes de los Eventos",
                "background" => $colores[0],
                "enlace" => "sedeEventos",
                "operaciones" => [
                    ["titulo" => "Nueva Sede de Evento", "enlace" => "create"],
                    ["titulo" => "Ver Sedes de Eventos", "enlace" => ""],
                ]
            ],

            [
                "titulo" => "Tipos de Organizadores",
                "background" => $colores[0],
                "enlace" => "tipoorganizador",
                "operaciones" => [
                    ["titulo" => "Nuevo Tipo de Organizador", "enlace" => "create"],
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
                "titulo" => "Academias",
                "background" => $colores[0],
                "enlace" => "academias",
                "operaciones" => [
                    ["titulo" => "Nueva Academia", "enlace" => "create"],
                    ["titulo" => "Ver Academia", "enlace" => ""],
                ]
            ],

            [
                "titulo" => "Empresas",
                "background" => $colores[0],
                "enlace" => "empresas",
                "operaciones" => [
                    ["titulo" => "Nueva Empresa", "enlace" => "create"],
                    ["titulo" => "Gestión de Empresas", "enlace" => ""],
                ]
            ],

            [
                "titulo" => "Programas Educativos",
                "background" => $colores[1],
                "enlace" => "programaEducativo",
                "operaciones" => [
                    ["titulo" => "Nuevo Programa Educativo", "enlace" => "create"],
                    ["titulo" => "Gestión de Programas Educativos", "enlace" => ""],
                ]
            ],

            [
                "titulo" => "Constancias",
                "background" => $colores[0],
                "enlace" => "constancias",
                "operaciones" => [
                    ["titulo" => "Nueva Constancia", "enlace" => "create"],
                    ["titulo" => "Gestión de Constancias", "enlace" => ""],
                ]
            ],

            [
                "titulo" => "Grupos",
                "background" => $colores[0],
                "enlace" => "grupos",
                "operaciones" => [
                    ["titulo" => "Nuevo Grupo", "enlace" => "create"],
                    ["titulo" => "Gestión de Grupos", "enlace" => ""],
                ]
            ],

            [
                "titulo" => "Estudiantes",
                "background" => $colores[0],
                "enlace" => "estudiantes",
                "operaciones" => [
                    ["titulo" => "Nuevo Estudiante", "enlace" => "create"],
                    ["titulo" => "Gestión de Estudiantes", "enlace" => ""],
                ]
            ],

        ];


        return view("home", ['opciones' => $opciones]);
    }
}
