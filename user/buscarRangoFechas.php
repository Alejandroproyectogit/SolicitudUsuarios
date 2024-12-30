<?php
require "../conexion/conexion.php";

$fechaInicio = $_POST["fechaInicio"];
$fechaFin = $_POST["fechaFin"];

if (isset($fechaInicio) == false) {
    $fechaInicio = $fechaFin;
}
if (isset($fechaFin) == false) {
    $fechaFin = $fechaInicio;
}


$buscaRango = $con->prepare("SELECT
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
            u.nombres,
            s.estado
        FROM
            solicitudes s
        INNER JOIN usuarios u ON
            s.QuienSolicita = u.id
        INNER JOIN sistemas_de_informacion sis ON
            s.id_sistema = sis.id
        WHERE s.fechaSolicitud BETWEEN '$fechaInicio' AND '$fechaFin' ORDER BY s.id_solicitud DESC");
$buscaRango->execute();
$result=$buscaRango->fetchAll();

if ($result) {
    foreach ($result as $fila) {
        echo "<tr>
            <td>".$fila['tipoDocumento']."</td>
            <td>".$fila['documento']."</td>
            <td>".$fila['nombres']."</td>
            <td>".$fila['apellidos']."</td>
            <td>".$fila['telefono']."</td>
            <td>".$fila['correo']."</td>
            <td>".$fila['cargo']."</td>
            <td>".$fila['nombreSistema']."</td>
            <td>".$fila['nombreUsuarioCopia']."</td>
            <td>".$fila['documentoUsuCopia']."</td>
            <td>".$fila['nombres']."</td>
            <td>".$fila['estado']."</td>
            <td>".$fila['fechaSolicitud']."</td>
            </tr> 
        ";
        
                
    }
}

?>
