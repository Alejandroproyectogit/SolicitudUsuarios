<?php
require "../conexion/conexion.php";
session_start();
$id = $_SESSION["idUsuRec"];
$nuevaPass = $_POST["nuevaPass"];
$confirmPass = $_POST["confirmPass"];

if(!empty($id) && !empty($nuevaPass) && !empty($confirmPass)){
    if($nuevaPass == $confirmPass){
        $up_hash_contrasena = password_hash($confirmPass, PASSWORD_BCRYPT);
        $upContra = $con->prepare("UPDATE usuarios SET contrasena = :newPass WHERE id = :idUsu");
        $upContra->bindParam(":idUsu", $id, PDO::PARAM_STR);
        $upContra->bindParam(":newPass", $up_hash_contrasena, PDO::PARAM_STR);
        $resultUp = $upContra->execute();

        if($resultUp){
            $_SESSION["idUsuRec"] = null;
            echo json_encode(["status" => "success", "message" => "Actualizaste tu contraseña"]);
        }else{
            echo json_encode(["status" => "error", "message" => "Hubo un error al actualizar la contraseña"]);
        }

    }else{
        echo json_encode(["status" => "error", "message" => "Las contraseñas no coinciden"]);
    }
}else{
    echo json_encode(["status" => "error", "message" => "Todos los campos son obligatorios"]);
}



?>