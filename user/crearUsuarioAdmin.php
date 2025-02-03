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
                        <span class="activity-indicator"></span>
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
                                    <h1>Crear Usuario para el software</h1>
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
                                            <form id="UsuarioNuevo">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="settingsState" class="form-label">Tipo de Documento</label>
                                                        <select class="js-states form-control" id="tipoDocumento" name="tipoDocumento" tabindex="-1" style="width: 100%">
                                                            <option value="CC">CC</option>
                                                            <option value="TI">TI</option>
                                                            <option value="CE">CE</option>
                                                            <option value="PP">PP</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="settingsPhoneNumber" class="form-label">Documento</label>
                                                        <input type="text" class="form-control" id="nDocumento" name="nDocumento" maxlength="10" placeholder="xxxxxxxxxx" required>
                                                        <div id="aviso" class="aviso text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="row m-t-lg">
                                                    <div class="col-md-6">
                                                        <label for="settingsInputFirstName" class="form-label">Nombres</label>
                                                        <input type="text" class="form-control" id="nombres" name="nombres" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="settingsInputLastName" class="form-label">Apellidos</label>
                                                        <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                                                    </div>
                                                </div>
                                                <div class="row m-t-lg">
                                                    <div class="col-md-6">
                                                        <label for="settingsInputFirstName" class="form-label">correo</label>
                                                        <input type="text" class="form-control" id="correo" name="correo" required>
                                                        <div id="avisoCorreo" class="avisoCorreo text-danger"></div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="settingsInputFirstName" class="form-label">Usuario</label>
                                                        <input type="text" class="form-control" id="usuario" name="usuario" required>
                                                        <div id="avisoUsuario" class="avisoUsuario text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="row m-t-lg">
                                                    <div class="col-md-6">
                                                        <label for="settingsInputFirstName" class="form-label">Contraseña</label>
                                                        <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="settingsPhoneNumber" class="form-label">Cargo</label>
                                                        <input type="text" class="form-control" id="cargo" name="cargo" required>
                                                    </div>

                                                </div>
                                                <div class="row m-t-lg">
                                                    <div class="col-md-6">
                                                        <label for="settingsInputFirstName" class="form-label">Area</label>
                                                        <input type="text" class="form-control" id="area" name="area" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="settingsState" class="form-label">Rol del Usuario</label>
                                                        <select class="js-states form-control" id="rol" name="rol" tabindex="-1" style="width: 100%">
                                                            <option value="1">Administrador</option>
                                                            <option value="2">Usuario</option>
                                                        </select>
                                                    </div>

                                                    <div class="row m-t-lg">
                                                        <div class="col">

                                                            <button type="submit" name="enviar" id="enviar" class="btn btn-primary m-t-sm">Crear</button>
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
    <script type="text/javascript">


        const formulario = document.getElementById("UsuarioNuevo");

        formulario.addEventListener("submit", function(evento) {
            evento.preventDefault();

            const datosFormulario = new FormData(evento.target);
            const datosEnviados = Object.fromEntries(datosFormulario.entries());

            fetch("insertar.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(datosEnviados),
                })
                .then((response) => response.json())
                .then((resultado) => {
                    if (resultado.message == 1) {
                        Swal.fire({
                            title: "EXITO",
                            text: "Usuario Creado",
                            icon: "success"
                        }).then(() => {
                            location.reload();
                        });
                    } else if (resultado.message == 2) {
                        Swal.fire({
                            title: "ERROR",
                            text: "El documento, el usuario o el correo ya existe.",
                            icon: "error"
                        });

                    } else if (resultado.message == 3) {
                        Swal.fire({
                            title: "ERROR",
                            text: "Campos Vacios",
                            icon: "error"
                        }).then(() => {
                            location.reload();
                        });
                    }
                })
                .catch((error) => {
                    // En caso de error en la solicitud o el proceso
                    Swal.fire({
                        title: "Error",
                        text: "Ocurrió un error en el servidor o la conexión.",
                        icon: "error"
                    });
                    console.error("Error en la solicitud:", error); // Log de error en consola para depuración
                });
        });
        $("#nDocumento").on("keyup",function () {
            var documento = $("#nDocumento").val();
            var longitud = $("#nDocumento").val().length;
            
            if (longitud >= 1) {
                $.ajax({
                    url: "validarCedula.php",
                    type: "POST",
                    data: {
                        documento: documento
                    },
                    success: function(response) {
                        if (response == 1) {
                            $(".aviso").css("display", "flex");
                            $("#aviso").html("La Cedula Ya Existe");
                            $("#aviso").removeClass("text-success");
                            $("#aviso").addClass("text-danger");
                        } else {
                            $(".aviso").css("display", "flex");
                            $("#aviso").html("Cedula Valida");
                            $("#aviso").removeClass("text-danger");
                            $("#aviso").addClass("text-success");
                        }
                    }
                })
            }else{
                $(".aviso").css("display", "none");

            }
        });
        $("#usuario").on("keyup",function () {
            var usuario = $("#usuario").val();
            var longitud = $("#usuario").val().length;
            
            if (longitud >= 1) {
                $.ajax({
                    url: "validarUsuario.php",
                    type: "POST",
                    data: {
                        usuario: usuario
                    },
                    success: function(response) {
                        if (response == 1) {
                            $(".avisoUsuario").css("display", "flex");
                            $("#avisoUsuario").html("Usuario Existente");
                            $("#avisoUsuario").removeClass("text-success");
                            $("#avisoUsuario").addClass("text-danger");
                        } else {
                            $(".avisoUsuario").css("display", "flex");
                            $("#avisoUsuario").html("Usuario Valido");
                            $("#avisoUsuario").removeClass("text-danger");
                            $("#avisoUsuario").addClass("text-success");
                        }
                    }
                })
            }else{
                $(".aviso").css("display", "none");

            }
        });
        $("#correo").on("keyup",function (){
            var correoLongitud = $("#correo").val().length;
            var correo = $("#correo").val();

            if (correoLongitud > 2){
                $.ajax({
                    url: "validarCorreo.php",
                    type: "POST",
                    data: {
                        correo:correo
                    },
                    success: function(response) {
                        if (response == 1){
                            $(".avisoCorreo").css("display", "flex");
                            $("#avisoCorreo").html("El Correo Ya Existe");
                            $("#avisoCorreo").removeClass("text-success");
                            $("#avisoCorreo").addClass("text-danger");
                        }else{
                            $(".avisoCorreo").css("display", "flex");
                            $("#avisoCorreo").html("Correo Valido");
                            $("#avisoCorreo").removeClass("text-danger");
                            $("#avisoCorreo").addClass("text-success");
                        }
                    }
                });
            }else{
                $(".avisoCorreo").css("display", "none");
            }
        });
    </script>

</body>

</html>