<?php
	/**
	 * Created by PhpStorm.
	 * User: jom
	 * Date: 10/21/18
	 * Time: 4:50 PM
	 */
date_default_timezone_set('America/Mexico_City');

// sitio
//$sitio='tiresias';
//$sitio='dedalomx';
$sitio='mihost';

if($sitio==='tiresias'){
	define('SERVIDOR','localhost');
	define('SERVIDOR_USUARIO','root');
	define('SERVIDOR_CLAVE','lehendakari');
	define('SERVIDOR_DB','hotelesMichael');
	define('SERVIDOR_PUERTO','3306');
	define('DEBUG',"1");
	define('RUTA_SOPORTES',"hotelesMichael/");
	
	
//	error_reporting(E_ALL);
	error_reporting(0);
}else if ($sitio==='dedalomx'){
	define('SERVIDOR','localhost');
	define('SERVIDOR_USUARIO','dedalomx_cotrame');
	define('SERVIDOR_CLAVE','VcqqcQUZhlC(');
	define('SERVIDOR_DB','dedalomx_cotramex');
	define('SERVIDOR_PUERTO','3306');
	define('DEBUG',"1");
//	error_reporting(0);
	error_reporting(E_ALL);
}else if($sitio==='mihost'){
	define('SERVIDOR','localhost');
	define('SERVIDOR_USUARIO','biosf973_undp_user');
	define('SERVIDOR_CLAVE','biosf973_undp_user');
	define('SERVIDOR_DB','biosf973_undp-hoteles');
	define('SERVIDOR_PUERTO','3306');
	define('DEBUG',"0");
	define('RUTA_SOPORTES',"");
	error_reporting(E_ALL);
//	error_reporting(0);
	



}

define('NOMBRE_SITIO','Dashboard Hoteles');
define('NOMBRE_FORMULARIO','hotelesDashboard');
define('HOY', date("d-m-Y"));
define('HOY_MYSQL', date("Y-m-d"));


//define('DEBUG',"1");
//error_reporting(E_ALL);
//	error_reporting(0);
