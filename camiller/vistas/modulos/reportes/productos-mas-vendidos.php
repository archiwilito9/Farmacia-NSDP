<?php

$item = null;
$valor = null;
$orden = "ventas";

$productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);


$coloresCirculo = array("color0","color1","color2","color3","color4","color5","color6","color7","color8","color9");

$coloresNuevos = array("#F09696","#F0CA96","#D7EA72","#A1F096","#96F0C4","#96DCF0","#96A5F0","#C896F0","#F096E2","#CD667F");

$totalVentas = ControladorProductos::ctrMostrarSumaVentas();


?>

<!--=====================================
PRODUCTOS MÁS VENDIDOS
======================================-->

<div class="box box-default">
	
	<div class="box-header with-border">
  
      <h3 class="box-title">Productos más vendidos</h3>

    </div>

	<div class="box-body">
    
      	<div class="row">

	        <div class="col-md-7">

	 			<div class="chart-responsive">
	            
	            	<canvas id="pieChart" height="150"></canvas>
	          
	          	</div>

	        </div>

		    <div class="col-md-5">
		      	
		  	 	<ul class="chart-legend clearfix">

		  	 	<?php



					for($i = 0; $i < 10; $i++){
// text-'.$colores[$i].' 
					echo ' <li><i class="fas fa-circle colorTextNew-'.$coloresCirculo[$i].'"></i> '.$productos[$i]["descripcion"].'</li>';

					}


		  	 	?>


		  	 	</ul>

		    </div>

		</div>

    </div>

    <div class="box-footer no-padding">
    	
		<ul class="nav nav-pills nav-stacked">
			
			 <?php

       if($_SESSION["perfil"]=="Vendedor"){
        for($i = 0; $i <2; $i++){
      
              echo '<li>
             
             <a>

             <img src="'.$productos[$i]["imagen"].'" class="img-thumbnail" width="60px" style="margin-right:10px"> 
             '.$productos[$i]["descripcion"].'

             <span class="pull-right colorTextNew-'.$coloresCirculo[$i].'">   
             '.ceil($productos[$i]["ventas"]*100/$totalVentas["total"]).'%
             </span>
              
             </a>

              </li>';

      }
            
          }elseif ($_SESSION["perfil"]=="Administrador") {
            for($i = 0; $i <6; $i++){
      
              echo '<li>
             
             <a>

             <img src="'.$productos[$i]["imagen"].'" class="img-thumbnail" width="60px" style="margin-right:10px"> 
             '.$productos[$i]["descripcion"].'

             <span class="pull-right colorTextNew-">   
             '.ceil($productos[$i]["ventas"]*100/$totalVentas["total"]).'%
             </span>
              
             </a>

              </li>';

      }
          }

          	

			?>


		</ul>

    </div>

</div>

<script>
	

  // -------------
  // - PIE CHART -
  // -------------
  // Get context with jQuery - using jQuery's .get() method.
  var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
  var pieChart       = new Chart(pieChartCanvas);
  var PieData        = [

  <?php

  for($i = 0; $i < 10; $i++){

  	echo "{
      value    : ".$productos[$i]["ventas"].",
      color    : '".$coloresNuevos[$i]."',
      highlight: '".$coloresNuevos[$i]."',
      label    : '".$productos[$i]["descripcion"]."'
    },";

  }
    
   ?>
  ];
  var pieOptions     = {
    // Boolean - Whether we should show a stroke on each segment
    segmentShowStroke    : true,
    // String - The colour of each segment stroke
    segmentStrokeColor   : '#fff',
    // Number - The width of each segment stroke
    segmentStrokeWidth   : 1,
    // Number - The percentage of the chart that we cut out of the middle
    percentageInnerCutout: 50, // This is 0 for Pie charts
    // Number - Amount of animation steps
    animationSteps       : 100,
    // String - Animation easing effect
    animationEasing      : 'easeOutBounce',
    // Boolean - Whether we animate the rotation of the Doughnut
    animateRotate        : true,
    // Boolean - Whether we animate scaling the Doughnut from the centre
    animateScale         : false,
    // Boolean - whether to make the chart responsive to window resizing
    responsive           : true,
    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio  : false,
    // String - A legend template
    legendTemplate       : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
    // String - A tooltip template
    tooltipTemplate      : '<%=value %> <%=label%>'
  };
  // Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.
  pieChart.Doughnut(PieData, pieOptions);
  // -----------------
  // - END PIE CHART -
  // -----------------


</script>