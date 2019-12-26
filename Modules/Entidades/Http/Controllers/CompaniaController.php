<?php

namespace Modules\Entidades\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use LinkApp\Http\Controllers\Controller;
use LinkApp\Models\ERP\Persona;
use LinkApp\Models\ERP\PersonaRol;
use Illuminate\Support\Facades\Storage; //para los discos virtuales
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Validator;

class CompaniaController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index()
    {

        return view('entidades::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
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


        //Ejecutar consulta y cambios en la bae de datos
        $compania->save();


        $personaRol = new PersonaRol();
       
        $personaRol->idPersona = $compania->id;
        $personaRol->idRol = 1;
        $personaRol->idCompania = $compania->id;

        $personaRol->save();
        

        return response()->json(['success'=>__('Compañía creada con éxito!')]);
        
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function verCuadros(Request $request)
    {
        $buscar = $request->buscador;

        $prueba = DB::table('persona')
        ->distinct()
        ->join('persona_rol', 'persona.id', '=', 'persona_rol.idPersona')
        ->select('*')
        ->where(function ($query) use ($buscar){ 
            $query->where('persona.nombre','LIKE','%'.$buscar.'%')
            ->orWhere('persona.alias','LIKE','%'.$buscar.'%')
            ->orWhere('persona.cedula','LIKE','%'.$buscar.'%');
        })
        ->where('persona_rol.idRol', 1)->get();


        //$prueba = PersonaRol::where('idRol',1)->get();
       // $prueba2 = $prueba->persona;
       

        $content = '';

        foreach($prueba as $pruebas){

                $content .= '<div class="col-md-3 datos">
                            <div class="ibox-content text-center">
                                <span class="badge badge-success pull-right">Activo</span>
                                <h3 class="inlineText">
                                    <img src="'.route('persona.image',['filename' => $pruebas->img ]).'" height="24px">
                                </h3>
                                <p class="font-bold">'.$pruebas->cedula.'</p>
                                <p class="font-bold">'.$pruebas->nombre.' | '.$pruebas->alias.'</p>
                                <div class="text-center">
                                    <a data-toggle="modal" href="#modalMantenimiento" class="btn-primary btn btn-xs" onclick="editar(1)"><i class="fa fa-pencil"></i> Editar</a>
                                    <button class="btn-primary btn btn-xs" onclick="eliminar(1)"> <i class="fa fa-times"></i> Eliminar</button>
                                </div>
                            </div>
                        </div>';  
        }

   

        return $content;
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('entidades::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('entidades::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
