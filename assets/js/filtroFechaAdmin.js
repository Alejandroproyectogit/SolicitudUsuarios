$(document).ready(function () {
    
    /* Aqui tenemos la funcion que recibe y envia los datos de los filtros que se encuentran en user/vistaAdmin */

    function cargarDatos() {
        
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

                /* Se agregan los registros al id "#agregar-registros" activando DataTables, este id se encuenta en user/vistaAdmin */

                $("#agregar-registros").html(datos);
                if ($.fn.dataTable.isDataTable('#tabla')) {
                    $('#tabla').DataTable().destroy();
                    $("#agregar-registros").html(datos);
                    $('#tabla').DataTable({
                        language: {
                            url: "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                        },
                        order: [[0, 'desc']]
                    });
                }else{
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

    /* Aqui tenemos el codigo que se ejecuta cuando se cambia algun input de los filtros y llama la función para enviar esos cambios hechos en los inputs */

    $(document).on(
        "change",
        "#asignarFiltro, #fechaInicio, #fechaFin",
        function () {
            cargarDatos();
        }
    );

    /* Cuando se presiona el boton "borrarFiltro", se borran los filtros aplicados y se colocan los filtros por defecto */

    $(".borrarFiltro").on("click", function (){
        $("#asignarFiltro").val("TODO");
        $("#fechaInicio").val("");
        $("#fechaFin").val("");
        cargarDatos();
    });
});




