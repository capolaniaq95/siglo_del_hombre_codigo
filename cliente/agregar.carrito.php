<?php
session_start();


if (isset($_POST['id_libro'])) {
    $idLibro = intval($_POST['id_libro']);


    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = array();
    }


    if (array_key_exists($idLibro, $_SESSION['carrito'])) {
        $_SESSION['carrito'][$idLibro]++;
    } else {
        $_SESSION['carrito'][$idLibro] = 1;
    }


    header('Location: libros.php');
    exit();
} else {
    echo "Error: No se ha enviado el ID del libro.";
}