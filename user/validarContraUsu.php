<?php

/* Obtenemos la conexion */
require "../conexion/conexion.php";

/* Definimos las constantes para la desencriptación de las contraseñas */

define('ENCRYPTION_KEY', 'ABwVQ$gYH2Xn^QjfadEEB9LzuT!yinb%'); // 32 caracteres
define('IV', '1234567890abcdef'); // 16 caracteres

/* funcion para desencriptar */
function decrypt($data)
{
    $cipher = "AES-256-CBC";
    $decodedData = urldecode($data); // Decodificar desde la URL
    return openssl_decrypt($decodedData, $cipher, ENCRYPTION_KEY, 0, IV);
}

/* Recibimos los datos que se envian del formulario que se encuentra en filtrarVistaUsuarios.php */
$idUsuario = $_POST['idUsuario'];
$idUsuario = decrypt($idUsuario);

$id_solicitud = $_POST['id_solicitud'];
$contrasena = $_POST['contrasena'];

/* Validamos que los datos no estén vacíos */
if (!empty($idUsuario) && !empty($id_solicitud) && !empty($contrasena)) {
    /* Preparamos y ejecutamos la consulta para validar la contraseña del usuario */
    $validacion = $con->prepare("SELECT contrasena FROM usuarios WHERE id = :id");
    $validacion->bindParam(":id", $idUsuario, PDO::PARAM_INT);
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
                /* Almacenamos la información de la solicitud de la BD en variables */
                $usuario = $resultSol["usuario"];

            /* Desencriptamos la contraseña para mostrarla al usuario */
                $contra = $resultSol["contrasena"];
                $contra = decrypt($contra);
                $comentario = $resultSol["comentario"];

                
                
                /* Enviamos la información de la solicitud en formato JSON */
                echo json_encode(["status" => "success", "dato1" => $usuario, "dato2" => $contra, "dato3" => $comentario]);
            
            } else {
                /* Enviamos un error si no encontramos resultados de la información de la solicitud */
                echo json_encode(["status" => "error", "message" => "Error Al Ver Información"]);
            }
        }else {
            /* Enviamos un error si la contraseña no coincide */
            echo json_encode(["status" => "error", "message" => "Contraseña Incorrecta"]);
        }
    }
} else {
    /* Si los datos están vacíos, enviamos un mensaje de error, recordar que el usuario solo envia la contraseña, los otros datos se obtienen por variables que ya estan en el codigo */
    echo json_encode(["status" => "error", "message" => "Campo Vacio"]);
}
