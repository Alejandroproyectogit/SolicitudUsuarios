<?php
//Abrimos una session_start para obtener las variables "SESSION" definidas en el archivo procesoRecuperacion.php
session_start();
//Almacenamos las variables super globales en unas variables
$codigoGenerado = $_SESSION["codigoGenerado"];
$temporizador = $_SESSION["timestampGenerado"];

//Se verifica si el código fue generado y existe en la sesión, también se valida si "$temporizador" no esta vacio 
if (isset($codigoGenerado) && isset($temporizador)) {
    $codigoIngresado = $_POST["codigo"]; //Se recibe el código que el usuario ingresó

    //Se verificar si el código ingresado es correcto
    if ($codigoIngresado == $codigoGenerado) {
        //Se verificar si el código ha expirado
        $tiempoTranscurrido = time() - $temporizador;
        
        if ($tiempoTranscurrido > 15 * 60) { //Se definen 15 minutos en segundos
            //Si el código ha expirado
            unset($_SESSION["codigoGenerado"]); //Se elimina el código de la sesión
            unset($_SESSION["timestampGenerado"]); //Se elimina el timestamp de la sesión
            echo json_encode(["status" => "errorCodigo", "message" => "El código ha expirado"]); //Se envian las varibles status y message, en este caso son de error
        } else {
            //El código es válido y no ha expirado
            echo json_encode(["status" => "success"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Código incorrecto"]); //Si el codigo digitado por el usuario no es igual al generado, arrojara error
    }
} else {
    echo json_encode(["status" => "error", "message" => "No se encontró un código válido"]);//Error si algo esta vacio
}

?>