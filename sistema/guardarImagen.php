<?php
include "../conexion.php";
include "barcode/barcode.php";

$filepath = $_POST['filepath'];
$text = $_POST['text'];
$nombre = $_POST['nombre'];
//barcode( $filepath, $text, $size, $orientation, $code_type, $print, $sizefactor );
echo $nombre;
barcode( $filepath, $text,'70','horizontal','code128',true,1);

//guardar en la bd
$query_insert = mysqli_query($conexion, "INSERT INTO codigobarras(codigo,producto) values ('$text', '$nombre')");
if ($query_insert) {
    $alert = '<div class="alert alert-primary" role="alert">
                        Código Registrado.
                    </div>';
} else {
    $alert = '<div class="alert alert-danger" role="alert">
                        Error al guardar el codigo generado, favor de intentarlo nuevamente.
                </div>';
}

mysqli_close($conexion);
?>