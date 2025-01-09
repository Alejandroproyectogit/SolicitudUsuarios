<?php 
require "../conexion/conexion.php";
$usuario = $_POST["usuario"];

$consulta = $con->prepare("SELECT usuario FROM usuarios WHERE usuario = :nUsuario");
$consulta->bindParam(":nUsuario",$usuario, PDO::PARAM_INT);
$consulta->execute();
$resultadoCon = $consulta->fetch();

if($resultadoCon){
    echo "1";
}else{
    echo "2";
}

?>