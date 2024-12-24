<?php
require "../conexion/conexion.php";

$idSolicitud = $_POST["eliminarSolicitud"];
if (!empty($idSolicitud)) {
    $delete = $con->prepare("DELETE FROM solicitudes WHERE id_solicitud = :id");
    $delete->bindParam(":id",$idSolicitud,PDO::PARAM_INT);
    $delete->execute();
    header("location: vistaAdmin.php");
}


?>