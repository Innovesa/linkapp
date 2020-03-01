<?php

namespace Modules\Seguridad\Http\Controllers;

use Exception;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use LinkApp\Http\Controllers\Controller;
use LinkApp\Models\ERP\Persona;
use LinkApp\Models\ERP\Estado;
use LinkApp\Models\ERP\Permiso;
use Illuminate\Support\Facades\Storage; //para los discos virtuales
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use LinkApp\Models\ERP\Perfil;
use LinkApp\Models\ERP\CompaniaPersona;
use Illuminate\Support\Facades\Hash;
use LinkApp\Models\ERP\PerfilUsuario;
use LinkApp\Models\ERP\Usuario;
use Validator;

class UsuarioController extends Controller
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
    

            return view('seguridad::usuarios.index');

        } else{
            return redirect("/home");
        }
        

    }

    //Trae los botones si tiene el permiso
    public function getButtons($nombre,$objeto)
    {
        $permiso = new Permiso();

        if ($nombre == 'modify' && $permiso->ModifyPermission()) {

            return '<a id="editar"  data-route="'.route('seguridad.usuarios.updateData',['id' => $objeto->idUsuario]).'" data-toggle="modal" href="#modalMantenimiento" class="btn-primary btn btn-xs"><i class="fa fa-pencil"></i>'.@trans('entidades::entidades.editar').'</a>';

        }

        if ($nombre == 'activate' && $permiso->DeletePermission()) {

            return '<button id="estado" data-route="'.route('seguridad.usuarios.activar',['id' =>$objeto->idUsuario]).'" class="btn-primary btn btn-xs"> <i class="fa fa-times"></i>'.@trans('entidades::entidades.activar').'</button>';

        }
        
        if ($nombre == 'deactivate' && $permiso->DeletePermission()) {

            return '<button id="estado" data-route="'.route('seguridad.usuarios.desactivar',['id' =>$objeto->idUsuario]).'" class="btn-primary btn btn-xs"> <i class="fa fa-times"></i>'.@trans('entidades::entidades.desactivar').'</button>';

        }

        if ($nombre == 'delete' && $permiso->AdminPermission()) {

            return '<button id="eliminar" data-route="'.route('seguridad.usuarios.eliminar',['id' =>$objeto->idUsuario]).'" class="btn-primary btn btn-xs"> <i class="fa fa-times"></i>'.@trans('entidades::entidades.eliminar').'</button>';

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
          //conseguir usuario identificado

    
       $id = $resquest->input('id');

       $usuario = Usuario::find($id);
       
       //validate del formulario
      
       $validator = Validator::make($resquest->all(),[
            'idPersona' => ['required'],
            'username' => ['required', 'string', 'max:30', 'unique:usuario,username,'.$id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuario,email,'.$id],
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

        //Asignar nuevos valores al objeto del usuario
        $usuario->id = $id;
        $usuario->username = $username;
        $usuario->email = $email;
        $usuario->idPersona = $idPersona;

        

        //transaction start
        DB::beginTransaction();

        try {

            //Ejecutar consulta y cambios en la bae de datos
            $usuario->update();

        } catch (Exception $e) {

            DB::rollback();

            return response()->json(['errors'=>$e->getMessage()]);

        }

        //registro de perfiles 

        $permiso = new Permiso();

        try {
 


            if($resquest->input('usuarioPerfiles')){


                $perfiles = explode(",",$resquest->input('usuarioPerfiles'));

                for ($i=0; $i < count($perfiles); $i++) { 
                    
    
                    $validationPerfil = PerfilUsuario::where('idPerfil',$perfiles[$i])->where('idUsuario',$id)->first();
    
                    if (!$validationPerfil) {

                        $perfilUsuario = new PerfilUsuario();
    
                        $perfilUsuario->idUsuario = $id;
                        $perfilUsuario->idPerfil = $perfiles[$i];
                        $perfilUsuario->idCompania = session("compania")->id;
    
                        $perfilUsuario->save();
                    }
    
                }

                
                $perfileEliminar = PerfilUsuario::whereNotIn('idPerfil',$perfiles)->where('idUsuario',$id)->get();
                if ($perfileEliminar) {
                    foreach ($perfileEliminar as $perfil) {
                        $perfil->delete();
                    }
                }

            }else{

                if ($permiso->SuperPermission()) {

                    $perfiles = PerfilUsuario::where('idUsuario',$id)->delete();
                    if ($perfiles) {
                        foreach ($perfiles as $perfil) {
                            $perfil->delete();
                        }
                    }

                }else{

                    $perfiles = PerfilUsuario::where('idCompania',session('compania')->id)->where('idUsuario',$id)->get();
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

        return response()->json(['success'=>@trans('seguridad::seguridad.usuario.actualizada.exito')]);
        
    }


    // update 


    public function create(Request $resquest)
    {
        //conseguir usuario identificado

        
       $usuario = new Usuario();

       $estado = new Estado();

       //validate del formulario
       $validator = Validator::make($resquest->all(),[
            'idPersona' => ['required'],
            'username' => ['required', 'string', 'max:30', 'unique:usuario'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuario'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
        if($validator->fails()){
            return response()->json([
                    'errors' => $validator->getMessageBag()->toArray()
                ]);
        }

        //recoger daots del formulario
        $username = $resquest->input('username');
        $email = $resquest->input('email');
        $password = Hash::make($resquest->input('password'));
        $idPersona = $resquest->input('idPersona');

        //Asignar nuevos valores al objeto del usuario
        $usuario->username = $username;
        $usuario->email = $email;
        $usuario->password = $password;
        $usuario->idPersona = $idPersona;
        $usuario->idEstado = $estado->getidEstadoActivo();

        
        //transaction start
        DB::beginTransaction();

       try {

            //Ejecutar consulta y cambios en la bae de datos
            $usuario->save();


       } catch (Exception $e) {

           DB::rollback();
           return response()->json(['errors'=>$e->getMessage()]);

       }


        $perfiles = explode(",",$resquest->input('usuarioPerfiles'));
    
 
        try {
 
            if(is_array($perfiles)){

                for ($i=0; $i < count($perfiles); $i++) { 
                    
    
                    $validationPerfil = PerfilUsuario::where('idPerfil',$perfiles[$i])->where('idUsuario',$usuario->id)->first();
    
                    if (!$validationPerfil) {

                        $perfilUsuario = new PerfilUsuario();
    
                        $perfilUsuario->idUsuario = $usuario->id;
                        $perfilUsuario->idPerfil = $perfiles[$i];
                        $perfilUsuario->idCompania = session("compania")->id;
    
                        $perfilUsuario->save();
                    }
    
                }
            }
 
 
         } catch (Exception $e) {
 
             DB::rollback();
             return response()->json(['errors'=>$e->getMessage()]);
 
         }

        DB::commit();
        //transaction end

        return response()->json(['success'=>@trans('seguridad::seguridad.usuario.creada.exito')]);
        
    }

    //Eliminar compañia
    public function eliminar($id)
    {
        $permiso = new Permiso();

        if ($permiso->AdminPermission()) {

            $usuario = Usuario::find($id);

            $perfilUsuario = PerfilUsuario::where('idUsuario',$usuario->id)->get();

            //transaction start
            DB::beginTransaction();

            try {


                if($usuario &&  $perfilUsuario){
                    foreach ($perfilUsuario as $perfil) {
                        $perfil->delete();
                    }
                   
                    $usuario->delete(); 
                }


            } catch (Exception $e) {

                DB::rollback();

                //return response()->json(['errors'=>$e->getMessage()]);
                return response()->json(['errors'=> @trans('seguridad::seguridad.usuario.eliminar.error')]);
            }
            
            DB::commit();
            //transaction end
        
            return response()->json(['success'=> @trans('seguridad::seguridad.usuario.eliminar.exito')]);
        }

    }

    //Eliminar compañia
    public function desactivar($id)
    {
        $permiso = new Permiso();

        $estado = new Estado();

        if ($permiso->DeletePermission()) {

            $usuario = Usuario::find($id);
            $usuario->idEstado = $estado->getidEstadoDesactivado();
            //transaction start
            DB::beginTransaction();

            try {


                if($usuario){
                    $usuario->update();
                }


            } catch (Exception $e) {

                DB::rollback();

                return response()->json(['errors'=>$e->getMessage()]);
            // return response()->json(['errors'=>"Compañia no es posible de eliminar porque esta ligada algun permisos de perfil o usuario."]);
            }
            
            DB::commit();
            //transaction end
        
            return response()->json(['success'=>@trans('seguridad::seguridad.usuario.desactivada.exito')]);
        }

    }

        //Eliminar compañia
    public function activar($id)
    {
        $permiso = new Permiso();
        $estado = new Estado();

        if ($permiso->DeletePermission()) {

            $usuario = Usuario::find($id);
            $usuario->idEstado = $estado->getidEstadoActivo();
            //transaction start
            DB::beginTransaction();

            try {


                if($usuario){
                    $usuario->update();
                }


            } catch (Exception $e) {

                DB::rollback();

                return response()->json(['errors'=>$e->getMessage()]);
            // return response()->json(['errors'=>"Compañia no es posible de eliminar porque esta ligada algun permisos de perfil o usuario."]);
            }
            
            DB::commit();
            //transaction end
        
            return response()->json(['success'=>@trans('seguridad::seguridad.usuario.activada.exito')]);
        }

    }

    /// traer datos para crear en este caso solo los perfiles
    public function getCreateData()
    {
        $permiso = new Permiso();
        
        if ($permiso->InsertPermission()) {

            $perfil = new Perfil();

            return ['perfilesDisponibles'=>$perfil->getPerfil(session("compania"),$permiso->SuperPermission())];

        }
    }
    
    /// traer datos de la personamediante el id
    public function getUpdateData($id)
    {
        $permiso = new Permiso();
        
        if ($permiso->ModifyPermission()) {

            if(!$permiso->SuperPermission()){
                $whereCompania = session("compania")->id;
            }else{
                $whereCompania = null;
            }

            $usuario = Usuario::where('id',$id)->first();

            $persona = $usuario->persona()->first();

            $perfilesUsuario = $usuario->perfilUsuario()->where('idCompania','LIKE','%'.$whereCompania.'%')->get();

            $notInPerfil = [];
            $perfilesUsuarioCompleto = [];

            foreach ($perfilesUsuario as $perfiles) {
                $perfilesUsuarioCompleto[] = $perfiles->perfil()->get();
                $notInPerfil[] =  $perfiles->idPerfil;
            }
           
            $perfilesDisponibles = Perfil::where('idCompania','LIKE','%'.$whereCompania.'%')->whereNotIn('id',$notInPerfil)->get();

            return ['persona'=>$persona,'usuario'=>$usuario,
                    'perfilesUsuario'=>$perfilesUsuarioCompleto,
                    'perfilesDisponibles'=>$perfilesDisponibles];

        }
    }


    //resultado para la lista desplegable para elegir persona
    public function resultPersonas(Request $request)
    {
        $persona = new Persona();

        $permiso = new Permiso();

        $content = "";

        if ($permiso->ViewPermission()) {

            $buscar = $request->buscador;

            //Funcion para traer las personas por el id del rol o no
            $result = $persona->getPersonaPorRol($buscar,session("compania"),$permiso->SuperPermission(),null);

            $content .= '<select class="list-group" id="selectPersona" style="width:100%; height: auto;" multiple>';

            foreach ($result as $personas) {
                $content .= '<option class="list-group-item list-group-item-action" value="'.$personas->id.'">'.$personas->identificacion.' | '.$personas->nombre.'</option>';
            }

            $content .= '</select>';

            return $content;

        }

    }
    public function updatePassword(Request $resquest){
        
        //conseguir usuario identificado
       $id = $resquest->input('id');
       $usuario = usuario::find($id);

               //validate del formulario
       $validator = Validator::make($resquest->all(),[
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if($validator->fails()){
            return response()->json([
                    'errors' => $validator->getMessageBag()->toArray()
                ]);
        }


       $password = $resquest->input('password');

        DB::beginTransaction();

        try {
            //Ejecutar consulta y cambios en la bae de datos
            $usuario->update([
                'password' => Hash::make($password)
            ]);

        }catch (Exception $e) {

            DB::rollback();

            return response()->json(['errors'=>$e->getMessage()]);
            // return response()->json(['errors'=>"Compañia no es posible de eliminar porque esta ligada algun permisos de perfil o usuario."]);
        }

        DB::commit();
        //transaction end
       
        return response()->json(['success'=>@trans('seguridad::seguridad.usuario.creada.exito')]);
    }

    public function verCuadros(Request $request)
    {
        $usuario = new Usuario();

        $permiso = new Permiso();

        if ($permiso->ViewPermission()) {

            $buscar = $request->buscador;

            //Funcion para traer las personas por el id del rol o no
            $prueba = $usuario->getUsuario($buscar,session("compania"),$permiso->SuperPermission());


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
                                                    <th>'.@trans('entidades::entidades.username').'</th>
                                                    <th>'.@trans('entidades::entidades.nombre').'</th>
                                                    <th>'.@trans('entidades::entidades.correo').'</th>
                                                    <th>'.@trans('entidades::entidades.imagen').'</th>
                                                    <th>'.@trans('entidades::entidades.estado').'</th>
                                                    <th>'.@trans('entidades::entidades.accion').'</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                            
                    foreach($prueba as $pruebas){

                        if ($pruebas->codigo == 'ESTADO_ACTIVO') {
                            $estado = '<span class="badge badge-success pull-center">'.$pruebas->NombreEstado.'</span>';
                            $btnEstado = $this->getButtons('deactivate',$pruebas);
                        }else{
                            $estado = '<span class="badge badge-danger pull-center">'.$pruebas->NombreEstado.'</span>';
                            $btnEstado = $this->getButtons('activate',$pruebas);
                        }


                        $content .= '<tr>
                                        <td>'.$pruebas->username.'</td>
                                        <td>'.$pruebas->nombre.'</td>
                                        <td>'.$pruebas->email.'</td>
                                        <td>
                                            <h3 class="inlineText">
                                                <img src="'.url('/').'/persona/image/'.$pruebas->img.'" height="24px">
                                            </h3>
                                        </td>
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

                       
                            if ($pruebas->codigo == 'ESTADO_ACTIVO') {
                                $estado = '<span class="badge badge-success pull-right">'.$pruebas->NombreEstado.'</span>';
                                $btnEstado = $this->getButtons('deactivate',$pruebas);;
                            }else{
                                $estado = '<span class="badge badge-danger pull-right">'.$pruebas->NombreEstado.'</span>';
                                $btnEstado = $this->getButtons('activate',$pruebas);
                            }

                            $content .='<div class="col-lg-4">
                                            <div class="contact-box">
                                        
                                                <div class="col-sm-4">
                                                    <div class="text-center">
                                                        <img alt="image" class="m-t-xs img-responsive" src="'.url('/').'/persona/image/'.$pruebas->img.'" style="max-height: 90px;">
                                                    </div>
                                                </div>
                                                <div class="col-sm-8">
                                                    <h3><strong>'.$pruebas->username.'</strong>'.$estado.'</h3>
                                                    <p class="font-bold">'.$pruebas->nombre.'</p>
                                                    <p class="font-bold">'.$pruebas->email.'</p>
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
