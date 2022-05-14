<?php
/*Se requieren para utilizar los metodos a traves de objetos*/
require_once "controladores/plantilla.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/categorias.controlador.php";
require_once "controladores/productos.controlador.php";
require_once "controladores/clientes.controlador.php";
require_once "controladores/ventas.controlador.php";


require_once "modelos/usuarios.modelo.php";
require_once "modelos/categorias.modelo.php";
require_once "modelos/productos.modelo.php";
require_once "modelos/clientes.modelo.php";
require_once "modelos/ventas.modelo.php";
/*objeto plantilla con su clase*/
$plantilla = new ControladorPlantilla();
/*invocamos el metodo o funcion y lo ejecuta inmediatamente*/
$plantilla -> ctrPlantilla();
