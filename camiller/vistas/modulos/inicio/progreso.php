

  
    <div class="box box-primary">

      <div class="box-header with-border">
  
      <h3 class="box-title">Progreso meta de ventas</h3>
      <br>
      <small>Porcentaje completado según la meta establecida</small>
    </div>
        
    <div class="box-body ">
    
      	<div class="row">

	        <div class="col-md-12"> 
	        <div class="chart-responsive" style="text-align: center"> 
            
            <div class="caja" style="text-align: center">
    <input type="text" id="s"  class="dial">
         </div>
            
            </div>
    <!-- <input type="text" value="55" class="dial" data-width="200" data-thickness=".32" data-fgColor="#008BE8" data-bgColor="#EEEEEE" data-cursor=false data-displayInput="true" data-readOnly=true > -->
          
            
       
      



<?php

$item = null;
$valor = null;

$ventas = ControladorVentas::ctrMostrarVentas($item, $valor);
$usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

$arrayVendedores = array();
$sumaTotalVendedores=0;


foreach ($ventas as $key => $valueVentas) {

  foreach ($usuarios as $key => $valueUsuarios) {

    if($valueUsuarios["id"] == $valueVentas["id_vendedor"] && $valueUsuarios["nombre"]==$_SESSION["nombre"] ){

        $sumaTotalVendedores += $valueVentas["neto"];
        
        

    }
  
  }

}

$ganancia=$sumaTotalVendedores-$_SESSION["metaganacia"];
$ganancia=number_format($ganancia,2);
// $ganancia=$sumaTotalVendedores-$_SESSION["metaganacia"];
   
echo '<p class"col-md-9 /*text-right*/" style="text-align:center">$'. number_format($sumaTotalVendedores,2).' / $'.number_format($_SESSION["metaganacia"],2).'</p><center><input type="hidden" id="a" readonly></center>';
echo '</div>';
echo '</div>';
echo '</div>';
$porcentaje= ceil(($sumaTotalVendedores/$_SESSION["metaganacia"])*100);
$sumaTotalVendedores=0;


?>

<style type="text/css">
  #a{
    border: none;
    width: 100%;
    text-align: center;
    margin-bottom: 2%;
    background-color: #4AC848;
    padding: 2%;
    margin-top: 1%;
    font-family: 'Nunito', sans-serif;
    color: white;
  }
  .caja{
    font-family: 'Nunito', sans-serif;
    width: 100%;

  }

  p{
    margin-top: 2%;
    font-size: 24px;
  }
  .dial{
    margin: auto;
  }

  small{
    font-size: 18px;
    color: gray;
  }

</style>


<script>
    $(document).ready(function() {    
      //$(".dial").knob();

        <?php
        if($porcentaje>=100){
          if($ganancia>0){
            echo '$("#a").attr("value", " Ganancia: $'.$ganancia.'");'
             ;
             echo '$("#a").attr("type", "text");'
             ;
          }
         
         echo '$("#s").attr("value", "100");'
         ;
         

        }else{

          echo '$("#s").attr("value", "'.$porcentaje.'");';
        }
        ?>
        
        
        
   
      $('.dial').knob({
        'min':0,
        'max':100,
        'width':250,
        'height':250,
        'displayInput':true,
        'fgColor':"#5FBC8F",
        'release':function(v) {$("p").text(v);},
        'readOnly':true
      });
        
        
    });
  </script>
  
  