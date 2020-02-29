document.addEventListener("DOMContentLoaded", function() {

    tipoDeDatos = 'cuadros';

    
    getVerDatos();
    Buscador();
    cambiarVista();
    agregarRemoverPerfiles();
    frmMantenimientoUsuarios();
    buscadorPersona();
    cargarDatos();

});

function buscarPersonaSelect() {
    $("#selectPersona").click(function(){
    
        $.each($("#selectPersona option:selected"), function(){  

            $("#idPersona").val($(this).val());
            $("#persona").val($(this).html());
            $("#persona").prop( "disabled", true );
            $("#selectPersona").remove();
            
        });
    });

    if($("#persona").val() === ""){
        $("#selectPersonaDiv #selectPersona").remove();
    }
}

function buscadorPersona(){

        $("#persona").keyup(function(event){

            resultPersonas();

        });    

};

function resultPersonas(){
    event.preventDefault(); //prevent default action 

    buscar = $("#persona").val();


  $.ajax({
        url : "../seguridad/usuarios/result/personas",
        type: "get",
        datatype:"html",
        data : {
            buscador:buscar
        }

    }).done(function(response){ 
       //existingUsers
       $("#selectPersonaDiv").html(response);
       buscarPersonaSelect();
       console.log(response);
    });
}

function agregarRemoverPerfiles() {

    $("#addPerfil").click(function(){
      
        $.each($("#selectPerfiles option:selected"), function(){  

            opcion = '<option class="list-group-item list-group-item-action" value="'+$(this).val()+'">'+$(this).html()+'</option>';
            $("#selectPerfilesUsuario").append(opcion);
            $(this).remove();

        });
    });

    $("#removePerfil").click(function(){
   
        $.each($("#selectPerfilesUsuario option:selected"), function(){  

            opcion = '<option class="list-group-item list-group-item-action" value="'+$(this).val()+'">'+$(this).html()+'</option>';
            $("#selectPerfiles").append(opcion);
            $(this).remove();
            
        });
    });

}

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
        $("#divUsuarios").css("margin",'1px');
    }else{
        $("#divUsuarios").css("margin",'');
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
        url : "../seguridad/usuarios/cuadros",
        type: "get",
        datatype:"html",
        data : {
            buscador:buscar,
            tipoDeDatos:diseno 
        }

    }).done(function(response){ 
       //existingUsers
       $("#divUsuarios").html(response);
       getUpdateData();
       getCreateData();
       buttonExports();
       eliminar();
       estado();
        //console.log(response);
    });
}

function getCreateData(){

    //click para traer datos para el update
    $("a#crear").click(function() {


        var route = $(this).attr("data-route"); //get data info
        
        console.log(route );

     $.ajax({
            url : route,
            type: 'GET',
            dataType:'JSON',
        }).done(function(response){ 

            console.log(response);
            setCreateData(response);

        });

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

function addPasswordBlock() {
    $('#cambiarContrasena').hide();
    $('#passwordBlock').show();
    
}

function addCambiarContrasena() {

    $('#cambiarContrasena').show();
    $('#passwordBlock').hide();
    
}


function setUpdateData(response){

    $("#frmMantenimientoUsuarios #id").val(response.usuario.id);
    $("#frmMantenimientoUsuarios #idPersona").val(response.usuario.idPersona);
    $("#frmMantenimientoUsuarios #persona").val(response.persona.identificacion+" | "+response.persona.nombre).prop( "disabled", true );
    $("#frmMantenimientoUsuarios #email").val(response.usuario.email);
    $("#frmMantenimientoUsuarios #username").val(response.usuario.username);
    $("#selectPerfilesUsuario option").remove();
    $("#selectPerfiles option").remove();

    addCambiarContrasena();

    for (let i = 0; i < response.perfilesUsuario.length; i++) {
        
        opcion = '<option class="list-group-item list-group-item-action" value="'+response.perfilesUsuario[i][0].id+'">'+response.perfilesUsuario[i][0].nombre+'</option>';
        $("#selectPerfilesUsuario").append(opcion);
        
    }

    for (let i = 0; i < response.perfilesDisponibles.length; i++) {
        
        opcion = '<option class="list-group-item list-group-item-action" value="'+response.perfilesDisponibles[i].id+'">'+response.perfilesDisponibles[i].nombre+'</option>';
        $("#selectPerfiles").append(opcion);
        
    }

}


function setCreateData(response){

    $("#selectPerfilesUsuario option").remove();
    $("#selectPerfiles option").remove();

    addPasswordBlock();


    for (let i = 0; i < response.perfilesDisponibles.length; i++) {
        
        opcion = '<option class="list-group-item list-group-item-action" value="'+response.perfilesDisponibles[i].id+'">'+response.perfilesDisponibles[i].nombre+'</option>';
        $("#selectPerfiles").append(opcion);
        
    }

}


function Buscador(){
    $(document).ready(function() {

        $("#buscador").keyup(function(event){

            getVerDatos();

        })     

    });
};

        ////////////////////////

function frmMantenimientoUsuarios(){
 $("#frmMantenimientoUsuarios").submit(function(event){
        event.preventDefault(); //prevent default action 

        var post_url = $(this).attr("action"); //get form action url
        var request_method = $(this).attr("method"); //get form GET/POST method

        var perfiles = [];
        
        $.each($("#selectPerfilesUsuario option"), function(){  

            perfiles.push($(this).val());
           
        });


        form_data = $(this).serialize() + '&usuarioPerfiles=' + perfiles; //Encode form elements for submission


        $.ajax({

            url : post_url,
            type: request_method,
            data : form_data,
            dataType:'JSON',
            processData: false,
            //contentType: false,

        }).done(function(response){ //

            console.log(response);

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

    if(errors.username){
        $("#frmMantenimientoUsuarios #usernameGroup input").removeClass("form-control").addClass("form-control is-invalid");
        $("#frmMantenimientoUsuarios #usernameGroup").append(mensajeError(errors.username));
    }else{
        limpiarForm('username');
    }

    if(errors.password){
        $("#frmMantenimientoUsuarios #passwordGroup input").removeClass("form-control").addClass("form-control is-invalid");
        $("#frmMantenimientoUsuarios #passwordGroup").append(mensajeError(errors.password));
    }else{
        limpiarForm('password');
    }

    if(errors.password-confirm){
        $("#frmMantenimientoUsuarios #password-confirmGroup input").removeClass("form-control").addClass("form-control is-invalid");
        $("#frmMantenimientoUsuarios #password-confirmGroup").append(mensajeError(errors.password-confirm));
    }else{
        limpiarForm('password-confirm');
    }

    if(errors.email){
        $("#frmMantenimientoUsuarios #emailGroup input").removeClass("form-control").addClass("form-control is-invalid");
        $("#frmMantenimientoUsuarios #emailGroup").append(mensajeError(errors.email));
    }else{
        limpiarForm('email');
    }

    if(errors.persona){
        $("#frmMantenimientoUsuarios #personaGroup input").removeClass("form-control").addClass("form-control is-invalid");
        $("#frmMantenimientoUsuarios #personaGroup").append(mensajeError(errors.persona));
    }else{
        limpiarForm('persona');
    }

}

function limpiarForm(indicador){

    if(indicador == "todo"){
        $("#frmMantenimientoUsuarios").find('input:text,input:file,input:password,#id').val('');
        $("#frmMantenimientoUsuarios").find('input:text,input:file,input:password,#id').removeClass("form-control is-invalid").addClass("form-control").prop( "disabled", false);
        $("#frmMantenimientoUsuarios").find('.invalid-feedback').remove();
        $('#modalMantenimiento').modal('toggle');  
    }else{
        grupo = "#"+indicador+"Group";
        $("#frmMantenimientoUsuarios "+grupo).find('input:text,input:file,input:password,#id').removeClass("form-control is-invalid").addClass("form-control");
        $("#frmMantenimientoUsuarios "+grupo).find('.invalid-feedback').remove();
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

