<?php

namespace LinkApp\Models\ERP;

use Illuminate\Database\Eloquent\Model;

class Parametro extends Model
{
    protected $table = 'parametro';

    function getidRolCampania(){
        $idcompania = Parametro::where('codigo','ROL_COMPANIA')->first();
        return $idcompania->valor;
    }
}
