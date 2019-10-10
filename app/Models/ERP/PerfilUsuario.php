<?php

namespace LinkApp\Models\ERP;

use Illuminate\Database\Eloquent\Model;

class PerfilUsuario extends Model
{
    protected $table = 'perfil_usuario';

     //many to one
     public function perfil(){
        return $this->belongsTo('LinkApp\Models\ERP\Perfil','idPerfil');        
    }  

     //many to one
     public function usuario(){
        return $this->belongsTo('LinkApp\Models\ERP\Usuario','idUsuario');        
    } 
}
