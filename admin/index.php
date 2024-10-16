<?php
	/**
	 * Created by PhpStorm.
	 * User: jom
	 * Date: 08/07/19
	 * Time: 11:39 AM
	 */
	
	//include_once "includes/constantes.php";
	include_once "includes/conf.php";
	include_once "clases/Control.php";
	include_once("clases/Data.php");
//    use PhpOffice\PhpSpreadsheet\IOFactory;
//    use PhpOffice\PhpSpreadsheet\Spreadsheet;
//    require_once 'vendor/autoload.php';
 
	session_start();
    if (isset($_POST)) {
        if (isset($_POST['accion']) && $_POST['accion']=='salir' ) unset($_SESSION['Control']);
    }
	if (!isset($_SESSION['Control'])) {
		$_SESSION['Control']= new Control();
	}else{
		$_SESSION['Control']->hacerConexionMysql();
	}
	
	if (isset($_POST['accion']) && isset($_FILES)) {
		$_SESSION['Control']->evaluarPost($_POST, $_FILES);
	}else if (isset($_POST['accion'])) {
		$_SESSION['Control']->evaluarPost($_POST);
	}

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <title><?php echo NOMBRE_SITIO; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<!--        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">-->
<!--        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">-->
<!--        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css"></script>-->
        <link rel="stylesheet" href="css/estilos.css" >
        
        
        
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
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->
    
    <!-- popper-->
<!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>-->

    <!-- bootstrap-->
<!--    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>-->

    <!-- dataTables-->
<!--    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>-->
<!--    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>-->
    
    <!-- datePicker-->
<!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>-->
    
    <!-- jom-->
<!--    <script src="js/funciones.js"></script>-->
    </body>
</html>
