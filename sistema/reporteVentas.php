<?php
ob_start();

include "../conexion.php";
require_once('pdf/tcpdf.php');

if(isset($_POST['desde'])){
    $desde = $_POST['desde'];
}else{
    $desde = "";
}

if(isset($_POST['hasta'])){
    $hasta = $_POST['hasta'];
}else{
    $hasta = "";
}
if(isset($_POST['tipoventa'])){
    $tipoventa = $_POST['tipoventa'];
}else{
    $tipoventa = "";
}
if(isset($_POST['tipopago'])){
    $tipopago = $_POST['tipopago'];
}else{
    $tipopago = "";
}

$desde = date("Y-m-d",strtotime($desde."- 1 day"));

$hasta =  date("Y-m-d",strtotime($hasta."+ 1 day"));


//echo 'tipopago '.$tipopago.' tipodeventa '.$tipoventa;
if($tipopago == 0 and $tipoventa == 0 and $desde <> '' and $hasta <> ''){

    $sql = 'SELECT f.fecha, df.nofactura, df.cantidad, p.codproducto, sum(p.valor_impuesto) AS impuestos, f.subtotal, f.totalfactura,  u.usuario as nomusuario, if(idtipoventa = 1, "CONTADO",if(idtipoventa = 2, "CREDITO", if(idtipoventa = 3, "DEVOLUCION", "GASTO"))) as tipoventa, if(idtipopago = 1, "EFECTIVO", if(idtipopago=2, "TARJETA",if(idtipopago=3, "TRANSFERENCIA","DEPOSITO"))) as tipopago
    ,(select 
		ROUND((ROUND(dt.precio_siniva,2) *dt.cantidad)*(im.taza/100),2) as valorimpuesto	
		from detallefactura as dt inner join producto as p on p.codproducto=dt.codproducto
		left join impuesto as im on im.idimpuesto=p.idimpuesto
		where nofactura=df.nofactura and p.idimpuesto=1 GROUP BY  im.idimpuesto) as iva,
		(select 
		ROUND((ROUND(dt.precio_siniva,2) *dt.cantidad)*(im.taza/100),2) as valorimpuesto	
		from detallefactura as dt inner join producto as p on p.codproducto=dt.codproducto
		left join impuesto as im on im.idimpuesto=p.idimpuesto
		where nofactura=df.nofactura and p.idimpuesto=2 GROUP BY  im.idimpuesto) as ieps,
		(select 
		ROUND((ROUND(dt.precio_siniva,2) *dt.cantidad)*(im.taza/100),2) as valorimpuesto	
		from detallefactura as dt inner join producto as p on p.codproducto=dt.codproducto
		left join impuesto as im on im.idimpuesto=p.idimpuesto
		where nofactura=df.nofactura and p.idimpuesto=5 GROUP BY  im.idimpuesto) as tasa0,
		(select 
		ROUND((ROUND(dt.precio_siniva,2) *dt.cantidad)*(im.taza/100),2) as valorimpuesto	
		from detallefactura as dt inner join producto as p on p.codproducto=dt.codproducto
		left join impuesto as im on im.idimpuesto=p.idimpuesto
		where nofactura=df.nofactura and p.idimpuesto=6 GROUP BY  im.idimpuesto) as exento
    FROM detallefactura df
    LEFT JOIN factura f on f.nofactura = df.nofactura 
    LEFT JOIN producto p on p.codproducto = df.codproducto
    LEFT JOIN usuario u on f.usuario = u.idusuario
    WHERE f.fecha BETWEEN "'.$desde.'" and "'.$hasta.'"
    GROUP BY df.nofactura
    ';
   /* $sql = 'select *, f.subtotal, u.usuario as nomusuario,	if(idtipoventa = 1, "CONTADO",if(idtipoventa = 2, "CREDITO", if(idtipoventa = 3, "DEVOLUCION", "GASTO"))) as tipoventa,
    if(idtipopago = 1, "EFECTIVO", if(idtipopago=2, "TARJETA",if(idtipopago=3, "TRANSFERENCIA","DEPOSITO"))) as tipopago
    from factura f
    inner join usuario u on f.usuario = u.idusuario
    WHERE f.fecha BETWEEN "'.$desde.'" and "'.$hasta.'"';*/
}else if($tipopago <> 0 and $tipoventa == 0 and $desde <> '' and $hasta <> ''){

    $sql = 'SELECT f.fecha, df.nofactura, df.cantidad, p.codproducto, sum(p.valor_impuesto) AS impuestos, f.subtotal, f.totalfactura,  u.usuario as nomusuario, if(idtipoventa = 1, "CONTADO",if(idtipoventa = 2, "CREDITO", if(idtipoventa = 3, "DEVOLUCION", "GASTO"))) as tipoventa, if(idtipopago = 1, "EFECTIVO", if(idtipopago=2, "TARJETA",if(idtipopago=3, "TRANSFERENCIA","DEPOSITO"))) as tipopago
    ,(select 
		ROUND((ROUND(dt.precio_siniva,2) *dt.cantidad)*(im.taza/100),2) as valorimpuesto	
		from detallefactura as dt inner join producto as p on p.codproducto=dt.codproducto
		left join impuesto as im on im.idimpuesto=p.idimpuesto
		where nofactura=df.nofactura and p.idimpuesto=1 GROUP BY  im.idimpuesto) as iva,
		(select 
		ROUND((ROUND(dt.precio_siniva,2) *dt.cantidad)*(im.taza/100),2) as valorimpuesto	
		from detallefactura as dt inner join producto as p on p.codproducto=dt.codproducto
		left join impuesto as im on im.idimpuesto=p.idimpuesto
		where nofactura=df.nofactura and p.idimpuesto=2 GROUP BY  im.idimpuesto) as ieps,
		(select 
		ROUND((ROUND(dt.precio_siniva,2) *dt.cantidad)*(im.taza/100),2) as valorimpuesto	
		from detallefactura as dt inner join producto as p on p.codproducto=dt.codproducto
		left join impuesto as im on im.idimpuesto=p.idimpuesto
		where nofactura=df.nofactura and p.idimpuesto=5 GROUP BY  im.idimpuesto) as tasa0,
		(select 
		ROUND((ROUND(dt.precio_siniva,2) *dt.cantidad)*(im.taza/100),2) as valorimpuesto	
		from detallefactura as dt inner join producto as p on p.codproducto=dt.codproducto
		left join impuesto as im on im.idimpuesto=p.idimpuesto
		where nofactura=df.nofactura and p.idimpuesto=6 GROUP BY  im.idimpuesto) as exento
        FROM detallefactura df
    LEFT JOIN factura f on f.nofactura = df.nofactura 
    LEFT JOIN producto p on p.codproducto = df.codproducto
    LEFT JOIN usuario u on f.usuario = u.idusuario
    WHERE f.fecha BETWEEN "'.$desde.'" and "'.$hasta.'" and idtipopago = "'.$tipopago.'"
    GROUP BY df.nofactura
    ';
   /* $sql = 'select *, f.subtotal, u.usuario as nomusuario,	if(idtipoventa = 1, "CONTADO",if(idtipoventa = 2, "CREDITO", if(idtipoventa = 3, "DEVOLUCION", "GASTO"))) as tipoventa,
    if(idtipopago = 1, "EFECTIVO", if(idtipopago=2, "TARJETA",if(idtipopago=3, "TRANSFERENCIA","DEPOSITO"))) as tipopago
    from factura f
    inner join usuario u on f.usuario = u.idusuario
    WHERE f.fecha BETWEEN "'.$desde.'" and "'.$hasta.'" and idtipopago = "'.$tipopago.'"';*/
}else if($tipopago == 0 and $tipoventa <> 0 and $desde <> '' and $hasta <> ''){

    $sql = 'SELECT f.fecha, df.nofactura, df.cantidad, p.codproducto, sum(p.valor_impuesto) AS impuestos, f.subtotal, f.totalfactura,  u.usuario as nomusuario, if(idtipoventa = 1, "CONTADO",if(idtipoventa = 2, "CREDITO", if(idtipoventa = 3, "DEVOLUCION", "GASTO"))) as tipoventa, if(idtipopago = 1, "EFECTIVO", if(idtipopago=2, "TARJETA",if(idtipopago=3, "TRANSFERENCIA","DEPOSITO"))) as tipopago
    ,(select 
		ROUND((ROUND(dt.precio_siniva,2) *dt.cantidad)*(im.taza/100),2) as valorimpuesto	
		from detallefactura as dt inner join producto as p on p.codproducto=dt.codproducto
		left join impuesto as im on im.idimpuesto=p.idimpuesto
		where nofactura=df.nofactura and p.idimpuesto=1 GROUP BY  im.idimpuesto) as iva,
		(select 
		ROUND((ROUND(dt.precio_siniva,2) *dt.cantidad)*(im.taza/100),2) as valorimpuesto	
		from detallefactura as dt inner join producto as p on p.codproducto=dt.codproducto
		left join impuesto as im on im.idimpuesto=p.idimpuesto
		where nofactura=df.nofactura and p.idimpuesto=2 GROUP BY  im.idimpuesto) as ieps,
		(select 
		ROUND((ROUND(dt.precio_siniva,2) *dt.cantidad)*(im.taza/100),2) as valorimpuesto	
		from detallefactura as dt inner join producto as p on p.codproducto=dt.codproducto
		left join impuesto as im on im.idimpuesto=p.idimpuesto
		where nofactura=df.nofactura and p.idimpuesto=5 GROUP BY  im.idimpuesto) as tasa0,
		(select 
		ROUND((ROUND(dt.precio_siniva,2) *dt.cantidad)*(im.taza/100),2) as valorimpuesto	
		from detallefactura as dt inner join producto as p on p.codproducto=dt.codproducto
		left join impuesto as im on im.idimpuesto=p.idimpuesto
		where nofactura=df.nofactura and p.idimpuesto=6 GROUP BY  im.idimpuesto) as exento
    FROM detallefactura df
    LEFT JOIN factura f on f.nofactura = df.nofactura 
    LEFT JOIN producto p on p.codproducto = df.codproducto
    LEFT JOIN usuario u on f.usuario = u.idusuario
    WHERE f.fecha BETWEEN "'.$desde.'" and "'.$hasta.'" and idtipoventa = "'.$tipoventa.'"
    GROUP BY df.nofactura
    ';

   /* $sql = 'select *, f.subtotal, u.usuario as nomusuario,	if(idtipoventa = 1, "CONTADO",if(idtipoventa = 2, "CREDITO", if(idtipoventa = 3, "DEVOLUCION", "GASTO"))) as tipoventa,
    if(idtipopago = 1, "EFECTIVO", if(idtipopago=2, "TARJETA",if(idtipopago=3, "TRANSFERENCIA","DEPOSITO"))) as tipopago
    from factura f
    inner join usuario u on f.usuario = u.idusuario
    WHERE f.fecha BETWEEN "'.$desde.'" and "'.$hasta.'" and idtipoventa = "'.$tipoventa.'"';*/
}else if($tipopago <> 0 and $tipoventa <> 0 and $desde <> '' and $hasta <> ''){
    
    $sql = 'SELECT f.fecha, df.nofactura, df.cantidad, p.codproducto, sum(p.valor_impuesto) AS impuestos, f.subtotal, f.totalfactura,  u.usuario as nomusuario, if(idtipoventa = 1, "CONTADO",if(idtipoventa = 2, "CREDITO", if(idtipoventa = 3, "DEVOLUCION", "GASTO"))) as tipoventa, if(idtipopago = 1, "EFECTIVO", if(idtipopago=2, "TARJETA",if(idtipopago=3, "TRANSFERENCIA","DEPOSITO"))) as tipopago
    ,(select 
		ROUND((ROUND(dt.precio_siniva,2) *dt.cantidad)*(im.taza/100),2) as valorimpuesto	
		from detallefactura as dt inner join producto as p on p.codproducto=dt.codproducto
		left join impuesto as im on im.idimpuesto=p.idimpuesto
		where nofactura=df.nofactura and p.idimpuesto=1 GROUP BY  im.idimpuesto) as iva,
		(select 
		ROUND((ROUND(dt.precio_siniva,2) *dt.cantidad)*(im.taza/100),2) as valorimpuesto	
		from detallefactura as dt inner join producto as p on p.codproducto=dt.codproducto
		left join impuesto as im on im.idimpuesto=p.idimpuesto
		where nofactura=df.nofactura and p.idimpuesto=2 GROUP BY  im.idimpuesto) as ieps,
		(select 
		ROUND((ROUND(dt.precio_siniva,2) *dt.cantidad)*(im.taza/100),2) as valorimpuesto	
		from detallefactura as dt inner join producto as p on p.codproducto=dt.codproducto
		left join impuesto as im on im.idimpuesto=p.idimpuesto
		where nofactura=df.nofactura and p.idimpuesto=5 GROUP BY  im.idimpuesto) as tasa0,
		(select 
		ROUND((ROUND(dt.precio_siniva,2) *dt.cantidad)*(im.taza/100),2) as valorimpuesto	
		from detallefactura as dt inner join producto as p on p.codproducto=dt.codproducto
		left join impuesto as im on im.idimpuesto=p.idimpuesto
		where nofactura=df.nofactura and p.idimpuesto=6 GROUP BY  im.idimpuesto) as exento
    FROM detallefactura df
    LEFT JOIN factura f on f.nofactura = df.nofactura 
    LEFT JOIN producto p on p.codproducto = df.codproducto
    LEFT JOIN usuario u on f.usuario = u.idusuario
    WHERE f.fecha BETWEEN "'.$desde.'" and "'.$hasta.'" and idtipopago = "'.$tipopago.'" and idtipoventa = "'.$tipoventa.'"
    GROUP BY df.nofactura
    ';
    
    
    /*$sql = 'select *, f.subtotal, u.usuario as nomusuario,	if(idtipoventa = 1, "CONTADO",if(idtipoventa = 2, "CREDITO", if(idtipoventa = 3, "DEVOLUCION", "GASTO"))) as tipoventa,
    if(idtipopago = 1, "EFECTIVO", if(idtipopago=2, "TARJETA",if(idtipopago=3, "TRANSFERENCIA","DEPOSITO"))) as tipopago
    from factura f
    inner join usuario u on f.usuario = u.idusuario
    WHERE f.fecha BETWEEN "'.$desde.'" and "'.$hasta.'" and idtipopago = "'.$tipopago.'" and idtipoventa = "'.$tipoventa.'"';*/
}else if($tipopago <> 0 and $tipoventa <> 0 and $desde == '' and $hasta == ''){

    $sql = 'SELECT f.fecha, df.nofactura, df.cantidad, p.codproducto, sum(p.valor_impuesto) AS impuestos, f.subtotal, f.totalfactura,  u.usuario as nomusuario, if(idtipoventa = 1, "CONTADO",if(idtipoventa = 2, "CREDITO", if(idtipoventa = 3, "DEVOLUCION", "GASTO"))) as tipoventa, if(idtipopago = 1, "EFECTIVO", if(idtipopago=2, "TARJETA",if(idtipopago=3, "TRANSFERENCIA","DEPOSITO"))) as tipopago
    ,(select 
		ROUND((ROUND(dt.precio_siniva,2) *dt.cantidad)*(im.taza/100),2) as valorimpuesto	
		from detallefactura as dt inner join producto as p on p.codproducto=dt.codproducto
		left join impuesto as im on im.idimpuesto=p.idimpuesto
		where nofactura=df.nofactura and p.idimpuesto=1 GROUP BY  im.idimpuesto) as iva,
		(select 
		ROUND((ROUND(dt.precio_siniva,2) *dt.cantidad)*(im.taza/100),2) as valorimpuesto	
		from detallefactura as dt inner join producto as p on p.codproducto=dt.codproducto
		left join impuesto as im on im.idimpuesto=p.idimpuesto
		where nofactura=df.nofactura and p.idimpuesto=2 GROUP BY  im.idimpuesto) as ieps,
		(select 
		ROUND((ROUND(dt.precio_siniva,2) *dt.cantidad)*(im.taza/100),2) as valorimpuesto	
		from detallefactura as dt inner join producto as p on p.codproducto=dt.codproducto
		left join impuesto as im on im.idimpuesto=p.idimpuesto
		where nofactura=df.nofactura and p.idimpuesto=5 GROUP BY  im.idimpuesto) as tasa0,
		(select 
		ROUND((ROUND(dt.precio_siniva,2) *dt.cantidad)*(im.taza/100),2) as valorimpuesto	
		from detallefactura as dt inner join producto as p on p.codproducto=dt.codproducto
		left join impuesto as im on im.idimpuesto=p.idimpuesto
		where nofactura=df.nofactura and p.idimpuesto=6 GROUP BY  im.idimpuesto) as exento
    FROM detallefactura df
    LEFT JOIN factura f on f.nofactura = df.nofactura 
    LEFT JOIN producto p on p.codproducto = df.codproducto
    LEFT JOIN usuario u on f.usuario = u.idusuario
    WHERE idtipopago = "'.$tipopago.'" and idtipoventa = "'.$tipoventa.'"
    GROUP BY df.nofactura
    ';

  /*  $sql = 'select *, f.subtotal, u.usuario as nomusuario,	if(idtipoventa = 1, "CONTADO",if(idtipoventa = 2, "CREDITO", if(idtipoventa = 3, "DEVOLUCION", "GASTO"))) as tipoventa,
    if(idtipopago = 1, "EFECTIVO", if(idtipopago=2, "TARJETA",if(idtipopago=3, "TRANSFERENCIA","DEPOSITO"))) as tipopago
    from factura f
    inner join usuario u on f.usuario = u.idusuario
    WHERE idtipopago = "'.$tipopago.'" and idtipoventa = "'.$tipoventa.'"';*/
}else if($desde == '' and $hasta == '' and $tipoventa <> 0 and $tipopago == 0){
    
    $sql = 'SELECT f.fecha, df.nofactura, df.cantidad, p.codproducto, sum(p.valor_impuesto) AS impuestos, f.subtotal, f.totalfactura,  u.usuario as nomusuario, if(idtipoventa = 1, "CONTADO",if(idtipoventa = 2, "CREDITO", if(idtipoventa = 3, "DEVOLUCION", "GASTO"))) as tipoventa, if(idtipopago = 1, "EFECTIVO", if(idtipopago=2, "TARJETA",if(idtipopago=3, "TRANSFERENCIA","DEPOSITO"))) as tipopago
    ,(select 
		ROUND((ROUND(dt.precio_siniva,2) *dt.cantidad)*(im.taza/100),2) as valorimpuesto	
		from detallefactura as dt inner join producto as p on p.codproducto=dt.codproducto
		left join impuesto as im on im.idimpuesto=p.idimpuesto
		where nofactura=df.nofactura and p.idimpuesto=1 GROUP BY  im.idimpuesto) as iva,
		(select 
		ROUND((ROUND(dt.precio_siniva,2) *dt.cantidad)*(im.taza/100),2) as valorimpuesto	
		from detallefactura as dt inner join producto as p on p.codproducto=dt.codproducto
		left join impuesto as im on im.idimpuesto=p.idimpuesto
		where nofactura=df.nofactura and p.idimpuesto=2 GROUP BY  im.idimpuesto) as ieps,
		(select 
		ROUND((ROUND(dt.precio_siniva,2) *dt.cantidad)*(im.taza/100),2) as valorimpuesto	
		from detallefactura as dt inner join producto as p on p.codproducto=dt.codproducto
		left join impuesto as im on im.idimpuesto=p.idimpuesto
		where nofactura=df.nofactura and p.idimpuesto=5 GROUP BY  im.idimpuesto) as tasa0,
		(select 
		ROUND((ROUND(dt.precio_siniva,2) *dt.cantidad)*(im.taza/100),2) as valorimpuesto	
		from detallefactura as dt inner join producto as p on p.codproducto=dt.codproducto
		left join impuesto as im on im.idimpuesto=p.idimpuesto
		where nofactura=df.nofactura and p.idimpuesto=6 GROUP BY  im.idimpuesto) as exento
    FROM detallefactura df
    LEFT JOIN factura f on f.nofactura = df.nofactura 
    LEFT JOIN producto p on p.codproducto = df.codproducto
    LEFT JOIN usuario u on f.usuario = u.idusuario
    WHERE idtipoventa = "'.$tipoventa.'"
    GROUP BY df.nofactura
    ';
    
    
    /*$sql = 'select *, f.subtotal, u.usuario as nomusuario,	if(idtipoventa = 1, "CONTADO",if(idtipoventa = 2, "CREDITO", if(idtipoventa = 3, "DEVOLUCION", "GASTO"))) as tipoventa,
    if(idtipopago = 1, "EFECTIVO", if(idtipopago=2, "TARJETA",if(idtipopago=3, "TRANSFERENCIA","DEPOSITO"))) as tipopago
    from factura f
    inner join usuario u on f.usuario = u.idusuario
    WHERE idtipoventa = "'.$tipoventa.'"';*/

}else if($desde == '' and $hasta == '' and $tipoventa == 0 and $tipopago <> 0){
   
    $sql = 'SELECT f.fecha, df.nofactura, df.cantidad, p.codproducto, sum(p.valor_impuesto) AS impuestos, f.subtotal, f.totalfactura,  u.usuario as nomusuario, if(idtipoventa = 1, "CONTADO",if(idtipoventa = 2, "CREDITO", if(idtipoventa = 3, "DEVOLUCION", "GASTO"))) as tipoventa, if(idtipopago = 1, "EFECTIVO", if(idtipopago=2, "TARJETA",if(idtipopago=3, "TRANSFERENCIA","DEPOSITO"))) as tipopago
    ,(select 
		ROUND((ROUND(dt.precio_siniva,2) *dt.cantidad)*(im.taza/100),2) as valorimpuesto	
		from detallefactura as dt inner join producto as p on p.codproducto=dt.codproducto
		left join impuesto as im on im.idimpuesto=p.idimpuesto
		where nofactura=df.nofactura and p.idimpuesto=1 GROUP BY  im.idimpuesto) as iva,
		(select 
		ROUND((ROUND(dt.precio_siniva,2) *dt.cantidad)*(im.taza/100),2) as valorimpuesto	
		from detallefactura as dt inner join producto as p on p.codproducto=dt.codproducto
		left join impuesto as im on im.idimpuesto=p.idimpuesto
		where nofactura=df.nofactura and p.idimpuesto=2 GROUP BY  im.idimpuesto) as ieps,
		(select 
		ROUND((ROUND(dt.precio_siniva,2) *dt.cantidad)*(im.taza/100),2) as valorimpuesto	
		from detallefactura as dt inner join producto as p on p.codproducto=dt.codproducto
		left join impuesto as im on im.idimpuesto=p.idimpuesto
		where nofactura=df.nofactura and p.idimpuesto=5 GROUP BY  im.idimpuesto) as tasa0,
		(select 
		ROUND((ROUND(dt.precio_siniva,2) *dt.cantidad)*(im.taza/100),2) as valorimpuesto	
		from detallefactura as dt inner join producto as p on p.codproducto=dt.codproducto
		left join impuesto as im on im.idimpuesto=p.idimpuesto
		where nofactura=df.nofactura and p.idimpuesto=6 GROUP BY  im.idimpuesto) as exento
    FROM detallefactura df
    LEFT JOIN factura f on f.nofactura = df.nofactura 
    LEFT JOIN producto p on p.codproducto = df.codproducto
    LEFT JOIN usuario u on f.usuario = u.idusuario
    WHERE idtipopago = "'.$tipopago.'"
    GROUP BY df.nofactura
    ';
   
   
   
    /*$sql = 'select *, f.subtotal, u.usuario as nomusuario,	if(idtipoventa = 1, "CONTADO",if(idtipoventa = 2, "CREDITO", if(idtipoventa = 3, "DEVOLUCION", "GASTO"))) as tipoventa,
    if(idtipopago = 1, "EFECTIVO", if(idtipopago=2, "TARJETA",if(idtipopago=3, "TRANSFERENCIA","DEPOSITO"))) as tipopago
    from factura f
    inner join usuario u on f.usuario = u.idusuario
    WHERE idtipopago = "'.$tipopago.'"';*/

}else{

    $sql = 'SELECT f.fecha, df.nofactura, df.cantidad, p.codproducto, sum(p.valor_impuesto) AS impuestos, f.subtotal, f.totalfactura,  u.usuario as nomusuario, if(idtipoventa = 1, "CONTADO",if(idtipoventa = 2, "CREDITO", if(idtipoventa = 3, "DEVOLUCION", "GASTO"))) as tipoventa, if(idtipopago = 1, "EFECTIVO", if(idtipopago=2, "TARJETA",if(idtipopago=3, "TRANSFERENCIA","DEPOSITO"))) as tipopago
    ,(select 
		ROUND((ROUND(dt.precio_siniva,2) *dt.cantidad)*(im.taza/100),2) as valorimpuesto	
		from detallefactura as dt inner join producto as p on p.codproducto=dt.codproducto
		left join impuesto as im on im.idimpuesto=p.idimpuesto
		where nofactura=df.nofactura and p.idimpuesto=1 GROUP BY  im.idimpuesto) as iva,
		(select 
		ROUND((ROUND(dt.precio_siniva,2) *dt.cantidad)*(im.taza/100),2) as valorimpuesto	
		from detallefactura as dt inner join producto as p on p.codproducto=dt.codproducto
		left join impuesto as im on im.idimpuesto=p.idimpuesto
		where nofactura=df.nofactura and p.idimpuesto=2 GROUP BY  im.idimpuesto) as ieps,
		(select 
		ROUND((ROUND(dt.precio_siniva,2) *dt.cantidad)*(im.taza/100),2) as valorimpuesto	
		from detallefactura as dt inner join producto as p on p.codproducto=dt.codproducto
		left join impuesto as im on im.idimpuesto=p.idimpuesto
		where nofactura=df.nofactura and p.idimpuesto=5 GROUP BY  im.idimpuesto) as tasa0,
		(select 
		ROUND((ROUND(dt.precio_siniva,2) *dt.cantidad)*(im.taza/100),2) as valorimpuesto	
		from detallefactura as dt inner join producto as p on p.codproducto=dt.codproducto
		left join impuesto as im on im.idimpuesto=p.idimpuesto
		where nofactura=df.nofactura and p.idimpuesto=6 GROUP BY  im.idimpuesto) as exento
    FROM detallefactura df
    LEFT JOIN factura f on f.nofactura = df.nofactura 
    LEFT JOIN producto p on p.codproducto = df.codproducto
    LEFT JOIN usuario u on f.usuario = u.idusuario
    GROUP BY df.nofactura
    ';

    /*$sql = 'select *, f.subtotal, u.usuario as nomusuario,	if(idtipoventa = 1, "CONTADO",if(idtipoventa = 2, "CREDITO", if(idtipoventa = 3, "DEVOLUCION", "GASTO"))) as tipoventa,
    if(idtipopago = 1, "EFECTIVO", if(idtipopago=2, "TARJETA",if(idtipopago=3, "TRANSFERENCIA","DEPOSITO"))) as tipopago
    from factura f
    inner join usuario u on f.usuario = u.idusuario
    WHERE f.fecha';*/
}
//echo $sql;
$suma = 0;
$sumsub = 0;
$sumiva = 0;
$sumieps = 0;
$sumtasa0 = 0;
$sumexento = 0;
$r = $conexion -> query($sql);
$tabla = "";
$vuelta = 1;
if ($r -> num_rows >0){
    $tabla = $tabla.'<table  align = "center">';
    $tabla = $tabla.'<tr border="1" bgcolor="#FAAC9E">';
    $tabla = $tabla.'<th ><b>No.</b></th>';
    $tabla = $tabla.'<th ><b>ID VENTA</b></th>';
    $tabla = $tabla.'<th ><b>FECHA CAPTURA</b></th>';
    $tabla = $tabla."<th><b>USUARIO</b></th>";
    $tabla = $tabla."<th><b>SUBTOTAL</b></th>";
    $tabla = $tabla."<th><b>IVA</b></th>";
    $tabla = $tabla."<th><b>IEPS</b></th>";
    $tabla = $tabla."<th><b>TASA 0</b></th>";
    $tabla = $tabla."<th><b>EXENTO</b></th>";
    $tabla = $tabla.'<th ><b>TOTAL</b></th>';
    $tabla = $tabla.'<th ><b>TIPO PAGO</b></th>';
    $tabla = $tabla.'<th ><b>TIPO VENTA</b></th>';
    $tabla = $tabla."</tr>";
    while($f = $r -> fetch_array())
    {                  
        if (($vuelta % 2) == 0) {
            $tabla = $tabla.'<tr bgcolor="#FFFFFF">';
        }else{
            $tabla = $tabla.'<tr bgcolor="#FCD2CB">'; 
        }
        $tabla = $tabla.'<td>'.$vuelta.'</td>';
        $tabla = $tabla.'<td>'.$f['nofactura'].'</td>';
        $tabla = $tabla.'<td>'.$f['fecha'].'</td>';
        $tabla = $tabla.'<td>'.$f['nomusuario'].'</td>';
        $suma = $suma += $f['totalfactura'];
        $sumsub = $sumsub += $f['subtotal'];
        $sumiva = $sumiva += $f['iva'];
        $sumieps = $sumieps += $f['ieps'];
        $sumtasa0 = $sumtasa0 += $f['tasa0'];
        $sumexento = $sumexento += $f['exento'];
        $tabla = $tabla.'<td>$'.number_format($f['subtotal'], 2, '.', ',').'</td>';
        $tabla = $tabla.'<td>$'.number_format($f['iva'], 2, '.', ',').'</td>';
        $tabla = $tabla.'<td>$'.number_format($f['ieps'], 2, '.', ',').'</td>';
        $tabla = $tabla.'<td>$'.number_format($f['tasa0'], 2, '.', ',').'</td>';
        $tabla = $tabla.'<td>$'.number_format($f['exento'], 2, '.', ',').'</td>';
        $tabla = $tabla.'<td>$'.number_format($f['totalfactura'], 2, '.', ',').'</td>';
        $tabla = $tabla.'<td>'.$f['tipopago'].'</td>';
        $tabla = $tabla.'<td>'.$f['tipoventa'].'</td>';
        $tabla = $tabla."</tr>";  
        $vuelta++;               
    }
    $tabla = $tabla.'</table>';
    $tabla = $tabla.'<br><br><br>
    <table  align = "center" >
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td bgcolor="#FCD2CB">TOTALES</td>
            <td bgcolor="#FCD2CB">$'.number_format($sumsub, 2, '.', ',').'</td>
            <td bgcolor="#FCD2CB">$'.number_format($sumiva, 2, '.', ',').'</td>
            <td bgcolor="#FCD2CB">$'.number_format($sumieps, 2, '.', ',').'</td>
            <td bgcolor="#FCD2CB">$'.number_format($sumtasa0, 2, '.', ',').'</td>
            <td bgcolor="#FCD2CB">$'.number_format($sumexento, 2, '.', ',').'</td>
            <td bgcolor="#FCD2CB">$'.number_format($suma, 2, '.', ',').'</td>
            <td></td>
            <td></td>
        </tr>
        
    </table>';
}else{
    $tabla = $tabla.'<br><br><br>
    <table  align = "center" >
        <tr>
            <td  bgcolor="#FCD2CB">
                NO SE ENCONTRARON RESULTADOS PARA ESTA CONSULTA
            </td>
        </tr>
        
    </table>';
}




echo $tabla;
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('PUNTO DE VENTA');
$pdf->SetKeywords('Punto de Venta');
//$pdf->SetHeaderData('pdf_logo.jpg', '40','', '');
$pdf->SetHeaderData('aguira.jpg', '40', 'Listado de ventas', "Impreso: ".$fecha."");
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', '');
//$link = "http://".$urlnueva[0]."/md_lista.php";

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 9));
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
//$pdf->SetFooterData("Impreso: ".fecha_larga($fecha).", ".hora12($hora)." por ".nitavu_nombre($nitavu),array(0, 64, 0),array(0, 64, 128));

$pdf->setPrintFooter(true);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'pdf/lang/eng.php')) {
    require_once(dirname(__FILE__).'pdf/lang/eng.php');
    $pdf->setLanguageArray($l);
}
// set font
$pdf->SetFont('helvetica', '', 9);
// add a page
$pdf->AddPage('L', 'LETTER'); //en la tabla de reporte L o P
$html = $tabla;
//echo $html; aqui escribe el contenido de la consulta

$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();
//Close and output PDF document}
ob_end_clean();
$pdf->Output('reporte.pdf', 'I');
?>