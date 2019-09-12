
@component('temes.inspinia.layouts.principal')

    @slot('nombreAplicacion','ERP')

    @slot('nombreEmpresa','Innove S.A')




    @section('content')
        <div class="row">
            <div class="col-lg-12">
            <button type="button" class="btn btn-default" onClick="window.open('erp-aplicaciones.html','self');">
                    <i class="fa fa-th fa-5x"></i>
                    <h3>Aplicaciones</h3>
                </button>
                <button type="button" class="btn btn-primary">
                    <i class="fa fa-plus fa-5x"></i>
                    <h3>Agregar</h3>
                </button>
            </div>
        </div>
    @endsection
    

@endcomponent