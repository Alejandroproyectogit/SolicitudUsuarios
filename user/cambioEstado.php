<?php 
require "../conexion/conexion.php";

$id = json_decode(file_get_contents("php://input"), true);

if ($id){
    $id_solicitud = htmlspecialchars($id["cambio"]);
    $creado = $con->prepare("UPDATE solicitudes SET estado = 'CREADO' WHERE id_solicitud = :NumeroSolicitud");
    $creado->bindParam(":NumeroSolicitud",$id_solicitud, PDO::PARAM_INT);
    $result = $creado->execute();

    if ($result){
        $response = [
            'message' => "Usuario Realizado"
        ];
    } else {
        $response = [
            'message' => "Algo salio mal :("
        ];
    }

}

header('Content-Type: application/json');
echo json_encode($response);


?>
