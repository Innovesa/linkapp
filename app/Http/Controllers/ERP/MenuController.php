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

    public function index()
    {
        \TraerMenus::traerTodo();
        $_SESSION['aplicacion'] = 1;
        return view('temes.inspinia.home');
    }

    public function indexCRM()
    {
        \TraerMenus::traerTodo();
        $_SESSION['aplicacion'] = 4;
        return view('temes.inspinia.homeCRM');
    }

    public function prueba()
    {
        \TraerMenus::traerTodo();
        return view('temes.inspinia.prueba');
    }

    
}
