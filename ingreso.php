<?php

require "conexion.php";

$correo = $_POST['email'];
$password = $_POST['password'];
$rol = $_POST['rol'];

if ($rol == 'Administrador') {
	$rol_id = 1;
} else {
	$rol_id = 2;
}

$query = "SELECT * FROM usuario WHERE correo='$correo' AND password='$password' AND rol=$rol_id";

$result = $mysqli->query($query);
$num = $result->num_rows;


if ($num == 1) {

	$queryuser = $mysqli->query($query);

	$user = $queryuser->fetch_assoc();

	session_start();

	$_SESSION["id_usuario"] = $user['id_usuario'];
	$_SESSION["id_tipo"] = $rol_id;
	if ($rol_id == 1) {
		header("Location: index.administrador.php");
	} else {
		header("Location: index.php");
	}
} else {
	echo "<script> alert('Usuario, contraseña o rol incorrecto.');window.location='login.php' </script>";
}
