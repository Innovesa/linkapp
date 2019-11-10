<?php

namespace LinkApp\Models\ERP;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'rol';

    //one to many
    public function personaRol(){
        return $this->hasMany('LinkApp\Models\ERP\PersonaRol','idRol');
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
