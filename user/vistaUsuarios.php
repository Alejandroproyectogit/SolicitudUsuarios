<?php

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../index.php');
    exit();
}
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
                        <input type="hidden" id="numeroSesion" value="<?php echo $numeroSesion?>">
                    </div>
                    <div class="divider"></div>
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="datatable1" class="table" class="display" style="width:100%">
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
                                                    <td>Cuando Se Solicito</td>
                                                    <td>Quien Solicita</td>
                                                    <td>Estado</td>
                                                </tr>
                                            </thead>
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
        $('#datatable1').DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        order: [[0, 'desc']] 
    });
    </script>
</body>

</html>