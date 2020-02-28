<?php

namespace Modules\Entidades\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use LinkApp\Http\Controllers\Controller;
use LinkApp\Models\ERP\Persona;
use LinkApp\Models\ERP\PersonaRol;
use Illuminate\Support\Facades\Storage; //para los discos virtuales
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use LinkApp\Models\ERP\Parametro;
use Validator;

class SedeController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index()
    {

        return view('entidades::sedes.index');
    }

    public function createUpdate(Request $resquest)
    {

       if (!$resquest->input('id')) {

           return $this->create($resquest);
            
       }else{

           return $this->update($resquest);

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

       $compania = Persona::find($id);
       
       //validate del formulario
       $validator = Validator::make($resquest->all(),[
            'nombre' => ['required', 'string', 'max:200'],
            'cedula' => ['required', 'string', 'max:15','unique:persona,cedula,'.$id],
            'alias' => ['required', 'string', 'max:200'],
            'imagen' => ['image'],
        ]);
        
        if($validator->fails()){
            return response()->json([
                    'errors' => $validator->getMessageBag()->toArray()
                ]);
        }

        //recoger daots del formulario

        $nombre = $resquest->input('nombre');
        $cedula = $resquest->input('cedula');
        $alias = $resquest->input('alias');
        $imagen = $resquest->file('imagen');


        //Asignar nuevos valores al objeto del usuario
        $compania->id = $id;
        $compania->cedula = $cedula;
        $compania->nombre = $nombre;
        $compania->alias = $alias;

        //$compania->idTipoPersona = 2;
        $compania->idEstado = 1;



        //Subir fichero
        if ($imagen) {
            $image_path_name = time().$imagen->getClientOriginalName(); //concatena la hora para asegurar tener un nombre unico
        
            //Guarda en la carpeta storage (storage/app/users)
            Storage::disk('personas')->put($image_path_name,File::get($imagen)); //Nombre del archivo y despues el fichero
                                                            //extraer o copia la imagen de la carpeta temporal donde a guardado y consigue el fichero
                
            //Setea el nombre de la imagen en el objeto
            $compania->img =  $image_path_name; 
        }

        //transaction start
        DB::beginTransaction();

        try {


            //Ejecutar consulta y cambios en la bae de datos
            $compania->update();


        } catch (Exception $e) {

            DB::rollback();

            return response()->json(['errors'=>$e->getMessage()]);

        }
        
        DB::commit();
        //transaction end

        return response()->json(['success'=>@trans('entidades::entidades.sede.actualizada.exito')]);
        
    }


    // update 


    public function create(Request $resquest)
    {
          //conseguir usuario identificado
        
       $compania = new Persona();

       
       //validate del formulario
       $validator = Validator::make($resquest->all(),[
            'nombre' => ['required', 'string', 'max:200'],
            'cedula' => ['required', 'string', 'max:15','unique:persona'],
            'alias' => ['required', 'string', 'max:200'],
            'imagen' => ['required','image'],
        ]);
        
        if($validator->fails()){
            return response()->json([
                    'errors' => $validator->getMessageBag()->toArray()
                ]);
        }

        //recoger daots del formulario
        $nombre = $resquest->input('nombre');
        $cedula = $resquest->input('cedula');
        $alias = $resquest->input('alias');
        $imagen = $resquest->file('imagen');


        //Asignar nuevos valores al objeto del usuario
        $compania->cedula = $cedula;
        $compania->nombre = $nombre;
        $compania->alias = $alias;
        $compania->idTipoPersona = 2;
        $compania->idEstado = 1;



        //Subir fichero
         if ($imagen) {
            $image_path_name = time().$imagen->getClientOriginalName(); //concatena la hora para asegurar tener un nombre unico
        
            //Guarda en la carpeta storage (storage/app/users)
            Storage::disk('personas')->put($image_path_name,File::get($imagen)); //Nombre del archivo y despues el fichero
                                                            //extraer o copia la imagen de la carpeta temporal donde a guardado y consigue el fichero
                
            //Setea el nombre de la imagen en el objeto
            $compania->img =  $image_path_name; 
        }

        
        //transaction start
        DB::beginTransaction();

       try {

            //Ejecutar consulta y cambios en la bae de datos
            $compania->save();


       } catch (Exception $e) {

           DB::rollback();
           return response()->json(['errors'=>$e->getMessage()]);

       }


       $personaRol = new PersonaRol();
        
       $personaRol->idPersona = $compania->id;
       $personaRol->idRol = 1;
       $personaRol->idCompania = $compania->id;

       try {

            //Ejecutar consulta y cambios en la bae de datos
            $personaRol->save();


        } catch (Exception $e) {

            DB::rollback();
            return response()->json(['errors'=>$e->getMessage()]);

        }

        DB::commit();
        //transaction end

        return response()->json(['success'=>@trans('entidades::entidades.sede.creada.exito')]);
        
    }

    //Eliminar compañia
    public function eliminar($id)
    {

        $compania = Persona::find($id);

        $personaRol = PersonaRol::where('idPersona',$compania->id)->first();

        //transaction start
        DB::beginTransaction();

        try {


            if($compania && $personaRol){
                $personaRol->delete();
                $compania->delete(); 
            }


        } catch (Exception $e) {

            DB::rollback();

            //return response()->json(['errors'=>$e->getMessage()]);
            return response()->json(['errors'=> @trans('entidades::entidades.sede.eliminar.error')]);
        }
        
        DB::commit();
        //transaction end
    
        return response()->json(['success'=> @trans('entidades::entidades.sede.eliminar.exito')]);

    }

    //Eliminar compañia
    public function desactivar($id)
    {

        $compania = Persona::find($id);
        $compania->idEstado = 2;
        //transaction start
        DB::beginTransaction();

        try {


            if($compania){
                $compania->update();
            }


        } catch (Exception $e) {

            DB::rollback();

            return response()->json(['errors'=>$e->getMessage()]);
           // return response()->json(['errors'=>"Compañia no es posible de eliminar porque esta ligada algun permisos de perfil o usuario."]);
        }
        
        DB::commit();
        //transaction end
    
        return response()->json(['success'=>@trans('entidades::entidades.sede.activada.exito')]);

    }

        //Eliminar compañia
    public function activar($id)
    {

        $compania = Persona::find($id);
        $compania->idEstado = 1;
        //transaction start
        DB::beginTransaction();

        try {


            if($compania){
                $compania->update();
            }


        } catch (Exception $e) {

            DB::rollback();

            return response()->json(['errors'=>$e->getMessage()]);
           // return response()->json(['errors'=>"Compañia no es posible de eliminar porque esta ligada algun permisos de perfil o usuario."]);
        }
        
        DB::commit();
        //transaction end
    
        return response()->json(['success'=>@trans('entidades::entidades.sede.desactivada.exito')]);

    }
    
    /// traer datos de la compania mediante el id
    public function getUpdateData($id)
    {
        //$id = $resquest->id;

        $persona = Persona::where('id',$id)->first();

        return $persona->toJson();
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function verCuadros(Request $request)
    {
        $parametro = new Parametro();
        $compania = new Persona();

        $buscar = $request->buscador;

        //Funcion para traer las personas por el id del rol
        $prueba = $compania->getPersonaPorRol($buscar,$parametro->getidRolCampania());


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
                                            <th>'.@trans('entidades::entidades.cedula').'</th>
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
                    $btnEstado = '<button id="estado" data-route="'.route('entidades.sedes.desactivar',['id' =>$pruebas->id]).'" class="btn-primary btn btn-xs"> <i class="fa fa-times"></i>'.@trans('entidades::entidades.desactivar').'</button>';
                }else{
                    $estado = '<span class="badge badge-danger pull-center">'.$pruebas->NombreEstado.'</span>';
                    $btnEstado = '<button id="estado" data-route="'.route('entidades.sedes.activar',['id' =>$pruebas->id]).'" class="btn-primary btn btn-xs"> <i class="fa fa-times"></i>'.@trans('entidades::entidades.activar').'</button>';
                }


                $content .= '<tr>
                                <td>'.$pruebas->cedula.'</td>
                                <td>'.$pruebas->nombre.'</td>
                                <td>'.$pruebas->alias.'</td>
                                <td>
                                    <h3 class="inlineText">
                                        <img src="'.route('persona.image',['filename' => $pruebas->img ]).'" height="24px">
                                    </h3>
                                </td>
                                <td>'.$estado.'</td>
                                <td>
                                    <a id="editar"  data-route="'.route('entidades.sedes.updateData',['id' =>$pruebas->id]).'" data-toggle="modal" href="#modalMantenimiento" class="btn-primary btn btn-xs"><i class="fa fa-pencil"></i>'.@trans('entidades::entidades.editar').'</a>
                                    '.$btnEstado.'
                                    <button id="eliminar" data-route="'.route('entidades.sedes.eliminar',['id' =>$pruebas->id]).'" class="btn-primary btn btn-xs"> <i class="fa fa-times"></i>'.@trans('entidades::entidades.eliminar').'</button>
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
                        $btnEstado = '<button id="estado" data-route="'.route('entidades.sedes.desactivar',['id' =>$pruebas->id]).'" class="btn-primary btn btn-xs"> <i class="fa fa-times"></i>'.@trans('entidades::entidades.desactivar').'</button>';
                    }else{
                        $estado = '<span class="badge badge-danger pull-right">'.$pruebas->NombreEstado.'</span>';
                        $btnEstado = '<button id="estado" data-route="'.route('entidades.sedes.activar',['id' =>$pruebas->id]).'" class="btn-primary btn btn-xs"> <i class="fa fa-times"></i>'.@trans('entidades::entidades.activar').'</button>';
                    }

                    $content .= '<div class="col-md-3 datos">
                                <div class="ibox-content text-center">'.$estado.'
                                    <h3 class="inlineText">
                                        <img src="'.route('persona.image',['filename' => $pruebas->img ]).'" height="24px">
                                    </h3>
                                    <p class="font-bold">'.$pruebas->cedula.'</p>
                                    <p class="font-bold">'.$pruebas->nombre.' | '.$pruebas->alias.'</p>
                                    <div class="text-center">
                                        <a id="editar"  data-route="'.route('entidades.sedes.updateData',['id' =>$pruebas->id]).'" data-toggle="modal" href="#modalMantenimiento" class="btn-primary btn btn-xs"><i class="fa fa-pencil"></i>'.@trans('entidades::entidades.editar').'</a>
                                        '.$btnEstado.'
                                        <button id="eliminar" data-route="'.route('entidades.sedes.eliminar',['id' =>$pruebas->id]).'" class="btn-primary btn btn-xs"> <i class="fa fa-times"></i>'.@trans('entidades::entidades.eliminar').'</button>
                                    </div>
                                </div>
                            </div>';  
            }

        }

        return $content;
    }
}