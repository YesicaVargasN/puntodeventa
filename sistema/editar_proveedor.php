<?php
include "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['proveedor']) || empty($_POST['contacto']) || empty($_POST['telefono']) || empty($_POST['direccion'])) {
    mensajeicono('Todos los campos son obligatorios.', 'editar_proveedor.php','','info');

  } else {
    $idproveedor = $_GET['id'];
    $proveedor = $_POST['proveedor'];
    $contacto = $_POST['contacto'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $rfc = $_POST['rfc'];

    $sql_update = mysqli_query($conexion, "UPDATE proveedor SET proveedor = '$proveedor', contacto = '$contacto' , telefono = $telefono, direccion = '$direccion', rfc = '$rfc' WHERE codproveedor = $idproveedor");

    if ($sql_update) {
      historia('Se actualizo el proveedor '.$idproveedor);
      mensajeicono('Se ha actualizado con éxito el proveedor!', 'lista_proveedor.php','','exito');

    } else {
      historia('Error al actualizar el proveedor '.$idproveedor);
      mensajeicono('Hubo un error, favor de intentarlo de nuevo.', 'lista_proveedor.php','','error');

    }
  }
}
// Mostrar Datos

if (empty($_REQUEST['id'])) {
  header("Location: lista_proveedor.php");
  mysqli_close($conexion);
}
$idproveedor = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM proveedor WHERE codproveedor = $idproveedor");
mysqli_close($conexion);
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
  header("Location: lista_proveedor.php");
} else {
  while ($data = mysqli_fetch_array($sql)) {
    $idproveedor = $data['codproveedor'];
    $proveedor = $data['proveedor'];
    $contacto = $data['contacto'];
    $telefono = $data['telefono'];
    $direccion = $data['direccion'];
    $rfc = $data['rfc'];
  }
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <div class="row">
    <div class="col-lg-6 m-auto">

      <div class="card">
        <div class="card-header bg-primary">
          Modificar Proveedor
        </div>
        <div class="card-body">
          <?php echo isset($alert) ? $alert : ''; ?>
          <form class="" action="" method="post">
            <input type="hidden" name="id" value="<?php echo $idproveedor; ?>">
            <div class="form-group">
              <label for="proveedor">RFC</label>
              <input type="text" placeholder="Ingrese RFC" name="rfc" class="form-control" id="rfc" value="<?php echo $rfc; ?>">
            </div>
            <div class="form-group">
              <label for="proveedor">Proveedor</label>
              <input type="text" placeholder="Ingrese proveedor" name="proveedor" class="form-control" id="proveedor" value="<?php echo $proveedor; ?>">
            </div>
            <div class="form-group">
              <label for="nombre">Contacto</label>
              <input type="text" placeholder="Ingrese contacto" name="contacto" class="form-control" id="contacto" value="<?php echo $contacto; ?>">
            </div>
            <div class="form-group">
              <label for="telefono">Teléfono</label>
              <input type="number" placeholder="Ingrese Teléfono" name="telefono" class="form-control" id="telefono" value="<?php echo $telefono; ?>">
            </div>
            <div class="form-group">
              <label for="direccion">Dirección</label>
              <input type="text" placeholder="Ingrese Direccion" name="direccion" class="form-control" id="direccion" value="<?php echo $direccion; ?>">
            </div>

            <input type="submit" value="Editar Proveedor" class="btn btn-primary">
          </form>
        </div>
      </div>
    </div>
  </div>


</div>
<!-- /.container-fluid -->
<?php include_once "includes/footer.php"; ?>