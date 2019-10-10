<?php

namespace LinkApp\Models\ERP;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'persona';

    //one to many
    public function usuario(){
        return $this->hasMany('LinkApp\Models\ERP\Usuario');
    }

    //many to one
    public function estado(){
        return $this->belongsTo('LinkApp\Models\ERP\Estado','idEstado'); 
       
    }
}
