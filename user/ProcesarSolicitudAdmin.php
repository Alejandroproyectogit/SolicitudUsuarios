<?php
require "../conexion/conexion.php";

if (isset($_POST["enviar"])) {
    $tipoDocumento = $_POST["tipoDocumento"];
    $nDocumento = $_POST["nDocumento"];
    $nombres = $_POST["nombres"];
    $apellidos = $_POST["apellidos"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];
    $cargo = $_POST["cargo"];
    $sistemas = $_POST["sistemas"];
    $nombreUsuCopia = $_POST["nombreUsuCopia"];
    $documentoUsuCopia = $_POST["documentoUsuCopia"];
    $solicitante = $_POST["solicitante"];
    $estado = $_POST["estado"];

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
            header("location: vistaAdmin.php");
        } else {
            echo "no insertado";
        }
    } else {
        echo "Datos vacios";
    }
}
