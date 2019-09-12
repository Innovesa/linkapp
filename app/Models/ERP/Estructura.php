<?php

namespace LinkApp\Models\ERP;

use Illuminate\Database\Eloquent\Model;

class Estructura extends Model
{
    protected $table = 'erp_estructura';

    //one to many
    public function opcion(){
        return $this->hasMany('LinkApp\Models\ERP\Opcion');
    }

    //one to many
    public function estructuraOne(){
        return $this->hasMany('LinkApp\Models\ERP\Estructura');
    } 

     //many to one
    public function estructura(){
        return $this->belongsTo('LinkApp\Models\ERP\Estructura','superior'); 
           
    }   
    //many to one
    public function estado(){
        return $this->belongsTo('LinkApp\Models\ERP\Estado','idEstado'); 
           
    }

}
