<?php

namespace LinkApp\Models\ERP;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = 'estado';

    public function getidEstadoActivo(){
        $activo = Estado::where('codigo','ESTADO_ACTIVO')->first();
        return $activo->id;
    }

    public function getidEstadoDesactivado(){
        $desactivado = Estado::where('codigo','ESTADO_DESACTIVADO')->first();
        return $desactivado->id;
    }
}
