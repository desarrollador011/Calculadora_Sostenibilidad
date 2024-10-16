<?php
/**
 * Created by PhpStorm.
 * User: jom
 * Date: 10/21/18
 * Time: 4:50 PM
 */

date_default_timezone_set('America/Mexico_City');

// sitio
$sitio='mihost';


if($sitio==='mihost'){
	define('SERVIDOR','localhost');
	define('SERVIDOR_USUARIO','root');
	define('SERVIDOR_CLAVE','');
	define('SERVIDOR_DB','');
	define('SERVIDOR_PUERTO','3306');
	define('DEBUG',"0");
//	error_reporting(E_ALL);
	error_reporting(0);
}

define('NOMBRE_SITIO','Calculadora de sustentabilidad en el sector turismo');
define('NOMBRE_FORMULARIO','hoteles');
define('HOY', date("d-m-Y"));
define('HOY_MYSQL', date("Y-m-d"));
