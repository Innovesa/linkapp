<?php

namespace LinkApp\Models\ERP;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;

class Permiso extends Model
{
    public function ViewPermission()
    {
        return Gate::allows('view',[session("permisos"),url()->current()]);
    }

    public function AdminPermission()
    {
        return Gate::allows('admin',[session("permisos"),session("currentUrl")]);
    }

    public function DeletePermission()
    {
        return Gate::any(['delete','admin'],[session("permisos"),session("currentUrl")]);
    }

    public function ModifyPermission()
    {
        return Gate::any(['modify','admin'],[session("permisos"),session("currentUrl")]);
    }

    //Es las vistas hay que cambiar si hay algun cambio, igual en el modal de crear y update
    public function InsertPermission()
    {
        return Gate::any(['insert','admin'],[session("permisos"),session("currentUrl")]);
    }

    public function SuperPermission()
    {
        return Gate::allows('super',[session("permisos"),session("currentUrl")]);
    }
}
