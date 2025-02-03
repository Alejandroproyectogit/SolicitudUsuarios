<?php

require "../conexion/conexion.php";

$correo = $_POST["correo"];

$buscarCorreo = $con->prepare("SELECT correoUsuarios FROM usuarios WHERE correoUsuarios = :correo");
$buscarCorreo->bindParam(":correo", $correo, PDO::PARAM_STR);
$buscarCorreo->execute();
$resultado = $buscarCorreo->fetch();

if ($resultado) {
    echo "1";
} else {
    echo "2";
}

?>