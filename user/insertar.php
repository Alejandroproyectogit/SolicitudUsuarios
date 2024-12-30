<?php
require "../conexion/conexion.php";

$data = json_decode(file_get_contents("php://input"), true);

if ($data){
    $tipoDocumento = htmlspecialchars($data["tipoDocumento"]);
    $nDocumento = htmlspecialchars($data["nDocumento"]);
    $nombres = htmlspecialchars($data["nombres"]);
    $apellidos = htmlspecialchars($data["apellidos"]);
    $usuario = htmlspecialchars($data["usuario"]);
    $contrasena = htmlspecialchars($data["contrasena"]);
    $cargo = htmlspecialchars($data["cargo"]);
    $area = htmlspecialchars($data["area"]);
    $id_rol = htmlspecialchars($data["rol"]);

    $hash_contrasena = password_hash($contrasena, PASSWORD_BCRYPT);

    $stmt = $con->prepare("INSERT INTO usuarios (tipoDocumento,documento,nombres,apellidos,usuario,contrasena,cargo,area,id_rol) VALUES (:tipoDoc,:nDoc,:nombres,:apellidos,:usuario,:contra,:cargo,:are,:id_rol)");

    // Vincular parámetros
    $stmt->bindParam(":tipoDoc", $tipoDocumento, PDO::PARAM_STR);
    $stmt->bindParam(":nDoc", $nDocumento, PDO::PARAM_INT);
    $stmt->bindParam(":nombres", $nombres, PDO::PARAM_STR);
    $stmt->bindParam(":apellidos", $apellidos, PDO::PARAM_STR);
    $stmt->bindParam(":usuario", $usuario, PDO::PARAM_STR);
    $stmt->bindParam(":contra", $hash_contrasena);
    $stmt->bindParam(":cargo", $cargo, PDO::PARAM_STR);
    $stmt->bindParam(":are", $area, PDO::PARAM_STR);
    $stmt->bindParam(":id_rol", $id_rol, PDO::PARAM_INT);
    $result = $stmt->execute();

    if ($result){
        $response = [
            'message' => "Usuario Creado"
        ];
    }else{
        $response = [
            'message' => "Error Algo Salio Mal"
        ];
    }
}else{
    $response = [
        'message' => "Todos Los Campos Deben Estar LLenos"
    ];
}
header('Content-Type: application/json');
echo json_encode($response);
?>
