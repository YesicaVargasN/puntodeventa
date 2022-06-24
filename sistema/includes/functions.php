<?php
	date_default_timezone_set('America/Monterrey');

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

	function revisarCortesAbiertos(){
		require("..\conexion.php");
		$sql = "SELECT * FROM cortecaja WHERE Estado=0";	
		$r = $conexion -> query($sql);
		if ($r -> num_rows >0){
			return 1;
		}else{
			return 0;
		}			
					
	}


	function fechaCorte(){
		require("..\conexion.php");
		$sql = "SELECT FechaApertura FROM cortecaja WHERE Estado=0";	
		$r = $conexion -> query($sql);
		if ($r -> num_rows >0) {
			while($f = $r -> fetch_array())
			{
				return $f['FechaApertura'];
			}
		     
		}else{
			return 0;
		}
		    			
	}

	function montoInicial(){
		require("..\conexion.php");
		$sql = "SELECT MontoInicial FROM cortecaja WHERE Estado=0";	
		$r = $conexion -> query($sql);
		if ($r -> num_rows >0) {
			while($f = $r -> fetch_array())
			{
				return $f['MontoInicial'];
			}
		     
		}else{
			return 0;
		}
		    			
	}

	function idCorteAbierto(){
		require("..\conexion.php");
		$sql = "SELECT Id FROM cortecaja WHERE Estado=0";	
		$r = $conexion -> query($sql);
		if ($r -> num_rows >0) {
			while($f = $r -> fetch_array())
			{
				return $f['Id'];
			}
		     
		}else{
			return 0;
		}
		    			
	}

	function fechaCorteAperturaId($id){
		require("..\conexion.php");
		$sql = "SELECT FechaApertura FROM cortecaja WHERE id=".$id."";	
		$r = $conexion -> query($sql);
		if ($r -> num_rows >0) {
			while($f = $r -> fetch_array())
			{
				return $f['FechaApertura'];
			}
		     
		}else{
			return 0;
		}
		    			
	}

	function fechaCorteCierreId($id){
		require("..\conexion.php");
		$sql = "SELECT FechaCierre FROM cortecaja WHERE id=".$id."";	
		$r = $conexion -> query($sql);
		if ($r -> num_rows >0) {
			while($f = $r -> fetch_array())
			{
				return $f['FechaCierre'];
			}
		     
		}else{
			return 0;
		}
		    			
	}

	function existeEnAjusteelProducto($codproducto){
		require("..\conexion.php");
		$sql = "SELECT id FROM ajuste_inventario WHERE codproducto='".$codproducto."' and fecha  = CURRENT_DATE()";	
		echo $sql;
		$r = $conexion -> query($sql);
		if ($r -> num_rows >0) {
			while($f = $r -> fetch_array())
			{
				return $f['id'];
			}
		     
		}else{
			return 0;
		}
		    			
	}

	function entradasQueTenia($id){
		require("..\conexion.php");
		$sql = "SELECT entradas FROM ajuste_inventario WHERE id='".$id."' ";	
		$r = $conexion -> query($sql);
		if ($r -> num_rows >0) {
			while($f = $r -> fetch_array())
			{
				return $f['entradas'];
			}
		     
		}else{
			return 0;
		}
		    			
	}

	function salidasQueTenia($id){
		require("..\conexion.php");
		$sql = "SELECT salidas FROM ajuste_inventario WHERE id='".$id."' ";	
		$r = $conexion -> query($sql);
		if ($r -> num_rows >0) {
			while($f = $r -> fetch_array())
			{
				return $f['salidas'];
			}
		     
		}else{
			return 0;
		}
		    			
	}

	function actualizarExistenciasenProducto($id, $cantidadactual){
		require("..\conexion.php");
		$sql = "UPDATE producto SET existencia = ".$cantidadactual." WHERE codigo='".$id."' ";
		echo $sql;	
		$query = mysqli_query($conexion, $sql);
		if ($query) {
			return TRUE;
		}else {
			return FALSE;
		}
		    			
	}

	function nabonos($numcredito){
		include "../../conexion.php";
		$sql = "select count(*) as numabono from factura where numcredito=".$numcredito;					
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
		{
			// echo $sql;
			$rc= $conexion -> query($sql);
			if($f = $rc -> fetch_array())
				{		
							
					return $f['numabono'];
				}
			 else {return FALSE;}
		}
	}
 ?>
