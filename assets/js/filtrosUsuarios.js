$(function() {
    $("#fechaInicio").on('change', function () {
        var fechaInicio = $("#fechaInicio").val();
        var fechaFin = $("#fechaFin").val();
        var estado = $("#asignarFiltro").val();
        var numeroSesion = $("#numeroSesion").val();
        $.ajax({
            type:"POST",
            url:"../user/filtrarVistaUsuarios.php",
            data:{fechaInicio: fechaInicio, fechaFin: fechaFin, estado:estado, numeroSesion:numeroSesion},
            success: function(datos){
                $("#registros").html(datos);
            }
        });
        return false;
    });

    $("#fechaFin").on('change', function () {
        var fechaInicio = $("#fechaInicio").val();
        var fechaFin = $("#fechaFin").val();
        var estado = $("#asignarFiltro").val();
        var numeroSesion = $("#numeroSesion").val();
        $.ajax({
            type:"POST",
            url:"../user/filtrarVistaUsuarios.php",
            data:{fechaInicio: fechaInicio, fechaFin: fechaFin, estado:estado, numeroSesion:numeroSesion},
            success: function(datos){
                $("#registros").html(datos);
            }
        });
        return false;
    });
    
});

$(function () {
    $("#asignarFiltro").on('change', function () {
        var estado = $("#asignarFiltro").val();
        var fechaInicio = $("#fechaInicio").val();
        var fechaFin = $("#fechaFin").val();
        var numeroSesion = $("#numeroSesion").val();
        $.ajax({
            type:"POST",
            url:"../user/filtrarVistaUsuarios.php",
            data:{estado:estado, fechaInicio:fechaInicio, fechaFin:fechaFin, numeroSesion:numeroSesion},
            success:function (datos) {
                $("#registros").html(datos);
                
            }
        });
        return false;
    });
});
$(function() {
    $("#fechaInicio").trigger('change', function () {
        var fechaInicio = $("#fechaInicio").val();
        var fechaFin = $("#fechaFin").val();
        var estado = $("#asignarFiltro").val();
        var numeroSesion = $("#numeroSesion").val();
        $.ajax({
            type:"POST",
            url:"../user/filtrarVistaUsuarios.php",
            data:{fechaInicio: fechaInicio, fechaFin: fechaFin, estado:estado, numeroSesion:numeroSesion},
            success: function(datos){
                $("#registros").html(datos);
            }
        });
        return false;
    });
    
});