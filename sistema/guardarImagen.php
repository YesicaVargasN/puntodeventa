<?php
include "barcode/barcode.php";
require_once "conexion.php";

$filepath = $_POST['filepath'];
$text = $_POST['text'];
//$nombre = $_POST['nom'];
//barcode( $filepath, $text, $size, $orientation, $code_type, $print, $sizefactor );
barcode( $filepath, $text,'70','horizontal','code128',true,1);
//guardar en la bd

/*$sql = "INSERT INTO codigobarras(codigo, producto) values ('$text', '$nombre')";
echo $sql;
$query_insert = mysqli_query($conexion, $sql);
if ($query_insert) {
    $alert = '<div class="alert alert-primary" role="alert">
                Codigo registrado
            </div>';
} else {
    $alert = '<div class="alert alert-danger" role="alert">
                Error al registrar el código
            </div>';
}*/
?>