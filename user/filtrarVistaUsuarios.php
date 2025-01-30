<?php
require "../conexion/conexion.php";
session_start();
date_default_timezone_set('America/Bogota');

$fechaInicio = $_POST["fechaInicio"];
$fechaFin = $_POST["fechaFin"];
$estado = $_POST["estado"];
$id = $_POST["numeroSesion"];


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
            s.id_sistema = sis.id";

if ($estado == 'PENDIENTE') {
    $sql .= " WHERE s.estado = '$estado' AND s.QuienSolicita = '$id' AND s.fechaSolicitud BETWEEN '$fechaInicio' AND '$fechaFin' ORDER BY s.id_solicitud DESC";
}
elseif ($estado == 'CREADO') {
    $sql .= " WHERE s.estado = '$estado' AND s.QuienSolicita = '$id' AND s.fechaSolicitud BETWEEN '$fechaInicio' AND '$fechaFin' ORDER BY s.id_solicitud DESC";
}
elseif ($estado == 'TODO') {
    $sql .= " WHERE s.QuienSolicita = '$id' AND s.fechaSolicitud BETWEEN '$fechaInicio' AND '$fechaFin' ORDER BY s.id_solicitud DESC";
}

$preparar = $con->prepare($sql);
$preparar->execute();
$resultado = $preparar->fetchAll();

if ($resultado) {
    foreach ($resultado as $fila) {
        echo "
            <tr>
            <td>".$fila["id_solicitud"]."</td>
            <td>".$fila["tipoDocumento"]."</td>
            <td>".$fila["documento"]."</td>
            <td>".$fila["nombres"]."</td>
            <td>".$fila["apellidos"]."</td>
            <td>".$fila["telefono"]."</td>
            <td>".$fila["correo"]."</td>
            <td>".$fila["cargo"]."</td>
            <td>".$fila["nombreSistema"]."</td>
            <td>".$fila["nombreUsuarioCopia"]."</td>
            <td>".$fila["documentoUsuCopia"]."</td>
            <td>".$fila["fechaSolicitud"]."</td>
            <td>".$fila["nombre"]."</td>
            <td>".$fila["estado"]."</td>";
            if ($fila["estado"] == "PENDIENTE"){
                echo "<td><p class='btn btn-light align-middle'><span class='bi bi-clock-fill'></span></p></td>";
            }else{
                echo "<td>
                    <!-- Button trigger modal -->
                    <button type='button' class='btn btn-dark align-middle' data-bs-toggle='modal' data-bs-target='#verInfo{$fila['id_solicitud']}'>
                        <span class='bi bi-eye'></span>
                    </button>

                    <div class='modal fade contraModal' id='verInfo{$fila['id_solicitud']}' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                        <div class='modal-dialog modal-dialog-centered'>
                            <div class='modal-content'>
                                <form class='validarContraUsuario'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='exampleModalLabel'>Contraseña</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <input type='hidden' class='idUsuario' value='{$_SESSION['id_usuario']}'>
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
            }
            "</tr>";
    }
}else{
    echo "<tr><td colspan='13' class='text-center'>No hay resultados.</td></tr>";
} 

?>