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
                        <span class="activity-indicator"></span>
                        <!--Se obtiene la varible "$_SESSION['nombre']" para saludar al usuario-->
                        <span class="user-info-text">Bienvenid@ <?php echo $_SESSION['nombre']; ?> <br><span class="user-state-info">Administrador</span><span class="activity-indicator"></span></span>
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
            <?php require "../secciones/headerAdmin.php"; ?>
            <div class="app-content">
                <div class="content-wrapper">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <div class="page-description">
                                    <h1>Crear Solicitud</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
                                    <div class="card">
                                        <div class="card-body">

                                            <!-- Formulario para que el administrador pueda realizar una solicitud -->

                                            <form id="formSolicitudAdmin">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="settingsState" class="form-label">Tipo de Documento</label>
                                                        <select class="js-states form-control" id="settingsState" name="tipoDocumento" tabindex="-1" style="width: 100%">
                                                            <option value="CC">CC</option>
                                                            <option value="TI">TI</option>
                                                            <option value="CE">CE</option>
                                                            <option value="PP">PP</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="settingsPhoneNumber" class="form-label">Documento</label>
                                                        <input type="text" class="form-control" id="settingsPhoneNumber" name="nDocumento" placeholder="xxxxxxxxxx" required>
                                                    </div>
                                                </div>
                                                <div class="row m-t-lg">
                                                    <div class="col-md-6">
                                                        <label for="settingsInputFirstName" class="form-label">Nombres</label>
                                                        <input type="text" class="form-control" id="settingsInputFirstName" name="nombres" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="settingsInputLastName" class="form-label">Apellidos</label>
                                                        <input type="text" class="form-control" id="settingsInputLastName" name="apellidos" required>
                                                    </div>
                                                </div>
                                                <div class="row m-t-lg">
                                                    <div class="col-md-6">
                                                        <label for="settingsPhoneNumber" class="form-label">Telefono</label>
                                                        <input type="text" class="form-control" id="settingsPhoneNumber" name="telefono" placeholder="(xxx) xxx-xxxx" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="settingsInputEmail" class="form-label">Correo</label>
                                                        <input type="email" class="form-control" id="settingsInputEmail" name="correo" aria-describedby="settingsEmailHelp" placeholder="example@email.com">
                                                    </div>
                                                </div>
                                                <div class="row m-t-lg">
                                                    <div class="col-md-6">
                                                        <label for="settingsPhoneNumber" class="form-label">Cargo</label>
                                                        <input type="text" class="form-control" id="settingsPhoneNumber" name="cargo" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="settingsInputEmail" class="form-label">Seleccione</label><br>
                                                        <div class="btn-group dropend">
                                                            <button type="button" class="btn btn-info dropdown-toggle form-control" data-bs-toggle="dropdown" aria-expanded="false">
                                                                Sistemas requeridos
                                                            </button>
                                                            <!-- Aqui se incluye el archivo en donde se encuentran los checks de los diferentes sistemas -->
                                                            <?php require "elegirSistema.php"; ?>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row m-t-lg">
                                                    <div class="col-md-6">
                                                        <label for="settingsInputFirstName" class="form-label">Nombre del Usuario a Copiar</label>
                                                        <input type="text" class="form-control" id="settingsInputFirstName" name="nombreUsuCopia">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="settingsPhoneNumber" class="form-label">Documento del Usuario a Copiar</label>
                                                        <input type="text" class="form-control" id="settingsPhoneNumber" name="documentoUsuCopia" placeholder="xxxxxxxxxx">
                                                    </div>
                                                </div>

                                                <!-- Se envia el dato del usuario logueado para saber quien solicita -->

                                                <input type="text" name="solicitante" value="<?php echo $_SESSION["id_usuario"]; ?>" hidden>

                                                <!-- Por defecto se envia en PENDIENTE -->
                                                <input type="text" name="estado" value="PENDIENTE" hidden>
                                                <div class="row m-t-lg">
                                                    <div class="col">

                                                        <button type="submit" name="enviar" class="btn btn-primary m-t-sm">Solicitar</button>
                                                    </div>
                                                </div>
                                            </form>
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
    <script src="../assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
    <script src="../assets/plugins/pace/pace.min.js"></script>
    <script src="../assets/plugins/highlight/highlight.pack.js"></script>
    <script src="../assets/js/main.min.js"></script>
    <script src="../assets/js/custom.js"></script>
    <script>

        /* Este codigo se ejecuta cuando se envia el formulario "#formSolicitudAdmin" */
        $("#formSolicitudAdmin").submit(function(evento) {
            evento.preventDefault();

            /* Serializamos todos los datos del formulario */
            const datosFormulario = $(this).serialize();

            /* Se envia una solicitud AJAX, en donde enviamos los datos por POST y en formato JSON al archivo "ProcesarSolicitudAdmin.php" */
            $.ajax({
                url: "ProcesarSolicitudAdmin.php",
                type: "POST",
                data: datosFormulario,
                dataType: "json",

                /* Recibimos la respuesta del archivo "ProcesarSolicitudAdmin.php" */
                success: function(response) {
                    /* El archivo "ProcesarSolicitudAdmin.php" respondera una variable llamada "status", si su valor es igual a "success", entonces, aparecera la alerta de exito*/
                    if (response.status == "success") {
                        Swal.fire({
                            title: "EXITO",
                            text: response.message,
                            icon: "success"
                        }).then(() => {
                            /* Despues se recarga la pagina */
                            location.reload();
                        });
                    } else if (response.status == "error") {
                        /* El archivo "ProcesarSolicitudAdmin.php" respondera una variable llamada "status", si su valor es igual a "error", entonces, aparecera la alerta de error*/
                        Swal.fire({
                            title: "ERROR",
                            text: response.message,
                            icon: "error"
                        });
                    }
                },
                /* Si hubo un error en el servidor, aparecera la alerta de error */
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: "ERROR",
                        text: "Hubo un problema con la conexión",
                        icon: "error"
                    });
                }
            });
        });
    </script>

</body>

</html>