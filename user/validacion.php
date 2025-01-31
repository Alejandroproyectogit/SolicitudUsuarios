<?php

//Se abre una sesion para despues definir una variable global "$_SESSION" si el usuario ingresa correctamente

session_start();

// definimos la zona horaria de Bogota y recibimos las credenciales por POST

date_default_timezone_set('America/Bogota');
$usuario = $_POST["usuario"];
$pass = $_POST["pass"];

// verificamos si las credenciales existen y son válidas
if (!empty($usuario) && !empty($pass)) {
    
    // Realizamos las consulta en donde validaremos si el usuario esta en la BD

    $stmt = $con->prepare("SELECT id, nombre, usuario, contrasena, id_rol , estado, vencimientoClave  FROM usuarios WHERE usuario=:usu");
    $stmt->bindParam(":usu", $usuario, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch();

    // Si existe el usuario se ejecutara este codigo

    if ($result) {

        //Recibiremos el campo "vencimientoCLave" y "contrasena", también convertiremos la fecha y hora de vencimiento de acceso que tenemos en BD y la fecha y hora actual a DateTime.

        $fechaBd = $result["vencimientoClave"];
        $fechaActual = date("Y-m-d H:i:s");
        $fechaBdDT = new DateTime($fechaBd);
        $fechaActualDT = new DateTime($fechaActual); 
        $hash_pass = $result["contrasena"];

        if (password_verify($pass, $hash_pass)) {

            //Si la contraseña coincide con la que esta en la BD, se ejecuta lo siguiente.

            if ($result["id_rol"] == 1  && $result["estado"] == "ACTIVO" && $fechaBdDT > $fechaActualDT ) {

                //"id_rol = 1" significa Administrator, si el usuario tiene este "id_Rol" y su "estado" es "ACTIVO" y "vencimientoClave" es mayor a la actual, entonces, dejara ingresar a user/vistaAdmin.php

                // Definimos variables globales para el manejo de sesiones
                $_SESSION['id_usuario'] = $result["id"];
                $_SESSION['usuario'] = $result["usuario"];
                $_SESSION['nombre'] = $result["nombre"];
                $_SESSION['id_rol'] = $result["id_rol"];
                header("location: user/vistaAdmin.php");
                exit();
            } elseif ($result["id_rol"] == 2  && $result["estado"] == "ACTIVO" && $fechaBdDT > $fechaActualDT ) {

                //"id_rol = 2" significa Usuario, si el usuario tiene este "id_Rol" y su "estado" es "ACTIVO" y "vencimientoClave" es mayor a la actual, entonces, dejara ingresar a user/vistaUsuarios.php

                // Definimos variables globales para el manejo de sesiones
                $_SESSION['id_usuario'] = $result["id"];
                $_SESSION['usuario'] = $result["usuario"];
                $_SESSION['nombre'] = $result["nombre"];
                $_SESSION['id_rol'] = $result["id_rol"];
                header("location: user/vistaUsuarios.php");
                exit();
            } else{
                header("location: ../solicitudUsuarios/login.php?error=1");
                exit();
            }
        } else {
            header("location: ../solicitudUsuarios/login.php?error=1");
        }
    } else {
        header("location: ../solicitudUsuarios/login.php?error=1");
    }
} else {
    header("location: ../solicitudUsuarios/login.php?error=2");
}
// Si no se cumple algo, el programa enviara al login con un error.