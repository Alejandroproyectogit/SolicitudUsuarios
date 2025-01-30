<?php
require "conexion/conexion.php";

//aqui se recibe la accion enviada en el login y lo envia a user/validacion.php

if (isset($_GET["accion"])) {
    if ($_GET["accion"] == "validarCredenciales") {
        require "user/validacion.php";
    }
}else{
// si no hay ninguna acción, el programa lo enviara al login.php por defecto
    header("location: login.php");
}

?>
