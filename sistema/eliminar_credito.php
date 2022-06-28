<?php include_once "includes/header.php"; ?>
<?php
if (!empty($_GET['id'])) {
    require("../conexion.php");
    $id = $_GET['id'];
    $usuario = $_SESSION['idUser'];
    $query_del = mysqli_query($conexion, "UPDATE creditos set estado=2 ,fechacancelacion=NOW(), usuario_id_mod='".$usuario."' WHERE numcredito = '$id'");
    echo  "UPDATE creditos set estado=2 WHERE numcredito = '$id'";
    historia('Se cancelo el credito numero #'.$id);  
    mensajeicono('Se ha cancelado con éxito el credito!', 'lista_creditos.php','','exito');
}
?>
<?php include_once "includes/footer.php"; ?>