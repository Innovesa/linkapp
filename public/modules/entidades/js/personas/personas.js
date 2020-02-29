document.addEventListener("DOMContentLoaded", function() {

    tipoDeDatos = 'cuadros';

    getVerDatos();
    Buscador();
    cambiarVista();
    frmMantenimientoPersonas();
    cargarDatos();

});



function buttonExports(){
    $('.dataTables-example').DataTable({
        pageLength: 25,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [
            { extend: 'copy'},
            {extend: 'csv'},
            {extend: 'excel', title: 'file'},
            {extend: 'pdf', title: 'file'},

            {extend: 'print',
             customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
            }
            }
        ]

    });
}


function cargarDatos() {
    view = tipoDeDatos;
    $(".btnView").addClass("btn-white");
    $("#btn-" + view).removeClass("btn-white");
    $("#btn-" + view).addClass("btn-primary");

    if(view == 'table'){
        $("#divPersonas").css("margin",'1px');
    }else{
        $("#divPersonas").css("margin",'');
    }

}

function cambiarVista(){
    //cargar cuadros
    $("#btn-cuadros").click(function() {
        tipoDeDatos = 'cuadros';
        getVerDatos();
        cargarDatos();
    });

    //cargar table
    $("#btn-table").click(function() {
        tipoDeDatos = 'table';
        getVerDatos();
        cargarDatos();
    });
}


function getVerDatos(){
    event.preventDefault(); //prevent default action 

    buscar = $("#buscador").val();
    diseno = tipoDeDatos;

  $.ajax({
        url : "../entidades/personas/cuadros",
        type: "get",
        datatype:"html",
        data : {
            buscador:buscar,
            tipoDeDatos:diseno 
        }

    }).done(function(response){ 
       //existingUsers
       $("#divPersonas").html(response);
       getUpdateData();
       buttonExports();
       eliminar();
       estado();
        //console.log(response);
    });
}

function getUpdateData(){

    //click para traer datos para el update
    $("a#editar").click(function() {


        var route = $(this).attr("data-route"); //get data info
        
        console.log(route );

     $.ajax({
            url : route,
            type: 'GET',
            dataType:'JSON',
        }).done(function(response){ 

            console.log(response);
            setUpdateData(response);

        });

    });

}

function eliminar(){

    //click para eliminar
    $("button#eliminar").click(function(event) {
        event.preventDefault(); //prevent default action 

        var route = $(this).attr("data-route"); //get data info
        
        console.log(route);

     $.ajax({
            url : route,
            type: 'GET',
            dataType:'JSON',
        }).done(function(response){ 

            if(response.errors){

                alertDanger(response.errors);
                console.log(response);
            }else{
                getVerDatos();
                alertSuccess(response.success);
            }

        });

    });
}

function estado(){

    //click para eliminar
    $("button#estado").click(function(event) {
        event.preventDefault(); //prevent default action 

        var route = $(this).attr("data-route"); //get data info
        
        console.log(route);

     $.ajax({
            url : route,
            type: 'GET',
            dataType:'JSON',
        }).done(function(response){ 

            if(response.errors){

                alertDanger(response.errors);
                console.log(response);
            }else{
                getVerDatos();
                alertSuccess(response.success);
            }

        });

    });
}



function setUpdateData(response){

    $("#frmMantenimientoPersonas #id").val(response.id);
    $("#frmMantenimientoPersonas #nombre").val(response.nombre);
    $("#frmMantenimientoPersonas #alias").val(response.alias);
    $("#frmMantenimientoPersonas #identificacion").val(response.identificacion);
    
    $("#frmMantenimientoPersonas #tipoIdentificacion").val(response.idTipoIdentificacion).change();
}


function Buscador(){
    $(document).ready(function() {

        $("#buscador").keyup(function(event){

            getVerDatos();

        })     

    });
};

        ////////////////////////

function frmMantenimientoPersonas(){
 $("#frmMantenimientoPersonas").submit(function(event){
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

                erroresForm(response.errors)
                //console.log(response.errors);
            }else{
                //console.log(response.success);
                limpiarForm('todo');
                getVerDatos();
                alertSuccess(response.success);
                //location.reload();
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

function erroresForm(errors){

    if(errors.nombre){
        $("#frmMantenimientoPersonas #nombreGroup input").removeClass("form-control").addClass("form-control is-invalid");
        $("#frmMantenimientoPersonas #nombreGroup").append(mensajeError(errors.nombre));
    }else{
        limpiarForm('nombre');
    }

    if(errors.identificacion){
        $("#frmMantenimientoPersonas #identificacionGroup input").removeClass("form-control").addClass("form-control is-invalid");
        $("#frmMantenimientoPersonas #identificacionGroup").append(mensajeError(errors.identificacion));
    }else{
        limpiarForm('identificacion');
    }

    if(errors.alias){
        $("#frmMantenimientoPersonas #aliasGroup input").removeClass("form-control").addClass("form-control is-invalid");
        $("#frmMantenimientoPersonas #aliasGroup").append(mensajeError(errors.alias));
    }else{
        limpiarForm('alias');
    }

    if(errors.imagen){
        $("#frmMantenimientoPersonas #imagenGroup input").removeClass("form-control").addClass("form-control is-invalid");
        $("#frmMantenimientoPersonas #imagenGroup").append(mensajeError(errors.imagen));
    }else{
        limpiarForm('imagen');
    }

}

function limpiarForm(indicador){

    if(indicador == "todo"){
        $("#frmMantenimientoPersonas").find('input:text,input:file,#id').val('');
        $("#frmMantenimientoPersonas").find('input:text,input:file,#id').removeClass("form-control is-invalid").addClass("form-control");
        $("#frmMantenimientoPersonas").find('.invalid-feedback').remove();
        $('#modalMantenimiento').modal('toggle');  
    }else{
        grupo = "#"+indicador+"Group";
        $("#frmMantenimientoPersonas "+grupo).find('input:text,input:file,#id').removeClass("form-control is-invalid").addClass("form-control");
        $("#frmMantenimientoPersonas "+grupo).find('.invalid-feedback').remove();
    }

}

function alertSuccess(mensaje){
    toastr.options = {
        "closeButton": true,
        "debug": false,
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

function alertDanger(mensaje){
    toastr.options = {
        "closeButton": true,
        "debug": false,
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
    toastr.error('',mensaje);
}

