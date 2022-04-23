<?php
//requerimos nuevamente, porque js es como trabajar en segundo plano, por lo tanto js no toma en cuenta index.php
//requerimos el controlador para usar sus metodos
require_once "../controladores/usuarios.controlador.php";
//requerimos modelo para trabajar con la bdd y sus modelos
require_once "../modelos/usuarios.modelo.php";
//creamos una clase para usuarios
class AjaxUsuarios{

	/*=============================================
	EDITAR USUARIO
	=============================================*/	
//publica para seguir usandola mas adelatnte
	public $idUsuario;
//funcion para capturar los datos en los input
	public function ajaxEditarUsuario(){
//columna id
		$item = "id";
		//buscaremos el valor en la columnda id de lo que viene desde el atributo del boton del php
		$valor = $this->idUsuario;
		//llamamos al modelo para solicitar respuesta de la bdd
		//mandaremos el id porque es el que recibimos desde usuarios.js
		//mandamos el valor para buscarlo en la columna $item (id)
		$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
		//codificamos en json para que funcione a nivel de servidor en la bdd
		echo json_encode($respuesta);

	}

	/*=============================================
	ACTIVAR USUARIO
	=============================================*/	
//variables publicas para agarrar los valores del js
	public $activarUsuario;
	public $activarId;

//creamos la funcion para activar usuario
	public function ajaxActivarUsuario(){
//agarramos la tabla que vamos actualizar
		$tabla = "usuarios";

		$item1 = "estado";
		//agarra el valor 1 o 0 segun se guardo en el js
		$valor1 = $this->activarUsuario;

		$item2 = "id";
		//se agarra el id del usuario de la fila evaluada en el js
		$valor2 = $this->activarId;
//agarramos la respuesta del metodo del modelo
		//le mandamos el nombre de la tabla, dos columnas, la del id del usuario y la del estado
		$respuesta = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);

	}

	/*=============================================
	VALIDAR NO REPETIR USUARIO
	=============================================*/	
//variable para ver si no se repiten los majes
	public $validarUsuario;

	public function ajaxValidarUsuario(){

		$item = "usuario";
		$valor = $this->validarUsuario;
//mandamos la columna usuarios para buscar $valor
		$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
//codificamos en json para trabajar a nivel de servidor en la bdd
		echo json_encode($respuesta);

	}
}

/*=============================================
EDITAR USUARIO
=============================================*/
//revisamos si nos mandan un valor de idUsuario desde el js, que viene desde el php originalmente
if(isset($_POST["idUsuario"])){
//objeto de la clase AjaxUsuarios
	$editar = new AjaxUsuarios();
	//enlazamos en la propiedad idUsuario lo que venga desde el boton del php idUsuario que seria el id
	$editar -> idUsuario = $_POST["idUsuario"];
	//ejecutamos el metodo
	$editar -> ajaxEditarUsuario();

}

/*=============================================
ACTIVAR USUARIO
=============================================*/	
//si viene una variable post desde el js
if(isset($_POST["activarUsuario"])){
	//creamos el objeto y ejecutamos la clase AjaxUsuarios
	$activarUsuario = new AjaxUsuarios();
	//recibimos el valor post de activarUsuario de usuarios.js
	$activarUsuario -> activarUsuario = $_POST["activarUsuario"];
	//recibimos el valor de activarId del js
	$activarUsuario -> activarId = $_POST["activarId"];
	//ejecutamos el metodo
	$activarUsuario -> ajaxActivarUsuario();

}

/*=============================================
VALIDAR NO REPETIR USUARIO
=============================================*/
//si viene una variable validarUsuario
if(isset( $_POST["validarUsuario"])){
//enlazamos con la clase AjaxUsuarios
	$valUsuario = new AjaxUsuarios();
	//le damos un valor
	$valUsuario -> validarUsuario = $_POST["validarUsuario"];
	//ejecutamos la funcion de la clase
	$valUsuario -> ajaxValidarUsuario();

}