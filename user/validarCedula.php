<?php 
require "../conexion/conexion.php";
$idoc = $_POST["documento"];

$consulta = $con->prepare("SELECT documento FROM usuarios WHERE documento = :nDocumento");
$consulta->bindParam(":nDocumento",$idoc, PDO::PARAM_INT);
$consulta->execute();
$resultadoCon = $consulta->fetch();

if($resultadoCon){
    echo "1";
}else{
    echo "2";
}

?>