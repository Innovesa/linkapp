@extends('temes.inspinia.layouts.principal')

@section('content')

<link  rel="stylesheet" type="text/css"   href="{{ Module::asset('Entidades:css/entidades.css') }}">

<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Lista de Compañias</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{url('/home')}}"> {{session('aplicacion')->nombre}} </a>
                </li>
                <li>
                    <a href="#"> Entidades </a>
                </li>
                <li class="active">
                    <strong>Compañías</strong>
                </li>
            </ol>
        </div>

        <div class="col-sm-8">
                <div class="title-action">

                    @canany(['insert','admin'],[session("permisos"),session("currentUrl")])
                        
                        <a data-toggle="modal" class="btn btn-primary" href="#modalMantenimiento"><i class="fa fa-plus"></i>{{@trans('entidades::entidades.nuevo')}}</a>
                   
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
                            <i class="fa fa-search"></i>{{@trans('entidades::entidades.buscar')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <br>
    <div class="row" id="divCompanias">

    </div>
</div>


<!--Modal -->
@canany(['insert','modify','admin'],[session("permisos"),session("currentUrl")])

    <div class="modal inmodal fade" id="modalMantenimiento" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">{{@trans('entidades::entidades.mantenimiento.companias')}}</h4>
                            <small class="font-bold">{{@trans('entidades::entidades.mantenimiento.companias.agregar.editar')}}</small>
                        </div>
                        <div class="modal-body">
                            <form role="form" name="frmMantenimientoCompanias" id="frmMantenimientoCompanias" action="{{route('entidades.companias.create')}}" enctype="multipart/form-data" method="POST">
                                @csrf

                                <input type="hidden" id="id" name="id" value="">

                                <div class="form-group col-sm-12">
                                    <label>{{@trans('entidades::entidades.tipo.identificacion')}}</label>


                                    <div class="form-row">
                                        <div class="col-sm-3 no-padding-left">
                                            <select class="form-control" name="tipoIdentificacion" id="tipoIdentificacion">
                                                @foreach ($identificaciones as $identificacion)
                                                    <option value="{{$identificacion->id}}">{{$identificacion->nombre}}</option>
                                                 @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-9" id="identificacionGroup">

                                            <input type="text" id="identificacion" name="identificacion" placeholder="{{@trans('entidades::entidades.identificacion')}}" class="form-control">
                                   
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group col-sm-12" id="nombreGroup">
                                    <label>{{@trans('entidades::entidades.nombre')}}</label>
                                    <input type="text" id="nombre" name="nombre" placeholder="{{@trans('entidades::entidades.nombre')}}" class="form-control">
                                </div>

                                <div class="form-group col-sm-12" id="aliasGroup">
                                    <label>{{@trans('entidades::entidades.alias')}}</label>
                                    <input type="text" id="alias" name="alias" placeholder="{{@trans('entidades::entidades.alias')}}" class="form-control">
        
                                </div>

                                <div class="form-group col-sm-12" id="imagenGroup">
                                    <label>{{@trans('entidades::entidades.imagen')}}</label>
                                    <input type="file" id="imagen" name="imagen" placeholder="{{@trans('entidades::entidades.imagen')}}" class="form-control">
                                </div>

                            
                            <p>&nbsp;</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" id="btnCerrar">{{@trans('entidades::entidades.cerrar')}}</button>
                            <button type="submit" class="btn btn-primary" >{{@trans('entidades::entidades.guardar.cambios')}}</button>
                        </div>
                    </form>
                    </div>
                </div>
    </div>
    
@endcanany

<script src="{{ Module::asset('Entidades:js/companias/companias.js') }}"></script>
@endsection