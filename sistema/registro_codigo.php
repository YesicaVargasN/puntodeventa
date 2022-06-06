<?php
include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['proveedor']) || empty($_POST['contacto']) || empty($_POST['telefono']) || empty($_POST['direccion'])) {
        $alert = '<div class="alert alert-danger" role="alert">
                        Todo los campos son obligatorios
                    </div>';
    } else {
        $proveedor = $_POST['proveedor'];
        $contacto = $_POST['contacto'];
        $telefono = $_POST['telefono'];
        $Direccion = $_POST['direccion'];
        $usuario_id = $_SESSION['idUser'];
        $query = mysqli_query($conexion, "SELECT * FROM proveedor where contacto = '$contacto'");
        $result = mysqli_fetch_array($query);

        if ($result > 0) {
            $alert = '<div class="alert alert-danger" role="alert">
                        El Ruc ya esta registrado
                    </div>';
        }else{
        

        $query_insert = mysqli_query($conexion, "INSERT INTO proveedor(proveedor,contacto,telefono,direccion,usuario_id) values ('$proveedor', '$contacto', '$telefono', '$Direccion','$usuario_id')");
        if ($query_insert) {
            $alert = '<div class="alert alert-primary" role="alert">
                        Proveedor Registrado
                    </div>';
        } else {
            $alert = '<div class="alert alert-danger" role="alert">
                       Error al registrar proveedor
                    </div>';
        }
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
                Registro de código de barras
            </div>

            <!--GENERAR CODIGO DE BARRAS-->
            <div class="card">
                <div id="respuesta"></div>
                <form action="" autocomplete="off" method="post" class="card-body p-2">
                <div class="form-group">
                    <label for="nombre">Nombre del producto</label>
                    <input type="text" placeholder="Ingrese nombre" id="nombre" name="nombre" class="form-control">
                </div>
                <div class="form-group">
                    <label for="nombre">Código del producto</label>
                    <input type="text" id="data" name="data" placeholder="Ingresa un valor" class="form-control"> 
                </div>
                
                <div id="imagen"></div>
                
                
                <button type="button" id="generar_barcode" onclick="generar();" class="btn btn-primary">Generar código de barras</button>
                
                <button type="button" id="imprimir" onclick="imprimir();"  class="btn btn-primary">Imprimir</button>

                
            </div>            
        </div>
    </div>


</div>
<!-- /.container-fluid -->
<?php include_once "includes/footer.php"; ?>