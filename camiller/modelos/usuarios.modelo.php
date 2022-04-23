<?php
//requerimos la conexion para que el modelo este conectado con nuesta bdd
require_once "conexion.php";

class ModeloUsuarios{

	/*=============================================
	MOSTRAR USUARIOS
	=============================================*/
//obetenmos los parametros
	// debido a que algunos servidores tienen un archivo .ini nos obligan a poner metodos en static
	//entonces para evitar errores ponemos static
	static public function mdlMostrarUsuarios($tabla, $item, $valor){
		//si tenemos algo en item entonces nos busca una sola fila porque comparamos con un valor
		if($item != null){
			//almacenamos la respuesta de conectar de la clase conexion 
			//prepare se usa para poner la sentencia sql. Leemos la bdd
			//leemos todas las columnas dende un dato sea igual a $item 
			//colocamos :$item que es un parametro de PDO para proteger datos
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			//enlazamos con bindParam 
			// primer parametro :, concatenamos el $item y lo comparamos con $valor colocamos PDO::PARAM_STR para
			//indicar que es un parametro tipo string
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			//ejecutamos la sentencia sql
			$stmt -> execute();
			//retornamos la setencia ql con fetch para retornar solo una linea de la tabla
			return $stmt -> fetch();
//si $item viene vacío entonces buscamos datos en toda la tabla
		}else{
			//almacenamos la respuesta de conectar de la clase conexion 
			//prepare se usa para poner la sentencia sql. Leemos la bdd

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();
		//devolvemos todas las filas de la consulta
			return $stmt -> fetchAll();

		}
		//terminamos de retornar y cerramos la conexion y la volvemos nula para que no nos almacene la sentencia anterior 

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	REGISTRO DE USUARIO
	=============================================*/
//recibimos los parametros del controlador
	static public function mdlIngresarUsuario($tabla, $datos){
//hacemos la conexion y le enviamos los datos nuevos para crear una nueva fila con los datos del array enviado
		//colocamos : que es un parametro de PDO para proteger datos
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, usuario, password, perfil, metaganacia, foto) VALUES (:nombre, :usuario, :password, :perfil, :metaganacia, :foto)");
		//enlazamos con bindParam y guardamos los valores en las columnas de la tabla
		//como son datos string usamos PDO:PARAM_STR
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt->bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
		$stmt->bindParam(":metaganacia", $datos["metaganacia"], PDO::PARAM_STR);
		$stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
		//ejecutamos la sentencia sql
		if($stmt->execute()){
			//si hubo exito retornamos "ok"
			return "ok";	

		}else{
			//si hubo algun error retornamos "error"
			return "error";
		
		}
		//cerramos conexion
		$stmt->close();
		//restablecemos la variable
		$stmt = null;

	}

	/*=============================================
	EDITAR USUARIO
	=============================================*/
//recibimos el nombre de la tabla y el array de los datos
	static public function mdlEditarUsuario($tabla, $datos){
	//hacemos la conexion y ejecutamos la sentencia sql update para actualziar
		//evaluamos con usuario para obtener la fila
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, password = :password, perfil = :perfil, metaganacia = :metaganacia, foto = :foto WHERE usuario = :usuario");
		//mandamos los datos a las columnas
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt -> bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
		$stmt -> bindParam(":metaganacia", $datos["metaganacia"], PDO::PARAM_STR);
		$stmt -> bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
		$stmt -> bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
//ejecutamos y si da exito mandamos ok a la respuesta
		if($stmt -> execute()){

			return "ok";
		
		}else{
//si hubo error mandamos un error
			return "error";	

		}
//cerramos la conexion
		$stmt -> close();
//reiniciamos la variable de conexion
		$stmt = null;

	}

	/*=============================================
	ACTUALIZAR USUARIO
	=============================================*/
//recibimos los valores de ajax
	static public function mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2){
		//hacemos la conexion y tomamos las columnas $item1 y $item2
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");
		//enlazamos los paramtros a las columnas de la bdd
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);
//ejecutamos y si da exito mandamos ok a la respuesta
		if($stmt -> execute()){

			return "ok";
		
		}else{
//si hubo error mandamos un error
			return "error";	

		}
//cerramos la conexion
		$stmt -> close();
//reiniciamos la variable de conexion
		$stmt = null;

	}

	/*=============================================
	BORRAR USUARIO
	=============================================*/
//recibimos los datos del controlador
	static public function mdlBorrarUsuario($tabla, $datos){
//hacemos la conexion y evaluaremos la tabla usuarios y la columna id
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
		//enlazamos las variables con la columna
		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);
		//ejecutamos la sentencia sql
		if($stmt -> execute()){
			//si da exito, si borra, retornamos ok para la swal al controlador
			return "ok";
		
		}else{
			//si hubo algun error, pues mandamos error :v
			return "error";	

		}
		//nos desconectamos de la bdd
		$stmt -> close();
		//reiniciamos la variable de conexion
		$stmt = null;


	}

}