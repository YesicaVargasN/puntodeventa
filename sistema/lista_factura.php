<?php include_once "includes/header.php"; 



//GUARDAR ARCHIVOS
if(isset($_FILES['archivo']['name'])){
	$directorio = 'archivos/';
	
	$doc = $_FILES["archivo"]["name"];
    $tmp =$_FILES["archivo"]["tmp_name"];
	$numarchivo = narchivo(TRUE); 
	$nomarchivo = $numarchivo.'_'.$doc;
	$subir_archivo = $directorio.basename($nomarchivo);

	if (move_uploaded_file($tmp, $subir_archivo)) {
		//si se guarda en la carpeta hay que guardar en la bd
		$numarchivo = narchivo(FALSE); 
		$sql = "INSERT INTO archivos(archivo,fecha,activo,narchivo) values ('$doc', '$fecha', '1','$numarchivo')";
		//echo $sql;	
		$query_insert = mysqli_query($conexion, $sql);
        if ($query_insert) {
            $alert = '<div class="alert alert-primary" role="alert">
                       Factura Registrado
                    </div>';
        } else {
            $alert = '<div class="alert alert-danger" role="alert">
                       Error al registrar la factura
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
		<h1 class="h3 mb-0 text-gray-800">Facturas</h1>
		<a href="registro_factura.php" class="btn btn-primary">Nuevo</a>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="table">
					<thead class="thead-dark">
						<tr>
							<th>ID</th>
							<th>Factura (archivo)</th>
						</tr>
					</thead>
					<tbody>
						<?php
						include "../conexion.php";

						$query = mysqli_query($conexion, "SELECT * FROM archivos");
						$result = mysqli_num_rows($query);
						if ($result > 0) {
							while ($data = mysqli_fetch_assoc($query)) { ?>
								<tr>
									<td><?php echo $data['id']; ?></td>
									<td><a href='descargar.php?nombre=<?php echo $data['narchivo'].'_'.$data['archivo']; ?>' target='_self' title='Haga click aqui para descargar'><?php echo $data['archivo']; ?></a></td>
									
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