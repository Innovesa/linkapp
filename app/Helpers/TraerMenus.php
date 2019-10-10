<?php

namespace LinkApp\Helpers;

use LinkApp\Models\ERP\Aplicacion;
use LinkApp\Models\ERP\PerfilUsuario;
use LinkApp\Models\ERP\PerfilOpcion;
use LinkApp\Models\ERP\UsuarioOpcion;


class TraerMenus{

    
    public static function traerTodo()
    {
        $user = \Auth::User();
        $perfil = PerfilUsuario::where('idUsuario',$user->id)->get();
        
        $menus = new TraerMenus();
        if($perfil){

            $_SESSION['Estructura'] = $menus->menuGeneral($perfil); 
            /*var_dump($_SESSION['Estructura']['menus']['contextual'][0]); 
            die;*/
            $_SESSION['aplicacion'] = 1;
        }



    }



    public function menuGeneral($perfil){

        $aplicacion['menus'] = array();


        //Trae las opciones del perfil que tiene asignado el usuario
        
        foreach($perfil as $perfiles){

            $estructura = PerfilOpcion::where('idPerfil',$perfiles->idPerfil)->get();
            $l = 0;
            if(isset($estructura)){
                foreach ($estructura as $menus) {

                
                    foreach ($menus->opcion->menuOpcion as $prueba) {
        
                            if ($prueba->idOpcion == $menus->opcion->id) {
                                $items0 = array();
                                $items0['id'] = $menus->opcion->estructura->estructura->id;
                                $items0['nombre'] = $menus->opcion->estructura->estructura->nombre;
                                $items0['accion'] = $menus->opcion->estructura->estructura->accion;
                                $items0['icono'] = $menus->opcion->estructura->estructura->icono;
                                $items0['descripcion'] = $menus->opcion->estructura->estructura->descripcion;
                                //$items['items'] = array();
                                $aplicacion['menus']['aplicaciones'][] = $items0;

                            if(isset( $aplicacion['menus'])){
                                
                                    if(!isset( $aplicacion['menus'][$prueba->menu->nombre])){
                                        $items = array();
                                        $items['id'] = $menus->opcion->estructura->estructura->id;
                                        $items['nombre'] = $menus->opcion->estructura->estructura->nombre;
                                        $items['accion'] = $menus->opcion->estructura->estructura->accion;
                                        $items['icono'] = $menus->opcion->estructura->estructura->icono;
                                        $items['descripcion'] = $menus->opcion->estructura->estructura->descripcion;
                                        //$items['items'] = array();
                                        $aplicacion['menus'][$prueba->menu->nombre][] = $items;
                                        
                                    }else{
                                        $h = count($aplicacion['menus'][$prueba->menu->nombre])-1;
                                        $valor = true;
                                        for ($i=0; $i<=$h ; $i++) { 
                                            if($aplicacion['menus'][$prueba->menu->nombre][$i]['id'] == $menus->opcion->estructura->estructura->id){
                                                $valor = false;
                                            }
                                        }

                                        if($valor == true){
                                            $items2 = array();
                                            $items2['id'] = $menus->opcion->estructura->estructura->id;
                                            $items2['nombre'] = $menus->opcion->estructura->estructura->nombre;
                                            $items2['accion'] = $menus->opcion->estructura->estructura->accion;
                                            $items2['icono'] = $menus->opcion->estructura->estructura->icono;
                                            $items2['descripcion'] = $menus->opcion->estructura->estructura->descripcion;
                                            //$items2['items'] = array();
                                            $aplicacion['menus'][$prueba->menu->nombre][] = $items2;
                                        }
                                    }
                                    


                                    if(isset( $aplicacion['menus'][$prueba->menu->nombre])){
                                        $h = count($aplicacion['menus'][$prueba->menu->nombre])-1;
                                        

                                        for ($i=0; $i <= $h ; $i++) { 
    
                                            if (isset($aplicacion['menus'][$prueba->menu->nombre][$i]['items'])) {
                                            
                                            
                                                $j = count($aplicacion['menus'][$prueba->menu->nombre][$i]['items'])-1;
                                                $valor2 = false;
                                                for ($p=0; $p <= $j; $p++) { 
                                                    
                                                    if ($aplicacion['menus'][$prueba->menu->nombre][$i]['id'] == $menus->opcion->estructura->superior) {

                                                        if($aplicacion['menus'][$prueba->menu->nombre][$i]['items'][$p]['id'] != $menus->opcion->estructura->id){
                                                            $valor2 = true;
                                                        }else{
                                                            $valor2 = false;
                                                        }
        
                                                    }


                                                }

                                                if ($valor2) {
                                                    $items3 = array();
                                                    $items3['id'] = $menus->opcion->estructura->id;
                                                    $items3['nombre'] = $menus->opcion->estructura->nombre;
                                                    $items3['accion'] = $menus->opcion->estructura->accion;
                                                    $items3['icono'] = $menus->opcion->estructura->icono;
                                                    $items3['descripcion'] = $menus->opcion->estructura->descripcion;
                                                    $items3['superior'] = $menus->opcion->estructura->superior;
                                                // $items3['items'] = array();
                                                    $aplicacion['menus'][$prueba->menu->nombre][$i]['items'][] = $items3;
                                                }

                                                


                                            }else{
                                                
                                                $items3 = array();
                                                $items3['id'] = $menus->opcion->estructura->id;
                                                $items3['nombre'] = $menus->opcion->estructura->nombre;
                                                $items3['accion'] = $menus->opcion->estructura->accion;
                                                $items3['icono'] = $menus->opcion->estructura->icono;
                                                $items3['descripcion'] = $menus->opcion->estructura->descripcion;
                                                $items3['superior'] = $menus->opcion->estructura->superior;
                                                //$items3['items'] = array();
                                                $aplicacion['menus'][$prueba->menu->nombre][$i]['items'][] = $items3; 
                                            }
                                        }


                                    }

                                    if(isset( $aplicacion['menus'][$prueba->menu->nombre])){
                                        $h = count($aplicacion['menus'][$prueba->menu->nombre])-1;

                                        for ($i=0; $i <= $h ; $i++) { 

                                            $j = count($aplicacion['menus'][$prueba->menu->nombre][$i]['items'])-1;

                                            for ($p=0; $p <= $j; $p++) { 

                                                if($aplicacion['menus'][$prueba->menu->nombre][$i]['items'][$p]['id'] == $menus->opcion->superior){
        
                                                    $items4 = array();
                                                    $items4['id'] = $menus->opcion->id;
                                                    $items4['nombre'] = $menus->opcion->nombre;
                                                    $items4['accion'] = $menus->opcion->accion;
                                                    $items4['icono'] = $menus->opcion->icono;
                                                    $items4['descripcion'] = $menus->opcion->descripcion;
                                                    $items4['superior'] = $menus->opcion->superior;
                                                    $items4['items'] = array();
                                                    $aplicacion['menus'][$prueba->menu->nombre][$i]['items'][$p]['items'][] = $items4;
                
                                                }

                                            }
                                        }
                                    }   
                                }
                                
                            }
            
                    }
                }

            }
        }

        //Trae las opciones individales del usuario

        $estructuraUsuario = UsuarioOpcion::where('idUsuario',\Auth::User()->id)->get();

        if(isset($estructuraUsuario)){
            foreach ($estructuraUsuario as $menus) {

            
                foreach ($menus->opcion->menuOpcion as $prueba) {
    
                        if ($prueba->idOpcion == $menus->opcion->id) {

                           if(isset( $aplicacion['menus'])){

                                    $items0 = array();
                                    $items0['id'] = $menus->opcion->estructura->estructura->id;
                                    $items0['nombre'] = $menus->opcion->estructura->estructura->nombre;
                                    $items0['accion'] = $menus->opcion->estructura->estructura->accion;
                                    $items0['icono'] = $menus->opcion->estructura->estructura->icono;
                                    $items0['descripcion'] = $menus->opcion->estructura->estructura->descripcion;
                                    //$items['items'] = array();
                                    $aplicacion['menus']['aplicaciones'][] = $items0;
                          
                                if(!isset( $aplicacion['menus'][$prueba->menu->nombre])){
                                    $items = array();
                                    $items['id'] = $menus->opcion->estructura->estructura->id;
                                    $items['nombre'] = $menus->opcion->estructura->estructura->nombre;
                                    $items['accion'] = $menus->opcion->estructura->estructura->accion;
                                    $items['icono'] = $menus->opcion->estructura->estructura->icono;
                                    $items['descripcion'] = $menus->opcion->estructura->estructura->descripcion;
                                    //$items['items'] = array();
                                    $aplicacion['menus'][$prueba->menu->nombre][] = $items;
                                    
                                }else{
                                    $h = count($aplicacion['menus'][$prueba->menu->nombre])-1;
                                    $valor = true;
                                    for ($i=0; $i<=$h ; $i++) { 
                                        if($aplicacion['menus'][$prueba->menu->nombre][$i]['id'] == $menus->opcion->estructura->estructura->id){
                                            $valor = false;
                                        }
                                    }

                                    if($valor == true){
                                        $items2 = array();
                                        $items2['id'] = $menus->opcion->estructura->estructura->id;
                                        $items2['nombre'] = $menus->opcion->estructura->estructura->nombre;
                                        $items2['accion'] = $menus->opcion->estructura->estructura->accion;
                                        $items2['icono'] = $menus->opcion->estructura->estructura->icono;
                                        $items2['descripcion'] = $menus->opcion->estructura->estructura->descripcion;
                                        //$items2['items'] = array();
                                        $aplicacion['menus'][$prueba->menu->nombre][] = $items2;
                                    }
                                }
                                   


                                if(isset( $aplicacion['menus'][$prueba->menu->nombre])){
                                    $h = count($aplicacion['menus'][$prueba->menu->nombre])-1;
                                    

                                    for ($i=0; $i <= $h ; $i++) { 
 
                                        if (isset($aplicacion['menus'][$prueba->menu->nombre][$i]['items'])) {
                                           
                                           
                                            $j = count($aplicacion['menus'][$prueba->menu->nombre][$i]['items'])-1;
                                            $valor2 = false;
                                            for ($p=0; $p <= $j; $p++) { 
                                                
                                                if ($aplicacion['menus'][$prueba->menu->nombre][$i]['id'] == $menus->opcion->estructura->superior) {

                                                    if($aplicacion['menus'][$prueba->menu->nombre][$i]['items'][$p]['id'] != $menus->opcion->estructura->id){
                                                        $valor2 = true;
                                                    }else{
                                                        $valor2 = false;
                                                    }
       
                                                }


                                            }

                                            if ($valor2) {
                                                $items3 = array();
                                                $items3['id'] = $menus->opcion->estructura->id;
                                                $items3['nombre'] = $menus->opcion->estructura->nombre;
                                                $items3['accion'] = $menus->opcion->estructura->accion;
                                                $items3['icono'] = $menus->opcion->estructura->icono;
                                                $items3['descripcion'] = $menus->opcion->estructura->descripcion;
                                                $items3['superior'] = $menus->opcion->estructura->superior;
                                               // $items3['items'] = array();
                                                $aplicacion['menus'][$prueba->menu->nombre][$i]['items'][] = $items3;
                                            }

                                            


                                        }else{
                                            
                                            $items3 = array();
                                            $items3['id'] = $menus->opcion->estructura->id;
                                            $items3['nombre'] = $menus->opcion->estructura->nombre;
                                            $items3['accion'] = $menus->opcion->estructura->accion;
                                            $items3['icono'] = $menus->opcion->estructura->icono;
                                            $items3['descripcion'] = $menus->opcion->estructura->descripcion;
                                            $items3['superior'] = $menus->opcion->estructura->superior;
                                            //$items3['items'] = array();
                                            $aplicacion['menus'][$prueba->menu->nombre][$i]['items'][] = $items3; 
                                        }
                                    }


                                }

                                if(isset( $aplicacion['menus'][$prueba->menu->nombre])){
                                    $h = count($aplicacion['menus'][$prueba->menu->nombre])-1;

                                    for ($i=0; $i <= $h ; $i++) { 

                                        $j = count($aplicacion['menus'][$prueba->menu->nombre][$i]['items'])-1;

                                        for ($p=0; $p <= $j; $p++) { 

                                            if($aplicacion['menus'][$prueba->menu->nombre][$i]['items'][$p]['id'] == $menus->opcion->superior){
     
                                                $items4 = array();
                                                $items4['id'] = $menus->opcion->id;
                                                $items4['nombre'] = $menus->opcion->nombre;
                                                $items4['accion'] = $menus->opcion->accion;
                                                $items4['icono'] = $menus->opcion->icono;
                                                $items4['descripcion'] = $menus->opcion->descripcion;
                                                $items4['superior'] = $menus->opcion->superior;
                                                $items4['items'] = array();
                                                $aplicacion['menus'][$prueba->menu->nombre][$i]['items'][$p]['items'][] = $items4;
               
                                            }

                                        }
                                    }
                                }   
                            }
                            
                        }
        
                }
            }
        }

        $aplicacion['menus']['aplicaciones'] = $this->unique_multidim_array($aplicacion['menus']['aplicaciones'],'id');


       return $aplicacion;
    }


    function unique_multidim_array($array, $key) {
        $temp_array = array();
        $i = 0;
        $key_array = array();
       
        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }


}
