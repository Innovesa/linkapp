@extends('temes.inspinia.layouts.principal')

@section('content')

<link  rel="stylesheet" type="text/css"   href="{{ Module::asset('Entidades:css/entidades.css') }}">

<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Lista de Usuarios</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{url('/home')}}"> {{session('aplicacion')->nombre}} </a>
                </li>
                <li>
                    <a href="#">Seguridad </a>
                </li>
                <li class="active">
                    <strong>Usuarios</strong>
                </li>
            </ol>
        </div>

        <div class="col-sm-8">
                <div class="title-action">

                    @canany(['insert','admin'],[session("permisos"),session("currentUrl")])
                        
                        <a data-toggle="modal"  id="crear" data-route="{{route('seguridad.usuarios.createData')}}" class="btn btn-primary" href="#modalMantenimiento"><i class="fa fa-plus"></i>{{@trans('seguridad::seguridad.nuevo')}}</a>
                   
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
    <div class="row" id="divUsuarios">

    </div>
</div>


<!--Modal -->
@canany(['insert','modify','admin'],[session("permisos"),session("currentUrl")])

    <div class="modal inmodal fade" id="modalMantenimiento" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">{{@trans('seguridad::seguridad.mantenimiento.usuarios')}}</h4>
                            <small class="font-bold">{{@trans('seguridad::seguridad.mantenimiento.usuarios.agregar.editar')}}</small>
                        </div>
                        <form role="form" name="frmMantenimientoUsuarios" id="frmMantenimientoUsuarios" action="{{route('seguridad.usuarios.create')}}" enctype="multipart/form-data" method="POST">
                            @csrf

                            <div class="modal-body">
                                    
                                <div class="tabs-container">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true">Usuario</a></li>
                                        <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="false">Perfiles</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="tab-1" class="tab-pane active">
                                            <div class="panel-body">
                        
                                                <input type="hidden" id="id" name="id" value="">

                                                <div class="form-group col-sm-12" id="personaGroup">
                                                    
                                                    <label>{{@trans('seguridad::seguridad.persona')}}</label>
                                                    <input type="hidden" id="idPersona" name="idPersona" value="">
                                                    <input type="text" id="persona" name="persona" placeholder="{{@trans('seguridad::seguridad.persona')}}" class="form-control">

                                                    <div id="selectPersonaDiv">

                                                    </div>
                                                </div>
            
                                                <div class="form-group col-sm-12" id="emailGroup">
                                                    <label>{{@trans('seguridad::seguridad.correo')}}</label>
                                                    <input type="text" id="email" name="email" placeholder="{{@trans('seguridad::seguridad.correo')}}" class="form-control">
                                                </div>
            
                                                <div class="form-group col-sm-12" id="usernameGroup">
                                                    <label>{{@trans('seguridad::seguridad.username')}}</label>
                                                    <input type="text" id="username" name="username" placeholder="{{@trans('seguridad::seguridad.username')}}" class="form-control">
                                                </div>
                                                
                                                <div id="passwordBlock">
                                                    <div class="form-group col-sm-12" id="passwordGroup">
                                                        <label>{{@trans('seguridad::seguridad.password')}}</label>
                                                        <input type="password" id="password" name="password" placeholder="{{@trans('seguridad::seguridad.password')}}" class="form-control">
                
                                                    </div>
                
                                                    <div class="form-group col-sm-12" id="password-confirmGroup">
                                                        <label>{{@trans('seguridad::seguridad.password-confirm')}}</label>
                                                        <input type="password" id="password-confirm" name="password_confirmation" placeholder="{{@trans('seguridad::seguridad.password-confirm')}}" class="form-control">
                                                    </div>
                                                </div>


                                                <div id="cambiarContrasenaGroup">
                                                    <button type="button" id="cambiarContrasena" data-toggle="modal" data-target="#cambiarContrasena" class="btn btn-primary">Cambiar contraseña</button>
                                                </div>
            
                                            
                                            <p>&nbsp;</p>
                                            </div>
                                        </div>
                                        <div id="tab-2" class="tab-pane">
                                            <div class="panel-body">
                                                <div class="col-md-12">
                                                    <div class="col-md-5">
                
                                                        <ul class="list-group">
                                                            <li class="list-group-item list-group-item-dark">Perfiles asosiados al usuario</li>
                                                        </ul>
                
                                                        <select class="list-group" id="selectPerfilesUsuario" style="width:100%; height: 350px; " multiple>
                                                        </select>
                                                        
                                                    </div>
                                                    <div class="col-md-2 text-center align-middle" style="padding-top: 150px; ">
                                                        <button type="button" id="addPerfil" class="btn btn-primary">Agregar</button>
                                                        <p>&nbsp;</p>
                                                        <button type="button" id="removePerfil" class="btn btn-primary">Remover</button>
                
                                                    </div>
                                                    <div class="col-md-5">
                
                                                        <ul class="list-group">
                                                            <li class="list-group-item list-group-item-dark">Perfiles disponibles</li>
                                                        </ul>
                
                                                        <select class="list-group" id="selectPerfiles" style="width:100%; height: 350px; " multiple>

                                                        </select>
                                                    
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

@canany(['modify','admin'],[session("permisos"),session("currentUrl")])
<div class="modal inmodal fade" id="modalCambiarContrasena" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Cambiar contraseña</h4>
            
        </div>
        <form method="POST" name="frmCambiarContrasena" id="frmCambiarContrasena" action="{{ route('seguridad.usuarios.update.password') }}">
         @csrf
        <div class="modal-body">

            <input type="hidden" name="id" id="idChangePassword" value="">

                <div class="form-group row">
                    <label for="password" class="col-sm-3 col-form-label">Nueva Contraseña</label>

                    <div class="col-md-9">
                        <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password" minlength="8" autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password-confirm" class="col-sm-3 col-form-label">Confirmacion Contraseña</label>

                    <div class="col-md-9">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" minlength="8" required autocomplete="new-password">
                    </div>
                </div>
                <hr>
           
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" id="btnCerrarPasswordModal">{{@trans('seguridad::seguridad.cerrar')}}</button>
                    <button type="submit" class="btn btn-primary" >{{@trans('seguridad::seguridad.guardar.cambios')}}</button>
                </div>
    </form>
      </div>
    </div>
  </div>
@endcanany


<script src="{{ Module::asset('Seguridad:js/usuarios/usuarios.js') }}"></script>
@endsection