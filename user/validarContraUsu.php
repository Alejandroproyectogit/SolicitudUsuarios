<?php

require "../conexion/conexion.php";

define('ENCRYPTION_KEY', 'ABwVQ$gYH2Xn^QjfadEEB9LzuT!yinb%'); // 32 caracteres
define('IV', '1234567890abcdef'); // 16 caracteres
$cipher = "AES-256-CBC";


$idUsuario = $_POST['idUsuario'];
$id_solicitud = $_POST['id_solicitud'];
$contrasena = $_POST['contrasena'];

if (!empty($idUsuario) && !empty($id_solicitud) && !empty($contrasena)) {
    $validacion = $con->prepare("SELECT contrasena FROM usuarios WHERE id = :id");
    $validacion->bindParam(":id", $idUsuario, PDO::PARAM_INT);
    $validacion->execute();
    $dato = $validacion->fetch();
    if ($dato) {
        if (password_verify($contrasena, $dato["contrasena"])) {
            $val = $con->prepare("SELECT usuario, contrasena, comentario FROM solicitudes WHERE id_solicitud = :id_solicitud");
            $val->bindParam(":id_solicitud", $id_solicitud, PDO::PARAM_INT);
            $val->execute();
            $resultSol = $val->fetch();
            if($resultSol) {
                
                $usuario = $resultSol["usuario"];
                $contra = $resultSol["contrasena"];
                $comentario = $resultSol["comentario"];
                $decrypt = openssl_decrypt($contra, $cipher, ENCRYPTION_KEY, 0, IV);
                
                echo json_encode(["status" => "success", "dato1" => $usuario, "dato2" => $decrypt, "dato3" => $comentario]);
            
            } else {
                echo json_encode(["status" => "error", "message" => "Error Al Ver Información"]);
            }
        }else {
            echo json_encode(["status" => "error", "message" => "Contraseña Incorrecta"]);
        }
    }
} else {
    echo json_encode(["status" => "error", "message" => "Campo Vacio"]);
}
