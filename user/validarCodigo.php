<?php
session_start();
$codigoGenerado = $_SESSION["codigoGenerado"];
$temporizador = $_SESSION["timestampGenerado"];

// Verificar si el código fue generado y existe en la sesión
if (isset($codigoGenerado) && isset($temporizador)) {
    $codigoIngresado = $_POST["codigo"]; // El código que el usuario ingresó

    // Verificar si el código ingresado es correcto
    if ($codigoIngresado == $codigoGenerado) {
        // Verificar si el código ha expirado
        $tiempoTranscurrido = time() - $temporizador;
        
        if ($tiempoTranscurrido > 15 * 60) { // 15 minutos en segundos
            // El código ha expirado
            unset($_SESSION["codigoGenerado"]); // Eliminar el código de la sesión
            unset($_SESSION["timestampGenerado"]); // Eliminar el timestamp de la sesión
            echo json_encode(["status" => "errorCodigo", "message" => "El código ha expirado"]);
        } else {
            // El código es válido y no ha expirado
            echo json_encode(["status" => "success"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Código incorrecto"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "No se encontró un código válido"]);
}

?>