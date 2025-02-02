<?php

/* Obtenemos la conexion */
require "../conexion/conexion.php";

/* Definimos las constantes para la desencriptación de las contraseñas */

define('ENCRYPTION_KEY', 'ABwVQ$gYH2Xn^QjfadEEB9LzuT!yinb%'); // 32 caracteres
define('IV', '1234567890abcdef'); // 16 caracteres
$cipher = "AES-256-CBC"; //Formato de encriptación

/* Función para desencriptar */
function decrypt($data,$cipher)
{
    $decodedData = urldecode($data); // Decodificar desde la URL
    return openssl_decrypt($decodedData, $cipher, ENCRYPTION_KEY, 0, IV);
}

/* Recibimos los datos que se envian del formulario que se encuentra en buscarRangoFechas.php */
/* Dato a desencriptar */
$idUsuResp = $_POST['idUsuResp'];
$idUsuResp = decrypt($idUsuResp,$cipher);

$id_solicitud = $_POST['id_solicitud'];
$contrasena = $_POST['contrasena'];

/* Validamos que los datos no estén vacíos */
if (!empty($idUsuResp) && !empty($id_solicitud) && !empty($contrasena)) {
    /* Preparamos y ejecutamos la consulta para validar la contraseña del usuario */
    $validacion = $con->prepare("SELECT contrasena FROM usuarios WHERE id = :id");
    $validacion->bindParam(":id", $idUsuResp, PDO::PARAM_INT);
    $validacion->execute();
    $dato = $validacion->fetch();

    /* Si obtenemos datos */
    if ($dato) {
        /* Verificamos que la contraseña sea correcta */
        if (password_verify($contrasena, $dato["contrasena"])) {
            /* Si la contraseña coincide, preparamos y ejecutamos la consulta para obtener los datos de la solicitud */
            $val = $con->prepare("SELECT usuario, contrasena, comentario FROM solicitudes WHERE id_solicitud = :id_solicitud");
            $val->bindParam(":id_solicitud", $id_solicitud, PDO::PARAM_INT);
            $val->execute();
            $resultSol = $val->fetch();

            /* Si obtenemos datos de la solicitud */
            if($resultSol) {
                
                /* Si lo anterior se cumple, entonces almacenamos la información de la solicitud de la BD en variables */
                $usuario = $resultSol["usuario"];
                $contra = $resultSol["contrasena"];
                $comentario = $resultSol["comentario"];
                
                /* Desencriptamos la contraseña de la solicitud */
                $decrypt = openssl_decrypt($contra, $cipher, ENCRYPTION_KEY, 0, IV);
                
                /* Enviamos la información de la solicitud en formato JSON */
                echo json_encode(["status" => "success", "dato1" => $usuario, "dato2" => $decrypt, "dato3" => $comentario]);
                
            } else {
                /* Si no obtenemos datos de la solicitud, enviamos un mensaje de error */
                echo json_encode(["status" => "error", "message" => "Error Al Ver Información"]);
            }
        }else {
            /* Si la contraseña no coincide, enviamos un mensaje de error */
            echo json_encode(["status" => "error", "message" => "Contraseña Incorrecta"]);
        }
    }
} else {
    /* Si los datos están vacíos, enviamos un mensaje de error, recordar que el usuario solo envia la contraseña, los otros datos se obtienen por variables que ya estan en el codigo */
    echo json_encode(["status" => "error", "message" => "Campo Vacio"]);
}
