 <?php include_once "includes/header.php";
  include "../conexion.php";
  if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['proveedor']) || empty($_POST['producto']) || empty($_POST['precioventa']) || $_POST['precioventa'] <  0 || empty($_POST['cantidad'] || $_POST['cantidad'] <  0)) {
      $alert = '<div class="alert alert-danger" role="alert">
                Todo los campos son obligatorios
              </div>';
    } else {
      $codigo = $_POST['codigo'];
      $proveedor = $_POST['proveedor'];
      $producto = $_POST['producto'];
      $precio = $_POST['preciocosto'];
      $cantidad = $_POST['cantidad'];
      $usuario_id = $_SESSION['idUser'];
      $precioventa = $_POST['precioventa'];
      $preciomayoreo = $_POST['preciomayoreo'];
      $cantidad = $_POST['cantidad'];
      $unidadmedida = $_POST['medida'];
      $categoria = $_POST['categoria'];


      $query_insert = mysqli_query($conexion, "INSERT INTO producto(codigo, proveedor,descripcion,precio,existencia,usuario_id, precioventa, preciomayoreo, cantidad, unidadmedida, categoria) values ('$codigo','$proveedor', '$producto', '$precio', '$cantidad','$usuario_id', '$precioventa', '$preciomayoreo', '$cantidad', '$unidadmedida', '$categoria')");
      if ($query_insert) {
        $alert = '<div class="alert alert-success" role="alert">
                Producto Registrado
              </div>';
      } else {
        $alert = '<div class="alert alert-danger" role="alert">
                Error al registrar el producto
              </div>';
      }
    }
  }
  ?>

 <!-- Begin Page Content -->
 <div class="container-fluid">

   <!-- Page Heading -->
   <div class="d-sm-flex align-items-center justify-content-between mb-4">
     <h1 class="h3 mb-0 text-gray-800">Registrar Productos</h1>
     <a href="lista_productos.php" class="btn btn-primary">Regresar</a>
   </div>

   <!-- Content Row -->
   <div class="row">
     <div class="col-lg-6 m-auto">
       <div class="card">
         <div class="card-header bg-primary">
           Nuevo Producto
         </div>
         <div class="card-body">
           <form action="" method="post" autocomplete="off">
             <?php echo isset($alert) ? $alert : ''; ?>
             <div class="form-group">
               <label for="codigo">Código de Barras</label>
               <input type="text" placeholder="Ingrese código de barras" name="codigo" id="codigo" class="form-control">
             </div>
             <div class="form-group">
               <label for="producto">Producto</label>
               <input type="text" placeholder="Ingrese nombre del producto" name="producto" id="producto" class="form-control">
             </div>
             
             <div class="form-group">
               <label>Proveedor</label>
               <?php
                $query_proveedor = mysqli_query($conexion, "SELECT codproveedor, proveedor FROM proveedor ORDER BY proveedor ASC");
                $resultado_proveedor = mysqli_num_rows($query_proveedor);
               
                ?>

               <select id="proveedor" name="proveedor" class="form-control">
                 <?php
                  if ($resultado_proveedor > 0) {
                    while ($proveedor = mysqli_fetch_array($query_proveedor)) {
                      // code...
                  ?>
                     <option value="<?php echo $proveedor['codproveedor']; ?>"><?php echo $proveedor['proveedor']; ?></option>
                 <?php
                    }
                  }
                  ?>
               </select>
             </div>
             <div class="form-group">
               <label for="preciocosto">Precio Costo</label>
               <input type="text" placeholder="Ingrese precio" class="form-control" name="preciocosto" id="preciocosto">
             </div>
           
             <div class="form-group">
               <label for="precio">Precio Venta</label>
               <input type="text" placeholder="Ingrese precio" class="form-control" name="precioventa" id="precioventa">
             </div>
             <div class="form-group">
               <label for="preciomayoreo">Precio Mayoreo</label>
               <input type="text" placeholder="Ingrese precio" class="form-control" name="preciomayoreo" id="preciomayoreo">
             </div>

             <div class="form-group">
               <label for="cantidad">Cantidad</label>
               <input type="number" placeholder="Ingrese cantidad" class="form-control" name="cantidad" id="cantidad">
             </div>

             <div class="form-group">
               <label>Unidad de Medida</label>
               <?php
                $query_medida = mysqli_query($conexion, "SELECT idunidadmedida, nombrecorto FROM cat_unidadmedida");
                $resultado_medida = mysqli_num_rows($query_medida);
               
                ?>

               <select id="medida" name="medida" class="form-control">
                 <?php
                  if ($resultado_medida > 0) {
                    while ($medida = mysqli_fetch_array($query_medida)) {
                      // code...
                  ?>
                     <option value="<?php echo $medida['idunidadmedida']; ?>"><?php echo $medida['nombrecorto']; ?></option>
                 <?php
                    }
                  }
                  ?>
               </select>
             </div>

             <div class="form-group">
               <label>Categoria</label>
               <?php
                $query_dptos = mysqli_query($conexion, "SELECT iddepartamento, departamento FROM cat_departamento ORDER BY departamento ASC");
                $resultado_dptos = mysqli_num_rows($query_dptos);
                mysqli_close($conexion);
                ?>

               <select id="categoria" name="categoria" class="form-control">
                 <?php
                  if ($resultado_dptos > 0) {
                    while ($dptos = mysqli_fetch_array($query_dptos)) {
                      // code...
                  ?>
                     <option value="<?php echo $dptos['iddepartamento']; ?>"><?php echo $dptos['departamento']; ?></option>
                 <?php
                    }
                  }
                  ?>
             </div>
             
             <input type="submit" value="Guardar Producto" class="btn btn-primary">
           </form>
         </div>
       </div>
     </div>
   </div>


 </div>
 <!-- /.container-fluid -->
 <?php include_once "includes/footer.php"; ?>