<?php

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../index.php');
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
                        <span class="user-info-text">Bienvenid@ <?php echo $_SESSION['nombre'];?>  <br><span class="user-state-info">Usuario</span><span class="activity-indicator"></span></span>
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
            <?php require "../secciones/headerUsuario.php";?>
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
                        <div class="row">
                            <div class="col">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
                                        <div class="card">
                                            <div class="card-body">
                                                <form>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="settingsState" class="form-label">Tipo de Documento</label>
                                                            <select class="js-states form-control" id="settingsState" tabindex="-1" style="width: 100%">
                                                                <option value="CC">CC</option>
                                                                <option value="TI">TI</option>
                                                                <option value="CE">CE</option>
                                                                <option value="PP">PP</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="settingsPhoneNumber" class="form-label">Telefono</label>
                                                            <input type="text" class="form-control" id="settingsPhoneNumber" placeholder="(xxx) xxx-xxxx" required>
                                                        </div>
                                                    </div>
                                                    <div class="row m-t-lg">
                                                        <div class="col-md-6">
                                                            <label for="settingsInputFirstName" class="form-label">Nombres</label>
                                                            <input type="text" class="form-control" id="settingsInputFirstName" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="settingsInputLastName" class="form-label">Apellidos</label>
                                                            <input type="text" class="form-control" id="settingsInputLastName" required>
                                                        </div>
                                                    </div>
                                                    <div class="row m-t-lg">
                                                        <div class="col-md-6">
                                                            <label for="settingsPhoneNumber" class="form-label">Telefono</label>
                                                            <input type="text" class="form-control" id="settingsPhoneNumber" placeholder="(xxx) xxx-xxxx" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="settingsInputEmail" class="form-label">Correo</label>
                                                            <input type="email" class="form-control" id="settingsInputEmail" aria-describedby="settingsEmailHelp" placeholder="example@email.com">
                                                        </div>
                                                    </div>
                                                    <div class="row m-t-lg">
                                                        <div class="col-md-6">
                                                            <label for="settingsPhoneNumber" class="form-label">Cargo</label>
                                                            <input type="text" class="form-control" id="settingsPhoneNumber" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="settingsInputEmail" class="form-label">Seleccione</label><br>
                                                            <div class="btn-group dropend">
                                                                <button type="button" class="btn btn-info dropdown-toggle form-control" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    Sistemas requeridos
                                                                </button>
                                                                <?php require "elegirSistema.php"; ?>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row m-t-lg">
                                                        <div class="col-md-6">
                                                            <label for="settingsInputFirstName" class="form-label">Nombre del Usuario a Copiar</label>
                                                            <input type="text" class="form-control" id="settingsInputFirstName" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="settingsPhoneNumber" class="form-label">Documento del Usuario a Copiar</label>
                                                            <input type="text" class="form-control" id="settingsPhoneNumber" placeholder="xxxxxxxxxx" required>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="" id="" value="" hidden>
                                                    <input type="text" class="" id="" value="PENDIENTE" hidden>
                                                    <div class="row m-t-lg">
                                                        <div class="col">

                                                            <a href="#" class="btn btn-primary m-t-sm">Update</a>
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
    <script src="../assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
    <script src="../assets/plugins/pace/pace.min.js"></script>
    <script src="../assets/plugins/highlight/highlight.pack.js"></script>
    <script src="../assets/js/main.min.js"></script>
    <script src="../assets/js/custom.js"></script>
</body>

</html>