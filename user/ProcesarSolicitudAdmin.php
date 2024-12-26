<?php
require "../conexion/conexion.php";
$data = json_decode(file_get_contents("php://input"), true);
if ($data) {
    $tipoDocumento = $data["tipoDocumento"];
    $nDocumento = $data["nDocumento"];
    $nombres = $data["nombres"];
    $apellidos = $data["apellidos"];
    $telefono = $data["telefono"];
    $correo = $data["correo"];
    $cargo = $data["cargo"];
    $sistemas = $data["sistemas"];
    $nombreUsuCopia = $data["nombreUsuCopia"];
    $documentoUsuCopia = $data["documentoUsuCopia"];
    $solicitante = $data["solicitante"];
    $estado = $data["estado"];

    if (
        !empty($tipoDocumento) && !empty($nDocumento) && !empty($nombres) &&
        !empty($apellidos) && !empty($telefono) && !empty($correo) && !empty($cargo) &&
        !empty($sistemas) && !empty($nombreUsuCopia) &&
        !empty($documentoUsuCopia) && !empty($solicitante) && !empty($estado)
    ) {

        foreach ($sistemas as $sistema) {

            $insertSolicitud = $con->prepare("INSERT INTO solicitudes 
            (
            tipoDocumento, 
            documento, 
            nombres, 
            apellidos, 
            telefono, 
            correo, 
            cargo, 
            id_sistema, 
            nombreUsuarioCopia, 
            documentoUsuCopia,
            QuienSolicita,
            estado) 
            VALUES 
            (
            
            :tipo,
            :nDoc,
            :nom,
            :apll,
            :telf,
            :correo,
            :cargo,
            :sis,
            :nomUsuCopia,
            :docUsuCopia,
            :soli,
            :estado);");
            $insertSolicitud->bindParam(":tipo", $tipoDocumento, PDO::PARAM_STR);
            $insertSolicitud->bindParam(":nDoc", $nDocumento, PDO::PARAM_INT);
            $insertSolicitud->bindParam(":nom", $nombres, PDO::PARAM_STR);
            $insertSolicitud->bindParam(":apll", $apellidos, PDO::PARAM_STR);
            $insertSolicitud->bindParam(":telf", $telefono, PDO::PARAM_STR);
            $insertSolicitud->bindParam(":correo", $correo, PDO::PARAM_STR);
            $insertSolicitud->bindParam(":cargo", $cargo, PDO::PARAM_STR);
            $insertSolicitud->bindParam(":sis", $sistema);
            $insertSolicitud->bindParam(":nomUsuCopia", $nombreUsuCopia, PDO::PARAM_STR);
            $insertSolicitud->bindParam(":docUsuCopia", $documentoUsuCopia, PDO::PARAM_INT);
            $insertSolicitud->bindParam(":soli", $solicitante);
            $insertSolicitud->bindParam(":estado", $estado, PDO::PARAM_STR);
            $resultado = $insertSolicitud->execute();
        }

        if ($resultado) {
            $response = [
                'message' => "Solicitud Realizada Con Exito"
            ];
        } else {
            $response = [
                'message' => "Algo Salio Mal"
            ];
        }
    } else {
        $response = [
            'message' => "Algo Salio Mal"
        ];
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

