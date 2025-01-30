$(document).ready(function () {

    function cargarDatos() {
        
        var fechaInicio = $("#fechaInicio").val();
        var fechaFin = $("#fechaFin").val();
        var estado = $("#asignarFiltro").val();
        var numeroSesion = $("#numeroSesion").val();

        $.ajax({
            type: "POST",
            url: "../user/filtrarVistaUsuarios.php",
            data: {
                fechaInicio: fechaInicio,
                fechaFin: fechaFin,
                estado: estado,
                numeroSesion: numeroSesion
            },
            success: function (datos) {
                if ($.fn.dataTable.isDataTable('#tabla')) {
                    $('#tabla').DataTable().destroy();
                    $("#registros").html(datos);
                    $('#tabla').DataTable({
                        language: {
                            url: "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                        },
                        order: [[0, 'desc']]
                    });
                }else if(!$.fn.dataTable.isDataTable('#tabla')){
                    $("#registros").html(datos);
                    $('#tabla').DataTable({
                        language: {
                            url: "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                        },
                        order: [[0, 'desc']]
                    });
                }
            },
        });
        return false;
    }

    cargarDatos();

    $(document).on(
        "change",
        "#asignarFiltro, #fechaInicio, #fechaFin",
        function () {
            cargarDatos();
        }
    );

    $(".borrarFiltro").on("click", function (){
        $("#asignarFiltro").val("TODO");
        $("#fechaInicio").val("");
        $("#fechaFin").val("");
        cargarDatos();
    });
});




