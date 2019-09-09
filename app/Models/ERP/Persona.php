<?php

namespace LinkApp\Models\ERP;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'erp_persona';

    //one to many
    public function usuario(){
        return $this->hasMany('LinkApp\Models\ERP\Usuario'); //Metodo lo que hace es traerme todos los likes relacionados con el id de img.
    }
}
