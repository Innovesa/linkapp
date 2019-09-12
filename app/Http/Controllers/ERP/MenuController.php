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

    public function index()
    {
        return view('temes.inspinia.home');
    }

    public function prueba()
    {
        return view('temes.inspinia.prueba');
    }

    
}
