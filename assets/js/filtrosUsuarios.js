$(document).ready(function () {
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
            $("#registros").html(datos);
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
    "#asignarFiltro, #fechaInicio, #fechaFin, #numeroSesion",
    function () {
        const fechaInicio = $("#fechaInicio").val();
        const fechaFin = $("#fechaFin").val();
        const estado = $("#asignarFiltro").val();
        const numeroSesion = $("#numeroSesion").val();

        $.ajax({
            url: "../user/filtrarVistaUsuarios.php",
            method: "POST",
            data: { fechaInicio, fechaFin, estado, numeroSesion },
            success: function (response) {
                $("#registros").html(response);
            },
        });
    }
);