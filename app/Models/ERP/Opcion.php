<?php

namespace LinkApp\Models\ERP;

use Illuminate\Database\Eloquent\Model;

class Opcion extends Model
{
    protected $table = 'erp_opcion';

    //many to one
    public function estructura(){
        return $this->belongsTo('LinkApp\Models\ERP\Estructura','idEstructura'); 
               
    }

    //many to one
    public function estado(){
        return $this->belongsTo('LinkApp\Models\ERP\Estado','idEstado'); 
           
    }

    //one to many
    public function menuOpcion(){
        return $this->hasMany('LinkApp\Models\ERP\MenuOpcion');
    }

    //one to many
    public function perfilOpcion(){
        return $this->hasMany('LinkApp\Models\ERP\PerfilOpcion');
    }

    //one to many
    public function usuarioOpcion(){
        return $this->hasMany('LinkApp\Models\ERP\UsuarioOpcion');
    }
}
