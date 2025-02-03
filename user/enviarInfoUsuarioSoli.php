<?php
require "../conexion/conexion.php";
require "../assets/plugins/PHPMailer/Exception.php";
require "../assets/plugins/PHPMailer/PHPMailer.php";
require "../assets/plugins/PHPMailer/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// Datos para desencriptar
define('ENCRYPTION_KEY', 'ABwVQ$gYH2Xn^QjfadEEB9LzuT!yinb%'); // 32 caracteres
define('IV', '1234567890abcdef'); // 16 caracteres
$cipher = "AES-256-CBC";

$id = $_POST["id_solicitud"];
$nomSistema = $_POST["nomSistema"];
$usuario = $_POST["usuario"];
$contrasena = $_POST["contrasena"];
$comentario = $_POST["comentario"];

if (empty($comentario)) {
    $comentario = "NINGUN COMENTARIO";
}

if (!empty($id) && !empty($usuario) && !empty($contrasena)) {
    $encrypted = openssl_encrypt($contrasena, $cipher, ENCRYPTION_KEY, 0, IV);
    $stmt = $con->prepare("UPDATE solicitudes SET usuario = :usuarioRes, contrasena = :contRes, comentario = :comentarioRes, estado = 'CREADO' WHERE id_solicitud = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":usuarioRes", $usuario, PDO::PARAM_STR);
    $stmt->bindParam(":contRes", $encrypted);
    $stmt->bindParam(":comentarioRes", $comentario, PDO::PARAM_STR);
    $resultado = $stmt->execute();
    if ($resultado) {
        $obtenerCorreo = $con->prepare("SELECT correo FROM solicitudes WHERE id_solicitud = :idSol");
        $obtenerCorreo->bindParam(":idSol", $id, PDO::PARAM_INT);
        $obtenerCorreo->execute();
        $result = $obtenerCorreo->fetch();
        if ($result) {
            $correo = $result['correo'];

            $oMail = new PHPMailer();
            $oMail->isSMTP();
            $oMail->Host = 'smtp.gmail.com';
            $oMail->Port = 587;
            $oMail->SMTPSecure = 'tls';
            $oMail->SMTPAuth = true;
            $oMail->Username = 'pepeperez123prueba@gmail.com';
            $oMail->Password = 'avcb fahj hxvh qypb';
            $oMail->setFrom('pepeperez123prueba@gmail.com', 'Respuesta De La Solicitud De Usuario');
            $oMail->addAddress($correo);
            $oMail->isHTML(true); // Indicamos que el contenido es HTML
            $oMail->Subject = 'Solicitud De Usuario';

            // Cuerpo del correo HTML con estilos CSS y una imagen
            $oMail->Body = "
                <html>
                <head>
                    <style>
                        body {
                            font-family: 'Arial', sans-serif;
                            background-color: #f7f7f7;
                            margin: 0;
                            padding: 0;
                            color: #333;
                        }
                        .container {
                            width: 100%;
                            max-width: 650px;
                            margin: 40px auto;
                            background-color: #ffffff;
                            padding: 30px;
                            border-radius: 10px;
                            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                        }
                        .header {
                            text-align: center;
                            margin-bottom: 20px;
                            color:rgb(218, 146, 11);
                        }
                        .header h2 {
                            margin: 0;
                            font-size: 26px;
                        }
                        .content {
                            font-size: 15px;
                            line-height: 1.6;
                        }
                        .content p {
                            margin-bottom: 15px;
                        }
                        .credential {
                            background-color: #ecf0f1;
                            padding: 12px;
                            margin: 12px 0;
                            border-radius: 6px;
                            font-size: 16px;
                            color: #2c3e50;
                            font-weight: bold;
                        }
                        .comment {
                            background-color: #f9f9f9;
                            padding: 15px;
                            margin: 20px 0;
                            border-left: 5px solid rgb(99, 172, 56);
                            font-size: 14px;
                            color: #555;
                        }
                        .footer {
                            text-align: center;
                            font-size: 12px;
                            color: #777;
                            margin-top: 25px;
                        }
                        .footer span {
                            color: #3498db;
                            text-decoration: none;
                        }
                        .highlight {
                            color: #e74c3c;
                        }
                    </style>
                </head>
                <body>

                <div class='container'>
                    <div class='header'>
                        <h2>Información de solicitud</h2>
                    </div>

                    <div class='content'>
                        <p>Hola, a continuación te compartimos el usuario solicitado para el sistema <strong>" . $nomSistema . ":</strong></p>

                        <div class='credential'>
                            <strong>Usuario:</strong> " . $usuario . "
                        </div>

                        <div class='credential'>
                            <strong>Contraseña:</strong> " . $contrasena . "
                        </div>

                        <div class='comment'>
                            <strong>Comentario:</strong>
                            <p>" . $comentario . "</p>
                        </div>

                        <p>Recuerda no compartir esta información, es por tu seguridad y la de nosotros.</p>
                    </div>

                    <div class='footer'>
                        <p>Si tienes alguna pregunta, no dudes en ponerte en <span>contacto</span> con nuestro soporte.</p>
                        <p><strong>&copy; ".date("Y")." Clinaltec</strong>. Todos los derechos reservados.</p>
                    </div>
                </div>

                </body>
                </html>

            ";



            if (!$oMail->send()) {
                echo json_encode(["status" => "error", "message" => $oMail->ErrorInfo]);
            } else {
                echo json_encode(["status" => "success", "message" => "Solicitud Cumplida"]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Error Al Obtener Correo"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Error Al Cumplir La Solicitud"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Datos vacíos"]);
}


/* // Datos para desencriptar
define('ENCRYPTION_KEY', 'ABwVQ$gYH2Xn^QjfadEEB9LzuT!yinb%'); // 32 caracteres
define('IV', '1234567890abcdef'); // 16 caracteres

// Función para desencriptar
function decrypt($data)
{
    $cipher = "AES-256-CBC";
    $decodedData = urldecode($data); // Decodificar desde la URL
    return openssl_decrypt($decodedData, $cipher, ENCRYPTION_KEY, 0, IV);
}

$cedulaJefe = htmlspecialchars($_POST['NOMBRE_JEFE_INMEDIATO']);
$cedulaJefe = decrypt($cedulaJefe);

// Función para encriptar
function encrypt($data)
{
    $cipher = "AES-256-CBC";
    $encrypted = openssl_encrypt($data, $cipher, ENCRYPTION_KEY, 0, IV);
    return urlencode($encrypted); // Codificar para URL
} */
