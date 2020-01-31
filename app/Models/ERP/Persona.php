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
    public function telefono(){
        return $this->hasMany('LinkApp\Models\ERP\Telefono','idPersona');
    }
    //one to many
    public function correo(){
        return $this->hasMany('LinkApp\Models\ERP\Correo','idPersona');
    }

    //one to many
    public function perfilUsuario(){
        return $this->hasMany('LinkApp\Models\ERP\PerfilUsuario','idCompania');
    }
    
    //many to one
    public function tipoPersona(){
        return $this->belongsTo('LinkApp\Models\ERP\TipoPersona','idTipoPersona');        
    }

    //one to many
    public function personaRol(){
        return $this->hasMany('LinkApp\Models\ERP\PersonaRol','idRol');
    }

    //many to one
    public function estado(){
        return $this->belongsTo('LinkApp\Models\ERP\Estado','idEstado'); 
       
    }

    //trae personas mediante el rol
    public function getPersonaPorRol($buscar,$idRol){

        $result = DB::table($this->table)
        ->distinct()
        ->join('persona_rol', 'persona.id', '=', 'persona_rol.idPersona')
        ->join('estado', 'persona.idEstado', '=', 'estado.id')
        ->select('persona.*','estado.nombre as NombreEstado','estado.codigo')
        ->where(function ($query) use ($buscar){ 
            $query->where('persona.nombre','LIKE','%'.$buscar.'%')
            ->orWhere('persona.alias','LIKE','%'.$buscar.'%')
            ->orWhere('persona.cedula','LIKE','%'.$buscar.'%');
        })
        ->where('persona_rol.idRol', $idRol)
        ->orderBy('persona.updated_at', 'DESC')
        ->get();

        return $result;
    }
}
