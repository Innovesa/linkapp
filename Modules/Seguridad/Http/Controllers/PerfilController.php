<?php

namespace Modules\Seguridad\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use LinkApp\Http\Controllers\Controller;
use LinkApp\Models\ERP\Estado;
use LinkApp\Models\ERP\Permiso;
use Illuminate\Support\Facades\DB;
use LinkApp\Models\ERP\Perfil;
use Illuminate\Support\Facades\Hash;
use LinkApp\Models\ERP\Opcion;
use LinkApp\Models\ERP\Perfilperfil;
use LinkApp\Models\ERP\PerfilOpcion;
use Validator;

class PerfilController extends Controller
{
     public function __construct()
    {
       $this->middleware('auth');
    }

    public function index()
    {
    
        $permiso = new Permiso();

        if ($permiso->AccessPermission()) {

            session(['currentUrl' => url()->current()]);
    

            return view('seguridad::perfiles.index');

        } else{
            return redirect("/home");
        }
        

    }

    //Trae los botones si tiene el permiso
    public function getButtons($nombre,$objeto)
    {
        $permiso = new Permiso();

        if ($nombre == 'modify' && $permiso->ModifyPermission()) {

            return '<a id="editar"  data-route="'.route('seguridad.perfiles.updateData',['id' => $objeto->id]).'" data-toggle="modal" href="#modalMantenimiento" class="btn-primary btn btn-xs"><i class="fa fa-pencil"></i>'.@trans('entidades::entidades.editar').'</a>';

        }

        if ($nombre == 'activate' && $permiso->DeletePermission()) {

            return '<button id="estado" data-route="'.route('seguridad.perfiles.activar',['id' =>$objeto->id]).'" class="btn-primary btn btn-xs"> <i class="fa fa-times"></i>'.@trans('entidades::entidades.activar').'</button>';

        }
        
        if ($nombre == 'deactivate' && $permiso->DeletePermission()) {

            return '<button id="estado" data-route="'.route('seguridad.perfiles.desactivar',['id' =>$objeto->id]).'" class="btn-primary btn btn-xs"> <i class="fa fa-times"></i>'.@trans('entidades::entidades.desactivar').'</button>';

        }

        if ($nombre == 'delete' && $permiso->AdminPermission()) {

            return '<button id="eliminar" data-route="'.route('seguridad.perfiles.eliminar',['id' =>$objeto->id]).'" class="btn-primary btn btn-xs"> <i class="fa fa-times"></i>'.@trans('entidades::entidades.eliminar').'</button>';

        }


    }

    //crea o actualiza si tiene el id
    public function createUpdate(Request $resquest)
    {
        $permiso = new Permiso();

       if (!$resquest->input('id')) {

            if ($permiso->InsertPermission()) {

                return $this->create($resquest);
            }
            
       }else{

           if ($permiso->ModifyPermission()) {

                return $this->update($resquest);

           }

       }
       
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function update(Request $resquest)
    {
          //conseguir perfil identificado

    
       $id = $resquest->input('id');

       $perfil = Perfil::find($id);
       
       //validate del formulario
      
       $validator = Validator::make($resquest->all(),[
            'nombre' => ['required', 'string', 'max:45', 'unique:perfil,username,'.$id],
        ]);
        
        if($validator->fails()){
            return response()->json([
                    'errors' => $validator->getMessageBag()->toArray()
                ]);
        }


        //recoger daots del formulario
        $username = $resquest->input('username');
        $email = $resquest->input('email');
        $idPersona = $resquest->input('idPersona');

        //Asignar nuevos valores al objeto del perfil
        $perfil->id = $id;
        $perfil->username = $username;
        $perfil->email = $email;
        $perfil->idPersona = $idPersona;

        

        //transaction start
        DB::beginTransaction();

        try {

            //Ejecutar consulta y cambios en la bae de datos
            $perfil->update();

        } catch (Exception $e) {

            DB::rollback();

            return response()->json(['errors'=>$e->getMessage()]);

        }

        //registro de perfiles 

        $permiso = new Permiso();

        try {
 


            if($resquest->input('perfilPerfiles')){


                $perfiles = explode(",",$resquest->input('perfilPerfiles'));

                for ($i=0; $i < count($perfiles); $i++) { 
                    
    
                    $validationPerfil = PerfilPerfil::where('idPerfil',$perfiles[$i])->where('idPerfil',$id)->first();
    
                    if (!$validationPerfil) {

                        $perfilOpcion = new Perfilperfil();
    
                        $perfilOpcion->idPerfil = $id;
                        $perfilOpcion->idPerfil = $perfiles[$i];
                        $perfilOpcion->idCompania = session("compania")->id;
    
                        $perfilOpcion->save();
                    }
    
                }

                
                $perfileEliminar = PerfilPerfil::whereNotIn('idPerfil',$perfiles)->where('idPerfil',$id)->get();
                if ($perfileEliminar) {
                    foreach ($perfileEliminar as $perfil) {
                        $perfil->delete();
                    }
                }

            }else{

                if ($permiso->SuperPermission()) {

                    $perfiles = PerfilPerfil::where('idPerfil',$id)->delete();
                    if ($perfiles) {
                        foreach ($perfiles as $perfil) {
                            $perfil->delete();
                        }
                    }

                }else{

                    $perfiles = PerfilPerfil::where('idCompania',session('compania')->id)->where('idPerfil',$id)->get();
                    if ($perfiles) {
                        foreach ($perfiles as $perfil) {
                            $perfil->delete();
                        }
                        
                    }
                }

            }
 
 
         } catch (Exception $e) {
 
             DB::rollback();
             return response()->json(['errors'=>$e->getMessage()]);
 
         }
        
        DB::commit();
        //transaction end

        return response()->json(['success'=>@trans('seguridad::seguridad.perfil.actualizada.exito')]);
        
    }


    // update 


    public function create(Request $resquest)
    {
        //conseguir perfil identificado

        
       $perfil = new perfil();

       $estado = new Estado();



       //validate del formulario
       $validator = Validator::make($resquest->all(),[
            'nombre' => ['required', 'string', 'max:45', 'unique:perfil'],
        ]);
        
        if($validator->fails()){
            return response()->json([
                    'errors' => $validator->getMessageBag()->toArray()
                ]);
        }

        //recoger daots del formulario
        $nombre = $resquest->input('nombre');

        //Asignar nuevos valores al objeto del perfil
        $perfil->nombre = $nombre;
        $perfil->idCompania = session("compania")->id;
        $perfil->idEstado = $estado->getidEstadoActivo();

        
        //transaction start
        DB::beginTransaction();

       try {

            //Ejecutar consulta y cambios en la bae de datos
            $perfil->save();


       } catch (Exception $e) {

           DB::rollback();
           return response()->json(['errors'=>$e->getMessage()]);

       }

       $opciones = $resquest->input('rolesOpciones');
       
        try {
 
            if(is_array($opciones)){

                for ($i=0; $i < count($opciones); $i++) { 
                    
                        $perfilOpcion = new PerfilOpcion();
    
                        $perfilOpcion->idPerfil = $perfil->id;
                        $perfilOpcion->idOpcion = $opciones[$i]['idOpcion'];
                        $perfilOpcion->rolModificar = $opciones[$i]['rolModificar'];
                        $perfilOpcion->rolEliminar = $opciones[$i]['rolEliminar'];
                        $perfilOpcion->rolInsertar = $opciones[$i]['rolInsertar'];
                        $perfilOpcion->rolAdmin= $opciones[$i]['rolAdmin'];
                        $perfilOpcion->rolSuper = $opciones[$i]['rolSuper'];
    
                        $perfilOpcion->save();
                }
            }
 
 
         } catch (Exception $e) {
 
             DB::rollback();
             return response()->json(['errors'=>$e->getMessage()]);
 
         }

        DB::commit();
        //transaction end

        return response()->json(['success'=>@trans('seguridad::seguridad.perfil.creada.exito')]);
        
    }

    //Eliminar compañia
    public function eliminar($id)
    {
        $permiso = new Permiso();

        if ($permiso->AdminPermission()) {

            $perfil = Perfil::find($id);

            $perfilOpcion = PerfilOpcion::where('idPerfil',$perfil->id)->get();

            //transaction start
            DB::beginTransaction();

            try {


                if($perfil &&  $perfilOpcion){
                    foreach ($perfilOpcion as $perfiles) {
                        $perfiles->delete();
                    }
                   
                    $perfil->delete(); 
                }


            } catch (Exception $e) {

                DB::rollback();

                //return response()->json(['errors'=>$e->getMessage()]);
                return response()->json(['errors'=> @trans('seguridad::seguridad.perfil.eliminar.error')]);
            }
            
            DB::commit();
            //transaction end
        
            return response()->json(['success'=> @trans('seguridad::seguridad.perfil.eliminar.exito')]);
        }

    }

    //Eliminar compañia
    public function desactivar($id)
    {
        $permiso = new Permiso();

        $estado = new Estado();

        if ($permiso->DeletePermission()) {

            $perfil = Perfil::find($id);
            $perfil->idEstado = $estado->getidEstadoDesactivado();
            //transaction start
            DB::beginTransaction();

            try {


                if($perfil){
                    $perfil->update();
                }


            } catch (Exception $e) {

                DB::rollback();

                return response()->json(['errors'=>$e->getMessage()]);
            // return response()->json(['errors'=>"Compañia no es posible de eliminar porque esta ligada algun permisos de perfil o perfil."]);
            }
            
            DB::commit();
            //transaction end
        
            return response()->json(['success'=>@trans('seguridad::seguridad.perfil.desactivada.exito')]);
        }

    }

        //Eliminar compañia
    public function activar($id)
    {
        $permiso = new Permiso();
        $estado = new Estado();

        if ($permiso->DeletePermission()) {

            $perfil = Perfil::find($id);
            $perfil->idEstado = $estado->getidEstadoActivo();
            //transaction start
            DB::beginTransaction();

            try {


                if($perfil){
                    $perfil->update();
                }


            } catch (Exception $e) {

                DB::rollback();

                return response()->json(['errors'=>$e->getMessage()]);
            // return response()->json(['errors'=>"Compañia no es posible de eliminar porque esta ligada algun permisos de perfil o perfil."]);
            }
            
            DB::commit();
            //transaction end
        
            return response()->json(['success'=>@trans('seguridad::seguridad.perfil.activada.exito')]);
        }

    }

    /// traer datos para crear en este caso solo los perfiles
    public function getCreateData()
    {

        //SELECT * FROM opcion where id not in(SELECT DISTINCT superior FROM opcion where superior IS NOT NULL)
        $permiso = new Permiso();
        
        if ($permiso->InsertPermission()) {

            $opcion = new Opcion();

            return ['opcionesDisponibles'=>$opcion->getOpcion()];

        }
    }
    
    /// traer datos de la personamediante el id
    public function getUpdateData($id)
    {
        $permiso = new Permiso();
        $opcion = new Opcion();

        if ($permiso->ModifyPermission()) {


            $perfil = Perfil::find($id);

            $opcionePerfil = $perfil->perfilOpcion()->get();

            $notInPerfil = [];
            $opcionesPerfil = [];

            foreach ($opcionePerfil as $opciones) {
                $opcionesPerfil['roles'][] =  $opciones;
                $opcionesPerfil['opcion'][] =  $opciones->opcion;
                $notInPerfil[] =   $opciones->idOpcion;
            }
           
            $opcionesDisponibles = $opcion->getOpcion($notInPerfil);

            return ['perfil'=>$perfil,
                    'opcionesPerfil'=>$opcionesPerfil,
                    'opcionesDisponibles'=>$opcionesDisponibles];

        }
    }



    public function verCuadros(Request $request)
    {
        $perfil = new Perfil();

        $permiso = new Permiso();

        if ($permiso->ViewPermission()) {

            $buscar = $request->buscador;

            //Funcion para traer las personas por el id del rol o no
            $prueba = $perfil->getPerfil(session("compania"),$permiso->SuperPermission(),$buscar);


            $tipoDeDatos = $request->tipoDeDatos;

            $content = '';

            if ($tipoDeDatos == 'table') {

                    $content .= '
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                <table class="table table-striped table-bordered table-hover dataTables-example dataTable">
                                            <thead>
                                                <tr>
                                                    <th>'.@trans('entidades::entidades.nombre').'</th>
                                                    <th>'.@trans('entidades::entidades.compania').'</th>
                                                    <th>'.@trans('entidades::entidades.estado').'</th>
                                                    <th>'.@trans('entidades::entidades.accion').'</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                            
                    foreach($prueba as $pruebas){

                        if ($pruebas->estado->codigo == 'ESTADO_ACTIVO') {
                            $estado = '<span class="badge badge-success pull-center">'.$pruebas->estado->nombre.'</span>';
                            $btnEstado = $this->getButtons('deactivate',$pruebas);
                        }else{
                            $estado = '<span class="badge badge-danger pull-center">'.$pruebas->estado->nombre.'</span>';
                            $btnEstado = $this->getButtons('activate',$pruebas);
                        }


                        $content .= '<tr>
                                        <td>'.$pruebas->nombre.'</td>
                                        <td>'.$pruebas->compania->nombre.'</td>
                                        <td>'.$estado.'</td>
                                        <td>
                                            '.$this->getButtons('modify',$pruebas).'
                                            '.$btnEstado.'
                                            '.$this->getButtons('delete',$pruebas).'
                                        </td>
                                    </tr>';  
                    }

                    $content .= '</tbody>
                                </table>
                            </div>
                        </div>
                    </div>';

                }else{
                    
                
                    foreach($prueba as $pruebas){

                       
                            if ($pruebas->estado->codigo == 'ESTADO_ACTIVO') {
                                $estado = '<span class="badge badge-success pull-right">'.$pruebas->estado->nombre.'</span>';
                                $btnEstado = $this->getButtons('deactivate',$pruebas);;
                            }else{
                                $estado = '<span class="badge badge-danger pull-right">'.$pruebas->estado->nombre.'</span>';
                                $btnEstado = $this->getButtons('activate',$pruebas);
                            }

                            $content .='<div class="col-lg-3">
                                            <div class="contact-box">
                                        
                                                <div class="col-sm-12">
                                                    <h3><strong>'.$pruebas->nombre.'</strong>'.$estado.'</h3>
                                                    <p class="font-bold">'.$pruebas->compania->nombre.'</p>
                                                    <div class="align-bottom">
                                                    '.$this->getButtons('modify',$pruebas).'
                                                    '.$btnEstado.'
                                                    '.$this->getButtons('delete',$pruebas).'
                                                    </div>

                                                </div>
                                                <div class="clearfix"></div>
                                                
                                            </div>
                                        </div>';
                                        
                    }
                    
                }

            return $content;
        }
    }
}
