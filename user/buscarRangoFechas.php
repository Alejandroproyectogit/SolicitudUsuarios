<?php
/* Obtenemos la conexión */
require "../conexion/conexion.php";

/* Iniciamos sesión */
session_start();

/* Definimos zona horaria */
date_default_timezone_set('America/Bogota');

/* Constantes para encriptar */
define('ENCRYPTION_KEY', 'ABwVQ$gYH2Xn^QjfadEEB9LzuT!yinb%'); // 32 caracteres
define('IV', '1234567890abcdef'); // 16 caracteres

/* Definimos función para encriptar */
function encrypt($data)
{
    $cipher = "AES-256-CBC";
    $encrypted = openssl_encrypt($data, $cipher, ENCRYPTION_KEY, 0, IV);
    return urlencode($encrypted); // Codificar para URL
}

$idUsuario = $_SESSION['id_usuario'];
$idUsuario = encrypt($idUsuario);

/* Definimos variables y obtenemos los datos de los filtros enviados por post */

$fechaInicio = $_POST["fechaInicio"];
$fechaFin = $_POST["fechaFin"];
$estado = $_POST["estado"];

if (empty($fechaInicio)) {
    /* si el campo $fechaInicio esta vacio, le damos el valor de la $fechaFin */
    $fechaInicio = $fechaFin;
}
if (empty($fechaFin)) {
    /* si el campo $fechaFin esta vacio, le damos el valor de la $fechaInicio */
    $fechaFin = $fechaInicio;
}

/* Si los dos campos de las fechas estan vacios, se coloca por defecto el rango de fecha del mes actual */
if (empty($fechaInicio) && empty($fechaFin)) {
    $fechaInicio = date("Y-m-01");
    $fechaFin = date("Y-m-t");
}

/* Creamos la consulta SQL para la busqueda en base a los filtros */
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
    /* Si el filtro de estado es igual a PENDIENTE entonces añadira lo siguente en la consulta SQL */
    $sql .= " WHERE s.estado = '$estado' AND s.fechaSolicitud BETWEEN '$fechaInicio' AND '$fechaFin' ORDER BY s.id_solicitud DESC";
} elseif ($estado === 'CREADO') {
    /* Si el filtro de estado es igual a CREADO entonces añadira lo siguente en la consulta SQL */
    $sql .= " WHERE s.estado = '$estado' AND s.fechaSolicitud BETWEEN '$fechaInicio' AND '$fechaFin' ORDER BY s.id_solicitud DESC";
} elseif ($estado === 'TODO') {
    /* Si el filtro de estado es igual a TODO entonces añadira lo siguente en la consulta SQL */
    $sql .= " WHERE s.fechaSolicitud BETWEEN '$fechaInicio' AND '$fechaFin' ORDER BY s.id_solicitud DESC";
}

/* Preparamos y ejecutamos la consulta SQL */
$buscaRango = $con->prepare($sql);
$buscaRango->execute();
$result = $buscaRango->fetchAll();

/* Si la consulta SQL devuelve resultados, generamos la tabla con los resultados */
if ($result) {
    /* Usamos un foreach para mostrar todos los resultados */
    foreach ($result as $fila) {
        /* Aqui obtenemos cada dato de los campos de la BD */
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
        /* Aqui se genera el botón del modal para responder a la solicitud, solo si el estado es PENDIENTE */
        if ($fila['estado'] == 'PENDIENTE') {
            echo "<td>
                    <!-- Boton que abre el modal -->
                    <button type='button' class='btn btn-success align-middle' data-bs-toggle='modal' data-bs-target='#exampleModal{$fila['id_solicitud']}'>
                        <span class='bi bi-check'></span>
                    </button>

                    <!-- Modal -->
                    <div class='modal fade' id='exampleModal{$fila['id_solicitud']}' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>

                                <!-- Formulario para responder a la solicitud -->

                                <form class='formRespuestaSolicitud'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='exampleModalLabel'>Información del Usuario Creado</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <div class='divider'></div>
                                    <div class='modal-body'>
                                        <input type='hidden' class='id_solicitud' value='{$fila['id_solicitud']}'>
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
            /* Si el estado de la solucitud es igual a CREADO, entonces, aparecera el boton para abrir el modal de la validación de la contraseña, para ver las credenciales */ 
            echo "<td>
                    <!-- Boton que abre el modal -->
                    <button type='button' class='btn btn-dark align-middle' data-bs-toggle='modal' data-bs-target='#verInfo{$fila['id_solicitud']}'>
                        <span class='bi bi-eye'></span>
                    </button>

                    <div class='modal fade contraModal' id='verInfo{$fila['id_solicitud']}' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                        <div class='modal-dialog modal-dialog-centered'>
                            <div class='modal-content'>

                                <!-- formulario para enviar la contraseña -->

                                <form class='validarContra'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='exampleModalLabel'>Contraseña</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <input type='hidden' class='idUsuResp' value='{$idUsuario}'>
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
}
/* Si no hay resultados, se mostrara el "no hay datos" que tiene por defecto el DataTables */