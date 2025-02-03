<?php
require "../conexion/conexion.php";

$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $tipoDocumento = htmlspecialchars($data["tipoDocumento"]);
    $nDocumento = htmlspecialchars($data["nDocumento"]);
    $nombres = htmlspecialchars($data["nombres"]);
    $apellidos = htmlspecialchars($data["apellidos"]);
    $correo = htmlspecialchars($data["correo"]);
    $usuario = htmlspecialchars($data["usuario"]);
    $contrasena = htmlspecialchars($data["contrasena"]);
    $cargo = htmlspecialchars($data["cargo"]);
    $area = htmlspecialchars($data["area"]);
    $id_rol = htmlspecialchars($data["rol"]);
    $vencimientoClave = date("Y-m-d H:i:s", strtotime('+1 year')); 

    if (
        !empty($tipoDocumento) && !empty($nDocumento) && !empty($nombres) &&
        !empty($apellidos) && !empty($correo) && !empty($usuario) && !empty($contrasena) &&
        !empty($cargo) && !empty($area) && !empty($id_rol)
    ) {
        $sql = "SELECT documento, usuario, correoUsuarios FROM usuarios WHERE documento = :nDoc OR usuario = :usu OR correoUsuarios = :correo";
        $sentencia = $con->prepare($sql);
        $sentencia->bindParam(":nDoc", $nDocumento, PDO::PARAM_STR);
        $sentencia->bindParam(":correo", $correo, PDO::PARAM_STR);
        $sentencia->bindParam(":usu", $usuario, PDO::PARAM_STR);
        $sentencia->execute();
        $resultado = $sentencia->fetchColumn();

        if (!$resultado) {
            $hash_contrasena = password_hash($contrasena, PASSWORD_BCRYPT);

            $stmt = $con->prepare("INSERT INTO usuarios (tipoDocumento,documento,nombre,apellidos,correoUsuarios,usuario,contrasena,cargo,area,id_rol ,estado,vencimientoClave ) VALUES (:tipoDoc,:nDoc,:nombres,:apellidos,:correo,:usuario,:contra,:cargo,:are,:id_rol ,'ACTIVO',:vencimientoClave )");

            // Vincular parámetros
            $stmt->bindParam(":tipoDoc", $tipoDocumento, PDO::PARAM_STR);
            $stmt->bindParam(":nDoc", $nDocumento, PDO::PARAM_INT);
            $stmt->bindParam(":nombres", $nombres, PDO::PARAM_STR);
            $stmt->bindParam(":apellidos", $apellidos, PDO::PARAM_STR);
            $stmt->bindParam(":correo", $correo, PDO::PARAM_STR);
            $stmt->bindParam(":usuario", $usuario, PDO::PARAM_STR);
            $stmt->bindParam(":contra", $hash_contrasena);
            $stmt->bindParam(":cargo", $cargo, PDO::PARAM_STR);
            $stmt->bindParam(":are", $area, PDO::PARAM_STR);
            $stmt->bindParam(":id_rol", $id_rol, PDO::PARAM_INT);
            $stmt->bindParam(":vencimientoClave",$vencimientoClave, PDO::PARAM_STR); 
            $result = $stmt->execute();

            if ($result) {
                $response = [
                    'message' => "1"
                ];
            }
        }else{
            $response = [
                'message' => "2"
            ];
        }
    } else {
        $response = [
            'message' => "3"
        ];
    }
}
header('Content-Type: application/json');
echo json_encode($response);
