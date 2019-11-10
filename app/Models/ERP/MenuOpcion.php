<?php

namespace LinkApp\Models\ERP;

use Illuminate\Database\Eloquent\Model;

class MenuOpcion extends Model
{
    protected $table = 'menu_opcion';

    //many to one
    public function menu(){
        return $this->belongsTo('LinkApp\Models\ERP\Menu','idMenu'); 
           
    }

    //many to one
    public function opcion(){
        return $this->belongsTo('LinkApp\Models\ERP\Opcion','idOpcion'); 
           
    }
}
