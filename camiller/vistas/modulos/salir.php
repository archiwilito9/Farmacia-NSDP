<?php
//destruimos las sesiones
session_destroy();
//redireccionamos a login
echo '<script>

	window.location = "ingreso";

</script>';