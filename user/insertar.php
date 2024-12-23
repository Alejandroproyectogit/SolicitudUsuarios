<?php
// Datos de conexión a la base de datos (asegúrate de tener $con ya inicializado)
require "../conexion/conexion.php";
$id = 3;
$nombre = "Kevin";
$usuario = 123321;
$contrasena = 123;
$cargo = "Jefe";
$area = "IMG";
$id_rol = 2;


// Crear el hash de la contraseña con bcrypt
$hash_contrasena = password_hash($contrasena, PASSWORD_BCRYPT);

// Preparar la consulta SQL
$stmt = $con->prepare("INSERT INTO usuarios (id,nombre,usuario,contrasena,cargo,area,id_rol) VALUES (:id,:nombre,:usuario,:contrasena,:cargo,:area,:id_rol)");

// Vincular parámetros
$stmt->bindParam(":id", $id, PDO::PARAM_INT);
$stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
$stmt->bindParam(":usuario", $usuario, PDO::PARAM_INT);
$stmt->bindParam(":contrasena", $hash_contrasena, PDO::PARAM_STR);
$stmt->bindParam(":cargo", $cargo, PDO::PARAM_STR);
$stmt->bindParam(":area", $area, PDO::PARAM_STR);
$stmt->bindParam(":id_rol", $id_rol, PDO::PARAM_INT); // Asegúrate de tener el valor de $id_rol

// Ejecutar la consulta
$stmt->execute();

echo "Usuario creado correctamente!";
?>
