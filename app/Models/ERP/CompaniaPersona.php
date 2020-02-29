<?php

namespace LinkApp\Models\ERP;

use Illuminate\Database\Eloquent\Model;

class CompaniaPersona extends Model
{
    protected $table = 'compania_persona';

    //many to one
     public function persona(){
        return $this->belongsTo('LinkApp\Models\ERP\Persona','idPersona');        
    } 

    //many to one a persona
    public function compania(){
        return $this->belongsTo('LinkApp\Models\ERP\Persona','idCompania'); 
       
    }
}
