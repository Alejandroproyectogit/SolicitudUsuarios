<?php
session_start();
$usuario = $_POST["usuario"];
$pass = $_POST["pass"];
if (!empty($usuario) && !empty($pass)) {
    $stmt = $con->prepare("SELECT id, nombre, usuario, contrasena, id_rol FROM usuarios WHERE usuario=:usu");
    $stmt->bindParam(":usu", $usuario, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch();

    if ($result) {

        $hash_pass = $result["contrasena"];

        if (password_verify($pass, $hash_pass)) {
            if ($result["id_rol"] == 1) {
                $_SESSION['id_usuario'] = $result["id"];
                $_SESSION['usuario'] = $result["usuario"];
                $_SESSION['nombre'] = $result["nombre"];
                $_SESSION['id_rol'] = $result["id_rol"];
                header("location: user/vistaAdmin.php");
                exit();
            } elseif ($result["id_rol"] == 2) {
                $_SESSION['id_usuario'] = $result["id"];
                $_SESSION['usuario'] = $result["usuario"];
                $_SESSION['nombre'] = $result["nombre"];
                $_SESSION['id_rol'] = $result["id_rol"];
                header("location: user/vistaUsuarios.php");
                exit();
            }
        } else {
            header("location: ../solicitudUsuarios/login.php?error=1");
        }
    } else {
        header("location: ../solicitudUsuarios/login.php?error=1");
    }
} else {
    echo "<p>Ingresa Usuario y contraseña</p>";
}
