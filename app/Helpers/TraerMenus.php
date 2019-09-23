<?php

namespace LinkApp\Helpers;

use LinkApp\Models\ERP\Estructura;
use LinkApp\Models\ERP\PerfilUsuario;
use LinkApp\Models\ERP\PerfilOpcion;
use LinkApp\Models\ERP\MenuOpcion;


class TraerMenus{
    
    public static function traerTodo()
    {
        $user = \Auth::User();
        $perfil = PerfilUsuario::where('idUsuario',$user->id)->first();
        
        $menus = new TraerMenus();
        if($perfil){
            $menus->menuAplicaciones();
            $menus->menuGeneral($perfil->id);
        }
    }



    public function menuGeneral($id){
        $menu = MenuOpcion::all();
        $perfilOpcion = PerfilOpcion::where('idPerfil',$id)->get();
        $estructura = Estructura::all();
        $idSuperior = null;

        foreach ($menu as $menus) {
            
            foreach($perfilOpcion as $opcionPerfil){
            
                if ($menus->idOpcion == $opcionPerfil->opcion->id) {

                    foreach ($estructura as $estructuras) {

                        if ($estructuras->id == $opcionPerfil->opcion->idEstructura) {

                            if ($menus->menu->nombre == 'principal') {
                                $_SESSION['menu'][$menus->menu->nombre]['id'][] = $menus->opcion->id;
                                $_SESSION['menu'][$menus->menu->nombre]['nombre'][] = $menus->opcion->nombre;
                                $_SESSION['menu'][$menus->menu->nombre]['accion'][] = $menus->opcion->accion;
                                $_SESSION['menu'][$menus->menu->nombre]['icono'][] = $menus->opcion->icono;
                                
                            }else{

                                $_SESSION['menu'][$menus->menu->nombre][$estructuras->estructura->nombre]['opcion']['id'][] = $menus->opcion->id;
                                $_SESSION['menu'][$menus->menu->nombre][$estructuras->estructura->nombre]['opcion']['nombre'][] = $menus->opcion->nombre;
                                $_SESSION['menu'][$menus->menu->nombre][$estructuras->estructura->nombre]['opcion']['accion'][] = $menus->opcion->accion;
                                $_SESSION['menu'][$menus->menu->nombre][$estructuras->estructura->nombre]['opcion']['icono'][] = $menus->opcion->icono;
                                $_SESSION['menu'][$menus->menu->nombre][$estructuras->estructura->nombre]['opcion']['idEstructura'][] = $menus->opcion->idEstructura;
                                
                                if (isset($_SESSION['menu'][$menus->menu->nombre][$estructuras->estructura->nombre]['superior'])) {
                                
                                    for ($i=0; $i < count($_SESSION['menu'][$menus->menu->nombre][$estructuras->estructura->nombre]['superior']['id']);$i++) { 
                                        
                                        if ($_SESSION['menu'][$menus->menu->nombre][$estructuras->estructura->nombre]['superior']['id'][$i] != $estructuras->id) {

                                            $_SESSION['menu'][$menus->menu->nombre][$estructuras->estructura->nombre]['superior']['id'][] = $estructuras->id;
                                            $_SESSION['menu'][$menus->menu->nombre][$estructuras->estructura->nombre]['superior']['nombre'][] = $estructuras->nombre;
                                            $_SESSION['menu'][$menus->menu->nombre][$estructuras->estructura->nombre]['superior']['accion'][] = $estructuras->accion;
                                            $_SESSION['menu'][$menus->menu->nombre][$estructuras->estructura->nombre]['superior']['icono'][] = $estructuras->icono;
                                        
                                        }else{
                                            break;
                                        }
                                
                                    }
                                }else{
                                    $_SESSION['menu'][$menus->menu->nombre][$estructuras->estructura->nombre]['superior']['id'][] = $estructuras->id;
                                    $_SESSION['menu'][$menus->menu->nombre][$estructuras->estructura->nombre]['superior']['nombre'][] = $estructuras->nombre;
                                    $_SESSION['menu'][$menus->menu->nombre][$estructuras->estructura->nombre]['superior']['accion'][] = $estructuras->accion;
                                    $_SESSION['menu'][$menus->menu->nombre][$estructuras->estructura->nombre]['superior']['icono'][] = $estructuras->icono;
                                }
                            }
                        }

                    }
                   
                }
            }

        }

    }


    public function menuAplicaciones(){
        $user = \Auth::User();
        $perfil = PerfilUsuario::where('idUsuario',$user->id)->first();
        $perfilOpcion = PerfilOpcion::where('idPerfil',$perfil->id)->get();
        $estructura = Estructura::all();
        $estructuraSuperior = Estructura::where('superior',null)->get();
        
        
        $valor = array();
        $aplicacionNombre = null;

        foreach ($estructura as $superior){
            
            foreach ($perfilOpcion  as $OpcionPerfil) {
                

                    if($OpcionPerfil->opcion->idEstructura == $superior->id){

                        foreach ($estructuraSuperior as $aplicacion) {

                            if ($superior->superior == $aplicacion->id) {

                                if($aplicacionNombre <> $aplicacion->nombre){
                                    $valor['id'][] = $aplicacion->id;
                                    $valor['nombre'][]= $aplicacion->nombre;
                                    $valor['accion'][] = $aplicacion->accion;
                                    $valor['icono'][] = $aplicacion->icono;

                                    $aplicacionNombre = $aplicacion->nombre;
                                }

                            }
                           
                        }
                       
                    }
               
            }
        }

        $_SESSION['menu']['aplicaciones'] = $valor;

    }


}
