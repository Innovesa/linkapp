@extends('temes.inspinia.layouts.principal')

@section('content')

<link itemprop="url" href="{{ Module::asset('Entidades:css/entidades.css') }}">

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
                    <a data-toggle="modal" class="btn btn-primary" href="#modalMantenimiento"><i class="fa fa-plus"></i> Nuevo</a>
                    <div class="btn-group">
                        <button class="btn btnView btn-primary" id="btn-widget" onclick="cargarDatos('widget')"><i class="fa fa-th-large"></i></button>
                        <button class="btn btnView btn-primary btn-white" id="btn-table" onclick="cargarDatos('table')"><i class="fa fa-th-list"></i></button>
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
                            <i class="fa fa-search"></i> Buscar
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

<div class="modal inmodal fade" id="modalMantenimiento" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Mantenimiento de compañías</h4>
                        <small class="font-bold">Agregar o editar compañías.</small>
                    </div>
                    <div class="modal-body">
                        <form role="form" name="frmMantenimientoCompanias" id="frmMantenimientoCompanias" action="{{route('entidades.companias.create')}}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <input type="hidden" id="id" name="id" value="">
                            <div class="form-group col-sm-12" id="cedulaGroup">
                                <label>Cédula</label>
                                <input type="text" id="cedula" name="cedula" placeholder="Cédula" class="form-control">
                            </div>

                            <div class="form-group col-sm-12" id="nombreGroup">
                                <label>Nombre</label>
                                <input type="text" id="nombre" name="nombre" placeholder="Nombre" class="form-control">
                            </div>

                            <div class="form-group col-sm-12" id="aliasGroup">
                                <label>Alias</label>
                                <input type="text" id="alias" name="alias" placeholder="Alias" class="form-control">
     
                            </div>

                            <div class="form-group col-sm-12" id="imagenGroup"><label>Imagen</label>
                                 <input type="file" id="imagen" name="imagen" placeholder="Imagen" class="form-control">

                            </div>
                        
                        <p>&nbsp;</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" id="btnCerrar">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="btnGuardar">Guardar cambios</button>
                    </div>
                </form>
                </div>
            </div>
</div>

<script src="{{ Module::asset('Entidades:js/companias.js') }}"></script>
@endsection