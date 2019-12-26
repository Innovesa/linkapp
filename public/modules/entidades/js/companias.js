document.addEventListener("DOMContentLoaded", function() {

    getVerCuadros();
    Buscador();
    frmMantenimientoCompanias();
});




function cargarDatos(vista) {
    view = vista;
    $(".btnView").addClass("btn-white");
    $("#btn-" + view).removeClass("btn-white");
    $("#btn-" + view).addClass("btn-primary");

}


function getVerCuadros(){
    event.preventDefault(); //prevent default action 

    buscar = $("#buscador").val();

  $.ajax({
        url : "../entidades/companias/cuadros",
        type: "get",
        datatype:"html",
        data : {
            buscador:buscar
        }

    }).done(function(response){ 
       //existingUsers
       $("#divCompanias").html(response);
   
        //console.log(response);
    });
}


function Buscador(){
    $(document).ready(function() {

        $("#buscador").keyup(function(event){

            getVerCuadros();

        })     

    });
};

        ////////////////////////

function frmMantenimientoCompanias(){
    $("#frmMantenimientoCompanias").submit(function(event){
        event.preventDefault(); //prevent default action 

        var post_url = $(this).attr("action"); //get form action url
        var request_method = $(this).attr("method"); //get form GET/POST method
        var form_data = new FormData(this); //Encode form elements for submission

        $.ajax({
            url : post_url,
            type: request_method,
            data : form_data,
            dataType:'JSON',
            processData: false,
            contentType: false,
        }).done(function(response){ //

            if(response.errors){

                errores(response.errors)
                //console.log(response.errors);
            }else{
                //console.log(response.success);
                limpiarForm('todo');
                getVerCuadros();
                alertSuccess(response.success);
            }

        });
    });

    //limpiar al cerrar
    $("#btnCerrar").click(function() {
        limpiarForm('todo');
    });
};

function mensajeError(mensaje){

    error = '<span class="invalid-feedback" role="alert">\
                <strong>'+mensaje+'</strong>\
            </span>';
    
    return error;
}

function errores(errors){

    if(errors.nombre){
        $("#frmMantenimientoCompanias #nombreGroup input").removeClass("form-control").addClass("form-control is-invalid");
        $("#frmMantenimientoCompanias #nombreGroup").append(mensajeError(errors.nombre));
    }else{
        limpiarForm('nombre');
    }

    if(errors.cedula){
        $("#frmMantenimientoCompanias #cedulaGroup input").removeClass("form-control").addClass("form-control is-invalid");
        $("#frmMantenimientoCompanias #cedulaGroup").append(mensajeError(errors.cedula));
    }else{
        limpiarForm('cedula');
    }

    if(errors.alias){
        $("#frmMantenimientoCompanias #aliasGroup input").removeClass("form-control").addClass("form-control is-invalid");
        $("#frmMantenimientoCompanias #aliasGroup").append(mensajeError(errors.alias));
    }else{
        limpiarForm('alias');
    }

    if(errors.imagen){
        $("#frmMantenimientoCompanias #imagenGroup input").removeClass("form-control").addClass("form-control is-invalid");
        $("#frmMantenimientoCompanias #imagenGroup").append(mensajeError(errors.imagen));
    }else{
        limpiarForm('imagen');
    }

}

function limpiarForm(indicador){

    if(indicador == "todo"){
        $("#frmMantenimientoCompanias").find('input:text,input:file').val('');
        $("#frmMantenimientoCompanias").find('input:text,input:file').removeClass("form-control is-invalid").addClass("form-control");
        $("#frmMantenimientoCompanias").find('.invalid-feedback').remove();
        $('#modalMantenimiento').modal('toggle');  
    }else{
        grupo = "#"+indicador+"Group";
        $("#frmMantenimientoCompanias "+grupo).find('input:text,input:file').removeClass("form-control is-invalid").addClass("form-control");
        $("#frmMantenimientoCompanias "+grupo).find('.invalid-feedback').remove();
    }

}

function alertSuccess(mensaje){
    toastr.options = {
        "closeButton": true,
        "debug": true,
        "progressBar": true,
        "preventDuplicates": false,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "400",
        "hideDuration": "1000",
        "timeOut": "7000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    toastr.success('',mensaje);
}
