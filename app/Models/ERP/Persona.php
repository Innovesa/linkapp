<?php

namespace LinkApp\Models\ERP;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Persona extends Model
{
    protected $table = 'persona';

    //one to many
    public function usuario(){
        return $this->hasMany('LinkApp\Models\ERP\Usuario','idPersona');
    }

    //one to many
    public function perfilUsuario(){
        return $this->hasMany('LinkApp\Models\ERP\PerfilUsuario','idCompania');
    }

    //one to many
    public function companiaPersona(){
        return $this->hasMany('LinkApp\Models\ERP\CompaniaPersona','idCompania');
    }

    //one to many
    public function personaCompania(){
        return $this->hasMany('LinkApp\Models\ERP\CompaniaPersona','idPersona');
    }
    
    //many to one
    public function tipoIdentificacion(){
        return $this->belongsTo('LinkApp\Models\ERP\TipoIdentificacion','idTipoIdentificacion');        
    }

    //one to many
    public function personaRol(){
        return $this->hasMany('LinkApp\Models\ERP\PersonaRol','idRol');
    }

    //one to many
    public function perfil(){
        return $this->hasMany('LinkApp\Models\ERP\Perfil','idCompania');
    }

    //many to one
    public function estado(){
        return $this->belongsTo('LinkApp\Models\ERP\Estado','idEstado'); 
       
    }

    //trae personas mediante el rol o no 
    public function getPersonaPorRol($buscar,$Compania,$isSuper=null,$idRol=null){

        if($Compania && !$isSuper){
            $whereCompania = $Compania->id;
        }else{
            $whereCompania = null;
        }

        if($idRol){

            $result = DB::table($this->table)
            ->distinct()
            ->join('persona_rol', 'persona.id', '=', 'persona_rol.idPersona')
            ->join('compania_persona', 'persona.id', '=', 'compania_persona.idPersona')
            ->join('estado', 'persona.idEstado', '=', 'estado.id')
            ->select('persona.*','estado.nombre as NombreEstado','estado.codigo')
            ->where(function ($query) use ($buscar){ 
                $query->where('persona.nombre','LIKE','%'.$buscar.'%')
                ->orWhere('persona.alias','LIKE','%'.$buscar.'%')
                ->orWhere('persona.identificacion','LIKE','%'.$buscar.'%');
            })
            ->where('persona_rol.idRol', $idRol)
            ->where('compania_persona.idCompania','LIKE','%'.$whereCompania.'%')
            ->orderBy('persona.idEstado', 'asc')
            ->orderBy('persona.nombre', 'asc')
            ->get();
            
        }else{

            $result = DB::table($this->table)
            ->distinct()
            ->join('compania_persona', 'persona.id', '=', 'compania_persona.idPersona')
            ->join('estado', 'persona.idEstado', '=', 'estado.id')
            ->select('persona.*','estado.nombre as NombreEstado','estado.codigo')
            ->where(function ($query) use ($buscar){ 
                $query->where('persona.nombre','LIKE','%'.$buscar.'%')
                ->orWhere('persona.alias','LIKE','%'.$buscar.'%')
                ->orWhere('persona.identificacion','LIKE','%'.$buscar.'%');
            })
            ->where('compania_persona.idCompania','LIKE','%'.$whereCompania.'%')
            ->orderBy('persona.idEstado', 'asc')
            ->orderBy('persona.nombre', 'asc')
            ->get();
            
        }


        return $result;
    }
}
