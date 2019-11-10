<?php

namespace LinkApp\Models\ERP;

use Illuminate\Database\Eloquent\Model;

class TipoPersona extends Model
{
    protected $table = 'tipo_persona';

    //one to many
    public function persona(){
        return $this->hasMany('LinkApp\Models\ERP\Persona','idTipoPersona');
    }

    //one to many
    public function rol(){
        return $this->hasMany('LinkApp\Models\ERP\Rol','idTipoPersona');
    }

    //many to one
    public function estado(){
        return $this->belongsTo('LinkApp\Models\ERP\Estado','idEstado'); 
       
    }
}
