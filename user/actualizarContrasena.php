<?php

/* Obtenemos la conexión */
require "../conexion/conexion.php";

/* Iniciamos un session */
session_start();

/* Obtenemos los valores del formulario */
$id = $_SESSION["idUsuRec"];//Obtenemos el valor de la variable $_SESSION["idUsuRec"] para saber a que usuario se actualiza la contraseña
$nuevaPass = $_POST["nuevaPass"];
$confirmPass = $_POST["confirmPass"];

/* Validamos que los campos no esten vacios */
if(!empty($id) && !empty($nuevaPass) && !empty($confirmPass)){
    /* Validamos que la nueva contraseña coincida con la que confirman */
    if($nuevaPass == $confirmPass){
        /* Ciframos la nueva contraseña con bcrypt */
        $up_hash_contrasena = password_hash($confirmPass, PASSWORD_BCRYPT);
        /* Preparamos y ejecutamos la consulta para actualizar la contraseña del usuario */
        $upContra = $con->prepare("UPDATE usuarios SET contrasena = :newPass WHERE id = :idUsu");
        $upContra->bindParam(":idUsu", $id, PDO::PARAM_STR);
        $upContra->bindParam(":newPass", $up_hash_contrasena, PDO::PARAM_STR);
        $resultUp = $upContra->execute();

        /* Si la actualización fue exitosa, destruimos la sesión y devuelve un mensaje de éxito */
        if($resultUp){
            $_SESSION["idUsuRec"] = null;
            echo json_encode(["status" => "success", "message" => "Actualizaste tu contraseña"]);
        }else{
            /* Si no se actualizo, saldra error */
            echo json_encode(["status" => "error", "message" => "Hubo un error al actualizar la contraseña"]);
        }

    }else{
        /* Si las contraseñas no coinciden, saldra error */
        echo json_encode(["status" => "error", "message" => "Las contraseñas no coinciden"]);
    }
}else{
    /* Si alguno de los campos esta vacio, saldra error */
    echo json_encode(["status" => "error", "message" => "Todos los campos son obligatorios"]);
}



?>