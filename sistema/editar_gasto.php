<?php
include "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";


    $id = $_GET['id'];
    $proveedor = $_POST['proveedor'];
    $subtotal = $_POST['subtotal'];
    $iva = $_POST['iva'];
    $ieps = $_POST['ieps'];
    $tasa = $_POST['tasa'];
    $exento = $_POST['exento'];
    $total = $_POST['total'];
    $fecha = $_POST['fecha'];
    $descripcion = $_POST['descripcion'];
    $usuario_id = $_SESSION['idUser'];
    $total = 0 - $total ;
		

    $sql =  "UPDATE gastos SET  proveedor = '$proveedor', subtotal = '$subtotal' , iva = $iva, ieps = '$ieps', tasa = '$tasa', exento = '$exento', total = '$total', fecha = '$fecha', descripcion = '$descripcion' WHERE id = $id";
    //echo $sql;
    $sql_update = mysqli_query($conexion,$sql);

    if ($sql_update) {
      historia('Se actualizo el gasto '.$id);
      mensajeicono('Se ha actualizado con éxito el gasto!', 'lista_factura.php','','exito');

    } else {
      historia('Error al actualizar el gasto '.$id);
      mensajeicono('Hubo un error, favor de intentarlo de nuevo.', 'lista_factura.php','','error');
  }
}
// Mostrar Datos


$id = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM gastos WHERE id = $id");
//mysqli_close($conexion);
$result_sql = mysqli_num_rows($sql);

  while ($data = mysqli_fetch_array($sql)) {
 
    $pro = $data['proveedor'];
    $subtotal = $data['subtotal'];
    $iva = $data['iva'];
    $ieps = $data['ieps'];
    $tasa = $data['tasa'];
    $exento = $data['exento'];
    $total = $data['total'];
    $fecha = $data['fecha'];
    $descripcion = $data['descripcion'];
  }

?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <div class="row">
    <div class="col-lg-6 m-auto">

      <div class="card">
        <div class="card-header bg-primary">
          Modificar Gasto
        </div>
        <div class="card-body">
          <?php echo isset($alert) ? $alert : ''; ?>
          <form class="" action="" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            
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
                              if($pro == $proveedor['codproveedor'] ){
                        ?>

                                <option value="<?php echo $proveedor['codproveedor']; ?>" selected><?php echo $proveedor['proveedor']; ?></option>
                        <?php
                              }else{
                        ?>
                                <option value="<?php echo $proveedor['codproveedor']; ?>"><?php echo $proveedor['proveedor']; ?></option>
                        <?php
                              }
                          }
                        }
                        ?>
                    </select>
                    </div>
                    <div class="form-group">
                        <label for="contacto">SUBTOTAL</label>
                        <input type="text" placeholder="Ingrese el subtotal de la factura" name="subtotal" id="subtotal" value="<?php echo $subtotal ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="contacto">IVA</label>
                        <input type="text" placeholder="Ingrese el impuesto iva de la factura" name="iva" id="iva" value="<?php echo $iva ?>" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="contacto">IEPS</label>
                        <input type="text" placeholder="Ingrese el impuesto ieps de la factura" name="ieps" id="ieps" value="<?php echo $ieps ?>" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="contacto">TASA 0%</label>
                        <input type="text" placeholder="Ingrese el impuesto de tasa 0 de la factura" name="tasa" id="tasa" value="<?php echo $tasa ?>" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="contacto">EXENTO</label>
                        <input type="text" placeholder="Ingrese el impresto exento de la factura" name="exento" id="exento" value="<?php echo $exento ?>" class="form-control" >
                    </div>
                    
                    <div class="form-group">
                        <label for="contacto">TOTAL</label>
                        <input type="text" placeholder="Ingrese el total de la factura" name="total" id="total" value="<?php echo $total ?>" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="contacto">DESCRIPCIÓN</label>
                        <input type="text" placeholder="Ingrese una pequeña descripcion de la factura" name="descripcion" id="descripcion" value="<?php echo $descripcion ?>" class="form-control" required>
                    </div>

                    <input type="submit" value="Editar Gasto" class="btn btn-primary">
          </form>
        </div>
      </div>
    </div>
  </div>


</div>
<!-- /.container-fluid -->
<?php include_once "includes/footer.php"; ?>