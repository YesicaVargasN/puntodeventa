<?php include_once "includes/header.php"; 



//GUARDAR ARCHIVOS
if(isset($_FILES['archivo']['name'])){
	$directorio = 'archivos/';
	
	$doc = $_FILES["archivo"]["name"];
    $tmp =$_FILES["archivo"]["tmp_name"];
	$numarchivo = narchivo(TRUE); 
	$nomarchivo = $numarchivo.'_'.$doc;
	$subir_archivo = $directorio.basename($nomarchivo);
	$proveedor = $_POST['proveedor'];
	$subtotal = $_POST['subtotal'];
	$iva = $_POST['iva'];
	$total = $_POST['total'];
	$fecha = $_POST['fecha'];
	$descripcion = $_POST['descripcion'];

	if (move_uploaded_file($tmp, $subir_archivo)) {
		//si se guarda en la carpeta hay que guardar en la bd
		$numarchivo = narchivo(FALSE); 
		$sql = "INSERT INTO gastos(archivo,fecha,activo,narchivo, proveedor, subtotal, iva, total, descripcion) values ('$doc', '$fecha', '1','$numarchivo', '$proveedor','$subtotal', '$iva', '$total', '".$descripcion."')";
		//echo $sql;	
		$query_insert = mysqli_query($conexion, $sql);
        if ($query_insert) {
            $alert = '<div class="alert alert-primary" role="alert">
                       Gasto Registrado
                    </div>';
        } else {
            $alert = '<div class="alert alert-danger" role="alert">
                       Error al registrar los gastos
                    </div>';
        }
    }
		//echo "El archivo es válido y se cargó correctamente.<br><br>";
		//echo"<a href='".$subir_archivo."' target='_blank'><img src='".$subir_archivo."' width='150'></a>";
	 else {
		$alert = '<div class="alert alert-danger" role="alert">
		La subida ha fallado
	 </div>';
		
	}
		
	echo $alert;
}


?>




<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Cortes de Caja</h1>
		<a href="registro_factura.php" class="btn btn-primary">Nuevo</a>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="table">
					<thead class="thead-dark">
						<tr>
							<th>ID</th>
							<th>MONTO INICIAL</th>
							<th>MONTO FINAL</th>
							<th>FECHA APERTURA</th>
							<th>FECHA CIERRE</th>
                            <th>TOTAL VENTAS</th>
							<th>MONTO TOTAL</th>
                            <th>ESTADO</th>
							<?php if ($_SESSION['rol'] == 1) { ?>
							<th>ACCIONES</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php
						include "../conexion.php";

						$query = mysqli_query($conexion, "SELECT * FROM cortecaja");
						$result = mysqli_num_rows($query);
						if ($result > 0) {
							while ($data = mysqli_fetch_assoc($query)) { ?>
								<tr>
									<td><?php echo $data['id']; ?></td>
									<td style='width:200px;'><?php echo $data['Id']; ?></td>
									<td style='width:150px;'><?php echo '$ '.$data['MontoInicial']; ?></td>
									<td><?php echo $data['MontoFinal']; ?></td>
                                    <td><?php echo $data['FechaApertura']; ?></td>
                                    <td><?php echo $data['FechaCierre']; ?></td>
                                    <td><?php echo $data['TotalVentas']; ?></td>
                                    <td><?php echo $data['MontoTotal']; ?></td>
                                    <td><?php echo $data['Estado']; ?></td>
									<?php if ($_SESSION['rol'] == 1) { ?>
									<td>
										<form action="eliminar_gastos.php?id=<?php echo $data['id']; ?>" method="post" class="confirmar d-inline">
											<button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
										</form>
									</td>
										<?php } ?>
								</tr>
						<?php }
						} ?>
					</tbody>

				</table>
			</div>

		</div>
	</div>


</div>
<!-- /.container-fluid -->


<?php include_once "includes/footer.php"; ?>