<?php

namespace LinkApp\Models\ERP;

use Illuminate\Database\Eloquent\Model;

class PerfilOpcion extends Model
{
    protected $table = 'perfil_opcion';

     //many to one
    public function perfil(){
        return $this->belongsTo('LinkApp\Models\ERP\Perfil','idPerfil');        
    }

    //many to one
    public function opcion(){
        return $this->belongsTo('LinkApp\Models\ERP\Opcion','idOpcion');        
    }
}
