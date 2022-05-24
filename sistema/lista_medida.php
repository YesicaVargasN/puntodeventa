<?php include_once "includes/header.php"; ?>




<?php

$alert = '<div class="alert alert-primary" role="alert">
            Categoría eliminada con éxito
        </div>';

    if(isset($_GET['ideliminar'])){
        require("../conexion.php");
        $id = $_GET['ideliminar'];
        $query_delete = mysqli_query($conexion, "DELETE FROM cat_departamento WHERE iddepartamento = $id");
        mysqli_close($conexion);
        echo $alert;
    }



?>

<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Unidades de medida</h1>
		<a href="registro_medida.php" class="btn btn-primary">Nuevo</a>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="table">
					<thead class="thead-dark">
						<tr>
							<th>ID</th>
							<th>UNIDAD DE MEDIDA</th>
                            <th>NOMBRE CORTO</th>
							<?php if ($_SESSION['rol'] == 1) { ?>
							<th>ACCIONES</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php
						include "../conexion.php";

						$query = mysqli_query($conexion, "SELECT * FROM cat_unidadmedida");
						$result = mysqli_num_rows($query);
						if ($result > 0) {
							while ($data = mysqli_fetch_assoc($query)) { ?>
								<tr>
									<td><?php echo $data['idunidadmedida']; ?></td>
									<td><?php echo $data['unidadmedida']; ?></td>
                                    <td><?php echo $data['nombrecorto']; ?></td>
									<?php if ($_SESSION['rol'] == 1) { ?>
									<td>
										<form action="lista_cat.php?ideliminar=<?php echo $data['idunidadmedida']; ?>" method="post" class="confirmar d-inline">
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