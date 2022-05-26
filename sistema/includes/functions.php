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
