<?php

$mysqli = new mysqli('localhost', 'root', '', 'siglo_del_hombre');

if ($mysqli->connect_error) {
	die('Error en la conexion' . $mysqli->connect_errno);
}
