<?php 
require "../conexion/conexion.php";

$id = $_POST["cambioEstado"];

if (!empty($id)){
    $creado = $con->prepare("UPDATE solicitudes SET estado = 'CREADO' WHERE id_solicitud = :NumeroSolicitud");
    $creado->bindParam(":NumeroSolicitud",$id, PDO::PARAM_INT);
    $creado->execute();

    header("location:vistaAdmin.php?success=1");
}

?>