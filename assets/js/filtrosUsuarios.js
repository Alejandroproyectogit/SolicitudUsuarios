$(document).ready(function () {

    /* Aqui tenemos la funcion que recibe y envia los datos de los filtros que se encuentran en user/vistaUsuarios */

    function cargarDatos() {
        
        /* Recibimos los campos de los filtros */

        var fechaInicio = $("#fechaInicio").val();
        var fechaFin = $("#fechaFin").val();
        var estado = $("#asignarFiltro").val();
        var numeroSesion = $("#numeroSesion").val();//Recibimos el numero del id del usuario que seria el $_SESSION["id_usuario"], para enviarlo y obtener solo las solicitudes que ha realizado el usuario logueado

        /* Se envian los datos por post en una petición AJAX al archivo ../user/filtrarVistaUsuarios.php */

        $.ajax({
            type: "POST",
            url: "../user/filtrarVistaUsuarios.php",
            data: {
                fechaInicio: fechaInicio,
                fechaFin: fechaFin,
                estado: estado,
                numeroSesion: numeroSesion
            },

            /* Se obtiene la respuesta */

            success: function (datos) {

                /* Se valida si hay una DataTable Inicializada para destruirla, agregar los registros y inicializar un DataTable nuevo para esos registros obtenidos */
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
                    /* Si no hay ningun DataTable inicializado, se agregaran los registros al id #registros y se inicializara un DataTable para esos registros obtenidos */
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

    /* Llamamos la función */

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




