<?php include_once "includes/header.php"; 



//GUARDAR ARCHIVOS
if(isset($_POST['montoinicial'])){
	$montoinicial = $_POST['montoinicial'];
	
	$sql = "INSERT INTO cortecaja(MontoInicial,FechaApertura,Estado) values ('$montoinicial', '$fecha', '0')";
	//echo $sql;	
	$query_insert = mysqli_query($conexion, $sql);
	if ($query_insert) {
		$alert = '<div class="alert alert-primary" role="alert">
					Corte de caja abierto
				</div>';
	} else {
		$alert = '<div class="alert alert-danger" role="alert">
					Error al crear el nuevo corte de caja
				</div>';
	}
	
	echo $alert;
}


?>
<script>
$('#abrircorte').on('show.bs.modal', function (event) {
	 var montoinicial = $('#montoinicial').val(); 
	 $.ajax({
		url: "lista_cortes.php",
		type: "post",
		data: {montoinicial: montoinicial},
		success: function(data){
			
		}
	});

})


</script>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#abrircorte">
  Abrir
</button>

<!-- Modal -->
<div class="modal fade" id="abrircorte" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style='color: #fff;' id="exampleModalLongTitle">Abrir corte de caja</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <div class="modal-body">
	 
		<label for="montoinicial" style="color: #fff;">Monto Inicial</label>
		<input type="text" placeholder="Ingrese el monto inicial" id="montoinicial" name="montoinicial" class="form-control">
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Cortes de Caja</h1>
		<a href="apertura_corte.php" class="btn btn-primary">Abrir</a>
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
									<td style='width:200px;'><?php echo $data['Id']; ?></td>
									<td style='width:150px;'><?php echo '$ '.$data['MontoInicial']; ?></td>
									<td><?php echo $data['MontoFinal']; ?></td>
                                    <td><?php echo $data['FechaApertura']; ?></td>
                                    <td><?php echo $data['FechaCierre']; ?></td>
                                    <td><?php echo $data['TotalVentas']; ?></td>
                                    <td><?php echo $data['MontoTotal']; ?></td>
                                    <td><?php if($data['Estado']==0){ echo 'Abierta'; } else {echo 'Cerrada'; } ?></td>
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