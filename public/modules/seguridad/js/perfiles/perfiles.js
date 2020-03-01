document.addEventListener("DOMContentLoaded", function() {

    tipoDeDatos = 'cuadros';

    
    getVerDatos();
    Buscador();
    cambiarVista();
    agregarRemoverPerfiles();
    frmMantenimientoPerfiles();
    cargarDatos();


});


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
        $("#divPerfiles").css("margin",'1px');
    }else{
        $("#divPerfiles").css("margin",'');
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
        url : "../seguridad/perfiles/cuadros",
        type: "get",
        datatype:"html",
        data : {
            buscador:buscar,
            tipoDeDatos:diseno 
        }

    }).done(function(response){ 
       //existingUsers
       $("#divPerfiles").html(response);
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

    $("#frmMantenimientoPerfiles #id").val(response.usuario.id);
    $("#frmMantenimientoPerfiles #idPersona").val(response.usuario.idPersona);
    $("#frmMantenimientoPerfiles #persona").val(response.persona.identificacion+" | "+response.persona.nombre).prop( "disabled", true );
    $("#frmMantenimientoPerfiles #email").val(response.usuario.email);
    $("#frmMantenimientoPerfiles #username").val(response.usuario.username);

    $("#modalCambiarContrasena #idChangePassword").val(response.usuario.id);
    $("#selectPerfilesUsuario option").remove();
    $("#selectPerfiles option").remove();

    frmCambiarContrasena();
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

function cambiarContrasenaModal() {

    $("#cambiarContrasena").click(function() {
        $('#modalMantenimiento').modal('toggle');
        $('#modalCambiarContrasena').modal('show');
    });

    
    
}

function Buscador(){
    $(document).ready(function() {

        $("#buscador").keyup(function(event){

            getVerDatos();

        })     

    });
};

        ////////////////////////

function frmMantenimientoPerfiles(){
 $("#frmMantenimientoPerfiles").submit(function(event){
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

function frmCambiarContrasena(){
    $("#frmCambiarContrasena").submit(function(event){
           event.preventDefault(); //prevent default action 
   
           var post_url = $(this).attr("action"); //get form action url
           var request_method = $(this).attr("method"); //get form GET/POST method

   
           form_data = $(this).serialize(); //Encode form elements for submission
   
   
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
                   
               }else{
                   
                   limpiarForm('todo');
                   getVerDatos();
                   alertSuccess(response.success);
                   
               }
   
           });
       });
   
       //limpiar al cerrar
       $("#btnCerrarPasswordModal").click(function() {
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
        $("#frmMantenimientoPerfiles #usernameGroup input").removeClass("form-control").addClass("form-control is-invalid");
        $("#frmMantenimientoPerfiles #usernameGroup").append(mensajeError(errors.username));
    }else{
        limpiarForm('username');
    }

    if(errors.password){
        $("#frmMantenimientoPerfiles #passwordGroup input").removeClass("form-control").addClass("form-control is-invalid");
        $("#frmMantenimientoPerfiles #passwordGroup").append(mensajeError(errors.password));
    }else{
        limpiarForm('password');
    }

    if(errors.password-confirm){
        $("#frmMantenimientoPerfiles #password-confirmGroup input").removeClass("form-control").addClass("form-control is-invalid");
        $("#frmMantenimientoPerfiles #password-confirmGroup").append(mensajeError(errors.password-confirm));
    }else{
        limpiarForm('password-confirm');
    }

    if(errors.email){
        $("#frmMantenimientoPerfiles #emailGroup input").removeClass("form-control").addClass("form-control is-invalid");
        $("#frmMantenimientoPerfiles #emailGroup").append(mensajeError(errors.email));
    }else{
        limpiarForm('email');
    }

    if(errors.persona){
        $("#frmMantenimientoPerfiles #personaGroup input").removeClass("form-control").addClass("form-control is-invalid");
        $("#frmMantenimientoPerfiles #personaGroup").append(mensajeError(errors.persona));
    }else{
        limpiarForm('persona');
    }

}

function limpiarForm(indicador){

    if(indicador == "todo"){
        $("#frmMantenimientoPerfiles").find('input:text,input:file,input:password,#id').val('');
        $("#frmMantenimientoPerfiles").find('input:text,input:file,input:password,#id').removeClass("form-control is-invalid").addClass("form-control").prop( "disabled", false);
        $("#frmMantenimientoPerfiles").find('.invalid-feedback').remove();
        $('#modalMantenimiento').modal('hide');  
        $('#modalCambiarContrasena').modal('hide'); 
    }else{
        grupo = "#"+indicador+"Group";
        $("#frmMantenimientoPerfiles "+grupo).find('input:text,input:file,input:password,#id').removeClass("form-control is-invalid").addClass("form-control");
        $("#frmMantenimientoPerfiles "+grupo).find('.invalid-feedback').remove();
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

