$(function() {
    $("#fechaInicio").on('change', function () {
        var fechaInicio = $("#fechaInicio").val();
        var fechaFin = $("#fechaFin").val();
        var estado = $("#asignarFiltro").val();
        $.ajax({
            type:"POST",
            url:"../user/buscarRangoFechas.php",
            data:{fechaInicio: fechaInicio, fechaFin: fechaFin, estado:estado},
            success: function(datos){
                $("#agregar-registros").html(datos);
            }
        });
        return false;
    });

    $("#fechaFin").on('change', function () {
        var fechaInicio = $("#fechaInicio").val();
        var fechaFin = $("#fechaFin").val();
        var estado = $("#asignarFiltro").val();
        $.ajax({
            type:"POST",
            url:"../user/buscarRangoFechas.php",
            data:{fechaInicio: fechaInicio, fechaFin: fechaFin, estado:estado},
            success: function(datos){
                $("#agregar-registros").html(datos);
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
        $.ajax({
            type:"POST",
            url:"../user/buscarRangoFechas.php",
            data:{estado:estado, fechaInicio:fechaInicio, fechaFin:fechaFin},
            success:function (datos) {
                $("#agregar-registros").html(datos);
                
            }
        })
    })
});