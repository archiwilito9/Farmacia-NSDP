<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Inicio |
      
      <small>Estado corporativo</small>
    
    </h1>
<!-- mapa de sitio -->
    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fas fa-map-marker-alt"></i> Inicio</a></li>
    
    </ol>

  </section>

  <section class="content">

    <div class="row">
       <div class="col-lg-12">
           
          <?php

          if($_SESSION["perfil"] =="Especial" || $_SESSION["perfil"] =="Vendedor"){

             echo '<div class="box box-success">

             <div class="box-header">

             <h1>Bienvenid@ ' .$_SESSION["nombre"].'</h1>

             </div>

             </div>';

          }

          ?>

         </div>
      
    <?php

    if($_SESSION["perfil"] =="Administrador"){

      include "inicio/cajas-superiores.php";

    }

    ?>

    </div> 

     <div class="row">
       
        <div class="col-lg-12">

          <?php

          if($_SESSION["perfil"] =="Administrador" || $_SESSION["perfil"]=="Especial"){
          
           include "reportes/grafico-ventas.php";

          }

          ?>

        </div>

        <div class="col-lg-6">

          <?php

          if($_SESSION["perfil"] =="Administrador" || $_SESSION["perfil"] =="Vendedor"){
          
           include "reportes/productos-mas-vendidos.php";

         }

          ?>

        </div>

        <div class="col-lg-6">

          <?php

          if($_SESSION["perfil"] =="Administrador"){
          
           include "inicio/productos-recientes.php";

         }

          ?>

        </div>

        


            <!--
         vendedor barra
         
-->
        <div class="col-lg-6">

          <?php

          if($_SESSION["perfil"] =="Vendedor"){
          
          include "inicio/progreso.php";

         }

          ?>

        </div>




     </div>

   

  </section>
 
</div>
