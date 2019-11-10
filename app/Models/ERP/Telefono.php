<?php

namespace LinkApp\Models\ERP;

use Illuminate\Database\Eloquent\Model;

class Telefono extends Model
{
    protected $table = 'telefono';

    //many to one
    public function persona(){
        return $this->belongsTo('LinkApp\Models\ERP\Persona','idPersona');        
    }

     //many to one
     public function estado(){
        return $this->belongsTo('LinkApp\Models\ERP\Estado','idEstado');        
    }
}
