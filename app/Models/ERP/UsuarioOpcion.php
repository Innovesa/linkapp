<?php

namespace LinkApp\Models\ERP;

use Illuminate\Database\Eloquent\Model;

class UsuarioOpcion extends Model
{
    protected $table = 'usuario_opcion';

    //many to one
    public function opcion(){
        return $this->belongsTo('LinkApp\Models\ERP\Aplicacion','idOpcion'); 
               
    }

    //many to one
    public function usuario(){
        return $this->belongsTo('LinkApp\Models\ERP\Usuario','idUsuario'); 
               
    }
}
