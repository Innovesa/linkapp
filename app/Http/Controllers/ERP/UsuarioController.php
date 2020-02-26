<?php

namespace LinkApp\Http\Controllers\ERP;

use Illuminate\Http\Request;
use LinkApp\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage; //para los discos virtuales
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

class UsuarioController extends Controller
{
    public function __construct(){
        $this->middleware('auth'); //Para solo acceder si estas loguiado
    }
    
    //Traer Avatar 
    public function getImage($idPersona,$filename){
        $file = Storage::disk('personas')->get($idPersona.'/'.$filename);
        return new Response($file, 200); //Para devolver la imagen. Se ocupa Illuminate\Http\Response;
    }

    //Verificacion de perfil
    public function verificacionPerfil(){

        return view('temes.inspinia.bloqueada');
    }
}
