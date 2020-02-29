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

    public function getPerfil($Compania,$isSuper=null)
    {
        if($Compania && !$isSuper){
            $whereCompania = $Compania->id;
        }else{
            $whereCompania = null;
        }

        $result = Perfil::where('idCompania','LIKE','%'.$whereCompania.'%')->get();
            
        return $result;
    }
    
}
