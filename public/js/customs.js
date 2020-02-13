
$(document).ready(function () {

    $('#myModal').modal({backdrop: 'static', keyboard: false,action:"show"});

    $(".img-check").click(function(){
        $(".img-check").removeClass("check");
        $(this).toggleClass("check");
    });

    $( "#btnFormAddCompania" ).click(function() {
        $( "#FormAddCompania" ).submit();
    });  


});