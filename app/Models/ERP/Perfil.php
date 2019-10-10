<?php

namespace LinkApp\Models\ERP;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'perfil';
    
    //one to many
    public function perfilUsuario(){
        return $this->hasMany('LinkApp\Models\ERP\PerfilUsuario');
    }

    //one to many
    public function perfilOpcion(){
        return $this->hasMany('LinkApp\Models\ERP\PerfilOpcion');
    }

     //many to one
    public function estado(){
        return $this->belongsTo('LinkApp\Models\ERP\Estado','idEstado');        
    }

    /*many to many 
    public function opcion(){
        return $this->belongsToMany('LinkApp\Models\ERP\Opcion', 'erp_perfil_opcion','idOpcion', 'idPerfil');        
    }*/
    
}
