<?php

/* Obtenemos la conexión */
require "../conexion/conexion.php";

// Datos para desencriptar
define('ENCRYPTION_KEY', 'ABwVQ$gYH2Xn^QjfadEEB9LzuT!yinb%'); // 32 caracteres
define('IV', '1234567890abcdef'); // 16 caracteres

/* Función para desencriptar */

function decrypt($data)
{
    $cipher = "AES-256-CBC";
    $decodedData = urldecode($data); // Decodificar desde la URL
    return openssl_decrypt($decodedData, $cipher, ENCRYPTION_KEY, 0, IV);
}

/* Obtenemos los datos que se enviaron por post */
$tipoDocumento = $_POST["tipoDocumento"];
$nDocumento = $_POST["nDocumento"];
$nombres = $_POST["nombres"];
$apellidos = $_POST["apellidos"];
$telefono = $_POST["telefono"];
$correo = $_POST["correo"];
$cargo = $_POST["cargo"];
$sistemas = isset($_POST["sistemas"]) ? $_POST["sistemas"] : [];//Realizamos un operador ternario
$nombreUsuCopia = !empty($_POST["nombreUsuCopia"]) ? $_POST["nombreUsuCopia"] : null;//Realizamos un operador ternario
$documentoUsuCopia = !empty($_POST["documentoUsuCopia"]) ? $_POST["documentoUsuCopia"] : null;//Realizamos un operador ternario

/* Dato encriptado para desencriptar */
$solicitante = $_POST["solicitante"];
$solicitante = decrypt($solicitante);

$estado = $_POST["estado"];

/* Validamos que los datos recibidos no estén vacíos */
if (
    !empty($tipoDocumento) && !empty($nDocumento) && !empty($nombres) &&
    !empty($apellidos) && !empty($telefono) && !empty($correo) && !empty($cargo) &&
    !empty($sistemas) && !empty($solicitante) && !empty($estado)
) {
    /* Usamos un foreach para hacer una inserción para cada sistema que se selecciono */
    foreach ($sistemas as $sistema) {

        /* Preparamos la consulta para insertar los datos en la base de datos */
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
        
        /* Usamos bindParam para evitar inyecciones sql */
        $insertSolicitud->bindParam(":tipo", $tipoDocumento, PDO::PARAM_STR);
        $insertSolicitud->bindParam(":nDoc", $nDocumento, PDO::PARAM_INT);
        $insertSolicitud->bindParam(":nom", $nombres, PDO::PARAM_STR);
        $insertSolicitud->bindParam(":apll", $apellidos, PDO::PARAM_STR);
        $insertSolicitud->bindParam(":telf", $telefono, PDO::PARAM_STR);
        $insertSolicitud->bindParam(":correo", $correo, PDO::PARAM_STR);
        $insertSolicitud->bindParam(":cargo", $cargo, PDO::PARAM_STR);
        $insertSolicitud->bindParam(":sis", $sistema, PDO::PARAM_INT);  
        $insertSolicitud->bindParam(":nomUsuCopia", $nombreUsuCopia, PDO::PARAM_STR);
        $insertSolicitud->bindParam(":docUsuCopia", $documentoUsuCopia, PDO::PARAM_INT);
        $insertSolicitud->bindParam(":soli", $solicitante);
        $insertSolicitud->bindParam(":estado", $estado, PDO::PARAM_STR);
        
        /* Ejecutamos la consulta */
        $resultado = $insertSolicitud->execute();
    }

    /* Si la consulta se ejecutó correctamente, respondemos con éxito */
    if ($resultado) {
        echo json_encode(["status" => "success", "message" => "Solicitud Registrada"]);
    } else {
        /* Respondemos error si no se ralizó la inserción */
        echo json_encode(["status" => "error", "message" => "Algo Salio Mal"]);
    }
} else {
    /* Respondemos error si los datos recibidos están vacíos */
    echo json_encode(["status" => "error", "message" => "Datos vacíos"]);
}
?>
