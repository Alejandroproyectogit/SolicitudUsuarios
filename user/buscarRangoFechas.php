<?php
require "../conexion/conexion.php";

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
} elseif($estado === 'TODO'){
    $sql .= " WHERE s.fechaSolicitud BETWEEN '$fechaInicio' AND '$fechaFin' ORDER BY s.id_solicitud DESC";
}
$buscaRango = $con->prepare($sql);
$buscaRango->execute();
$result = $buscaRango->fetchAll();

if ($result) {
    foreach ($result as $fila) {
        echo "<tr>
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
        if ($fila['estado'] == 'PENDIENTE'){
            echo "
                <td>
                    <form class='cambioEstado'>
                        <input name='cambio' value='{$fila['id_solicitud']}' hidden>
                        <button type='submit' class='btn btn-success align-middle'><span class='bi bi-check'></span></button>
                    </form>
                </td>";
            /*echo "<td>
                    <!-- Button trigger modal -->
                    <button type='button' class='btn btn-success align-middle' data-bs-toggle='modal' data-bs-target='#exampleModal{$fila['id_solicitud']}'>
                        <span class='bi bi-check'></span>
                    </button>

                    <!-- Modal -->
                    <div class='modal fade' id='exampleModal{$fila['id_solicitud']}' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <form>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='exampleModalLabel'>Información del Usuario Creado</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <input type='hidden' value='{$fila['id_solicitud']}'>
                                        <label for='exampleInputEmail1' class='form-label'>Sistema</label>
                                        <input type='text' class='form-control' id='exampleInputEmail1' aria-describedby='emailHelp' value='{$fila['nombreSistema']}' readonly>
                                        <label for='exampleInputEmail1' class='form-label'>Usuario</label>
                                        <input type='email' class='form-control' id='exampleInputEmail1' aria-describedby='emailHelp'>
                                        <label for='exampleInputEmail1' class='form-label'>Contraseña</label>
                                        <input type='password' class='form-control form-control-solid-bordered' id='exampleInputEmail1' aria-describedby='emailHelp'>
                                        <label for='exampleInputEmail1' class='form-label'>Comentarios</label>
                                        <textarea class='form-control'></textarea>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-success'>Enviar Datos</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </td>";*/
        }else{
            echo "<td>ninguna acción</td>";
        };
        echo "</tr>";
    }
}else{
    echo "<tr><td colspan='13' class='text-center'>No hay resultados.</td></tr>";
}
