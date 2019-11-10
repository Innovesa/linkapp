<?php

namespace LinkApp\Models\ERP;

use Illuminate\Database\Eloquent\Model;

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

    //many to one
    public function estado(){
        return $this->belongsTo('LinkApp\Models\ERP\Estado','idEstado'); 
       
    }
}
