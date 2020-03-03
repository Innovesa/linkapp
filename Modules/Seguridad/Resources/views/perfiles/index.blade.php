@extends('temes.inspinia.layouts.principal')

@section('content')

<link  rel="stylesheet" type="text/css"   href="{{ Module::asset('Entidades:css/entidades.css') }}">

<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Lista de Perfiles</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{url('/home')}}"> {{session('aplicacion')->nombre}} </a>
                </li>
                <li>
                    <a href="#">Seguridad </a>
                </li>
                <li class="active">
                    <strong>Perfiles</strong>
                </li>
            </ol>
        </div>

        <div class="col-sm-8">
                <div class="title-action">

                    @canany(['insert','admin'],[session("permisos"),session("currentUrl")])
                        
                        <a data-toggle="modal"  id="crear" data-route="{{route('seguridad.perfiles.createData')}}" class="btn btn-primary" href="#modalMantenimiento"><i class="fa fa-plus"></i>{{@trans('seguridad::seguridad.nuevo')}}</a>
                   
                    @endcanany

                    <div class="btn-group">
                        <button class="btn btnView btn-primary" id="btn-cuadros" ><i class="fa fa-th-large"></i></button>
                        <button class="btn btnView btn-primary btn-white" id="btn-table" ><i class="fa fa-th-list"></i></button>
                    </div>
                </div>
        </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
            <div class="search-form  col-md-12">
                <div class="input-group">
                    <input type="text" placeholder="Buscar" id="buscador" class="form-control input-lg">
                    <div class="input-group-btn">
                        <button class="btn btn-lg btn-primary" id="btn-buscar">
                            <i class="fa fa-search"></i>{{@trans('seguridad::seguridad.buscar')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <br>
    <div class="row" id="divPerfiles">

    </div>
</div>


<!--Modal -->
@canany(['insert','modify','admin'],[session("permisos"),session("currentUrl")])

    <div class="modal inmodal fade" id="modalMantenimiento" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">{{@trans('seguridad::seguridad.mantenimiento.perfiles')}}</h4>
                            <small class="font-bold">{{@trans('seguridad::seguridad.mantenimiento.perfiles.agregar.editar')}}</small>
                        </div>
                        <form role="form" name="frmMantenimientoPerfiles" id="frmMantenimientoPerfiles" action="{{route('seguridad.perfiles.create')}}" enctype="multipart/form-data" method="POST">
                            @csrf

                            <div class="modal-body">
                                    
                                <div class="tabs-container">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true">Perfil</a></li>
                                        <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="false">Roles</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="tab-1" class="tab-pane active">
                                            <div class="panel-body">

                                                <input type="hidden" name="id" id="id" value="">

                                                <div class="form-group col-sm-12" id="nombreGroup">
                                                    <label>{{@trans('entidades::entidades.nombre')}}</label>
                                                    <input type="text" id="nombre" name="nombre" placeholder="{{@trans('entidades::entidades.nombre')}}" class="form-control">
                                                </div>

                                                <p>&nbsp;</p>

                                                <div class="col-md-12">
                                                    <div class="col-md-5">
                
                                                        <ul class="list-group">
                                                            <li class="list-group-item list-group-item-dark">Opciones asosiadas al perfil</li>
                                                        </ul>
                
                                                        <select class="list-group" id="selectOpcionesPerfil" style="width:100%; height: 350px; " multiple>
                                                        </select>
                                                        
                                                    </div>
                                                    <div class="col-md-2 text-center align-middle" style="padding-top: 150px; ">
                                                        <button type="button" id="addPerfil" class="btn btn-primary">Agregar</button>
                                                        <p>&nbsp;</p>
                                                        <button type="button" id="removePerfil" class="btn btn-primary">Remover</button>
                
                                                    </div>
                                                    <div class="col-md-5">
                
                                                        <ul class="list-group">
                                                            <li class="list-group-item list-group-item-dark">Opciones disponibles</li>
                                                        </ul>
                
                                                        <select class="list-group" id="selectOpciones" style="width:100%; height: 350px; " multiple>

                                                        </select>
                                                    
                                                    </div>
                
                                                </div>
                
                                                
                                                <p>&nbsp;</p>
                                            </div>
                                        </div>
                                        <div id="tab-2" class="tab-pane">
                                            <div class="panel-body">

                                                <div class="col-md-12">
                                                    <div class="col-md-12">
                
                                                        <ul class="list-group">
                                                            <li class="list-group-item list-group-item-dark">Opciones asosiadas al perfil</li>
                                                        </ul>
                
                                                        <table class="table" id="opcionesRolesTable">
                                                            <thead>
                                                              <tr>
                                                                <th scope="col">Nombre</th>
                                                                <th scope="col">Modificar</th>
                                                                <th scope="col">Eliminar</th>
                                                                <th scope="col">Insertar</th>
                                                                <th scope="col">Admin</th>
                                                                <th scope="col">Super</th>
                                                                
                                                              </tr>
                                                            </thead>
                                                            <tbody>

                                                            </tbody>
                                                        </table>
                                                        
                                                    </div>
                                                    
                                                    
                                                </div>
                
                                                
                                                <p>&nbsp;</p>
                                            </div>
                                        </div>
                                    </div>
            
            
                                </div>

                                
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" id="btnCerrar">{{@trans('seguridad::seguridad.cerrar')}}</button>
                                <button type="submit" class="btn btn-primary" >{{@trans('seguridad::seguridad.guardar.cambios')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
    </div>
    
@endcanany



<script src="{{ Module::asset('Seguridad:js/perfiles/perfiles.js') }}"></script>
@endsection