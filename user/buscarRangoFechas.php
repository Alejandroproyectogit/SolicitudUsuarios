<?php
require "../conexion/conexion.php";
session_start();
date_default_timezone_set('America/Bogota');

$fechaInicio = $_POST["fechaInicio"];
$fechaFin = $_POST["fechaFin"];
$estado = $_POST["estado"];

if (empty($fechaInicio)) {
    $fechaInicio = $fechaFin;
}
if (empty($fechaFin)) {
    $fechaFin = $fechaInicio;
}
if (empty($fechaInicio) && empty($fechaFin)) {
    $fechaInicio = date("Y-m-01");
    $fechaFin = date("Y-m-t");
}

$sql = "SELECT
            s.id_solicitud,
            s.tipoDocumento,
            s.documento,
            s.nombres,
            s.apellidos,
            s.telefono,
            s.correo,
            s.cargo,
            sis.nombreSistema,
            s.nombreUsuarioCopia,
            s.documentoUsuCopia,
            s.fechaSolicitud,
            u.nombre,
            s.estado
        FROM
            solicitudes s
        INNER JOIN usuarios u ON
            s.QuienSolicita = u.id
        INNER JOIN sistemas_de_informacion sis ON
            s.id_sistema = sis.id
        ";
if ($estado === 'PENDIENTE') {
    $sql .= " WHERE s.estado = '$estado' AND s.fechaSolicitud BETWEEN '$fechaInicio' AND '$fechaFin' ORDER BY s.id_solicitud DESC";
} elseif ($estado === 'CREADO') {
    $sql .= " WHERE s.estado = '$estado' AND s.fechaSolicitud BETWEEN '$fechaInicio' AND '$fechaFin' ORDER BY s.id_solicitud DESC";
} elseif ($estado === 'TODO') {
    $sql .= " WHERE s.fechaSolicitud BETWEEN '$fechaInicio' AND '$fechaFin' ORDER BY s.id_solicitud DESC";
}
$buscaRango = $con->prepare($sql);
$buscaRango->execute();
$result = $buscaRango->fetchAll();

if ($result) {
    foreach ($result as $fila) {
        echo "<tr>
            <td>" . $fila['id_solicitud'] . "</td>
            <td>" . $fila['tipoDocumento'] . "</td>
            <td>" . $fila['documento'] . "</td>
            <td>" . $fila['nombres'] . "</td>
            <td>" . $fila['apellidos'] . "</td>
            <td>" . $fila['telefono'] . "</td>
            <td>" . $fila['correo'] . "</td>
            <td>" . $fila['cargo'] . "</td>
            <td>" . $fila['nombreSistema'] . "</td>
            <td>" . $fila['nombreUsuarioCopia'] . "</td>
            <td>" . $fila['documentoUsuCopia'] . "</td>
            <td>" . $fila['nombre'] . "</td>
            <td>" . $fila['estado'] . "</td>
            <td>" . $fila['fechaSolicitud'] . "</td>
        ";
        if ($fila['estado'] == 'PENDIENTE') {
            echo "<td>
                    <!-- Button trigger modal -->
                    <button type='button' class='btn btn-success align-middle' data-bs-toggle='modal' data-bs-target='#exampleModal{$fila['id_solicitud']}'>
                        <span class='bi bi-check'></span>
                    </button>

                    <!-- Modal -->
                    <div class='modal fade' id='exampleModal{$fila['id_solicitud']}' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <form class='formRespuestaSolicitud'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='exampleModalLabel'>Información del Usuario Creado</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <div class='divider'></div>
                                    <div class='modal-body'>
                                        <input type='hidden' class='id_solicitud' value='{$fila['id_solicitud']}'>
                                        <input type='hidden' class='idUsuRespuesta' value='{$_SESSION['id_usuario']}'>
                                        <input type='hidden' class='nomSistema' value='{$fila['nombreSistema']}'>
                                        <h5 class='modal-title' id='exampleModalLabel'>Sistema: <span class='modal-title badge badge-style-light rounded-pill badge-warning'>{$fila['nombreSistema']}</span></h5>
                                        <div class='divider'></div>
                                        <label for='labelUsuario' class='form-label'>Usuario</label>
                                        <input type='text' class='usuario form-control' aria-describedby='emailHelp'>
                                        <label for='labelContra' class='form-label'>Contraseña</label>
                                        <input type='password' class='contrasena form-control form-control-solid-bordered'aria-describedby='emailHelp'>
                                        <label for='labelComentarios' class='form-label'>Comentarios</label>
                                        <textarea class='comentario form-control'></textarea>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='submit' class='enviarForm btn btn-success'>Enviar Datos</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </td>";
        } else {
            echo "<td>
                    <!-- Button trigger modal -->
                    <button type='button' class='btn btn-dark align-middle' data-bs-toggle='modal' data-bs-target='#verInfo{$fila['id_solicitud']}'>
                        <span class='bi bi-eye'></span>
                    </button>

                    <div class='modal fade contraModal' id='verInfo{$fila['id_solicitud']}' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                        <div class='modal-dialog modal-dialog-centered'>
                            <div class='modal-content'>
                                <form class='validarContra'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='exampleModalLabel'>Contraseña</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <input type='hidden' class='idUsuResp' value='{$_SESSION['id_usuario']}'>
                                        <input type='hidden' class='id_solicitud' value='{$fila['id_solicitud']}'>
                                        <input type='password' class='contra form-control form-control-solid-bordered' aria-describedby='emailHelp' required>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='submit' class='valContra btn btn-success'>Validar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </td>";
        };
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='13' class='text-center'>No hay resultados.</td></tr>";
}
