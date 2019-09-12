<?php

namespace LinkApp\Helpers;

use LinkApp\Models\ERP\Estructura;
use LinkApp\Models\ERP\PerfilUsuario;
use LinkApp\Models\ERP\PerfilOpcion;

class TraerMenus{
    
    public static function traerTodo()
    {
        $user = \Auth::User();
        $perfil = PerfilUsuario::where('idUsuario',$user->id)->first();

        $menus = new TraerMenus();
        $menus ->menusPadre();
        
        if($perfil){
            $menus ->opcionesPerfil($perfil->id);
            $menus ->menusHijo();
        }
    }

    //Trae los menu padre de las aplicaciones como CRM, ERP, ETC   
    public function menusPadre(){
        $_SESSION['menusPadres'] = Estructura::where('superior',null)->get();
       
    }

    //Trae los menu hijos. Los modulos de las aplicaciones
    public function menusHijo(){

        $menusHijos = Estructura::all();

        $opciones[] = '';
        $i = 0;

        foreach($menusHijos as $menu){

            if(count($_SESSION['opciones']) > $i){
                $validacion = $_SESSION['opciones'][$i]['idEstructura'];
                if($menu->id == $validacion){
                    
                    $opciones[$i] = $menu;

                    $i++;
                }
            }
            
        }

        $_SESSION['menusHijos'] = $opciones;
    }


    //Trae las opciones de los modulos
    public function opcionesPerfil($id){

        $perfilOpcion = PerfilOpcion::where('idPerfil',$id)->get();
        
        $opciones[] = '';
        $i = 0;

        foreach($perfilOpcion as $opcionPerfil){
            
            $opciones[$i] = $opcionPerfil->opcion;

            $i++;
        }

        $_SESSION['opciones'] = $opciones;

        

    }

}
