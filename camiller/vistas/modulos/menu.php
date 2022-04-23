<aside class="main-sidebar">

	 <section class="sidebar">

		<ul class="sidebar-menu">

		<?php

		if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Vendedor"){
// no ponemos links con el .php porque trabajamos con urls amigables
			echo '<li>

				<a href="inicio">

					<i class="fa fa-home"></i>
					<span>Inicio</span>

				</a>

			</li>';
		}
// no ponemos links con el .php porque trabajamos con urls amigables
		if($_SESSION["perfil"] == "Administrador"){

			echo '<li>

				<a href="usuarios">

					<i class="fas fa-users-cog""></i>
					<span>Usuarios</span>

				</a>

			</li>';

		}

			
// no ponemos links con el .php porque trabajamos con urls amigables
		if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Especial"){

			echo '<li>

				<a href="categorias">

					<i class="fas fa-boxes"></i>
					<span>Categorías</span>

				</a>

			</li>

			<li>

				<a href="productos">

					<i class="fas fa-tags"></i>
					<span>Productos</span>

				</a>

			</li>';

		}
// no ponemos links con el .php porque trabajamos con urls amigables
		if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Vendedor"){

			echo '<li>

				<a href="clientes">

					<i class="fa-users fa"></i>
					<span>Clientes</span>

				</a>

			</li>';

		}
// no ponemos links con el .php porque trabajamos con urls amigables
		 if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Vendedor"){

			echo '<li class="treeview">

				<a href="#">

					<i class="fas fa-shopping-cart"></i>
					
					<span>Ventas</span>
					
					<span class="pull-right-container">
					
						<i class="fa fa-angle-left pull-right"></i>

					</span>

				</a>

				<ul class="treeview-menu">

				<li>

						<a href="crear-venta">
							
							<i class="fas fa-file-invoice-dollar"></i>
							<span>&nbsp Crear venta</span>

						</a>

					</li>
					
					<li>

						<a href="ventas">
							
							<i class="fas fa-toolbox"></i>
							<span>&nbsp Administrar ventas</span>

						</a>

					</li>

					';
// no ponemos links con el .php porque trabajamos con urls amigables
					if($_SESSION["perfil"] == "Administrador"){

					echo '<li>

						<a href="reportes">
							
							<i class="fas fa-receipt"></i>
							<span>&nbsp Reporte de ventas</span>

						</a>

					</li>';

					}

				

				echo '</ul>

			</li>';

		} 

		?>

		</ul>

	 </section>

</aside>