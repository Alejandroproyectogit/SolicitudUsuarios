$(function() {
    $("#fechaInicio").on('change', function () {
        var fechaInicio = $("#fechaInicio").val();
        var fechaFin = $("#fechaFin").val();
        $.ajax({
            type:"POST",
            url:"../user/buscarRangoFechas.php",
            data:{fechaInicio: fechaInicio, fechaFin: fechaFin},
            success: function(datos){
                $("#agregar-registros").html(datos);
            }
        });
        return false;
    });

    $("#fechaFin").on('change', function () {
        var fechaInicio = $("#fechaInicio").val();
        var fechaFin = $("#fechaFin").val();
        $.ajax({
            type:"POST",
            url:"../user/buscarRangoFechas.php",
            data:{fechaInicio: fechaInicio, fechaFin: fechaFin},
            success: function(datos){
                $("#agregar-registros").html(datos);
            }
        });
        return false;
    });
    
});