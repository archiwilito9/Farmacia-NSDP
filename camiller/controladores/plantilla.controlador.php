<?php

class ControladorPlantilla{
/*static para evitar errores o choques con los diferentes servidores y el archivo .ini*/
	static public function ctrPlantilla(){
/*traemos la pagina completa con la ruta*/
		include "vistas/plantilla.php";

	}	


}