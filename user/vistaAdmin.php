<?php

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../index.php');
    exit();
}

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
                        <div class="filtroEstado">
                            <label for="exampleFormControlInput1">Filtrar por estado:</label>
                            <select id="asignarFiltro" name="asignarFiltro" class="form-select" aria-label="Default select example">
                                <option value="PENDIENTE">Pendientes</option>
                                <option value="CREADO">Realizados</option>
                                <option value="TODO">Todos</option>
                            </select>
                        </div>
                        <div class="fechaInicio">
                            <label for="exampleFormControlInput1">Fecha Inicio:</label>
                            <input type="date" id="fechaInicio" class="form-control flatpickr1">
                        </div>

                        <div class="fechaFin">
                            <label for="exampleFormControlInput1">Fecha Final:</label>
                            <input type="date" id="fechaFin" class="form-control flatpickr1">
                        </div>


                    </div>
                    <div class="divider"></div>
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <div id="table-refresh">
                                            <table id="tabla" class="table display" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <td>Tipo de Documento</td>
                                                        <td>Documento</td>
                                                        <td>Nombre</td>
                                                        <td>Apellidos</td>
                                                        <td>Telefono</td>
                                                        <td>Correo</td>
                                                        <td>Cargo</td>
                                                        <td>Sistemas requerido</td>
                                                        <td>Usuario a Copiar</td>
                                                        <td>Documento</td>
                                                        <td>Quien Solicita</td>
                                                        <td>Estado</td>
                                                        <td>Cuando Se Solicito</td>
                                                        <td>Acción</td>
                                                    </tr>
                                                </thead>
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
            // Usamos delegación de eventos para capturar los eventos de formulario incluso después de actualizar la tabla
            $(document).on('submit', '.cambioEstado', function(evento) {
                evento.preventDefault();
                Swal.fire({
                    title: "Advertencia",
                    text: "Cambiaras El Estado De La Solicitud",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#79b626",
                    cancelButtonColor: "#ff3333",
                    confirmButtonText: "Estoy Seguro",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        const idEstado = new FormData(evento.target);
                        const idEnviado = Object.fromEntries(idEstado.entries());

                        fetch("cambioEstado.php", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                },
                                body: JSON.stringify(idEnviado),
                            })
                            .then((response) => response.json())
                            .then((resultado) => {
                                Swal.fire({
                                    title: "EXITO",
                                    text: resultado.message,
                                    icon: "success"
                                }).then(() => {
                                    location.reload();
                                });
                            })
                            .catch((error) => console.error("error: ", error));
                    }
                });
            });
        });
    </script>




</body>

</html>