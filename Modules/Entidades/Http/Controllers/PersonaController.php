<?php

namespace Modules\Entidades\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use LinkApp\Http\Controllers\Controller;
use LinkApp\Models\ERP\Persona;
use LinkApp\Models\ERP\Estado;
use LinkApp\Models\ERP\Permiso;
use Illuminate\Support\Facades\Storage; //para los discos virtuales
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use LinkApp\Models\ERP\TipoIdentificacion;
use LinkApp\Models\ERP\CompaniaPersona;
use Illuminate\Support\Facades\Gate;
use Validator;

class PersonaController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index()
    {
    
        $permiso = new Permiso();

        if ($permiso->AccessPermission()) {

            $identificaciones = TipoIdentificacion::all();

            session(['currentUrl' => url()->current()]);

            return view('entidades::personas.index',['identificaciones'=>$identificaciones]);

        } else{
            return redirect("/home");
        }
        

    }

    //Trae los botones si tiene el permiso
    public function getButtons($nombre,$objeto)
    {
        $permiso = new Permiso();

        if ($nombre == 'modify' && $permiso->ModifyPermission()) {

            return '<a id="editar"  data-route="'.route('entidades.personas.updateData',['id' => $objeto->id]).'" data-toggle="modal" href="#modalMantenimiento" class="btn-primary btn btn-xs"><i class="fa fa-pencil"></i>'.@trans('entidades::entidades.editar').'</a>';

        }

        if ($nombre == 'activate' && $permiso->DeletePermission()) {

            return '<button id="estado" data-route="'.route('entidades.personas.activar',['id' =>$objeto->id]).'" class="btn-primary btn btn-xs"> <i class="fa fa-times"></i>'.@trans('entidades::entidades.activar').'</button>';

        }
        
        if ($nombre == 'deactivate' && $permiso->DeletePermission()) {

            return '<button id="estado" data-route="'.route('entidades.personas.desactivar',['id' =>$objeto->id]).'" class="btn-primary btn btn-xs"> <i class="fa fa-times"></i>'.@trans('entidades::entidades.desactivar').'</button>';

        }

        if ($nombre == 'delete' && $permiso->AdminPermission()) {

            return '<button id="eliminar" data-route="'.route('entidades.personas.eliminar',['id' =>$objeto->id]).'" class="btn-primary btn btn-xs"> <i class="fa fa-times"></i>'.@trans('entidades::entidades.eliminar').'</button>';

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

       $persona = Persona::find($id);
       
       //validate del formulario
       $validator = Validator::make($resquest->all(),[
            'nombre' => ['required', 'string', 'max:200'],
            'identificacion' => ['required', 'string', 'max:15','unique:persona,identificacion,'.$id],
            'alias' =>  ['max:200'],
            'imagen' => ['image'],
        ]);
        
        if($validator->fails()){
            return response()->json([
                    'errors' => $validator->getMessageBag()->toArray()
                ]);
        }

        //recoger daots del formulario

        $nombre = $resquest->input('nombre');
        $identificacion = $resquest->input('identificacion');
        $alias = $resquest->input('alias');
        $imagen = $resquest->file('imagen');
        $idTipoIdentificacion = $resquest->input('tipoIdentificacion');


        //Asignar nuevos valores al objeto del usuario
        $persona->id = $id;
        $persona->identificacion = $identificacion;
        $persona->nombre = $nombre;
        $persona->alias = $alias;
        $persona->idTipoIdentificacion = $idTipoIdentificacion;



        //Subir fichero
        if ($imagen) {
        
            //Guarda en la carpeta storage (storage/app/users)
            Storage::disk('personas')->put($id.'/imgPerfil.png',File::get($imagen)); //Nombre del archivo y despues el fichero
                                                            //extraer o copia la imagen de la carpeta temporal donde a guardado y consigue el fichero
                
            //Setea el nombre de la imagen en el objeto
            $persona->img = $id.'/imgPerfil.png'; 
        }

        //transaction start
        DB::beginTransaction();

        try {


            //Ejecutar consulta y cambios en la bae de datos
            $persona->update();


        } catch (Exception $e) {

            DB::rollback();

            return response()->json(['errors'=>$e->getMessage()]);

        }
        
        DB::commit();
        //transaction end

        return response()->json(['success'=>@trans('entidades::entidades.persona.actualizada.exito')]);
        
    }


    // update 


    public function create(Request $resquest)
    {
          //conseguir usuario identificado
        
       $persona= new Persona();

       $estado = new Estado();

       
       //validate del formulario
       $validator = Validator::make($resquest->all(),[
            'nombre' => ['required', 'string', 'max:200'],
            'identificacion' => ['required', 'string', 'max:15','unique:persona'],
            'alias' => ['max:200'],
            'imagen' => ['image'],
        ]);
        
        if($validator->fails()){
            return response()->json([
                    'errors' => $validator->getMessageBag()->toArray()
                ]);
        }

        //recoger daots del formulario
        $nombre = $resquest->input('nombre');
        $identificacion = $resquest->input('identificacion');
        $alias = $resquest->input('alias');
        $imagen = $resquest->file('imagen');
        $idTipoIdentificacion = $resquest->input('tipoIdentificacion');

        //Asignar nuevos valores al objeto del usuario
        $persona->identificacion = $identificacion;
        $persona->nombre = $nombre;
        $persona->alias = $alias;
        $persona->img = 'default/logo.png';
        $persona->idTipoIdentificacion = $idTipoIdentificacion;
        $persona->idEstado = $estado->getidEstadoActivo();

        
        //transaction start
        DB::beginTransaction();

       try {

            //Ejecutar consulta y cambios en la bae de datos
            $persona->save();

            //Subir fichero
            if ($imagen) {
            
                //Guarda en la carpeta storage (storage/app/users)
                Storage::disk('personas')->put($persona->id.'/imgPerfil.png',File::get($imagen)); //Nombre del archivo y despues el fichero
                                                                //extraer o copia la imagen de la carpeta temporal donde a guardado y consigue el fichero
                    
                //Setea el nombre de la imagen en el objeto
                $persona->img =  $persona->id.'/imgPerfil.png'; 

            }

            $persona->update();


       } catch (Exception $e) {

           DB::rollback();
           return response()->json(['errors'=>$e->getMessage()]);

       }

        $companiaPersona = new CompaniaPersona();
        
        $companiaPersona->idPersona = $persona->id;
        $companiaPersona->idCompania = session("compania")->id;
 
        try {
 
             //Ejecutar consulta y cambios en la bae de datos
             $companiaPersona->save();
 
 
         } catch (Exception $e) {
 
             DB::rollback();
             return response()->json(['errors'=>$e->getMessage()]);
 
         }

        DB::commit();
        //transaction end

        return response()->json(['success'=>@trans('entidades::entidades.persona.creada.exito')]);
        
    }

    //Eliminar compañia
    public function eliminar($id)
    {
        $permiso = new Permiso();

        if ($permiso->AdminPermission()) {

            $persona= Persona::find($id);

            $companiaPersona = CompaniaPersona::where('idPersona',$persona->id)->first();

            //transaction start
            DB::beginTransaction();

            try {


                if($persona && $companiaPersona){
                    $companiaPersona->delete();
                    $persona->delete(); 
                }


            } catch (Exception $e) {

                DB::rollback();

                //return response()->json(['errors'=>$e->getMessage()]);
                return response()->json(['errors'=> @trans('entidades::entidades.persona.eliminar.error')]);
            }
            
            DB::commit();
            //transaction end
        
            return response()->json(['success'=> @trans('entidades::entidades.persona.eliminar.exito')]);
        }

    }

    //Eliminar compañia
    public function desactivar($id)
    {
        $permiso = new Permiso();

        $estado = new Estado();

        if ($permiso->DeletePermission()) {

            $persona= Persona::find($id);
            $persona->idEstado = $estado->getidEstadoDesactivado();
            //transaction start
            DB::beginTransaction();

            try {


                if($persona){
                    $persona->update();
                }


            } catch (Exception $e) {

                DB::rollback();

                return response()->json(['errors'=>$e->getMessage()]);
            // return response()->json(['errors'=>"Compañia no es posible de eliminar porque esta ligada algun permisos de perfil o usuario."]);
            }
            
            DB::commit();
            //transaction end
        
            return response()->json(['success'=>@trans('entidades::entidades.persona.desactivada.exito')]);
        }

    }

        //Eliminar compañia
    public function activar($id)
    {
        $permiso = new Permiso();
        $estado = new Estado();

        if ($permiso->DeletePermission()) {

            $persona= Persona::find($id);
            $persona->idEstado = $estado->getidEstadoActivo();
            //transaction start
            DB::beginTransaction();

            try {


                if($persona){
                    $persona->update();
                }


            } catch (Exception $e) {

                DB::rollback();

                return response()->json(['errors'=>$e->getMessage()]);
            // return response()->json(['errors'=>"Compañia no es posible de eliminar porque esta ligada algun permisos de perfil o usuario."]);
            }
            
            DB::commit();
            //transaction end
        
            return response()->json(['success'=>@trans('entidades::entidades.persona.activada.exito')]);
        }

    }
    
    /// traer datos de la personamediante el id
    public function getUpdateData($id)
    {
        $permiso = new Permiso();
        
        if ($permiso->ModifyPermission()) {

            $persona = Persona::where('id',$id)->first();

            return $persona->toJson();

        }
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function verCuadros(Request $request)
    {
        $persona = new Persona();

        $permiso = new Permiso();

        if ($permiso->ViewPermission()) {

            $buscar = $request->buscador;

            //Funcion para traer las personas por el id del rol o no
            $prueba = $persona->getPersonaPorRol($buscar,session("compania"),$permiso->SuperPermission(),null);


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
                                                    <th>'.@trans('entidades::entidades.identificacion').'</th>
                                                    <th>'.@trans('entidades::entidades.nombre').'</th>
                                                    <th>'.@trans('entidades::entidades.alias').'</th>
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
                                        <td>'.$pruebas->identificacion.'</td>
                                        <td>'.$pruebas->nombre.'</td>
                                        <td>'.$pruebas->alias.'</td>
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
                                                    <h3><strong>'.$pruebas->nombre.'</strong>'.$estado.'</h3>
                                                    <p class="font-bold">'.$pruebas->identificacion.'</p>
                                                    <p class="font-bold">'.$pruebas->alias.'</p>
                                                    <div class="align-bottom">
                                                    '.$this->getButtons('modify',$pruebas).'
                                                    '.$btnEstado.'
                                                    '.$this->getButtons('delete',$pruebas).'
                                                    </div>

                                                </div>
                                                <div class="clearfix"></div>
                                                
                                            </div>
                                        </div>';

                            /*$contenthj = '<div class="col-md-3 datos">
                                        <div class="ibox-content text-center">'.$estado.'
                                            <h3 class="inlineText">
                                                <img src="'.route('persona.image',['filename' => $pruebas->img ]).'" height="24px">
                                            </h3>
                                            <p class="font-bold">'.$pruebas->identificacion.'</p>
                                            <p class="font-bold">'.$pruebas->nombre.' | '.$pruebas->alias.'</p>
                                            <div class="text-center">
                                                '.$this->getButtons('modify',$pruebas).'
                                                '.$btnEstado.'
                                                '.$this->getButtons('delete',$pruebas).'
                                            </div>
                                        </div>
                                    </div>';  */
                    }

                }

            return $content;
        }
    }
    
}


