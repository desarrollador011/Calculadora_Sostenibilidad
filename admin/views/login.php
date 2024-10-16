<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="views/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="views/dist/css/adminlte.min.css">
  <!-- data tables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Hoteles Dashboard</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Login para empezar la sesión</p>

      <form action="../../index3.html" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Usuario" name="usuario">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Clave" name="clave">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
<!--            <div class="icheck-primary">-->
<!--              <input type="checkbox" id="remember">-->
<!--              <label for="remember">-->
<!--                Remember Me-->
<!--              </label>-->
<!--            </div>-->
          </div>
          <!-- /.col -->
          <div class="col-4">
              <?php
              $this->fx->ponerBoton('login',null,null,'Login',null,null,null,'btn btn-primary btn-block','0',null,null,null);
                                //ponerBoton($accion, $subaccion, $item, $etiqueta, $imagen, $anchoImagen, $altoImagen, $clase, $borde, $subitem=null,$id=null,$funcionOnClick=null)
              ?>
<!--            <button type="submit" class="btn btn-primary btn-block">Login</button>-->
          </div>
          <!-- /.col -->
        </div>
      </form>

<!--      <div class="social-auth-links text-center mb-3">-->
<!--        <p>- OR -</p>-->
<!--        <a href="#" class="btn btn-block btn-primary">-->
<!--          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook-->
<!--        </a>-->
<!--        <a href="#" class="btn btn-block btn-danger">-->
<!--          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+-->
<!--        </a>-->
<!--      </div>-->
      <!-- /.social-auth-links -->

<!--      <p class="mb-1">-->
<!--        <a href="forgot-password.html">I forgot my password</a>-->
<!--      </p>-->
<!--      <p class="mb-0">-->
<!--        <a href="register.html" class="text-center">Register a new membership</a>-->
<!--      </p>-->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="views/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="views/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="views/dist/js/adminlte.min.js"></script>
<!-- dataTables -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<!-- jom-->
<script src="js/funciones.js"></script>

</body>
</html>
