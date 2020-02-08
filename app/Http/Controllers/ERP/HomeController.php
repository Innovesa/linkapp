<?php

namespace LinkApp\Http\Controllers\ERP;

use Illuminate\Http\Request;
use LinkApp\Http\Controllers\Controller;
use LinkApp\Models\ERP\Permiso;
use LinkApp\Models\ERP\PerfilUsuario;
use LinkApp\Models\ERP\Persona;
use LinkApp\Models\ERP\Opcion;

class HomeController extends Controller
{
    public function __construct(){
        $this->middleware('auth'); //Para solo acceder si estas loguiado
    }

    public function index()
    {

        \TraerMenus::traerTodo();

        var_dump();
        die;
        
        $permiso = new Permiso();

        if ($permiso->ViewHomePermission()) {

            session(['currentUrl' => url()->current()]);

            return view('temes.inspinia.home');

        }else{
            return redirect()->route('usuario.verificacion.perfil');
        } 
        
    }

    public function cambiarCompania($idCompania)
    {
        $compania = Persona::Where('id',$idCompania)->first();
        
        if ($compania) {

            session(['compania' => $compania]);

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
