<?php
	/**
	 * Created by PhpStorm.
	 * User: jom
	 * Date: 10/21/18
	 * Time: 11:39 AM
	 */
	
	include_once "includes/conf.php";
	include_once "clases/Control.php";
	include_once("clases/Data.php");
	
	session_start();
//    if (isset($_POST)) {
//        if (isset($_POST['accion']) && $_POST['accion']=='salir' ) unset($_SESSION['Control']);
//    }

	if (!isset($_SESSION['Control'])) {
		/**
		 * @var Control
		 *
		 */
		$_SESSION['Control']= new Control(SERVIDOR,SERVIDOR_USUARIO,SERVIDOR_CLAVE,SERVIDOR_DB);
	}else{
		$_SESSION['Control']->hacerConexionMysql(SERVIDOR,SERVIDOR_USUARIO,SERVIDOR_CLAVE,SERVIDOR_DB);
	}


    if (isset($_GET)) {
//        $usuarioGet=$_GET['usuario'];
//        $nombreGet=$_GET['nombre'];
//        $tokenGet=$_GET['token'];
		$_SESSION["Control"]->evaluarGet($_GET);
    }
	
	if (isset($_POST['accion']) && isset($_FILES)) {
		$_SESSION["Control"]->evaluarPost($_POST, $_FILES);
	}else if (isset($_POST['accion'])) {
		$_SESSION["Control"]->evaluarPost($_POST);
	}

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title><?php echo NOMBRE_SITIO; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link href="css/estilosHotel.css" rel="stylesheet" type="text/css">
    
    <script>
        function resizeIframe() {
            var obj = window.frameElement;
            if (obj){
                obj.src = "http://wibik.space/proyectos/2019/sector-privado.org.mx/";
            }
            obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
        }
    </script>
    
</head>
<body>
<form action="index.php" method="post" name="<?php echo(NOMBRE_FORMULARIO); ?>" target="_self" enctype="multipart/form-data">
	<input type="hidden" name="accion" value="">
	<input type="hidden" name="subaccion" value="">
	<input type="hidden" name="item" value="">
	<input type="hidden" name="subItem" value="">
	<input type="hidden" name="permisos" value="">
	
	<?php $_SESSION["Control"]->mostrarPantalla(); ?>
</form>

<!-- jquery-->
<script src="js/jquery-3.4.1.min.js"></script>

<!-- bootstrap-->
<script src="js/bootstrap.min.js"></script>

<!-- popper-->
<script src="js/popper.min.js"></script>

<!-- jom-->
<script src="js/funciones.js"></script>



</body>
</html>
