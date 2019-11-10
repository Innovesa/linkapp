<?php

namespace LinkApp\Models\ERP;

use Illuminate\Database\Eloquent\Model;

class PersonaRol extends Model
{
    protected $table = 'persona_rol';

    //many to one
    public function rol(){
        return $this->belongsTo('LinkApp\Models\ERP\Rol','idRol'); 
    }
    
    //many to one
    public function persona(){
        return $this->belongsTo('LinkApp\Models\ERP\Persona','idPersona');        
    }
    
    //many to one
    public function estado(){
        return $this->belongsTo('LinkApp\Models\ERP\Estado','idEstado');        
    }
}
