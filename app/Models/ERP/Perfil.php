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

    //many to one
    public function compania(){
        return $this->belongsTo('LinkApp\Models\ERP\Persona','idCompania');        
    }


    public function getPerfil($Compania,$isSuper=null,$buscar=null)
    {
        if($Compania && !$isSuper){
            $whereCompania = $Compania->id;
        }else{
            $whereCompania = null;
        }

        $result = Perfil::where('nombre','LIKE','%'.$buscar.'%')->where('idCompania','LIKE','%'.$whereCompania.'%')->get();
            
        return $result;
    }
    
}
