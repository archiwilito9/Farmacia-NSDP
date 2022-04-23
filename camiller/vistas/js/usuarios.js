/*=============================================
SUBIENDO LA FOTO DEL USUARIO
=============================================*/
//agarramos la clase del input para subir la foto de usuarios.php
//cuando cambien el input (change) ejecutamos la funcion siguiente
$(".nuevaFoto").change(function(){
//variable que almacena lo que nos trae la propiedad .files que solo funciona en input tipo file
	var imagen = this.files[0];
	
	/*=============================================
  	VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
  	=============================================*/
//con el parametro type comparamos el tipo de imagen
  	if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){
//limpiamos el input con .val("");
  		$(".nuevaFoto").val("");
//mandamos una swal para que el usuario sepa el error
  		 swal({
		      title: "Error al subir la imagen",
		      text: "La imagen debe estar en formato JPG o PNG",
		      type: "error",
		      confirmButtonText: "Cerrar"
		    });
//con el parametro size comparamos el tamaño
  	}else if(imagen["size"] > 2000000){
//si pesa mas de lo establecido limpiamos el input
  		$(".nuevaFoto").val("");
//mostramos una swal para que el usuario sepa el error
  		 swal({
		      title: "Error al subir la imagen",
		      text: "La imagen no debe pesar más de 2MB",
		      type: "error",
		      confirmButtonText: "Cerrar"
		    });

  	}else{
//creamos una variable de tipo objeto y usamos la clase FileReader para poder leer ficheros o archivos
  		var datosImagen = new FileReader;
// le colocamos el metodo readAsDataURL y como parametro le pasamos el archivo del input
  		datosImagen.readAsDataURL(imagen);
//cuando esté cargado lo codificaremos en un lenguaje base 64
  		$(datosImagen).on("load", function(event){
//creamos una ruta para la imagen y almacenamos el resultado del target del evento
  			var rutaImagen = event.target.result;
//para previsualizar la imagen, obtenemos una clase del anonymous.jpg y le pasamos la ruta nueva de la imagen al atributo src
  			$(".previsualizar").attr("src", rutaImagen);

  		})

  	}
})

/*=============================================
META DE VENDEDOR
=============================================*/

$("#nuevotipousuario").change(function(){

		var metodo = $(this).val();

		if(metodo == "Vendedor"){

			$(this).parent().parent().children('.VendedorMeta').html(

				'<br>'+

					'<div class="form-group">'+ 

				 	'<div class="input-group">'+ 

				 		'<span class="input-group-addon"><i class="fas fa-chart-pie"></i></span>'+ 

				 		// YO PUSE ESTE INPUT :V

				 		'<input type="number" name="nuevametaganacia" step="0.01" class="form-control input-lg" id="nuevoValorEfectivo" placeholder="Meta de ventas" autocomplete="off" required>'+

				 	'</div>'+

				 '</div>')

		}else{

			 $(this).parent().parent().children('.VendedorMeta').html(

			 	'')

		}

	})


/*=============================================
EDITAR META DE VENDEDOR
=============================================*/

$(".editarPerfil").change(function(){

		var metodo = $(this).val();

		if(metodo == "Vendedor"){

			$(this).parent().parent().children('.VendedorMeta').html(

				'<br>'+

					'<div class="form-group">'+ 

				 	'<div class="input-group">'+ 

				 		'<span class="input-group-addon"><i class="fas fa-chart-pie"></i></span>'+ 

				 		// YO PUSE ESTE INPUT :V

				 		'<input type="number" name="editarmetaganacia" step="0.01" class="form-control input-lg" id="editarmetaganacia" placeholder="Escriba la nueva meta de ventas" autocomplete="off" required>'+

				 	'</div>'+

				 '</div>')

		}else{

			 $(this).parent().parent().children('.VendedorMeta').html('')

		}

	})


/*=============================================
EDITAR USUARIO
=============================================*/
//cuando hagamos click en el boton de editar, que tiene la clase btnEditarUsuario dentro de las tablas con clase .tablas
//ejecutaremos una funcion
$(".tablas").on("click", ".btnEditarUsuario", function(){
//en una variable obetenemos el id, en el atributo idUsuario
//idUsuario en usuarios.php line 114 nos almacena el id de cada persona
//usamos this para decir que agarraremos el valor de "este " boton
	var idUsuario = $(this).attr("idUsuario");
//creamos la variable de ddatos
//le ponemos la clase FormData() de js
	var datos = new FormData();
	//le conctanamos a datos yna variable post y el valor sera lo que tenga la variable idUsuario
	datos.append("idUsuario", idUsuario);
//ejecutamos ajax
	$.ajax({
//pasamos la url que tiene el arhivoajax
		url:"ajax/usuarios.ajax.php",
		//colocamos el metodo post por esta trabajando con forms
		method: "POST",
		//los datos que enviaremos
		data: datos,
		//cache falso
		cache: false,
		//falso
		contentType: false,
		//falso
		processData: false,
		//enviamos datos json para trabajar a nivel de servidor
		dataType: "json",
		//si hay exito entonces hacemos una funcion que como parametro será lo que venga de la bdd
		success: function(respuesta){
			//como usamos ajax con el usuarios.modelo, nos manda una linea gracias al fetch del modelo
			//ahora en los input con un id le colocamos un valor a la propiedad value
			//mandamos los valores de la respuesta del modelo
			$("#editarNombre").val(respuesta["nombre"]);
			$("#editarUsuario").val(respuesta["usuario"]);
			$("#editarPerfil").html(respuesta["perfil"]);
			//si el perfil no semodifica se mantiene el mismo valor
			$("#editarPerfil").val(respuesta["perfil"]);
			$("#editarmetaganacia").val(respuesta["metaganacia"]);
			//si no cambiaron nada, entonces guardamos los mismos valores actuales
			$("#fotoActual").val(respuesta["foto"]);
			$("#passwordActual").val(respuesta["password"]);
			//si traemos una foto, la ruta
			if(respuesta["foto"] != ""){
				//la cajita con la clase previsualizar de usuarios.php en el atributo src mandamos la ruta de la bdd
				$(".previsualizar").attr("src", respuesta["foto"]);

			}

		}

	});

})

/*=============================================
ACTIVAR USUARIO
=============================================*/
//cuando le de click al boton con clase btnActivar
$(".tablas").on("click", ".btnActivar", function(){
//en el atributo idUsuario pues agarramos el id del usuario
	var idUsuario = $(this).attr("idUsuario");
	//en el atributo estadousuario del boton presionardo pues almacenamos el valor
	var estadoUsuario = $(this).attr("estadoUsuario");
	//creamos la variable de ddatos
//le ponemos la clase FormData() de js
	var datos = new FormData();
	//le concatenamos el id del usuario
 	datos.append("activarId", idUsuario);
 	//le concatenamos el valor del atributo estadoUsuario
  	datos.append("activarUsuario", estadoUsuario);
//ejcutamos ajax
  	$.ajax({
//pasamos la url que tiene el arhivoajax
	  url:"ajax/usuarios.ajax.php",
	  //colocamos el metodo post por esta trabajando con botones
	  method: "POST",
	  //mandamos los datos
	  data: datos,
	  //falso
	  cache: false,
	  //falso
      contentType: false,
      //falso
      processData: false,
      //si hay exito entonces hacemos una funcion que como parametro será lo que venga de la bdd
      success: function(respuesta){

      		if(window.matchMedia("(max-width:767px)").matches){

	      		 swal({
			      title: "El usuario ha sido actualizado",
			      type: "success",
			      confirmButtonText: "¡Cerrar!"
			    }).then(function(result) {
			        if (result.value) {

			        	window.location = "usuarios";

			        }


				});

	      	}

      }

  	})

  	if(estadoUsuario == 0){
//si el usuario es desactivado, entonces cambiamos de verde a rojo
  		$(this).removeClass('btn-success');
  		$(this).addClass('btn-danger');
  		$(this).html('Inactivo');
  		$(this).attr('estadoUsuario',1);

  	}else{
//si el usuario esta activado pasamos de rojo a verde
  		$(this).addClass('btn-success');
  		$(this).removeClass('btn-danger');
  		$(this).html('Activo');
  		$(this).attr('estadoUsuario',0);

  	}

})

/*=============================================
REVISAR SI EL USUARIO YA ESTÁ REGISTRADO
=============================================*/
//cuando el input de usuario al agregar usuario en el modal cambia
$("#nuevoUsuario").change(function(){
/*si ya la cagamos en poner un usuario repetido entonces al poner uno nuevo pues 
removemos las alertas para evitar que llenen las vistas de formulatio */
	$(".alert").remove();
//capturamos el usuario que se está escribiendo en el input
	var usuario = $(this).val();
//generamos una variable de datos para usar ajax

	var datos = new FormData();
	//concatenamos el valor a validarUsuario para ajax
	datos.append("validarUsuario", usuario);
//ejecutamos ajax
	 $.ajax({
	 	//pasamos la url que tiene el arhivoajax
	    url:"ajax/usuarios.ajax.php",
	    //establecemos metodo post por ser un input :v
	    method:"POST",
	    //enviamos los datos a trabajar
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    //usamos el tipo json para trabajar a nivel de servidor
	    dataType: "json",
	    success:function(respuesta){
	    	//si la respuesta dio true, y encontro algo en la bdd
	    	if(respuesta){
	    		//entonces ponemos un mensaje :v
	    		//usamos el parent para sacarlo del input y un after para que aparezca despues del inputo :v
	    		$("#nuevoUsuario").parent().after('<div class="alert alert-warning">Este usuario ya existe en la base de datos</div>');
	    		//limpiamos el valor para estetica :v
	    		$("#nuevoUsuario").val("");

	    	}

	    }

	})
})

/*=============================================
ELIMINAR USUARIO
=============================================*/
//si hacemos click en el boton con la clase btnEliminarUsuario hacemos la siguiente funcion
$(".tablas").on("click", ".btnEliminarUsuario", function(){
//creamos las variables
//les almacenamos el valor que traiga el boton en los diferentes atributos
  var idUsuario = $(this).attr("idUsuario");
  var fotoUsuario = $(this).attr("fotoUsuario");
  var usuario = $(this).attr("usuario");
//mandamos una alerta suave :V para asegurarnos
  swal({
    title: '¿Está seguro de borrar el usuario?',
    text: 'Seleccione una opción',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#6BD187',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Borrar'
      //luego nos manda un resultado
  }).then(function(result){
//validamos si el result es verdadero entonces redireccionamos con variables get
//enviamos por get, el id, la ruta de la foto para eliminarla de las carpetas
    if(result.value){

      window.location = "index.php?ruta=usuarios&idUsuario="+idUsuario+"&usuario="+usuario+"&fotoUsuario="+fotoUsuario;

    }

  })

})




