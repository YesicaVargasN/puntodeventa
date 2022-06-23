<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Lista de creditos</h1>
	</div>

	<!-- Elementos para crear el reporte -->
	<form action="reporteCreditos.php" method="post">
	<div class="row">
	
		<div class="col-md-4">
			<label for="producto">Desde</label>
            <input type="date" name="desde" id="desde" class="form-control">
		</div>
		<div class="col-md-4">
			<label for="producto">Hasta</label>
            <input type="date" name="hasta" id="hasta" class="form-control">
		</div>
		<div class="col-md-4">
			<input type="submit" value="Generar Reporte" class="btn btn-primary">
		</div>
	
	</div>
	</form>	

	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="table">
					<thead class="thead-dark">
						<tr>
							<th>Id</th>
							<th>Fecha</th>
                            <th>Cliente</th>
							<th>Total</th>
                            <th>Adeudo</th>
                            <th>Fecha Vencimiento</th>
                            <th>Estatus</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<?php
						require "../conexion.php";

                        $sql="SELECT numcredito, creditos.fecha,totalventa as total,totalventa-(select SUM(totalfactura) from factura where numcredito=creditos.numcredito GROUP BY NUMCREDITO) AS  adeudo,fechavencimiento,estado,nombre 
                        FROM creditos inner join cliente on cliente.idcliente=creditos.idcliente" ;
						$query = mysqli_query($conexion,$sql);
						mysqli_close($conexion);
						$cli = mysqli_num_rows($query);

						if ($cli > 0) {
							while ($dato = mysqli_fetch_array($query)) {
						?>
								<tr>
									<td><?php echo $dato['numcredito']; ?></td>                                   
						            <td><?php echo  date_format( date_create($dato['fecha']), 'd/m/Y  H:i:s'); ?></td>
                                    <td><?php echo $dato['nombre']; ?></td>
									<td><?php echo $dato['total']; ?></td>
                                    <td><?php echo $dato['adeudo']; ?></td>
                                    <td><?php echo date_format( date_create($dato['fechavencimiento']), 'd/m/Y');?></td>
                                    <td>
                                        <?php if( $dato['estado'] =='1')
                                    {
                                    echo '<span class="badge bg-success" style="color:white;">Activo</span>';
                                    }else{
                                     echo '   <span class="badge bg-danger" style="color:white;">Liquidada</span>';
                                    }
                                    ?>
                                  </td>
									<td>
                                    <button id="abrirAbonos" name="abrirAbonos" type="button" id="abrir" class="btn btn-primary" data-toggle="modal" data-target="#mostrarCredito">
                                    Abrir
                                </button>
        
                                <!-- Modal -->
                                <div class="modal fade" id="mostrarCredito" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" style='color: #fff;' id="exampleModalLongTitle">Abonos </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">X</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    <div class="row">                                  
                                        <div class="col-lg-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered" id="table">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Fecha</th>
                                                            <th>Cliente</th>
                                                            <th>Total</th>
                                                            <th>Pago</th>
                                                            <th>Adeudo</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        require "../conexion.php";
                                                        $sql="SELECT *  FROM abonos where nofactura=".$dato['nofactura'];
                                                        $query1 = mysqli_query($conexion, $sql);
                                                        mysqli_close($conexion);
                                                        $cli1 = mysqli_num_rows($query1);

                                                        if ($cli1 > 0) {
                                                            while ($dato1 = mysqli_fetch_array($query1)) {
                                                        ?>
                                                                <tr>
                                                                    <td><?php echo $dato1['nofactura']; ?></td>
                                                                
                                                                    <td><?php echo  date_format( date_create($dato1['fecha']), 'd/m/Y  H:i:s'); ?></td>
                                                                    <td><?php echo $dato['nombre']; ?></td>
                                                                    <td><?php echo $dato1['total']; ?></td>
                                                                    <td><?php echo $dato1['pago']; ?></td>
                                                                    <td><?php echo $dato1['adeudo']; ?></td>
                                                                    <td></td>
                                                                </tr>
                                                        <?php }
                                                        } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                        
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        
                                    </div>
                                    </div>
                                </div>
                                </div>
                                    </td>
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