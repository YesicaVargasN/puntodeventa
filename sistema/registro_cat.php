<?php
include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['nombre'])){
        $alert = '<div class="alert alert-danger" role="alert">
                        Los campos son obligatorios
                    </div>';
    } else {
        $nombre = $_POST['nombre'];
        

        $query_insert = mysqli_query($conexion, "INSERT INTO cat_departamento(iddepartamento,departamento) values ('', '$nombre')");
        if ($query_insert) {
            $alert = '<div class="alert alert-primary" role="alert">
                        Categoria Registrada
                    </div>';
        } else {
            $alert = '<div class="alert alert-danger" role="alert">
                       Error al registrar la categoria
                    </div>';
        }
        
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
                Registro de Categoria
            </div>
            <div class="card">
                <form action="" autocomplete="off" method="post" class="card-body p-2">
                    <?php echo isset($alert) ? $alert : ''; ?>
                    <div class="form-group">
                        <label for="nombre">NOMBRE CATEGORIA</label>
                        <input type="text" placeholder="Ingrese nombre" name="nombre" id="nombre" class="form-control">
                    </div>
                    
                    <input type="submit" value="Guardar Categoria" class="btn btn-primary">
                    <a href="lista_cat.php" class="btn btn-danger">Regresar</a>
                </form>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->
<?php include_once "includes/footer.php"; ?>