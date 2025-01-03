<?php
require "../conexion/conexion.php";

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
            <td>".$fila["estado"]."</td>
            </tr>
        ";
    }
}else{
    echo "<tr><td colspan='13' class='text-center'>No hay resultados.</td></tr>";
} 

?>