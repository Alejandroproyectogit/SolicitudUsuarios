$(document).ready(function () {
    var fechaInicio = $("#fechaInicio").val();
    var fechaFin = $("#fechaFin").val();
    var estado = $("#asignarFiltro").val();
    $.ajax({
        type: "POST",
        url: "../user/buscarRangoFechas.php",
        data: {
            fechaInicio: fechaInicio,
            fechaFin: fechaFin,
            estado: estado
        },
        success: function (datos) {
            $("#agregar-registros").html(datos);
            $('#tabla').add("#datatable1").DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                order: [[0, 'desc']]
            });
        },
    });
    return false;
});

$(document).on(
    "change",
    "#asignarFiltro, #fechaInicio, #fechaFin",
    function () {
        const fechaInicio = $("#fechaInicio").val();
        const fechaFin = $("#fechaFin").val();
        const estado = $("#asignarFiltro").val();

        $.ajax({
            url: "../user/buscarRangoFechas.php",
            method: "POST",
            data: { fechaInicio, fechaFin, estado },
            success: function (response) {
                $("#agregar-registros").html(response);
            },
        });
    }
);


