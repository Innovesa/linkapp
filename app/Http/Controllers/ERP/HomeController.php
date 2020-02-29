<?php

namespace LinkApp\Http\Controllers\ERP;

use Illuminate\Http\Request;
use LinkApp\Http\Controllers\Controller;
use LinkApp\Models\ERP\Permiso;
use LinkApp\Models\ERP\Usuario;
use LinkApp\Models\ERP\Persona;
use LinkApp\Models\ERP\Opcion;

class HomeController extends Controller
{
    public function __construct(){
        $this->middleware('auth'); //Para solo acceder si estas loguiado
    }

    public function index()
    {

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

        $usuario = new Usuario();

        
        if ($compania) {

            session(['compania' => $compania]);

            session(['permisos' => $usuario->getPermisos(\Auth::User(),$compania)]);

        }

        return redirect()->back();
    }


    public function cambiarAplicacion($idAplicacion)
    {
        $aplicacion = Opcion::Where('id',$idAplicacion)->first();
        
        if ($aplicacion) {

            session(['aplicacion' => $aplicacion]);

        }

        return redirect()->route('home');
    }


    public function addCompania(Request $request)
    {
        var_dump($request->input());
        die;
    }
}
