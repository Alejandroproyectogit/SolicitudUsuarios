<?php
require "conexion/conexion.php";

if (isset($_GET["accion"])) {
    if ($_GET["accion"] == "validarCredenciales") {
        require "user/validacion.php";
    }
}else{
    header("location: login.php");
}

?>
