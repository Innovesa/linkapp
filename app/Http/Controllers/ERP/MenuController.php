<?php

namespace LinkApp\Http\Controllers\ERP;

use Illuminate\Http\Request;
use LinkApp\Http\Controllers\Controller;
use LinkApp\Models\ERP\Estructura;
use LinkApp\Models\ERP\PerfilUsuario;
use LinkApp\Models\ERP\PerfilOpcion;
use LinkApp\Models\ERP\Opcion;


class MenuController extends Controller
{
    public function __construct(){
        $this->middleware('auth'); //Para solo acceder si estas loguiado
    }

    public function index($aplicacion)
    {
        \TraerMenus::traerTodo();
        return view('temes.inspinia.home',['nombreAplicacion' => $aplicacion]);
    }

    public function prueba($aplicacion)
    {
        \TraerMenus::traerTodo($aplicacion);
        return view('temes.inspinia.prueba',['nombreAplicacion' => $aplicacion]);
    }

    
}
