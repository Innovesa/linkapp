<?php

namespace LinkApp\Models\ERP;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';

    //many to one
    public function estado(){
        return $this->belongsTo('LinkApp\Models\ERP\Estado','idEstado'); 
           
    }
    
    //one to many
    public function menuOpcion(){
        return $this->hasMany('LinkApp\Models\ERP\MenuOpcion');
    }
}
