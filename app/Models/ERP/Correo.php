<?php

namespace LinkApp\Models\ERP;

use Illuminate\Database\Eloquent\Model;

class Correo extends Model
{
    protected $table = 'correo';

    //many to one
    public function persona(){
        return $this->belongsTo('LinkApp\Models\ERP\Persona','idPersona');        
    }

     //many to one
     public function estado(){
        return $this->belongsTo('LinkApp\Models\ERP\Estado','idEstado');        
    }
}

