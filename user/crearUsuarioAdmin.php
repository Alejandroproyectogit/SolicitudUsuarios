<?php

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../index.php');
    exit();
}
if ($_SESSION['id_rol'] == 2){
    header('Location: vistaUsuarios.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require "../secciones/head.php";?>
</head>

<body>
    <div class="app menu-off-canvas align-content-stretch d-flex flex-wrap">
        <div class="app-sidebar">
            <div class="logo">
                <a href="#" class="logo-icon"><span class="logo-text">Clinaltec</span></a>
                <div class="sidebar-user-switcher user-activity-online">
                    <a href="#">
                        <span class="activity-indicator"></span>
                        <span class="user-info-text">Bienvenid@ <?php echo $_SESSION['nombre'];?>  <br><span class="user-state-info">Administrador</span><span class="activity-indicator"></span></span>
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
            <?php require "../secciones/headerAdmin.php";?>
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
                                                            <label for="settingsInputFirstName" class="form-label">Usuario</label>
                                                            <input type="text" class="form-control" id="settingsInputFirstName" name="usuario" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="settingsInputFirstName" class="form-label">Contraseña</label>
                                                            <input type="password" class="form-control" id="settingsInputFirstName" name="contrasena" required>
                                                        </div>
                                                    </div>
                                                    <div class="row m-t-lg">
                                                        <div class="col-md-6">
                                                            <label for="settingsPhoneNumber" class="form-label">Cargo</label>
                                                            <input type="text" class="form-control" id="settingsPhoneNumber" name="cargo" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="settingsInputFirstName" class="form-label">Area</label>
                                                            <input type="text" class="form-control" id="settingsInputFirstName" name="area" required>
                                                        </div>

                                                    </div>
                                                    <div class="row m-t-lg">
                                                        <div class="col-md-6">
                                                            <label for="settingsState" class="form-label">Rol del Usuario</label>
                                                            <select class="js-states form-control" id="settingsState" name="rol" tabindex="-1" style="width: 100%">
                                                                <option value="1">Administrador</option>
                                                                <option value="2">Usuario</option>
                                                            </select>
                                                        </div>
                                                        
                                                    <div class="row m-t-lg">
                                                        <div class="col">

                                                            <button type="submit" name="enviar" class="btn btn-primary m-t-sm">Crear</button>
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

        formulario.addEventListener("submit", function (evento){
            evento.preventDefault();

            const datosFormulario = new FormData(evento.target);
            const datosEnviados = Object.fromEntries(datosFormulario.entries());

            fetch("insertar.php",{
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(datosEnviados),
            })
            .then((response) => response.json())
            .then((resultado) => {
                Swal.fire({
                    title: "EXITO",
                    text: resultado.message,
                    icon: "success"
                }).then(() => {
                    windows.location.href = "vistaAdmin.php";
                });
            })
            .catch((error) => console.error("Error:", error));
        });
    </script>
    
</body>

</html>