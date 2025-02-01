<?php

session_start();

//Se valida si la variable "$_SESSION['id_usuario']" no esta vacia y no es null, si esta vacia o es null, no dejara acceder a esta vista.

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../index.php');
    exit();
}

//Si la variable "$_SESSION['id_rol'] == 2" entonces no dejara acceder a esta vista.

if ($_SESSION['id_rol'] == 2) {
    header('Location: vistaUsuarios.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require "../secciones/head.php"; ?>
</head>

<body>
    <div class="app menu-off-canvas align-content-stretch d-flex flex-wrap">
        <div class="app-sidebar">
            <div class="logo">
                <a href="#" class="logo-icon"><span class="logo-text">Clinaltec</span></a>
                <div class="sidebar-user-switcher user-activity-online">
                    <a href="#">
                        <!--Se obtiene la varible para saludar al usuario-->
                        <span class="user-info-text">Bienvenid@ <?php echo $_SESSION['nombre']; ?> <br><span class="user-state-info">Administrador</span><span class="activity-indicator"></span></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="app-container">

            <?php require "../secciones/headerAdmin.php"; ?>
            <div class="app-content">
                <div class="content-wrapper">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <h1>Solicitudes</h1>
                                <span>Usuarios Pendientes Por Crear</span>
                            </div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="d-flex justify-content-between">
                        
                        <!--Filtro por estado-->

                        <div class="filtroEstado">
                            <label for="exampleFormControlInput1">Filtrar por estado:</label>
                            <select id="asignarFiltro" name="asignarFiltro" class="form-select" aria-label="Default select example">
                                <option value="TODO">Todos</option>
                                <option value="PENDIENTE">Pendientes</option>
                                <option value="CREADO">Realizados</option>
                            </select>
                        </div>

                        <!--Filtro por fechas-->

                        <div class="fechaInicio">
                            <label for="exampleFormControlInput1">Fecha Inicio:</label>
                            <input type="date" id="fechaInicio" class="form-control flatpickr1">
                        </div>

                        <div class="fechaFin">
                            <label for="exampleFormControlInput1">Fecha Final:</label>
                            <input type="date" id="fechaFin" class="form-control flatpickr1">
                        </div>

                        <!-- Boton que borra los filtros ingresados -->

                        <div class="btnReset">
                            <button class="btn btn-info mt-4 borrarFiltro"><i class="bi bi-arrow-repeat"></i></button>
                        </div>


                    </div>
                    <div class="divider"></div>
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <div id="table-refresh">

                                            <!--Tabla en donde apareceran las solicitudes-->

                                            <table id="tabla" class="table display" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Tipo de Documento</th>
                                                        <th>Documento</th>
                                                        <th>Nombre</th>
                                                        <th>Apellidos</th>
                                                        <th>Telefono</th>
                                                        <th>Correo</th>
                                                        <th>Cargo</th>
                                                        <th>Sistemas requerido</th>
                                                        <th>Usuario a Copiar</th>
                                                        <th>Documento</th>
                                                        <th>Quien Solicita</th>
                                                        <th>Estado</th>
                                                        <th>Cuando Se Solicito</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <!--Los registros apareceran por respuesta AJAX-->
                                                <tbody id="agregar-registros">

                                                </tbody>


                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Javascripts -->
    <script src="../assets/plugins/jquery/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- A este archivo van los datos del filtro -->
    
    <script src="../assets/js/filtroFechaAdmin.js"></script>
    <script src="../assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
    <script src="../assets/plugins/pace/pace.min.js"></script>
    <script src="../assets/plugins/highlight/highlight.pack.js"></script>
    <script src="../assets/plugins/datatables/datatables.min.js"></script>
    <script src="../assets/js/main.min.js"></script>
    <script src="../assets/js/custom.js"></script>
    <script src="../assets/js/pages/datatables.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            /* Este codigo se ejecuta cuando se envia el formulario .formRespuestaSolicitud, este formulario se encuentra en buscarRangoFechas.php */
            $(document).on('submit', '.formRespuestaSolicitud', function(evento) {
                evento.preventDefault();

                /* Tenemos una alerta de advertencia antes de enviar el formulario */
                Swal.fire({
                    title: "Advertencia",
                    text: "¿Estas Seguro De Realizar Esta Acción?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#79b626",
                    cancelButtonColor: "#ff3333",
                    confirmButtonText: "Confirmar",
                    cancelButtonText: "Cancelar"
                }).then((result) => {

                    /* Si confirman el envio del formulario, se obtienen los datos del mismo formulario */
                    if (result.isConfirmed) {
                        /* Utilizamos $(this).find() para que no hayan conflictos al obtener los datos, ya que, el formulario se encuentra en un foreach */
                        const id_solicitud = $(this).find(".id_solicitud").val();
                        const idUsuRespuesta = $(this).find(".idUsuRespuesta").val(); 
                        const nomSistema = $(this).find(".nomSistema").val();                        
                        const usuario = $(this).find(".usuario").val();
                        const contrasena = $(this).find(".contrasena").val();
                        const comentario = $(this).find(".comentario").val();

                        /* Se envia una solicitud AJAX, en donde enviamos los datos por POST y en formato JSON al archivo "enviarInforUsuarioSoli.php" */
                        $.ajax({
                            method: "POST",
                            url: "enviarInfoUsuarioSoli.php",
                            data: {                            
                                id_solicitud: id_solicitud,
                                idUsuRespuesta: idUsuRespuesta,
                                nomSistema: nomSistema,
                                usuario: usuario,
                                contrasena: contrasena,
                                comentario: comentario
                            },
                            dataType: "json",

                            /* Recibimos la respuesta AJAX */
                            success: function(response) {
                                /* El archivo "enviarInfoUsuarioSoli.php", respondera una variable "status" y si su valor es igual a "success", entonces, se mostrara la alerta de exito */
                                if (response.status == "success") {
                                    Swal.fire({
                                        title: "EXITO",
                                        text: response.message,
                                        icon: "success"
                                    }).then(() => {
                                        /* Despues se recargara la pagina */
                                        location.reload();
                                    });
                                } else if (response.status == "error") {
                                    /* El archivo "enviarInfoUsuarioSoli.php", respondera una variable "status" y si su valor es igual a "error", entonces, se mostrara la alerta de error */
                                    Swal.fire({
                                        title: "ERROR",
                                        text: response.message,
                                        icon: "error"
                                    });
                                }
                            },
                            /* Alerta de error si hubo algun error en el servidor */
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    title: "ERROR",
                                    text: xhr.responseText,
                                    icon: "error"
                                });
                            }
                        });
                    };
                });
            });

            /* Este codigo se ejecuta cuando se envia el formulario ".validarContra", este formulario se encuentra en buscarRangoFechas.php */
            $(document).on('submit', '.validarContra', function(event) {
                event.preventDefault();

                /* Utilizamos $(this).find() para que no hayan conflictos al obtener los datos, ya que, el formulario se encuentra en un foreach */

                const idUsuResp = $(this).find(".idUsuResp").val();
                const id_solicitud = $(this).find(".id_solicitud").val();
                const contrasena = $(this).find(".contra").val();

                /* Se envia una solicitud AJAX, en donde enviamos los datos por POST y en formato JSON al archivo "validarContra.php" */
                $.ajax({
                    type: "POST",
                    url: "validarContra.php",
                    data: {
                        idUsuResp: idUsuResp,
                        id_solicitud: id_solicitud,
                        contrasena: contrasena
                    },
                    dataType: "json",

                    /* Recibimos la respuesta AJAX */
                    success: function(response) {
                        /* El archivo "validarContra.php", respondera una variable "status" y si su valor es igual a "success", entonces, pasara lo siguiente: */
                        if (response.status == "success") {
                            /* Ocultamos el modal con la clase "contraModal" */
                            $(".contraModal").modal('hide');
                            /* Limpiamos el input de la contraseña */
                            $(".contra").val("");
                            /* Se mostrara una alerta con la información de usuario, contraseña y comentario */
                            Swal.fire({
                                html: `
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='exampleModalLabel'>Datos</h5>
                                    </div>
                                    <div class='modal-body'>
                                        <label for='labelUsuario' class='form-label'>Usuario:</label>
                                        <input type='text' class='form-control' aria-describedby='emailHelp' value="${response.dato1}" style='background-color: white;' disabled><br>
                                        <label for='labelContrasena' class='form-label'>Contraseña:</label>
                                        <input type='text' class='form-control' aria-describedby='emailHelp' value="${response.dato2}" style='background-color: white;' disabled><br>
                                        <label for='labelComen' class='form-label'>Comentario:</label>
                                        <textarea class='form-control' style='background-color: white;' disabled>${response.dato3}</textarea>
                                    </div>
                                `,
                                confirmButtonText: "Cerrar"
                            });
                        } else if (response.status == "error") {
                            /* El archivo "validarContra.php", respondera una variable "status" y si su valor es igual a "error", entonces, saldra el error que nos responda */
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: response.message
                            });
                        }
                        
                    }
                });


            });
        });
    </script>




</body>

</html>