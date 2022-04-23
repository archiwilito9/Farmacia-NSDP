<?php
//creamos la clase para pasarsela a los objetos y puedan usar los metodos :v
class ControladorUsuarios{

	/*=============================================
	INGRESO DE USUARIO
	=============================================*/
//hay que poner static porque algunos servidores nos exigen en el archivo php.ini que nos exigen static
	static public function ctrIngresoUsuario(){
//evaluamos si existen variables post con el nombre de los input del formulario usuario y password
		if(isset($_POST["ingUsuario"])){
//usamos los preg_match para permitir caractes [a-zA-Z0-9] a-z minuscula y mayusculas numeros 0 al 9
			//usamos el preg match para bloquear caracteres especiales y evitar inyecciones o algun ataque
			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])){
				//encriptamos la contraseña que ponen, ya que la que esta en la bdd esta encriptada
			   	$encriptar = crypt($_POST["ingPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
			   //nombre de la tabla
				$tabla = "usuarios";
				//consultamos el item  de la columna usuarios
				$item = "usuario";
				//el valor se iguala al valor del input por medio de post y el name del input
				$valor = $_POST["ingUsuario"];
				//invocamos el modelo usuarios y el metodo de mostrar usuarios
				//mandamos el nombre de la tabla, la columna y el valor
				//usamos los :: para que la respuesta o el resultado del metodo lo almacenemos en una variable ($respuesta)
				//$respuesta obtendra una linea del modelo gracias a fetch
				$respuesta = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);
				//comparamos la columna de fetch del username con el valor del input de login
				//comparamos la contraseña encriptada del input con la encriptada de la bdd
				if($respuesta["usuario"] == $_POST["ingUsuario"] && $respuesta["password"] == $encriptar){
					//antes de hacer variables de sesion evaluamos el estado, si es 1 entonces puede entrar
					if($respuesta["estado"] == 1){
						//creamos y guardamos valores en las varibles de sesion
						//primero va la variable a crear y luego la columna con su valor de la bdd
						//ponemos ok para que nos cargue las vistas en plantilla.php
						$_SESSION["iniciarSesion"] = "ok";
						$_SESSION["id"] = $respuesta["id"];
						$_SESSION["nombre"] = $respuesta["nombre"];
						$_SESSION["usuario"] = $respuesta["usuario"];
						$_SESSION["foto"] = $respuesta["foto"];
						$_SESSION["metaganacia"] = $respuesta["metaganacia"];
						$_SESSION["perfil"] = $respuesta["perfil"];

						/*=============================================
						REGISTRAR FECHA PARA SABER EL ÚLTIMO LOGIN
						=============================================*/
						//configuramos la zona horaria gracias a php
						date_default_timezone_set('America/El_Salvador');
						//capturamos la fecha con un formato porque asi se debe subir a la bdd

						$fecha = date('Y-m-d');
						//capturamos la hora con un formato que acepte la bdd
						$hora = date('H:i:s');

						//unimos las dos variables en una sola
						$fechaActual = $fecha.' '.$hora;

						//agarramos la columna para guardarlo en la bdd
						$item1 = "ultimo_login";
						//mandamos el valor que pondremos en la columna ultimo_login
						$valor1 = $fechaActual;
						//agarramos la columna para guardarlo al usuario que se esta loguando
						$item2 = "id";
						//agarramos el id de la persona actual para buscarlo en la columna id de la bdd
						$valor2 = $respuesta["id"];
						//actualizamos la tabla con el mdlActualizarUsuario y le mandamos los paremtros que ta encontramos
						$ultimoLogin = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);
						//si la respuesta ultimoLogin es ok entonces nos dejará pasar
						if($ultimoLogin == "ok"){

							echo '<script>

								window.location = "inicio";

							</script>';

						}				
						
					}else{
						//si el usuario esta desactivado, tiene 0 pues no lo deja pasar y tira una alerta
						echo '<br>
							<div class="alert alert-danger">El usuario aún no está activado</div>';

					}		

				}else{
					//si el usuario no existe mandamos una alerta
					echo '<br><div class="alert alert-danger">Error al ingresar, vuelve a intentarlo</div>';

				}

			}	

		}

	}



	/*=============================================
	CREACIÓN DE USUARIO
	=============================================*/

	static public function ctrCrearUsuario(){
//evaluamos si existe algo en el input de nuevo usuario
		if(isset($_POST["nuevoUsuario"])){
//validamos los caracteres validos de cada input
			//permitimos tildes y letras y numeros y espacio en el nombre
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"]) &&
				//permitimos el mismo preg match del usuario para ingresar
				//solo alfanumericos, sin caracteres especiales
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoUsuario"]) &&
			   //solo alfanumericos para contraseña
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoPassword"])){

			   	/*=============================================
				VALIDAR IMAGEN
				=============================================*/
				//ruta vacía por si no ponen foto
				$ruta = "";
				//validamos con $_FILES porque estamos mandando un archivo a traves del input nuevaFoto
				//usamos un archivo temporal de la foto
				if(isset($_FILES["nuevaFoto"]["tmp_name"])){
					//creamos un array con metodo de php list para un nuevo alto y ancho
					//indice 0 = ancho
					//indice 1 = alto
					//get image size trae un arreglo, en el indice 0 el acho y el 1 el alto
					//por eso lo guardamos
					list($ancho, $alto) = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);
					//creamos los nuevos valores de pixeles para redimensionar todas las fotos
					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/
					//creamos una variable con la ruta donde queremos que se haga el directorio
					//le concatenamos el nombre del usuario para crear un directorio por usuario
					$directorio = "vistas/img/usuarios/".$_POST["nuevoUsuario"];
					//creamos el directorio primero, y los permisos de lectura y escritura de php 0755
					mkdir($directorio, 0755);

					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/
					//comparamos el tipo de la foto que tenemos con el tipo de php JPEG
					if($_FILES["nuevaFoto"]["type"] == "image/jpeg"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/
						//generamos un random para un nombre
						$aleatorio = mt_rand(100,999);
						//buscamos la ruta donde se va a guardar la foto con el username
						//concatenamos el nombre de la imagen y concatenamos el formato .jpg
						$ruta = "vistas/img/usuarios/".$_POST["nuevoUsuario"]."/".$aleatorio.".jpg";
						//hacemos una variable para obtener el origen de donde viene
						$origen = imagecreatefromjpeg($_FILES["nuevaFoto"]["tmp_name"]);						
						//hacemos una variable para obtener el destino para donde va
						/*cuando pasemos la imagen al destino, mantiene el color con imagecreatetruecolor pero
						con parametros para redimensionar*/
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
						//imagecopyresized(dst_image, src_image, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h)
						//corte empieza desde los valores de dst_x, dst_y para imagen de destino
						//corte empieza desde los valores de src_x, src_y para imagen de origen
						//los valores de ancho y alto del destino dst_w dst_h
						//los valores de ancho y alto del origen src_w src_h
						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
						//guarda la foto $destino en la $ruta que asignamos
						imagejpeg($destino, $ruta);

					}

					if($_FILES["nuevaFoto"]["type"] == "image/png"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/
						//generamos un random para un nombre
						$aleatorio = mt_rand(100,999);
						//buscamos la ruta donde se va a guardar la foto con el username
						//concatenamos el nombre de la imagen y concatenamos el formato .png
						$ruta = "vistas/img/usuarios/".$_POST["nuevoUsuario"]."/".$aleatorio.".png";
						//hacemos una variable para obtener el origen de donde viene
						$origen = imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);						
						//hacemos una variable para obtener el destino para donde va
						/*cuando pasemos la imagen al destino, mantiene el color con imagecreatetruecolor pero
						con parametros para redimensionar*/
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
						//imagecopyresized(dst_image, src_image, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h)
						//corte empieza desde los valores de dst_x, dst_y para imagen de destino
						//corte empieza desde los valores de src_x, src_y para imagen de origen
						//los valores de ancho y alto del destino dst_w dst_h
						//los valores de ancho y alto del origen src_w src_h
						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
						//guarda la foto $destino en la $ruta que asignamos
						imagepng($destino, $ruta);

					}

				}
				//guardaremos los datos en la tabla usuarios
				$tabla = "usuarios";
				//variable para almacenar password encriptada
				//usamos crypt de php primero el valor a encriptar y el segundo parametro sera el $salt de php
				//usamos un $salt para que sea más segura la ecnriptación
				//utilizamos el hash blowfish $2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$
				$encriptar = crypt($_POST["nuevoPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
				//le enviaremos a la tabla un array para que se guarden en las columnas de la fila
				$datos = array("nombre" => $_POST["nuevoNombre"],
					           "usuario" => $_POST["nuevoUsuario"],
					           "password" => $encriptar,
					           "perfil" => $_POST["nuevoPerfil"],
					           "metaganacia" => $_POST["nuevametaganacia"],
					           "foto"=>$ruta);
				//solicitamos una respuesta al metodo del modelo, enviamos la tabla y los datos
				$respuesta = ModeloUsuarios::mdlIngresarUsuario($tabla, $datos);
				//si regreso del modelo con un "ok" tiramos la alerta suave como exito :v
				if($respuesta == "ok"){

					echo '<script>

					swal({

						type: "success",
						title: "Usuario creado",
						text: "El usuario se creó correctamente",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"

					}).then(function(result){

						if(result.value){
						
							window.location = "usuarios";

						}

					});
				

					</script>';


				}	


			}else{
				//validamos si nos dejan campos vacíos o no cumplen los datos con el preg match
				echo '<script>

					swal({

						type: "error",
						title: "Error al crear usuario",
						text: "No se permiten caracteres especiales ni espacios vacíos",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"

					}).then(function(result){

						if(result.value){
						
							window.location = "usuarios";

						}

					});
				

				</script>';

			}


		}


	}

	/*=============================================
	MOSTRAR USUARIO
	=============================================*/
	//para mostrar usuarios en la bdd
	//enviamos los datos vacios para obtener todos los datos de la tabla
	static public function ctrMostrarUsuarios($item, $valor){

		$tabla = "usuarios";
		//conectamos con el model de mostrar usuarios para obtener la respuesta
		//le enviamos el nombre de la tabla y el item y el valor
		$respuesta = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);
		//returnamos la respuesta a la vista usuarios.php
		return $respuesta;
	}

	/*=============================================
	EDITAR USUARIO
	=============================================*/

	static public function ctrEditarUsuario(){
//validamos si existe algo en el input editarUsuario
		if(isset($_POST["editarUsuario"])){
//hacemos un preg match para no permitir caracteres especiales
			//no agararamos nickname ni password
			//pueden presentar conflictos con la carpeta de la foto de cada usuario
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"])){

				/*=============================================
				VALIDAR IMAGEN
				=============================================*/
				//mismo codigo para la foto de meter la imagen
				//la ruta cambia con la ruta actual, la ruta "vieja"
				$ruta = $_POST["fotoActual"];
				//si es una nueva foto pues hacemos lo mismo de la foto pra crear usuario
				//si el input de editarfoto trae algo ahcemos la accion de actualizar la foto 
				if(isset($_FILES["editarFoto"]["tmp_name"]) && !empty($_FILES["editarFoto"]["tmp_name"])){

					list($ancho, $alto) = getimagesize($_FILES["editarFoto"]["tmp_name"]);

					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/

					$directorio = "vistas/img/usuarios/".$_POST["editarUsuario"];

					/*=============================================
					PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
					=============================================*/
					//si trae algo la fotoactual que me la boore para hacer una nueva carpeta con la nueva foto
					if(!empty($_POST["fotoActual"])){
						//la eliminamos con unlink
						unlink($_POST["fotoActual"]);

					}else{

						mkdir($directorio, 0755);

					}	

					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

					if($_FILES["editarFoto"]["type"] == "image/jpeg"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/usuarios/".$_POST["editarUsuario"]."/".$aleatorio.".jpg";

						$origen = imagecreatefromjpeg($_FILES["editarFoto"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $ruta);

					}

					if($_FILES["editarFoto"]["type"] == "image/png"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/usuarios/".$_POST["editarUsuario"]."/".$aleatorio.".png";

						$origen = imagecreatefrompng($_FILES["editarFoto"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);

					}

				}
				//creamos variable para actualizar la tabla usuarios
				$tabla = "usuarios";
				//si tiene algo el input entonces enciptamos la contraseña
				if($_POST["editarPassword"] != ""){
					//evaluamos que no traiga caracteres especiales
					if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarPassword"])){
						//encriptamos
						$encriptar = crypt($_POST["editarPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

					}else{
						//si se falsea el preg match entonces es porque esta vacio o tiene caracteres especiales
						echo'<script>

								swal({
									  type: "error",
									  title: "Contraseña inválida",
									  text: "No se permiten caracteres especiales ni espacios vacíos",
									  showConfirmButton: true,
									  confirmButtonText: "Cerrar"
									  }).then(function(result) {
										if (result.value) {

										window.location = "usuarios";

										}
									})

						  	</script>';

					}

				}else{
					//si no se cambia la contraseña, entonces encriptamos el input para mandarlo a la bdd
					$encriptar = $_POST["passwordActual"];

				}
				//hacemos el arreglo para modificar la tabla usuarios
				$datos = array("nombre" => $_POST["editarNombre"],
							   "usuario" => $_POST["editarUsuario"],
							   "password" => $encriptar,
							   "perfil" => $_POST["editarPerfil"],
							   "metaganacia" => $_POST["editarmetaganacia"],
							   "foto" => $ruta);
				//le mandamos los parametros, la tabla que se va a modificar y los datos que se pondrán v:
				$respuesta = ModeloUsuarios::mdlEditarUsuario($tabla, $datos);
				//si la respuesta viene ok, es porque se edito el usuario
				if($respuesta == "ok"){
					//mostramos una alerta suave que hubo exito
					echo'<script>

					swal({
						  type: "success",
						  title: "Usuario editado",
						  text: "El usuario ha sido editado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
									if (result.value) {

									window.location = "usuarios";

									}
								})

					</script>';

				}


			}else{
				//si el nombre lleva caracteres especiales o vacio
				echo'<script>

					swal({
						  type: "error",
						  title: "Nombre inválido",
						  text: "No se permiten caracteres especiales ni espacios vacíos",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
							if (result.value) {

							window.location = "usuarios";

							}
						})

			  	</script>';

			}

		}

	}

	/*=============================================
	BORRAR USUARIO
	=============================================*/
//mandamos static para que no de error en php.ini de algunos servidores
	static public function ctrBorrarUsuario(){
//si por la url existe idUsuario es porque vamos a borrar datos de ese usuario con ese id
		if(isset($_GET["idUsuario"])){
			//sacamos la tabla en la que borraremos
			$tabla ="usuarios";
			//mandamos el id del usuario
			$datos = $_GET["idUsuario"];
			//si la foto viene con algo, hay algo para eliminar
			if($_GET["fotoUsuario"] != ""){
				//eliminamos la foto
				unlink($_GET["fotoUsuario"]);
				//eliminamos la carpeta y el nombre del usuario, porque las carpetas se nombran con el username
				rmdir('vistas/img/usuarios/'.$_GET["usuario"]);

			}
			//mandamos a llamar el modelo y ejecutamos la funcion de borrar usuario
			//le pasamos la tabla y los datos a evaluar
			$respuesta = ModeloUsuarios::mdlBorrarUsuario($tabla, $datos);
			//si la respuesta dio ok, es porque se elimino la fila del id seleccionado
			if($respuesta == "ok"){
				//mostramos la swal
				echo'<script>

				swal({
					  type: "success",
					  title: "Usuario borrado",
					  text: "El usuario ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then(function(result) {
								if (result.value) {

								window.location = "usuarios";

								}
							})

				</script>';

			}		

		}

	}


}
	


