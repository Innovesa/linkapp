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
      
        $.each($("#selectOpciones option:selected"), function(){  

            opcion = '<option class="list-group-item list-group-item-action" value="'+$(this).val()+'">'+$(this).html()+'</option>';
            $("#selectOpcionesPerfil").append(opcion);

            var tr = '<tr>\
            <input type="hidden" name="idOpcion" value="'+$(this).val()+'">\
            <td>'+$(this).html()+'</td>\
            <td><input type="checkbox" name="modificar" value="1"/></td>\
            <td><input type="checkbox" name="eliminar" value="1"/></td>\
            <td><input type="checkbox" name="insertar" value="1"/></td>\
            <td><input type="checkbox" name="admin" value="1"></td>\
            <td><input type="checkbox" name="super" value="1"/></td>\
            </tr>';

            $("#opcionesRolesTable tbody").append(tr);
            $(this).remove();

        });
    });

    $("#removePerfil").click(function(){
   
        $.each($("#selectOpcionesPerfil option:selected"), function(){  

            opcion = '<option class="list-group-item list-group-item-action" value="'+$(this).val()+'">'+$(this).html()+'</option>';
            $("#selectOpciones").append(opcion);

            $("#opcionesRolesTable tbody tr input[name=idOpcion]").find('input[name=idOpcion]').val();

            var idOpcion = $(this).val();

            $.each($("#opcionesRolesTable tbody tr"), function(){  
                if ($(this).find('input[name=idOpcion]').val() == idOpcion ) {

                    $(this).remove();
                }
            });

            $(this).remove();
            
        });
    });


    $("#pruebaBtn").click(function(){

        prueba = [];
   
        $.each($("#opcionesRolesTable tbody tr"), function(){  

            var rolModificar = getRolValue($(this),'modificar');
            var rolEliminar = getRolValue($(this),'eliminar');
            var rolInsertar = getRolValue($(this),'insertar');
            var rolAdmin = getRolValue($(this),'admin');
            var rolSuper = getRolValue($(this),'super');

            prueba.push({
                idOpcion:$(this).find('input[name=idOpcion]').val(),
                rolModificar:rolModificar,
                rolEliminar:rolEliminar,
                rolInsertar:rolInsertar,
                rolAdmin :rolAdmin ,
                rolSuper:rolSuper
            });
            
        });

    });

}

function getRolValue(buscar,rol) {

    if ($(buscar).find('input[name='+rol+']:checked').val()) {
        return parseInt($(buscar).find('input[name='+rol+']:checked').val());
    }else{
        return 0;
    }
}

function setRolChecked(rol) {

    if (rol == 1) {
        return "checked";
    }else{
        return "";
    }
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
        

     $.ajax({
            url : route,
            type: 'GET',
            dataType:'JSON',
        }).done(function(response){ 

            
            setCreateData(response);

        });

    });

}

function getUpdateData(){

    //click para traer datos para el update
    $("a#editar").click(function() {


        var route = $(this).attr("data-route"); //get data info
        


     $.ajax({
            url : route,
            type: 'GET',
            dataType:'JSON',
        }).done(function(response){ 

           
            setUpdateData(response);

        });

    });

}

function eliminar(){

    //click para eliminar
    $("button#eliminar").click(function(event) {
        event.preventDefault(); //prevent default action 

        var route = $(this).attr("data-route"); //get data info
        
  

     $.ajax({
            url : route,
            type: 'GET',
            dataType:'JSON',
        }).done(function(response){ 

            if(response.errors){

                alertDanger(response.errors);
                
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
    

     $.ajax({
            url : route,
            type: 'GET',
            dataType:'JSON',
        }).done(function(response){ 

            if(response.errors){

                alertDanger(response.errors);
               
            }else{
                getVerDatos();
                alertSuccess(response.success);
            }

        });

    });
}



function setUpdateData(response){

    $("#frmMantenimientoPerfiles #id").val(response.perfil.id);
    $("#frmMantenimientoPerfiles #nombre").val(response.perfil.nombre);

    $("#opcionesRolesTable tbody tr").remove();
    $("#selectOpcionesPerfil option").remove();
    $("#selectOpciones option").remove();


    for (let i = 0; i < response.opcionesPerfil.opcion.length; i++) {

        
        opcion = '<option class="list-group-item list-group-item-action" value="'+response.opcionesPerfil.opcion[i].id+'">'+response.opcionesPerfil.opcion[i].nombre+'</option>';
        $("#selectOpcionesPerfil").append(opcion);

        var tr = '<tr>\
        <input type="hidden" name="idOpcion" value="'+response.opcionesPerfil.opcion[i].id+'">\
        <td>'+response.opcionesPerfil.opcion[i].nombre+'</td>\
        <td><input type="checkbox" name="modificar" value="1" '+setRolChecked(response.opcionesPerfil.roles[i].rolModificar)+'/></td>\
        <td><input type="checkbox" name="eliminar" value="1" '+setRolChecked(response.opcionesPerfil.roles[i].rolEliminar)+'/></td>\
        <td><input type="checkbox" name="insertar" value="1" '+setRolChecked(response.opcionesPerfil.roles[i].rolInsertar)+'/></td>\
        <td><input type="checkbox" name="admin" value="1" '+setRolChecked(response.opcionesPerfil.roles[i].rolAdmin)+'/></td>\
        <td><input type="checkbox" name="super" value="1" '+setRolChecked(response.opcionesPerfil.roles[i].rolSuper)+'/></td>\
        </tr>';

        $("#opcionesRolesTable tbody").append(tr);
        
    }

    for (let i = 0; i < response.opcionesDisponibles.length; i++) {
        
        opcion = '<option class="list-group-item list-group-item-action" value="'+response.opcionesDisponibles[i].id+'">'+response.opcionesDisponibles[i].nombre+'</option>';
        $("#selectOpciones").append(opcion);
        
    }

}


function setCreateData(response){

    $("#opcionesRolesTable tbody tr").remove();
    $("#selectOpcionesPerfil option").remove();
    $("#selectOpciones option").remove();

    for (let i = 0; i < response.opcionesDisponibles.length; i++) {
        
        opcion = '<option class="list-group-item list-group-item-action" value="'+response.opcionesDisponibles[i].id+'">'+response.opcionesDisponibles[i].nombre+'</option>';
        $("#selectOpciones").append(opcion);
        
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

function frmMantenimientoPerfiles(){
 $("#frmMantenimientoPerfiles").submit(function(event){
        event.preventDefault(); //prevent default action 

        var post_url = $(this).attr("action"); //get form action url
        var request_method = $(this).attr("method"); //get form GET/POST method

        var perfiles = [];
        
        $.each($("#selectOpcionesPerfil option"), function(){  

            perfiles.push($(this).val());
           
        });

        roles = [];
   
        $.each($("#opcionesRolesTable tbody tr"), function(){  

            var rolModificar = getRolValue($(this),'modificar');
            var rolEliminar = getRolValue($(this),'eliminar');
            var rolInsertar = getRolValue($(this),'insertar');
            var rolAdmin = getRolValue($(this),'admin');
            var rolSuper = getRolValue($(this),'super');

            roles.push({
                idOpcion:$(this).find('input[name=idOpcion]').val(),
                rolModificar:rolModificar,
                rolEliminar:rolEliminar,
                rolInsertar:rolInsertar,
                rolAdmin :rolAdmin ,
                rolSuper:rolSuper
            });
            
        });

        console.log(roles);

        form_data = $(this).serialize() + '&'+$.param({rolesOpciones:roles}); //Encode form elements for submission


        $.ajax({

            url : post_url,
            type: request_method,
            data : form_data,
            dataType:'JSON',
            processData: false,
            //contentType: false,

        }).done(function(response){ //

           

            if(response.errors){

                erroresForm(response.errors)
                console.log(response.errors);
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
        $("#frmMantenimientoPerfiles #nombreGroup input").removeClass("form-control").addClass("form-control is-invalid");
        $("#frmMantenimientoPerfiles #nombreGroup").append(mensajeError(errors.nombre));
    }else{
        limpiarForm('nombre');
    }

}

function limpiarForm(indicador){

    if(indicador == "todo"){
        $("#frmMantenimientoPerfiles").find('input:text,input:file,input:password,#id').val('');
        $("#frmMantenimientoPerfiles").find('input:text,input:file,input:password,#id').removeClass("form-control is-invalid").addClass("form-control").prop( "disabled", false);
        $("#frmMantenimientoPerfiles").find('.invalid-feedback').remove();
        $('#modalMantenimiento').modal('hide');  
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

