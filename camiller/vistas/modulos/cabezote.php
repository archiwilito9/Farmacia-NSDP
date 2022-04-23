 <header class="main-header">
 	
	<!--=====================================
	LOGO
	======================================-->
	<a href="inicio" class="logo">
		
		<!-- logo mini -->
		<!-- <span class="logo-mini">
			
			<img src="vistas/img/plantilla/logo-pixel.jpg" class="img-responsive" style="padding:10px">

		</span> -->

		<!-- logo normal -->

		<!-- <span class="logo-lg">
			
			<img src="vistas/img/plantilla/Espacio-Radtek.jpg" class="img-responsive" style="padding:0px 0px">

		</span>
 -->
	</a>

	<!--=====================================
	BARRA DE NAVEGACIÓN
	======================================-->
	<nav class="navbar navbar-static-top" role="navigation">
		
		<!-- Botón de navegación -->

	 	<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        	
        	<span class="sr-only">Toggle navigation</span>
      	
      	</a>

		<!-- perfil de usuario -->

		<div class="navbar-custom-menu">
				
			<ul class="nav navbar-nav">
				
				<li class="dropdown user user-menu">
					
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<!-- abrimos archivo php para que nos imprima foto y nombre con las variables de sesion del usuario logeado -->
					<?php
					//si foto tiene algo
					if($_SESSION["foto"] != ""){
						//entonces nos muestra la foto
						//la variable de sesion foto trae una ruta de la bdd, por lo tanto lo ponemos en el src
						echo '<img src="'.$_SESSION["foto"].'" class="user-image">';

					}else{
						//si no tiene nada la sesion foto pues nos muestra la foto por defecto :V

						echo '<img src="vistas/img/usuarios/default/anonymous.png" class="user-image">';

					}


					?>
						<!-- si esta loguado obviamente tiene un nombre, por lo tanto imprimimos el name  -->
						<span class="hidden-xs"><?php  echo $_SESSION["nombre"]; ?></span>

					</a>

					<!-- Dropdown-toggle -->

					<ul class="dropdown-menu">
						
						<li class="user-body">
							
							<div class="pull-right">
								<!-- abrimos salir.php para destruir sessiones -->
								<a href="salir" class="btn btn-default btn-flat"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>

							</div>

						</li>

					</ul>

				</li>

			</ul>

		</div>

	</nav>

 </header>