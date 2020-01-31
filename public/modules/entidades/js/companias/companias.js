document.addEventListener("DOMContentLoaded", function() {

    tipoDeDatos = 'cuadros';

    getVerDatos();
    Buscador();
    cambiarVista();
    frmMantenimientoCompanias();
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
        $("#divCompanias").css("margin",'1px');
    }else{
        $("#divCompanias").css("margin",'');
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
        url : "../entidades/companias/cuadros",
        type: "get",
        datatype:"html",
        data : {
            buscador:buscar,
            tipoDeDatos:diseno 
        }

    }).done(function(response){ 
       //existingUsers
       $("#divCompanias").html(response);
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

    $("#frmMantenimientoCompanias #id").val(response.id);
    $("#frmMantenimientoCompanias #nombre").val(response.nombre);
    $("#frmMantenimientoCompanias #alias").val(response.alias);
    $("#frmMantenimientoCompanias #cedula").val(response.cedula);

}


function Buscador(){
    $(document).ready(function() {

        $("#buscador").keyup(function(event){

            getVerDatos();

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

                erroresForm(response.errors)
                //console.log(response.errors);
            }else{
                //console.log(response.success);
                limpiarForm('todo');
                getVerDatos();
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

function erroresForm(errors){

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
        $("#frmMantenimientoCompanias").find('input:text,input:file,#id').val('');
        $("#frmMantenimientoCompanias").find('input:text,input:file,#id').removeClass("form-control is-invalid").addClass("form-control");
        $("#frmMantenimientoCompanias").find('.invalid-feedback').remove();
        $('#modalMantenimiento').modal('toggle');  
    }else{
        grupo = "#"+indicador+"Group";
        $("#frmMantenimientoCompanias "+grupo).find('input:text,input:file,#id').removeClass("form-control is-invalid").addClass("form-control");
        $("#frmMantenimientoCompanias "+grupo).find('.invalid-feedback').remove();
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

