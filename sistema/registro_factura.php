<?php
include_once "includes/header.php";
include "../conexion.php";


?>
<script>

</script>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card-header bg-primary text-white">
                Registro de gastos
            </div>
            <div class="card">
                <form enctype="multipart/form-data" action="lista_factura.php" autocomplete="off" method="post" class="card-body p-2">
                    <?php echo isset($alert) ? $alert : ''; ?>
                    
                    <div class="form-group">
                        <label for="contacto">FECHA</label>
                        <input type="date"  name="fecha" id="fecha" class="form-control" value="<?php echo $fecha ?>" required>
                    </div>

                    <div class="form-group">
                    <label>PROVEEDOR</label>
                    <?php
                        $query_proveedor = mysqli_query($conexion, "SELECT codproveedor, proveedor FROM proveedor ORDER BY proveedor ASC");
                        $resultado_proveedor = mysqli_num_rows($query_proveedor);
                        
                    ?>

                    <select id="proveedor" name="proveedor" class="form-control">
                        <?php
                        if ($resultado_proveedor > 0) {
                            while ($proveedor = mysqli_fetch_array($query_proveedor)) {
                            // code...
                        ?>
                            <option value="<?php echo $proveedor['codproveedor']; ?>"><?php echo $proveedor['proveedor']; ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                    </div>
                    <div class="form-group">
                        <label for="contacto">SUBTOTAL</label>
                        <input type="text" placeholder="Ingrese el subtotal de la factura" name="subtotal" id="subtotal" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="contacto">IVA</label>
                        <input type="text" placeholder="Ingrese el impuesto iva de la factura" name="iva" id="iva" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="contacto">IEPS</label>
                        <input type="text" placeholder="Ingrese el impuesto ieps de la factura" name="ieps" id="ieps" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="contacto">TASA 0%</label>
                        <input type="text" placeholder="Ingrese el impuesto de tasa 0 de la factura" name="tasa" id="tasa" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="contacto">EXENTO</label>
                        <input type="text" placeholder="Ingrese el impresto exento de la factura" name="exento" id="exento" class="form-control" >
                    </div>
                    
                    <div class="form-group">
                        <label for="contacto">TOTAL</label>
                        <input type="text" placeholder="Ingrese el total de la factura" name="total" id="total" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="contacto">ARCHIVO</label>
                        <input type="file" placeholder="Suba el archivo de la factura" name="archivo" id="archivo" class="form-control" accept="application/pdf">
                    </div>
                   
                    <div class="form-group">
                        <label for="contacto">DESCRIPCIÓN</label>
                        <input type="text" placeholder="Ingrese una pequeña descripcion de la factura" name="descripcion" id="descripcion" class="form-control" required>
                    </div>

                    <input type="submit" value="Guardar Factura" class="btn btn-primary">
                    <a href="lista_factura.php" class="btn btn-danger">Regresar</a>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<?php include_once "includes/footer.php"; ?>