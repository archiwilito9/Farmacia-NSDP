<?php
//clase para poner un metodo
class Conexion{
//definimos el metodo
	static public function conectar(){
/*PDO es clase php para que las conexiones a la bdd sean seguras*/
//parametros de PDO: conexion de servidor y nombre de bdd, usuario, contraseña
		$link = new PDO("mysql:host=localhost;dbname=pos",
			            "root",
			            "");
/*evaluamos la informacion d ela variable $link ejecutando exec, para que cuando
		se pongan caracteres latinos los tomemos sin errores  con la codificacion*/
		$link->exec("set names utf8");
/* returnamos la conexion */
		return $link;

	}

}