<?php

$item = null;
$valor = null;
$orden = "id";

$ventas = ControladorVentas::ctrSumaTotalVentas();

$categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);
$totalCategorias = count($categorias);

$clientes = ControladorClientes::ctrMostrarClientes($item, $valor);
$totalClientes = count($clientes);

$productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
$totalProductos = count($productos);

?>



<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
<script>
  
  var fecha = new Date();
  var dia = fecha.getDate();
  var mes = fecha.getMonth();
  if(dia == 30){
    swal({
          title: "Recordatorio mensual",
          text: "Revisa tu inventario",
          type: "info",
          confirmButtonText: "Cerrar"
        });
  }else if( dia == 28  && mes == 1 ){
    swal({
          title: "Tienes que haces inventario",
          text: "Revisa tu inventario",
          type: "info",
          confirmButtonText: "Cerrar"
        });
  }else if( dia == 29 && mes == 1 ){
    swal({
          title: "Recordatorio mensual",
          text: "Revisa tu inventario",
          type: "info",
          confirmButtonText: "Cerrar"
        });
  }

</script>
  <div class="small-box bg-blue">
    
    <div class="inner">
      
      <h3>$<?php echo number_format($ventas["total"],2); ?></h3>

      <p>Ventas totales</p>
    
    </div>
    
    <div class="icon">
      
      <i class="ion ion-social-usd"></i>
    
    </div>
    
    <a href="ventas" class="small-box-footer">
      
      Ver más <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>

<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">

  <div class="small-box bg-blue">
    
    <div class="inner">
    
      <h3><?php echo number_format($totalCategorias); ?></h3>

      <p>Categorías totales</p>
    
    </div>
    
    <div class="icon">
    
      <i class="ion ion-clipboard"></i>
    
    </div>
    
    <a href="categorias" class="small-box-footer">
      
      Ver más <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>

<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">

  <div class="small-box bg-blue">
    
    <div class="inner">
    
      <h3><?php echo number_format($totalClientes); ?></h3>

      <p>Clientes totales</p>
  
    </div>
    
    <div class="icon">
    
      <i class="ion ion-person-add"></i>
    
    </div>
    
    <a href="clientes" class="small-box-footer">

      Ver más <i class="fa fa-arrow-circle-right"></i>

    </a>

  </div>

</div>

<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">

  <div class="small-box bg-blue">
  
    <div class="inner">
    
      <h3><?php echo number_format($totalProductos); ?></h3>

      <p>Productos totales</p>
    
    </div>
    
    <div class="icon">
      
      <i class="ion ion-ios-cart"></i>
    
    </div>
    
    <a href="productos" class="small-box-footer">
      
      Ver más <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>