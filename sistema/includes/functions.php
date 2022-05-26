<?php
	date_default_timezone_set('America/Mexico');

	function fechaMexico(){
		$mes = array("","Enero",
					  "Febrero",
					  "Marzo",
					  "Abril",
					  "Mayo",
					  "Junio",
					  "Julio",
					  "Agosto",
					  "Septiembre",
					  "Octubre",
					  "Noviembre",
					  "Diciembre");
		return date('d')." de ". $mes[date('n')] . " de " . date('Y');
	}

	function narchivo($consulta){
		require("..\conexion.php");
		$sql = "SELECT * FROM contadores WHERE id='0'";					
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
		{
			if ($consulta==TRUE)
			{
				return $f['narchivo'];
			}
			else
			{ // sino es consulta entonces aumentarle y aumentar el contador de ceropapel
			// la diferencia entre ceropapel y este, es que cero papel se multiplica
			// por las copias que se entregan o con copia, para estadistica de cuanto se ha ahorrado
				$n2 = $f['narchivo'] + 1;
				$sql="UPDATE contadores SET narchivo='".$n2."' WHERE id='0'";
				$resultado = $conexion -> query($sql);
					if ($conexion->query($sql) == TRUE) 
					{
						return $f['narchivo'];
					}
					else {
						return  FALSE;}
					}
				}
				else
				{
						return FALSE;
				}
	}
	
	// funtion existenciaProducto($idproducto)
	// {
	// 	include "../conexion.php";
	// $query = mysqli_query($conexion, "SELECT existencia FROM producto where id=".$idproducto.";");
    // $result = mysqli_num_rows($query);
    // if ($result > 0) {
    //     while ($data = mysqli_fetch_assoc($query)) { 
    //         $existencia= $data['existencia'];
    //     }
    // }else{

    //     $existencia =0;
    // }
	// return $existencia;
	// }


 ?>
