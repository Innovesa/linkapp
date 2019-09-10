<?php

namespace LinkApp\Models\ERP;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'erp_perfil';
    
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

    
}
