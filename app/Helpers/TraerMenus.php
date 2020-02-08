<?php

namespace LinkApp\Helpers;

use Illuminate\Support\Facades\DB;
USE Illuminate\Support\Collection;
use LinkApp\Models\ERP\Opcion;
use LinkApp\Models\ERP\PerfilUsuario;
use LinkApp\Models\ERP\PerfilOpcion;
use LinkApp\Models\ERP\UsuarioOpcion;


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



        $MENU = DB::table('menu')
            ->distinct()
            ->join('menu_opcion', 'menu.id', '=', 'menu_opcion.idMenu')
            ->join('opcion', 'menu_opcion.idOpcion', '=', 'opcion.id')
            ->join('opcion as modulo', 'opcion.superior', '=', 'modulo.id')
            ->join('opcion as aplicacion', 'modulo.superior', '=', 'aplicacion.id')
            ->join('perfil_opcion', 'opcion.id', '=', 'perfil_opcion.idOpcion')
            ->join('perfil', 'perfil_opcion.idPerfil', '=', 'perfil.id')
            ->join('perfil_usuario', 'perfil.id', '=', 'perfil_usuario.idPerfil')
            ->join('persona', 'persona.id', '=', 'perfil_usuario.idCompania')
            ->select(
                'opcion.id','menu.codigo','menu_opcion.orden','opcion.nombre',
                'opcion.descripcion','opcion.icono','opcion.accion','opcion.superior as idModulo',
                'modulo.descripcion as descripcionModulo','modulo.icono as iconoModulo','modulo.accion as accionModulo',
                'modulo.nombre as nombreModulo','modulo.superior as idAplicacion',
                'aplicacion.descripcion as descripcionAplicacion','aplicacion.icono as iconoAplicacion','aplicacion.nombre as nombreAplicacion',
                'perfil_opcion.rolModificar','perfil_opcion.rolEliminar','perfil_opcion.rolInsertar',
                'perfil_opcion.rolAdmin','perfil_opcion.rolSuper'
                )
            ->whereIn('perfil_opcion.idPerfil', $PerfilUser)->get();
/*
        $MENU2 = DB::table('opcion')
            ->distinct()
            ->leftJoin('perfil_opcion', 'opcion.id', '=', 'perfil_opcion.idOpcion')
            ->leftJoin('menu_opcion', 'menu_opcion.idOpcion', '=', 'opcion.id')
            ->leftJoin('menu', 'menu_opcion.idMenu', '=', 'menu.id')
            ->leftJoin('perfil', 'perfil_opcion.idOpcion', '=', 'perfil.id')
            ->leftJoin('perfil_usuario', 'perfil.id', '=', 'perfil_usuario.idPerfil')
            ->leftJoin('persona', 'persona.id', '=', 'perfil_usuario.idCompania')
            ->select(
                'opcion.id','persona.nombre as nombreCompania','persona.img as imagenCompania','perfil_usuario.idCompania','menu.codigo','menu_opcion.orden','opcion.nombre',
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
                'opcion.id','persona.nombre as nombreCompania','persona.img as imagenCompania', 'usuario_opcion.idCompania', 'menu.codigo','menu_opcion.orden','opcion.nombre',
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
                'opcion.id','persona.nombre as nombreCompania','persona.img as imagenCompania','perfil_usuario.idCompania','menu.codigo','menu_opcion.orden','opcion.nombre',
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
*/

        return $this->menusUsuario($MENU);
        
    }


    function menusUsuario($menu) {

        $array = [];
        
        //$pos2 = false;
       // $pos = false;

        foreach ($menu as $estrutura) {

            $pos = false;

            $aplicacion = array('id' => $estrutura->idAplicacion,'nombre' => $estrutura->nombreAplicacion,
                                'descripcion' => $estrutura->descripcionAplicacion,'icono' => $estrutura->iconoAplicacion,'opciones' => []);

            if(!isset($array[$estrutura->codigo])){
                $array[$estrutura->codigo][] = $aplicacion;
            }

            for ($i=0; $i < count($array[$estrutura->codigo]); $i++) { 

                if (isset($array[$estrutura->codigo][$i]['id'])) {

                    $pos = in_array($aplicacion['id'],$array[$estrutura->codigo][$i]);

                    if ($pos) {
                        break;
                    }
                }

            }
           

            if (!$pos) {
                $array[$estrutura->codigo][] = $aplicacion;
           }

           for ($i=0; $i < count($array[$estrutura->codigo]) ; $i++) { 

                $modulo = array('id'=>$estrutura->idModulo,'nombre'=>$estrutura->nombreModulo,'descripcion' => $estrutura->descripcionModulo,
                                'icono' => $estrutura->iconoModulo,'accion' => $estrutura->accionModulo, 'opciones' => []);

                $pos2 = false;
                
                for ($j=0; $j < count($array[$estrutura->codigo][$i]); $j++) { 

                    if (isset($array[$estrutura->codigo][$i]['opciones'][$j]['id'])) {
    
                        $pos2 = in_array($modulo['id'],$array[$estrutura->codigo][$i]['opciones'][$j]);
    
                        if ($pos2) {
                            break;
                        }
                    }
    
                }

                if (!$pos2 && $array[$estrutura->codigo][$i]['id'] == $estrutura->idAplicacion) {
                    $array[$estrutura->codigo][$i]['opciones'][] = $modulo;

                }


            
            }

            for ($i=0; $i < count($array[$estrutura->codigo]); $i++) { 

                for ($j=0; $j < count($array[$estrutura->codigo][$i]['opciones']); $j++) { 

                    $opcion = array('id'=>$estrutura->id,'nombre'=>$estrutura->nombre,'descripcion' => $estrutura->descripcion,
                                    'icono' => $estrutura->icono,'accion' => $estrutura->accion);

                    $pos = in_array($opcion,$array[$estrutura->codigo][$i]['opciones'][$j]['opciones']);
    
                    if ($array[$estrutura->codigo][$i]['opciones'][$j]['id'] == $estrutura->idModulo && !$pos) {
    
                        $array[$estrutura->codigo][$i]['opciones'][$j]['opciones'][] = $opcion;
                        
                    }
                    
                }
                
            }
            
           
        } 

        
        echo json_encode($array);
        die;

        return $array;
    }  
    



}
