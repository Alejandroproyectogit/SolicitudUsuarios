<?php

session_start();

//Se valida si la variable "$_SESSION['id_usuario']" no esta vacia y no es null, si esta vacia o es null, no dejara acceder a esta vista.

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../index.php');
    exit();
}

//Se almacena la variable "$_SESSION['id_usuario']" en $numeroSesion, para despues enviar la misma y obtener solo las solicitudes que ha hecho este usuario.
$numeroSesion = $_SESSION['id_usuario'];

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
                        <!--Se obtiene la varible "$_SESSION['nombre']" para saludar al usuario-->
                        <span class="user-info-text">Bienvenid@ <?php echo $_SESSION['nombre']; ?> <br><span class="user-state-info">Usuario</span><span class="activity-indicator"></span></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="app-container">
            <div class="search">
                <form>
                    <input class="form-control" type="text" placeholder="Type here..." aria-label="Search">
                </form>
                <a href="#" class="toggle-search"><i class="material-icons">close</i></a>
            </div>
            <?php require "../secciones/headerUsuario.php"; ?>
            <div class="app-content">
                <div class="content-wrapper">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <div class="page-description">
                                    <h1>Solicitudes Creadas</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">

                        <!-- Filtro Estado -->

                        <div class="filtroEstado">
                            <label for="exampleFormControlInput1">Filtrar por estado:</label>
                            <select id="asignarFiltro" name="asignarFiltro" class="form-select" aria-label="Default select example">
                                <option value="TODO">Todos</option>
                                <option value="PENDIENTE">Pendientes</option>
                                <option value="CREADO">Realizados</option>
                            </select>
                        </div>

                        <!-- Filtro por fechas -->

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

                        <!-- Enviar dato del usuario para solo mostrar las solicitudes de ese usuario -->

                        <input type="hidden" id="numeroSesion" value="<?php echo $numeroSesion?>">
                    </div>
                    <div class="divider"></div>
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">

                                        <!-- Tabla en donde apareceran las solicitudes que fueron creadas por el usuario -->

                                        <table id="tabla" class="table" class="display" style="width:100%">
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
                                                    <th>Cuando Se Solicito</th>
                                                    <th>Quien Solicita</th>
                                                    <th>Estado</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <!-- Aqui apareceran los registros de la BD -->
                                            <tbody id="registros">
                                                
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

    <!-- Javascripts -->
    <script src="../assets/plugins/jquery/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- A este archivo se enviaran los datos de los filtros -->

    <script src="../assets/js/filtrosUsuarios.js"></script>
    <script src="../assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
    <script src="../assets/plugins/pace/pace.min.js"></script>
    <script src="../assets/plugins/highlight/highlight.pack.js"></script>
    <script src="../assets/plugins/datatables/datatables.min.js"></script>
    <script src="../assets/js/main.min.js"></script>
    <script src="../assets/js/custom.js"></script>
    <script src="../assets/js/pages/datatables.js"></script>
    <script>
        $(document).ready(function() {

            /* Este codigo se ejecuta cuando se envia el formulario .validarContraUsuario, este formulario se encuentra en filtrarVistaUsuarios.php */
            $(document).on("submit",".validarContraUsuario", function (e){
                e.preventDefault();

                /* Utilizamos $(this).find() para que no hayan conflictos al obtener los datos, ya que, el formulario se encuentra en un foreach */
                /* Obtenemos los datos */
                var idUsuario = $(this).find(".idUsuario").val();
                var id_solicitud = $(this).find(".id_solicitud").val();
                var contrasena = $(this).find(".contra").val();

                /* Se envia una solicitud AJAX, en donde enviamos los datos por POST y en formato JSON al archivo "validarContraUsu.php" */
                $.ajax({
                    url: 'validarContraUsu.php',
                    type: 'POST',
                    data: {
                        idUsuario:idUsuario,
                        id_solicitud:id_solicitud,
                        contrasena:contrasena
                    },
                    dataType: "json",

                    /* Recibimos la respuesta AJAX */
                    success: function(response) {
                        /* El archivo "validarContraUsu.php", respondera una variable "status", si esta variable es igual a "success", pasara lo siguiente: */
                        if (response.status == "success") {
                            /* Ocultamos el modal */
                            $(".contraModal").modal('hide');
                            $(".contra").val("");//Limpiamos el input con clase ".contra".

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
                            /* El archivo "validarContraUsu.php", respondera una variable "status", si esta variable es igual a "error", el programa arrojara una alerta con el error que se responde */
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