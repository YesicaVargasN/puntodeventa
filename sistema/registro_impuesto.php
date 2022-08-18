<?php
include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
    $alert = "";
    
        $impuesto = $_POST['impuesto'];
        $taza = $_POST['taza'];

        $sql= "INSERT INTO impuesto(impuesto,taza, activo) values ('$impuesto', '$taza','1' )";
        echo $sql;
        $query_insert = mysqli_query($conexion,$sql);
       
        if ($query_insert) {
            historia('Se registro un nuevo impuesto '.$impuesto);
            mensajeicono('Se ha registrado con éxito el nuevo impuesto!', 'lista_impuestos.php','','exito');

        } else {
            historia('Error al intentar registrar el nuevo impuesto '.$impuesto);
            mensajeicono('Hubo un error, favor de intentarlo de nuevo.', 'lista_impuestos.php','','error');

        }
        
    
}
mysqli_close($conexion);
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card-header bg-primary text-white">
                Registro de Impuestos
            </div>
            <div class="card">
                <form action="" autocomplete="off" method="post" class="card-body p-2">
                    <?php echo isset($alert) ? $alert : ''; ?>
                    <div class="form-group">
                        <label for="mmeida">Impuesto</label>
                        <input type="text" required  placeholder="Ingrese nombre del impuesto" name="impuesto" id="impuesto" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="nombrecorto">Porcentaje</label>
                        <input type="text" required placeholder="Ingrese el porcentaje que tendra el impuesto" name="taza" id="taza" class="form-control" onkeypress="mayus(this);">
                    </div>
                   
                    <input type="submit" value="Guardar Impuesto" class="btn btn-primary">
                    <a href="lista_impuestos.php" class="btn btn-danger">Regresar</a>
                </form>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->
<?php include_once "includes/footer.php"; ?>