<?php

//Obtenemos el archivo de conexión y los archivos de la libreria PHPMailer

require "../conexion/conexion.php";
require "../assets/plugins/PHPMailer/Exception.php";
require "../assets/plugins/PHPMailer/PHPMailer.php";
require "../assets/plugins/PHPMailer/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Obtenemos el correo que se envio del archivo recuperarContrasena.php
$correo = $_POST["correo"];

//Validamos que no este vacio
if (!empty($correo)){
    //Buscamos si el correo existe en la BD, utilizamos un SELECT para obtener el id y el correo
    $buscarCorreo = $con->prepare("SELECT id,correoUsuarios FROM usuarios WHERE correoUsuarios = :corr");
    $buscarCorreo->bindParam(":corr",$correo, PDO::PARAM_STR);
    $buscarCorreo->execute();
    $resultado = $buscarCorreo->fetch();

    //Si se encuentra la información se ejecutara lo siguiente
    if ($resultado){
        
        $correo = $resultado["correoUsuarios"]; //Guardamos el correo de la BD en la variable $correo
        $numero_aleatorio = random_int(10000, 99999); //Generamos un número aleatorio para el código de recuperación
        $oMail = new PHPMailer(); //Se llama la clase PHPMailer que es de la libreria
        $oMail->isSMTP();
        $oMail->Host = 'smtp.gmail.com';
        $oMail->Port = 587;
        $oMail->SMTPSecure = 'tls';
        $oMail->SMTPAuth = true;
        $oMail->Username = 'pepeperez123prueba@gmail.com'; //Aqui se coloca el correo que enviara todos los correos
        $oMail->Password = 'avcb fahj hxvh qypb'; //Aqui se coloca la contraseña del correo
        $oMail->setFrom('pepeperez123prueba@gmail.com', 'Clinaltec');
        $oMail->addAddress($correo); //Este sera el correo destinatario
        $oMail->CharSet = 'UTF-8'; //Definimos UTF-8 para que no hayan conflictos con caracteres como la "Ñ"
        $oMail->isHTML(true); // Indicamos que el contenido es HTML
        $oMail->Subject = 'Codigo de Recuperación';

        // Cuerpo del correo HTML con estilos CSS
        $oMail->Body = "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Recuperación de Cuenta</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                }
                .email-container {
                    width: 100%;
                    max-width: 600px;
                    margin: 0 auto;
                    background-color: #ffffff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                }
                .header {
                    text-align: center;
                    padding: 20px;
                    background-color:rgb(255, 196, 0);
                    color: white;
                    border-radius: 8px 8px 0 0;
                }
                .header h1 {
                    margin: 0;
                }
                .content {
                    padding: 20px;
                    font-size: 16px;
                    color: #333333;
                }
                .content p {
                    margin: 15px 0;
                }
                .footer {
                    text-align: center;
                    font-size: 12px;
                    color: #888888;
                    margin-top: 30px;
                }
            </style>
        </head>
        <body>

            <div class='email-container'>
                <!-- Header -->
                <div class='header'>
                    <h1>Recuperación de Cuenta</h1>
                </div>

                <!-- Content -->
                <div class='content'>
                    <p>¡Hola!</p>
                    <p>Hemos recibido una solicitud para recuperar tu cuenta en Solicitud Usuarios Clinaltec. Por favor, usa el siguiente código de recuperación para restablecer tu contraseña:</p>
                    <h2 style='text-align: center; font-size: 24px; font-weight: bold; color:rgb(0, 0, 0);'>".$numero_aleatorio."</h2>
                    <p>Este código expirará en 15 minutos. Si no solicitaste esta recuperación, ignora este mensaje.</p>
                </div>

                <!-- Footer -->
                <div class='footer'>
                    <p>Si tienes alguna pregunta, no dudes en ponerte en contacto con nuestro soporte.</p>
                    <p>&copy; ".date("Y")." Clinaltec. Todos los derechos reservados.</p>
                </div>
            </div>

        </body>
        </html>
        ";


        //Se valida si se envia el correo
        if ($oMail->send()) {
            //Si el correo se envia correctamente, generamos la sesion
            session_start();
            $_SESSION["idUsuRec"] = $resultado["id"];
            $_SESSION["codigoGenerado"] = $numero_aleatorio; //Guardamos el código generado en una SESSION
            $_SESSION["timestampGenerado"] = time(); //Creamos una SESSION con time para el vencimiento del codigo, nos da el momento en que se genero el codigo
            
            echo json_encode(["status" => "success", "message" => "Se Envio un codigo a tu correo"]); //Se responde un Success con su mensaje para mostrar la alerta en recuperarContrasena.php
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Usuario no encontrado"]);//Si no se encuentra la información arroja error
    }
}else{
    echo json_encode(["status" => "error", "message" => "Campo Vacío"]);//Si el campo esta vacio arroja error
}

?>