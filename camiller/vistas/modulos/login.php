<div id="back"></div>

<div class="login-box">
  
  <div class="login-logo">

    <!-- <img src="vistas/img/plantilla/Espacio-Radtek.jpg" class="img-responsive" style="padding:-30px -30px 0px 30px"> -->

  </div>

  <div class="login-box-body">

    <p class="login-box-msg">Ingresar al sistema</p>

    <form method="post">

      <div class="form-group has-feedback">

        <input type="text" class="form-control" placeholder="Usuario" name="ingUsuario" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>

      </div>

      <div class="form-group has-feedback">

        <input type="password" class="form-control" placeholder="Contraseña" name="ingPassword" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      
      </div>

      <div class="row">
       
        <div class="col-xs-12">
        <style>
          .btn-primary{
            background-color: #5FBC8F;
            width: 100%;
            border: none;
          }
          .btn-primary:hover{
            background-color: #3C966A;
          }
          a{
            color: #444;
          }
          a:hover{
            color: #646464;
          }

          .buttonAboutUs{
              color: darkgray;
              font-size: 14px;
              width: 40%;
              text-align: center;
              text-decoration: none;
              background-color: white;
              border: 1px solid #ccc;
          }

          .buttonAboutUs:hover{
            border-color: gray;
            color: gray;
          }

          .botonIr{
            text-align: center;
          }

        </style>
          <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
        
        </div>
       
        
      </div>

      <?php
//creamos un objeto llamado login con la clase ControladorUsuarios() para ejecutar el metodo ctrIngresoUsuario()
      // usamos -> para que el objeto creado ($login) ejecute el metodo de la clase sin guardar nada en alguna variable
        $login = new ControladorUsuarios();
        $login -> ctrIngresoUsuario();
      ?>

    </form>
   
  </div>

</div>



