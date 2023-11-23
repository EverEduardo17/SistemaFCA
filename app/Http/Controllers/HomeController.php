<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $colores = ["#00A639", "#0D47A1"];
        $opciones = [
            [
                "titulo" => "Eventos",
                "background" => $colores[0],
                "enlace" => "eventos",
                "operaciones" => [
                    ["titulo" => "Nuevo Evento", "enlace" => "create"],
                    ["titulo" => "Ver Eventos", "enlace" => "index"],
                ],
                "permiso" => "eventos-listar"
            ],

            [
                "titulo" => "Académicos",
                "background" => $colores[1],
                "enlace" => "academicos",
                "operaciones" => [
                    ["titulo" => "Nuevo Académico", "enlace" => "create"],
                    ["titulo" => "Ver Académicos", "enlace" => "index"],
                ],
                "permiso" => "academicos-listar"
            ],

            [
                "titulo" => "Sedes de los Eventos",
                "background" => $colores[0],
                "enlace" => "sedeEventos",
                "operaciones" => [
                    ["titulo" => "Nueva Sede de Evento", "enlace" => "create"],
                    ["titulo" => "Ver Sedes de Eventos", "enlace" => "index"],
                ],
                "permiso" => "sedes-listar"
            ],

            [
                "titulo" => "Tipos de Organizadores",
                "background" => $colores[0],
                "enlace" => "tipoorganizador",
                "operaciones" => [
                    ["titulo" => "Nuevo Tipo de Organizador", "enlace" => "create"],
                    ["titulo" => "Ver Tipos de Organizadores", "enlace" => "index"],
                ],
                "permiso" => "tipoorganizador-listar"
            ],

            [
                "titulo" => "Facultades",
                "background" => $colores[1],
                "enlace" => "facultades",
                "operaciones" => [
                    ["titulo" => "Nueva Facultad", "enlace" => "create"],
                    ["titulo" => "Ver Facultades", "enlace" => "index"],
                ],
                "permiso" => "facultades-listar"
            ],

            [
                "titulo" => "Academias",
                "background" => $colores[0],
                "enlace" => "academias",
                "operaciones" => [
                    ["titulo" => "Nueva Academia", "enlace" => "create"],
                    ["titulo" => "Ver Academia", "enlace" => "index"],
                ],
                "permiso" => "academias-listar"
            ],

            [
                "titulo" => "Empresas",
                "background" => $colores[0],
                "enlace" => "empresas",
                "operaciones" => [
                    ["titulo" => "Nueva Empresa", "enlace" => "create"],
                    ["titulo" => "Gestión de Empresas", "enlace" => "index"],
                ],
                "permiso" => "empresas-listar"
            ],

            [
                "titulo" => "Programas Educativos",
                "background" => $colores[1],
                "enlace" => "programaEducativo",
                "operaciones" => [
                    ["titulo" => "Nuevo Programa Educativo", "enlace" => "create"],
                    ["titulo" => "Gestión de Programas Educativos", "enlace" => "index"],
                ],
                "permiso" => "programas-listar"
            ],

            [
                "titulo" => "Constancias",
                "background" => $colores[0],
                "enlace" => "constancias",
                "operaciones" => [
                    ["titulo" => "Nueva Constancia", "enlace" => "create"],
                    ["titulo" => "Gestión de Constancias", "enlace" => "index"],
                ],
                "permiso" => "constancias-listar"
            ],

            [
                "titulo" => "Estudiantes",
                "background" => $colores[0],
                "enlace" => "estudiantes",
                "operaciones" => [
                    ["titulo" => "Nuevo Estudiante", "enlace" => "create"],
                    ["titulo" => "Gestión de Estudiantes", "enlace" => "index"],
                ],
                "permiso" => "estudiantes-listar"
            ],

        ];


        return view("home", ['opciones' => $opciones]);
    }
}
