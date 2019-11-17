<?php

namespace LinkApp\Helpers;

use Illuminate\Support\Facades\DB;
USE Illuminate\Support\Collection;
use LinkApp\Models\ERP\Opcion;
use LinkApp\Models\ERP\PerfilUsuario;
use LinkApp\Models\ERP\PerfilOpcion;
use LinkApp\Models\ERP\UsuarioOpcion;
use PhpParser\Node\Stmt\Else_;

class TraerMenus{

    
    public static function traerTodo()
    {
        $user = \Auth::User();
        $perfil = PerfilUsuario::where('idUsuario',$user->id)->get();
        $userOpcion = UsuarioOpcion::where('idUsuario',$user->id)->get();
        
        $menus = new TraerMenus();
        
        if($perfil || $userOpcion){

            session(['estructura' => $menus->menuGeneral($perfil,$user)]);

        }


    }



    public function menuGeneral($perfil,$user){

        $PerfilUser = array();

        if ($perfil) {
            foreach($perfil as $perfiles){
                $PerfilUser[] = $perfiles->idPerfil;
            }
        }else{
            $PerfilUser = [0];
        }



        $MENU3 = DB::table('menu')
            ->distinct()
            ->join('menu_opcion', 'menu.id', '=', 'menu_opcion.idMenu')
            ->join('opcion', 'menu_opcion.idOpcion', '=', 'opcion.id')
            ->join('perfil_opcion', 'opcion.id', '=', 'perfil_opcion.idOpcion')
            ->join('perfil', 'perfil_opcion.idPerfil', '=', 'perfil.id')
            ->join('perfil_usuario', 'perfil.id', '=', 'perfil_usuario.idPerfil')
            ->join('persona', 'persona.id', '=', 'perfil_usuario.idCompania')
            ->select(
                'opcion.id','persona.nombre as nombreCompania', 'perfil_usuario.idCompania', 'menu.codigo','menu_opcion.orden','opcion.nombre',
                'opcion.descripcion','opcion.icono','opcion.accion','opcion.superior',
                'perfil_opcion.rolModificar','perfil_opcion.rolEliminar','perfil_opcion.rolInsertar',
                'perfil_opcion.rolAdmin','perfil_opcion.rolSuper'
                )
            ->whereIn('perfil_opcion.idPerfil', $PerfilUser);

        $MENU2 = DB::table('opcion')
            ->distinct()
            ->leftJoin('perfil_opcion', 'opcion.id', '=', 'perfil_opcion.idOpcion')
            ->leftJoin('menu_opcion', 'menu_opcion.idOpcion', '=', 'opcion.id')
            ->leftJoin('menu', 'menu_opcion.idMenu', '=', 'menu.id')
            ->leftJoin('perfil', 'perfil_opcion.idOpcion', '=', 'perfil.id')
            ->leftJoin('perfil_usuario', 'perfil.id', '=', 'perfil_usuario.idPerfil')
            ->leftJoin('persona', 'persona.id', '=', 'perfil_usuario.idCompania')
            ->select(
                'opcion.id','persona.nombre as nombreCompania','perfil_usuario.idCompania','menu.codigo','menu_opcion.orden','opcion.nombre',
                'descripcion','icono','accion','superior','perfil_opcion.rolModificar',
                'perfil_opcion.rolEliminar','perfil_opcion.rolInsertar',
                'perfil_opcion.rolAdmin','perfil_opcion.rolSuper'
                )
            ->whereIn('opcion.superior', function($query){
                $query->select('id')->from('opcion')->whereNull('superior');
            });


        $MENU4 = DB::table('menu')
            ->distinct()
            ->join('menu_opcion', 'menu.id', '=', 'menu_opcion.idMenu')
            ->join('opcion', 'menu_opcion.idOpcion', '=', 'opcion.id')
            ->join('usuario_opcion', 'opcion.id', '=', 'usuario_opcion.idOpcion')
            ->join('persona', 'persona.id', '=', 'usuario_opcion.idCompania')
            ->select(
                'opcion.id','persona.nombre as nombreCompania', 'usuario_opcion.idCompania', 'menu.codigo','menu_opcion.orden','opcion.nombre',
                'opcion.descripcion','opcion.icono','opcion.accion','opcion.superior',
                'usuario_opcion.rolModificar','usuario_opcion.rolEliminar','usuario_opcion.rolInsertar',
                'usuario_opcion.rolAdmin','usuario_opcion.rolSuper'
                )
            ->where('usuario_opcion.idUsuario', $user->id);


        $MENU = DB::table('opcion')
            ->distinct()
            ->leftJoin('perfil_opcion', 'opcion.id', '=', 'perfil_opcion.idOpcion')
            ->leftJoin('menu_opcion', 'menu_opcion.idOpcion', '=', 'opcion.id')
            ->leftJoin('menu', 'menu_opcion.idMenu', '=', 'menu.id')
            ->leftJoin('perfil', 'perfil_opcion.idOpcion', '=', 'perfil.id')
            ->leftJoin('perfil_usuario', 'perfil.id', '=', 'perfil_usuario.idPerfil')
            ->leftJoin('persona', 'persona.id', '=', 'perfil_usuario.idCompania')
            ->select(
                'opcion.id','persona.nombre as nombreCompania','perfil_usuario.idCompania','menu.codigo','menu_opcion.orden','opcion.nombre',
                'descripcion','icono','accion','superior','perfil_opcion.rolModificar',
                'perfil_opcion.rolEliminar','perfil_opcion.rolInsertar',
                'perfil_opcion.rolAdmin','perfil_opcion.rolSuper'
                )
            ->whereIn('opcion.id', function($query){
                $query->select('id')->from('opcion')->whereNull('superior');
            })
            ->union($MENU2)
            ->union($MENU3)
            ->union($MENU4)
            ->orderBy('idCompania', 'ASC')
            ->orderBy('codigo', 'ASC')
            //->orderBy('orden', 'ASC')
            ->orderBy('superior', 'ASC')
            ->orderBy('id', 'ASC')
            ->get();


        return $this->menusUsuario($MENU);
        
    }


    function menusUsuario($menu) {
        $array = array();
        $valor = array();
        $valor2 = array();
        $MENU_APLICACIONES = array();
        $app = array();
        $modulos = array();
        $opciones = array();
        $COMPANIA = 0;
        $CODIGO = null;
       // $menus = array();
        $MODULO = 0;

        foreach ($menu as $menus) {
            //Agrupa las app y modulos en arrays para ser recorridos por las opciones
            if($menus->superior == null){
                $app[] =['id'=>$menus->id,'superior'=>$menus->superior,'nombre' => $menus->nombre,'accion' => $menus->accion,'icono' => $menus->icono, 'opciones' => []];
            }else if($menus->codigo == null){
                $modulos [] = ['id'=>$menus->id,'superior'=>$menus->superior,'nombre' => $menus->nombre,'accion' => $menus->accion,'icono' => $menus->icono, 'opciones' => []] ;
            }

            //Inicio
            if ($menus->codigo != null) {

                for ($j=0; $j < count($app); $j++) { 
                    for ($i=0; $i < count($modulos); $i++) { 
                        if ($modulos[$i]['superior'] == $app[$j]['id']) {


                            if ($modulos[$i]['id'] == $menus->superior ) {
    
                             //Almacenamiento de las opciones
                                $opciones = json_decode(json_encode($menus), true);

                                //Reseteo de arrays
                                        if ($menus->codigo != $CODIGO) {
                                            $valor = array();
                                        }

                                        if ($menus->idCompania != $COMPANIA) {
                                         
                                            $valor = array();
                                            $MENU_APLICACIONES = array();
                                         
                                        }


                                        //Agrupamiento de las app con sus modulos y opciones

                                        if (!empty($valor2)) {

                                            if ($MODULO == $modulos[$i]['id']) {
                                                
                                                for ($h=0; $h < count($valor2); $h++) {
                                                    
                                                    if (isset($valor2[$h]['id']) && $valor2[$h]['id'] == $menus->superior) {

                                                        $valor2[$h]['opciones'][] = $opciones;


                                                       if (isset($valor[$j]['opciones'])) {

                                                           for ($p=0; $p < count($valor[$j]['opciones']); $p++) { 
                                                               if ($valor[$j]['opciones'][$p]['id'] == $valor2[$h]['id'] ) {
                                                                   
                                                                    $valor[$j]['id'] = $app[$j]['id'];
                                                                    $valor[$j]['nombre'] = $app[$j]['nombre'];
                                                                    $valor[$j]['accion'] = $app[$j]['accion'];
                                                                    $valor[$j]['icono'] = $app[$j]['icono'];
                                                                    $valor[$j]['opciones'][$p] = $valor2[$h];


                                                                    //Creacion menu de aplicaciones
                                                                    $MENU_APLICACIONES[$j]['id'] = $app[$j]['id'];
                                                                    $MENU_APLICACIONES[$j]['nombre'] = $app[$j]['nombre'];
                                                                    $MENU_APLICACIONES[$j]['accion'] = $app[$j]['accion'];
                                                                    $MENU_APLICACIONES[$j]['icono'] = $app[$j]['icono'];
                                                               }
                                                               
                                                           }
                                                           
                                                       }else{
                                                            $valor[$j]['id'] = $app[$j]['id'];
                                                            $valor[$j]['nombre'] = $app[$j]['nombre'];
                                                            $valor[$j]['accion'] = $app[$j]['accion'];
                                                            $valor[$j]['icono'] = $app[$j]['icono'];
                                                            $valor[$j]['opciones'][] = $valor2[$h];


                                                            //Creacion menu de aplicaciones
                                                            $MENU_APLICACIONES[$j]['id'] = $app[$j]['id'];
                                                            $MENU_APLICACIONES[$j]['nombre'] = $app[$j]['nombre'];
                                                            $MENU_APLICACIONES[$j]['accion'] = $app[$j]['accion'];
                                                            $MENU_APLICACIONES[$j]['icono'] = $app[$j]['icono'];
                                                       }
                                                    
                                                    }
                                                }
                                                
                                            }else{
        
                                                $rango = count($valor2);
                                                $valor2[$rango] = $modulos [$i];
                                                $valor2[$rango]['opciones'][] = $opciones;

                                                $rango2 = count($valor);
                                                $valor[$rango2]['id'] = $app[$j]['id'];
                                                $valor[$rango2]['nombre'] = $app[$j]['nombre'];
                                                $valor[$rango2]['accion'] = $app[$j]['accion'];
                                                $valor[$rango2]['icono'] = $app[$j]['icono'];
                                                $valor[$rango2]['opciones'][] = $valor2[$rango];
                                                $MODULO =  $modulos[$i]['id'];
                                                

                                                //Creacion menu de aplicaciones
                                                $MENU_APLICACIONES[$j]['id'] = $app[$j]['id'];
                                                $MENU_APLICACIONES[$j]['nombre'] = $app[$j]['nombre'];
                                                $MENU_APLICACIONES[$j]['accion'] = $app[$j]['accion'];
                                                $MENU_APLICACIONES[$j]['icono'] = $app[$j]['icono'];
                                               
                                            }

                                            
                                        }else{

                                            $rango = count($valor2);
                                            $valor2[0] = $modulos [$i];
                                            $valor2[0]['opciones'][] = $opciones;

                                            $rango2 = count($valor);
                                            $valor[$rango2]['id'] = $app[$j]['id'];
                                            $valor[$rango2]['nombre'] = $app[$j]['nombre'];
                                            $valor[$rango2]['accion'] = $app[$j]['accion'];
                                            $valor[$rango2]['icono'] = $app[$j]['icono'];
                                            $valor[$rango2]['opciones'][] = $valor2[0];
                                            $MODULO =  $modulos[$i]['id'];
                                            
                                        }

                                    //Asigna la compania a los menus
                                    if (!empty($array)) {

                                        if ($COMPANIA == $menus->idCompania) {

                                            for ($h=0; $h < count($array); $h++) { 
                                                if (isset($array[$h]['idCompania']) && $array[$h]['idCompania'] == $menus->idCompania) {

                                                    $array[$h]['menus'][$menus->codigo] = $valor;

                                                    //asigna menu de aplicaciones a su respectiva compania
                                                    $array[$h]['menus']['MENU_APLICACIONES'] = $MENU_APLICACIONES;

                                                    break;
                                                }
                                            }

                                        }else{
                                            $rango = count($array);
                                            $array[$rango]['idCompania'] = $menus->idCompania;
                                            $array[$rango]['nombre'] = $menus->nombreCompania;
                                            $array[$rango]['menus'][$menus->codigo] = $valor;
                                            

                                            //asigna menu de aplicaciones a su respectiva compania
                                            $array[$rango]['menus']['MENU_APLICACIONES'] = $MENU_APLICACIONES;

                                            //variables para el reset de los arrays de arriba
                                            $CODIGO = $menus->codigo;
                                            $COMPANIA = $menus->idCompania;
                                        
                                        }
                                        
                                    }else{

                                        $array[0]['idCompania'] = $menus->idCompania;
                                        $array[0]['nombre'] = $menus->nombreCompania;
                                        $array[0]['menus'][$menus->codigo] = $valor;

                                        //asigna menu de aplicaciones a su respectiva compania
                                        $array[0]['menus']['MENU_APLICACIONES'] = $MENU_APLICACIONES;

                                        //variables para el reset de los arrays de arriba
                                        $CODIGO = $menus->codigo;
                                        $COMPANIA = $menus->idCompania;
                                        
                                    }
  
                            }
                        }
                    }
                }

            }
        }

      /* echo json_encode($array);
       die;*/

        return $array;
    }  
    



}
