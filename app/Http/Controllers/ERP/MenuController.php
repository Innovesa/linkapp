<?php

namespace LinkApp\Http\Controllers\ERP;

use Illuminate\Http\Request;
use LinkApp\Http\Controllers\Controller;
use LinkApp\Models\ERP\Estructura;
use LinkApp\Models\ERP\PerfilUsuario;
use LinkApp\Models\ERP\Persona;
use LinkApp\Models\ERP\Opcion;


class MenuController extends Controller
{
    public function __construct(){
        $this->middleware('auth'); //Para solo acceder si estas loguiado
    }

    public function index()
    {
        
        return view('temes.inspinia.home');
    }

    public function cambiarCompania($idCompania)
    {
        $compania = Persona::Where('id',$idCompania)->first();
        
        if ($compania) {

            session(['aplicacion' => $idCompania]);

        }

        return redirect()->back();
    }

    public function cambiarAplicacion($idAplicacion)
    {
        $aplicacion = Opcion::Where('id',$idAplicacion)->first();
        
        if ($aplicacion) {

            session(['aplicacion' => $aplicacion]);

        }

        return redirect()->back();
    }

    
}
