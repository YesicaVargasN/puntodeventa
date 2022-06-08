<?php
include_once "includes/header.php";
include "../conexion.php";
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card-header bg-primary text-white">
                Registro de código de barras
            </div>

            <!--GENERAR CODIGO DE BARRAS-->
            <div class="card">
                <div id="respuesta"></div>
                <form action="" autocomplete="off" method="post" class="card-body p-2">
                <div class="form-group">
                    <label for="nombre">Nombre del producto</label>
                    <input type="text" placeholder="Ingrese nombre" id="nombre" name="nombre" class="form-control">
                </div>
                <div class="form-group">
                    <label for="nombre">Código del producto</label>
                    <input type="text" id="data" name="data" placeholder="Ingresa un valor" class="form-control"> 
                </div>
                
                <div id="imagen"></div>
                
                
                <button type="button" id="generar_barcode" onclick="cb();" class="btn btn-primary">Generar código de barras</button>
                
                <button type="button" id="imprimir" onclick="imprimir();"  class="btn btn-primary">Imprimir</button>
                
            </div>            
        </div>
    </div>
</div>

<!--<input type="text" id="data" placeholder="Ingresa un valor">
  <button type="button" onclick='cb();' id="generar_barcode">Generar código de barras</button>
  <div id="imagen"></div>-->

<script>
    function cb() {
        var data = $("#data").val();
        var nombre = $("#nombre").val();
        $("#imagen").html('<img src="barcode\\barcode.php?text='+data+'&size=90&codetype=Code39&print=true"/>');
        $("#data").val('');
        $("#nombre").val('');
        $.post( "guardarImagen.php", { filepath: "codigosGenerados/"+data+".png", text:data, nombre:nombre }  )
            .done(function( data ) {
                console.log("Data Loaded: " + data );
            }
        );

       /* $.post( "test.php", { name: "John", time: "2pm" })
        .done(function( data ) {
            alert( "Data Loaded: " + data );
        });*/
    }
  </script>


<!-- /.container-fluid -->
<?php include_once "includes/footer.php"; ?>