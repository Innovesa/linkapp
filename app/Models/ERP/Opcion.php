<?php

namespace LinkApp\Models\ERP;

use Illuminate\Database\Eloquent\Model;

class Aplicacion extends Model
{
    protected $table = 'opcion';

    //one to many
    public function estructuraOne(){
        return $this->hasMany('LinkApp\Models\ERP\Opcion','superior');
    } 

     //many to one
    public function estructura(){
        return $this->belongsTo('LinkApp\Models\ERP\Opcion','superior'); 
           
    }   
    
    //one to many
    public function menuOpcion(){
        return $this->hasMany('LinkApp\Models\ERP\MenuOpcion','idOpcion');
    }

    //one to many
    public function perfilOpcion(){
        return $this->hasMany('LinkApp\Models\ERP\PerfilOpcion','idOpcion');
    }

    //one to many
    public function usuarioOpcion(){
        return $this->hasMany('LinkApp\Models\ERP\UsuarioOpcion','idOpcion');
    }
    //many to one
    public function estado(){
        return $this->belongsTo('LinkApp\Models\ERP\Estado','idEstado'); 
           
    }

}
