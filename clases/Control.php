<?php
	/**
	 * Created by PhpStorm.
	 * User: jom
	 * Date: 10/21/18
	 * Time: 4:49 PM
	 */
	
	include_once("Data.php");
	include_once("Fx.php");
	include_once("PdfResultados.php");
	include_once("Respuestas.php");
	
	class Control
	{
		var $data;
		var $fx;
		var $pantalla="vistas/general/login.php";
		var $usuario;
		var $logueado=0;
		//var $nuevoRegistro=array();
		var $pantallaSubirEvidencia=0;
		var $idPregunta;
		// arreglos
		var $arrHoteles=array();
		var $arrTamanosHotel=array();
		var $arrestados=array();
		var $arrMunicipios=array();
		var $arrVocaciones=array();
		var $arrAlimentos=array();
		//var $arrBoleano=array();
		var $arrCuestionario=array();
		var $arrRespuestas=array();
		var $puntajeFinal;
		var $arrLeyendas=array();
		var $arrTiposHoteles=array();
		//var $grabarAlFinal=0;
		var $campoPonderacion;
		
		// evaluaciones
		var $idDefinitivoHotel;
		var $idEvaluacion;
		var $nombreHotel;
		var $estadoHotel;
		var $municipioHotel;
		var $tipoHotel;
		var $vocacionHotel;
		var $noCuartos;
		var $cuartosDisponibles;
		var $cuartosOcupados;
		var $tarifa;
		var $noHuespedes;
		var $revpar;
		var $costoCuartoOcupado;
		var $noColaboradores;
		var $porcentajeHotelero;
		var $porcentajeVacacional;
		var $porcentajeOtras;
		var $anosOperando;
		var $esCadena;
		var $comentarios;
		var $idEvaluacionTmp;
		var $arrEvaluacionesParciales=array();
		var $alimentos;
		
		var $seccionPorMostrar=2;
		var $itemSeleccionado;
		var $nombreTmpCuestionario;
		//var $idCuestionarioTmp;
		
		// pdf
		/**
		 * @var PdfResultados
		 *
		 */
		var $resultadosPdf;
		
		// soportes
		var $arrDocumentosSoporte=array();
		
		// plan
		var $planDeAccion;
		var $idHotel;
		var $resultadoPersonas='';
		var $resultadoPaz='';
		var $resultadoProsperidad='';
		var $resultadoPlaneta='';
		var $resultadoAlianzas='';
		
        var $arrAccionesPersonasPlan=array();
		var $arrAccionesPazPlan=array();
		var $arrAccionesProsperidadPlan=array();
		var $arrAccionesPlanetaPlan=array();
		var $arrAccionesAlianzasPlan=array();
		
		// temporales
		var $queryErrado;
		var $cuestionarioRazurado;
		
		
		//////////////////////
		
		function __construct($mysqlServidor, $mysqlUser, $mysqlClave, $mysqlDb)
		{
			$this->data = new Data($mysqlServidor,$mysqlUser,$mysqlClave,$mysqlDb);
			$this->fx=new Fx();
			$this->hacerArreglosIniciales();
			
			if(LLENAR_HOTEL==1) {
//				$this->nombreHotel ='Hotel Calinda';
//				$this->estadoHotel ='3';
//				$this->municipioHotel ='51';
//				$this->tipoHotel ='2';
//				$this->vocacionHotel ='1';
//				$this->noCuartos ='70';
//				$this->cuartosDisponibles ='20';
//				$this->cuartosOcupados ='80';
//				$this->tarifa ='1320.00';
//				$this->noHuespedes ='30000';
//				$this->revpar ='1234';
//				$this->costoCuartoOcupado ='800';
//				$this->noColaboradores ='40';
//				$this->porcentajeHotelero ='30';
//				$this->porcentajeVacacional ='50';
//				$this->porcentajeOtras ='20';
//				$this->anosOperando ='3';
//				$this->esCadena ='0';
			}
		}
		
		function __destruct()
		{
		
		}
		
		function hacerConexionMysql($mysqlServidor, $mysqlUser, $mysqlClave, $mysqlDb)
		{
			$this->data->hacerConexionMysql($mysqlServidor, $mysqlUser, $mysqlClave, $mysqlDb);
		}
		
		function hacerArreglosIniciales()
		{
			$this->arrTamanosHotel=$this->data->hacerArregloTamanosHotel();
			$this->arrVocaciones=$this->data->hacerArregloVocaciones();
			$this->arrAlimentos=$this->data->hacerArregloAlimentos();
			$this->arrestados=$this->data->hacerArregloEstados();
			$this->arrMunicipios=$this->data->hacerArregloMunicipios();
			$this->arrCuestionario=$this->data->hacerArregloPreguntasCompleto();
			$this->arrLeyendas=$this->data->getLeyendas();
			$this->arrTiposHoteles=$this->data->getTipos();
			$this->arrPeriodos=array();
			$this->arrPeriodos[]=array('id'=>'Corto', 'nombre'=>"Corto plazo (hasta 90 días)");
			$this->arrPeriodos[]=array('id'=>'Mediano', 'nombre'=>"Mediano plazo (hasta 180 día)");
			$this->arrPeriodos[]=array('id'=>'Largo', 'nombre'=>"Largo plazo (un año o más)");
			$this->arrRegresos=array();
			$this->arrRegresos[]=array('id'=>'2', 'nombre'=>"2");
			$this->arrRegresos[]=array('id'=>'3', 'nombre'=>"3");
			$this->arrRegresos[]=array('id'=>'4', 'nombre'=>"4");
			$this->arrRegresos[]=array('id'=>'5', 'nombre'=>"5");
			$this->arrRegresos[]=array('id'=>'6', 'nombre'=>"6");
			//$this->arrSiNo[]=array('id'=>'0', 'nombre'=>"No");
			//$this->arrSiNo[]=array('id'=>'1', 'nombre'=>"Si");
//			$this->arrBoleano[]=array('id'=>"no",'nombre'=>'No');
//			$this->arrBoleano[]=array('id'=>"si",'nombre'=>'Si');
		
		}
		
		function mostrarPantalla()
		{
			include($this->pantalla);
			
			if (DEBUG == 1) {
				include('vistas/general/debug.php');
			}
			
		}
		
		function evaluarGet($get)
		{
			if($this->logueado==false){
				if(isset($get['nombre']) && isset($get['usuario'])){
					$usuario = $this->data->validarLoginGet($get);
					if (isset($usuario['error'])) {
						$this->logueado = false;
						$this->fx->dispararAlerta($usuario['error']);
						$this->pantalla = 'vistas/errorDeUsuario.php';
					} else {
						$this->logueado = true;
						$this->usuario = $usuario;
						$this->arrHoteles = $this->data->buscarHotelesDeUsuario($this->usuario['id']);
						$this->ponerFechaHEnHotelesUsuario();
						$this->arrEvaluacionesParciales=$this->data->buscarEvaluacionesParciales($this->usuario['id']);
						$this->ponerFechaHEnEvaluacionesParciales();
						$this->hacerArreglosIniciales();
						$this->pantalla = 'vistas/inicioUsuario.php';
					}
				}else{
					$this->logueado = false;
					$this->pantalla = 'vistas/errorDeUsuario.php';
				}
			}else{
				if(isset($get['nombre']) && isset($get['usuario'])){
					if($get['nombre']!=$this->usuario['nombreGet'] || $get['usuario']!=$this->usuario['usuarioGet'] ){
						$usuario = $this->data->validarLoginGet($get);
						if (isset($usuario['error'])) {
							$this->logueado = false;
							$this->fx->dispararAlerta($usuario['error']);
							$this->pantalla = 'vistas/errorDeUsuario.php';
						} else {
							$this->logueado = true;
							$this->usuario = $usuario;
							$this->arrHoteles = $this->data->buscarHotelesDeUsuario($this->usuario['id']);
							$this->ponerFechaHEnHotelesUsuario();
							$this->hacerArreglosIniciales();
							$this->pantalla = 'vistas/inicioUsuario.php';
						}
					}
				}
			}
		}
		
		function evaluarPost($post,$files=null)
		{
			switch ($post['accion']) {
				// login y usuario
				case 'login':
					$usuario = $this->data->validarLogin($post['usuario'], $post['clave']);
					if (isset($usuario['error'])) {
						$this->logueado = false;
						$this->fx->dispararAlerta($usuario['error']);
					} else {
						$this->logueado = true;
						$this->usuario=$usuario;
						$this->arrHoteles=$this->data->buscarHotelesDeUsuario($this->usuario['id']);
						$this->ponerFechaHEnHotelesUsuario();
						$this->arrEvaluacionesParciales=$this->data->buscarEvaluacionesParciales($this->usuario['id']);
						$this->ponerFechaHEnEvaluacionesParciales();
						$this->hacerArreglosIniciales();
						$this->pantalla = 'vistas/inicioUsuario.php';
					}
					break;
				case 'registro':
					$this->pantalla = 'vistas/completarRegistro.php';
					break;
				case 'cambiarDeSeccion':
					$this->llenarDelPost($post);
					$error=$this->validarSeccionCompleta();
					if(count($error)>0){
						$texto='Faltó constestar las siguientes preguntas\\n';
						for($x=0;$x<count($error);$x++){
							$texto.=$error[$x]."\\n";
						}
						$this->fx->dispararAlerta($texto);
						$this->pantalla="vistas/cuestionarios/secciones2_6.php";
					}else{
						$cuestionarioRazurado=$this->razurarArregloParaSerializacion();
						$error=$this->data->actualizarEvaluacionTemporal($this->idEvaluacionTmp,$cuestionarioRazurado,$this->seccionPorMostrar);
						if(empty($error)){
							if(count($this->arrDocumentosSoporte)>0){
								$error=$this->acomodarArchivosSoporte();
								if(empty($error)) {
									$this->arrDocumentosSoporte=array();
									$this->seccionPorMostrar=$post['regresar'];
									$this->pantalla="vistas/cuestionarios/secciones2_6.php";
								}else{
									$this->fx->dispararAlerta($error);
									$this->pantalla="vistas/cuestionarios/secciones2_6.php";
								}
							}else{
								$this->seccionPorMostrar=$post['regresar'];
								$this->pantalla="vistas/cuestionarios/secciones2_6.php";
							}
						}else{
							$this->fx->dispararAlerta($error);
							$this->pantalla="vistas/cuestionarios/secciones2_6.php";
						}
					}
					break;
				case 'guardarSalir':
					//todo: validar completitud y grabar
					$this->llenarDelPost($post);
					$error=$this->validarSeccionCompleta();
					if(count($error)>0){
						$texto='Faltó constestar las siguientes preguntas\\n';
						for($x=0;$x<count($error);$x++){
							$texto.=$error[$x]."\\n";
						}
						$this->fx->dispararAlerta($texto);
						$this->pantalla="vistas/cuestionarios/secciones2_6.php";
					}else{
						$cuestionarioRazurado=$this->razurarArregloParaSerializacion();
						$error=$this->data->actualizarEvaluacionTemporal($this->idEvaluacionTmp,$cuestionarioRazurado,$this->seccionPorMostrar);
						if(empty($error)){
							if(count($this->arrDocumentosSoporte)>0){
								$error=$this->acomodarArchivosSoporte();
								if(empty($error)) {
									$this->arrDocumentosSoporte=array();
									$this->seccionPorMostrar=2;
									$this->arrEvaluacionesParciales=$this->data->buscarEvaluacionesParciales($this->usuario['id']);
									$this->ponerFechaHEnEvaluacionesParciales();
									$this->pantalla = 'vistas/inicioUsuario.php';
								}else{
									$this->fx->dispararAlerta($error);
									$this->pantalla="vistas/cuestionarios/secciones2_6.php";
								}
							}else{
								$this->seccionPorMostrar=2;
								$this->arrEvaluacionesParciales=$this->data->buscarEvaluacionesParciales($this->usuario['id']);
								$this->ponerFechaHEnEvaluacionesParciales();
								$this->pantalla = 'vistas/inicioUsuario.php';
							}
						}else{
							$this->fx->dispararAlerta($error);
							$this->pantalla="vistas/cuestionarios/secciones2_6.php";
						}
					}
					break;
				case 'completarRegistro':
					$insercion=$this->data->agregarUsuario($post['nombres'],$post['paterno'],$post['materno'],$post['cadena'],$post['usuarioReg'],$post['claveReg']);
					if(isset($insercion['error'])){
						$this->fx->dispararAlerta($insercion['error']);
						$this->pantalla = 'vistas/general/login.php';
					}else{
						$this->usuario = $this->data->getUsuario($insercion['idInsertado']);
						$this->arrHoteles=$this->data->buscarHotelesDeUsuario($this->usuario['id']);
						$this->ponerFechaHEnHotelesUsuario();
						$this->pantalla = 'vistas/inicioUsuario.php';
					}
					break;
				case 'agregarCuestionario':
					$this->idDefinitivoHotel='nuevo';
					$this->idEvaluacion='nueva';
					$this->inicializarHotel();
					$this->seccionPorMostrar=1;
					$this->arrCuestionario=$this->data->hacerArregloPreguntasCompleto();
					$this->pantalla = 'vistas/cuestionarios/seccion1.php';
					$this->arrDocumentosSoporte=array();
					break;
				case 'ponerSiguienteSeccion':
					if($this->seccionPorMostrar==1){
						$this->llenarDelPostSeccion1($post);
						$error=$this->validarSeccion1Completa();
						if($error!="0") {
							$this->fx->dispararAlerta($error);
							$this->pantalla = 'vistas/cuestionarios/seccion1.php';
						}else{
							$this->campoPonderacion=$this->definirCamposPonderacion();
							if(substr($this->campoPonderacion,0,6)=='valor_'){
								$this->recabarPonderaciones($this->campoPonderacion);
								$idInsertado=$this->data->incializarAutoevaluacion($this->usuario['id'],$this->idDefinitivoHotel, $this->nombreHotel, $this->estadoHotel, $this->municipioHotel, $this->tipoHotel,
									$this->vocacionHotel,$this->noCuartos, $this->cuartosDisponibles, $this->cuartosOcupados, $this->tarifa, $this->noHuespedes, $this->revpar,
									$this->costoCuartoOcupado, $this->noColaboradores, $this->anosOperando, $this->porcentajeHotelero,
									$this->porcentajeVacacional, $this->porcentajeOtras, $this->esCadena, $this->alimentos);
								if(substr($idInsertado,0,5)=='Error'){
									$this->idEvaluacionTmp='';
									$this->fx->dispararAlerta($idInsertado);
									$this->pantalla = 'vistas/cuestionarios/seccion1.php';
								}else{
									$this->idEvaluacionTmp=$idInsertado;
									$this->seccionPorMostrar=2;
									$this->pantalla="vistas/cuestionarios/secciones2_6.php";
								}
							}else{
								$this->fx->dispararAlerta($this->campoPonderacion);
								$this->pantalla = 'vistas/cuestionarios/seccion1.php';
							}
						}
					}else{
						$this->llenarDelPost($post);
						$error=$this->validarSeccionCompleta();
						if(count($error)>0){
							$texto='Faltó constestar las siguientes preguntas\\n';
							for($x=0;$x<count($error);$x++){
								$texto.=$error[$x]."\\n";
							}
							$this->fx->dispararAlerta($texto);
							$this->pantalla="vistas/cuestionarios/secciones2_6.php";
						}else{
							$cuestionarioRazurado=$this->razurarArregloParaSerializacion();
							$error=$this->data->actualizarEvaluacionTemporal($this->idEvaluacionTmp,$cuestionarioRazurado,$this->seccionPorMostrar);
							if(empty($error)){
								if(count($this->arrDocumentosSoporte)>0){
									$error=$this->acomodarArchivosSoporte();
									if(empty($error)) {
										$this->arrDocumentosSoporte=array();
										$this->seccionPorMostrar+=1;
										$this->pantalla="vistas/cuestionarios/secciones2_6.php";
									}else{
										$this->fx->dispararAlerta($error);
										$this->pantalla="vistas/cuestionarios/secciones2_6.php";
									}
								}else{
									$this->seccionPorMostrar+=1;
									$this->pantalla="vistas/cuestionarios/secciones2_6.php";
								}
							}else{
								$this->fx->dispararAlerta($error);
								$this->pantalla="vistas/cuestionarios/secciones2_6.php";
							}
						}
					}
					break;
				case 'ponerSeccion2':
					$this->seccionPorMostrar=2;
					break;
				case 'abrirAyuda':
					$this->llenarDelPostSeccion1($post);
					$cachos=explode('_',$post['subaccion']);
					$leyenda=$this->arrCuestionario[$cachos['0']]['temas'][$cachos['1']]['preguntas'][$cachos['2']]['ayuda'];
					$this->fx->dispararAlerta($leyenda);
					break;
				case 'subirEvidencia':
					$this->llenarDelPost($post);
					$cachos=explode('_',$post['subaccion']);
					$this->idPregunta=$this->arrCuestionario[$cachos['0']]['temas'][$cachos['1']]['preguntas'][$cachos['2']]['id'];
					$this->pantallaSubirEvidencia=1;
					break;
				case 'cancelarSubirEvidencia':
					$this->pantallaSubirEvidencia=0;
					break;
				case 'agregarArchivoSoporte':
					$error=$this->subirArchivoSoporte($post,$files);
					if(!empty($error)){
						$this->fx->dispararAlerta($error);
					}
					$this->pantallaSubirEvidencia=0;
					break;
				case 'actualizarEstado':
					$post['municipios']='';
					$this->llenarDelPostSeccion1($post);
					$this->municipioHotel='Seleccione';
					break;
				
					
				case 'nuevaEvaluacion':
					$this->idDefinitivoHotel=$post['item'];
					$this->idEvaluacion='nueva';
					$this->inicializarHotel();
					$arrDatosHotel=$this->data->buscarHotel($this->idDefinitivoHotel);
					
					$this->nombreHotel=$arrDatosHotel['nombreHotel'];
					$this->estadoHotel=$arrDatosHotel['estadoHotel'];
					$this->municipioHotel=$arrDatosHotel['municipioHotel'];
					$this->tipoHotel=$arrDatosHotel['tipoHotel'];
					$this->vocacionHotel=$arrDatosHotel['vocacion'];
					$this->noCuartos=$arrDatosHotel['noCuartos'];
					$this->cuartosDisponibles=$arrDatosHotel['cuartosDisponibles'];
					$this->cuartosOcupados=$arrDatosHotel['cuartosOcupados'];
					$this->tarifa=$arrDatosHotel['tarifa'];
					$this->noHuespedes=$arrDatosHotel['noHuespedes'];
					$this->revpar=$arrDatosHotel['revpar'];
					$this->costoCuartoOcupado=$arrDatosHotel['costoCuartoOcupado'];
					$this->noColaboradores=$arrDatosHotel['noColaboradores'];
					$this->porcentajeHotelero=$arrDatosHotel['porcentajeHotelero'];
					$this->porcentajeVacacional=$arrDatosHotel['porcentajeVacacional'];
					$this->porcentajeOtras=$arrDatosHotel['porcentajeOtras'];
					$this->anosOperando=$arrDatosHotel['anosOperando'];
					$this->esCadena=$arrDatosHotel['esCadena'];
					$this->idHotel=$arrDatosHotel['id'];
					
					$this->arrCuestionario=$this->data->hacerArregloPreguntasCompleto();
					
					$this->seccionPorMostrar=1;
					$this->pantalla = 'vistas/cuestionarios/seccion1.php';
					$this->arrDocumentosSoporte=array();
					
					
					break;
				// plan de accion
				case 'hacerPlanAccion':
					$this->resultadoPersonas='';
					$this->resultadoPaz='';
					$this->resultadoProsperidad='';
					$this->resultadoPlaneta='';
					$this->resultadoAlianzas='';

					$this->arrAccionesPersonasPlan=array();
					$this->arrAccionesPazPlan=array();
					$this->arrAccionesProsperidadPlan=array();
					$this->arrAccionesPlanetaPlan=array();
					$this->arrAccionesAlianzasPlan=array();
					$this->arrAccionesPersonasPlan[]=array('accion'=>'','indicador'=>'','responsable'=>'','fecha'=>'');
					$this->arrAccionesPazPlan[]=array('accion'=>'','indicador'=>'','responsable'=>'','fecha'=>'');
					$this->arrAccionesProsperidadPlan[]=array('accion'=>'','indicador'=>'','responsable'=>'','fecha'=>'');
					$this->arrAccionesPlanetaPlan[]=array('accion'=>'','indicador'=>'','responsable'=>'','fecha'=>'');
					$this->arrAccionesAlianzasPlan[]=array('accion'=>'','indicador'=>'','responsable'=>'','fecha'=>'');
					
//					$this->resultadoPersonas='personas';
//					$this->resultadoPaz='paz';
//					$this->resultadoProsperidad='prosp';
//					$this->resultadoPlaneta='planeta';
//					$this->resultadoAlianzas='alianzas';
//
//					$this->arrAccionesPersonasPlan=array();
//					$this->arrAccionesPazPlan=array();
//					$this->arrAccionesProsperidadPlan=array();
//					$this->arrAccionesPlanetaPlan=array();
//					$this->arrAccionesAlianzasPlan=array();
//					$this->arrAccionesPersonasPlan[]=array('accion'=>'personas1','indicador'=>'1','responsable'=>'2','fecha'=>'3');
//					$this->arrAccionesPazPlan[]=array('accion'=>'paz1','indicador'=>'4','responsable'=>'5','fecha'=>'6');
//					$this->arrAccionesPazPlan[]=array('accion'=>'paz2','indicador'=>'7','responsable'=>'8','fecha'=>'9');
//					$this->arrAccionesProsperidadPlan[]=array('accion'=>'prosp1','indicador'=>'10','responsable'=>'11','fecha'=>'12');
//					$this->arrAccionesPlanetaPlan[]=array('accion'=>'planeta1','indicador'=>'13','responsable'=>'14','fecha'=>'15');
//					$this->arrAccionesAlianzasPlan[]=array('accion'=>'alianzas1','indicador'=>'16','responsable'=>'17','fecha'=>'18');
					
					
					
					$this->pantalla = 'vistas/cuestionarios/plan.php';
					break;
				case 'agregarAccionPersona':
					$this->actualizarPostPlanDeAccion($post);
					$this->arrAccionesPersonasPlan[]=array('accion'=>'','indicador'=>'','responsable'=>'','fecha'=>'');
					break;
				case 'quitarAccionPersona':
					$this->actualizarPostPlanDeAccion($post);
					$arrTmp=array();
					$ultimo=count($this->arrAccionesPersonasPlan)-1;
					for($x=0;$x<$ultimo;$x++){
						$arrTmp[]=$this->arrAccionesPersonasPlan[$x];
					}
					$this->arrAccionesPersonasPlan=$arrTmp;
					break;
				case 'agregarAccionPaz':
					$this->actualizarPostPlanDeAccion($post);
					$this->arrAccionesPazPlan[]=array('accion'=>'','indicador'=>'','responsable'=>'','fecha'=>'');
					break;
				case 'quitarAccionPaz':
					$this->actualizarPostPlanDeAccion($post);
					$arrTmp=array();
					$ultimo=count($this->arrAccionesPazPlan)-1;
					for($x=0;$x<$ultimo;$x++){
						$arrTmp[]=$this->arrAccionesPazPlan[$x];
					}
					$this->arrAccionesPazPlan=$arrTmp;
					break;
				case 'agregarAccionProsperidad':
					$this->actualizarPostPlanDeAccion($post);
					$this->arrAccionesProsperidadPlan[]=array('accion'=>'','indicador'=>'','responsable'=>'','fecha'=>'');
					break;
				case 'quitarAccionProsperidad':
					$this->actualizarPostPlanDeAccion($post);
					$arrTmp=array();
					$ultimo=count($this->arrAccionesProsperidadPlan)-1;
					for($x=0;$x<$ultimo;$x++){
						$arrTmp[]=$this->arrAccionesProsperidadPlan[$x];
					}
					$this->arrAccionesProsperidadPlan=$arrTmp;
					break;
				case 'agregarAccionPlaneta':
					$this->actualizarPostPlanDeAccion($post);
					$this->arrAccionesPlanetaPlan[]=array('accion'=>'','indicador'=>'','responsable'=>'','fecha'=>'');
					break;
				case 'quitarAccionPlaneta':
					$this->actualizarPostPlanDeAccion($post);
					$arrTmp=array();
					$ultimo=count($this->arrAccionesPlanetaPlan)-1;
					for($x=0;$x<$ultimo;$x++){
						$arrTmp[]=$this->arrAccionesPlanetaPlan[$x];
					}
					$this->arrAccionesPlanetaPlan=$arrTmp;
					break;
				case 'agregarAccionAlianzas':
					$this->actualizarPostPlanDeAccion($post);
					$this->arrAccionesAlianzasPlan[]=array('accion'=>'','indicador'=>'','responsable'=>'','fecha'=>'');
					break;
				case 'quitarAccionAlianzas':
					$this->actualizarPostPlanDeAccion($post);
					$arrTmp=array();
					$ultimo=count($this->arrAccionesAlianzasPlan)-1;
					for($x=0;$x<$ultimo;$x++){
						$arrTmp[]=$this->arrAccionesAlianzasPlan[$x];
					}
					$this->arrAccionesAlianzasPlan=$arrTmp;
					break;
				case 'grabarPlan':
					$this->actualizarPostPlanDeAccion($post);
					$error=$this->data->grabarPlan(
						$this->idDefinitivoHotel,
						$this->idEvaluacion,
						$this->resultadoPersonas,
						$this->resultadoPaz,
						$this->resultadoProsperidad,
						$this->resultadoPlaneta,
						$this->resultadoAlianzas,
						$this->arrAccionesPersonasPlan,
						$this->arrAccionesPazPlan,
						$this->arrAccionesProsperidadPlan,
						$this->arrAccionesPlanetaPlan,
						$this->arrAccionesAlianzasPlan);
					if(empty($error)){
						$this->fx->dispararAlerta("El plan se grabo correctamente");
						$this->arrHoteles = $this->data->buscarHotelesDeUsuario($this->usuario['id']);
						$this->ponerFechaHEnHotelesUsuario();
						$this->pantalla="vistas/inicioUsuario.php";
					}else{
						$this->fx->dispararAlerta($error);
					}
					break;
				case 'traerPlan':
					$this->planDeAccion=$this->data->traerPlan($post['item']);
					$this->pantalla="vistas/cuestionarios/revisarPlan.php";
					break;
				case'irAInicio':
					$this->pantalla="vistas/inicioUsuario.php";
					break;
					
				// calculo
				case 'grabarCuestionario':
					$this->llenarDelPost($post);
					$error=$this->validarSeccionCompleta();
					if(count($error)>0){
						$texto='Faltó constestar las siguientes preguntas\\n';
						for($x=0;$x<count($error);$x++){
							$texto.=$error[$x]."\\n";
						}
						$this->fx->dispararAlerta($texto);
						$this->pantalla="vistas/cuestionarios/secciones2_6.php";
					}else{ // sin error en validar completitud
						if(count($this->arrDocumentosSoporte)>0){
							$error=$this->acomodarArchivosSoporte();
							if(!empty($error)) {
								$this->fx->dispararAlerta($error);
								$this->pantalla="vistas/cuestionarios/secciones2_6.php";
								$seguir=0;
							}else{
								$this->arrDocumentosSoporte=array();
								$seguir=1;
							}
						}else{
							$seguir=1;
						}
						if($seguir==1) {
							$cuestionarioRazurado=$this->razurarArregloParaSerializacion();
							$error = $this->data->actualizarEvaluacionTemporal($this->idEvaluacionTmp, $cuestionarioRazurado, $this->seccionPorMostrar);
							if (empty($error)) {
								if($this->idDefinitivoHotel=='nuevo' || $this->idDefinitivoHotel=='0'){
									$idInsertado = $this->data->inicializarHotelDefinitivo($this->idEvaluacionTmp);
									if (substr($idInsertado, 0, 5) == "Error") {
										$this->fx->dispararAlerta($idInsertado);
									} else {
										$this->arrRespuestas = $this->calcularRespuestas();
										$respuestasRazuradas=$this->razurarRespuestas();
										$error = $this->data->grabarEvaluacion($idInsertado, $this->idEvaluacionTmp, $respuestasRazuradas,$post['comentarios'],$this->puntajeFinal);
										if ($error>0) {
											$this->idDefinitivoHotel=$error;
											if (count($this->arrDocumentosSoporte) > 0) {
												$error = $this->acomodarArchivosSoporte();
												if (!empty($error)) {
													$this->fx->dispararAlerta($error);
													$this->pantalla = "vistas/cuestionarios/secciones2_6.php";
												}
											} else {
												$this->pantalla = "vistas/cuestionarios/resultados.php";
											}
										} else {
											$this->fx->dispararAlerta($error);
										}
									}
								}else{
									$this->arrRespuestas = $this->calcularRespuestas();
									$respuestasRazuradas=$this->razurarRespuestas();
									$error = $this->data->grabarEvaluacion($this->idDefinitivoHotel, $this->idEvaluacionTmp, $respuestasRazuradas,$post['comentarios'],$this->puntajeFinal);
									if ($error>0) {
										$this->idEvaluacion=$error;
										if (count($this->arrDocumentosSoporte) > 0) {
											$error = $this->acomodarArchivosSoporte();
											if (!empty($error)) {
												$this->fx->dispararAlerta($error);
												$this->pantalla = "vistas/cuestionarios/secciones2_6.php";
											}
										} else {
											$this->pantalla = "vistas/cuestionarios/resultados.php";
										}
									} else {
										$this->fx->dispararAlerta($error);
									}
								}
							} else { // de actualizar evaluacion temporal
								$this->fx->dispararAlerta($error);
								$this->pantalla = "vistas/cuestionarios/secciones2_6.php";
							}
						}
					}
					break;
				case 'llenarValores':
					$this->llenarDelPost($post);
					$this->llenarRespuestasBorrar();
					break;
				case 'llenarAlgunosValores':
					$this->llenarDelPost($post);
					$this->llenarAlgunasRespuestasBarras();
					break;
				case 'regresar':
					$this->arrHoteles=$this->data->buscarHotelesDeUsuario($this->usuario['id']);
					$this->ponerFechaHEnHotelesUsuario();
					$this->arrEvaluacionesParciales=$this->data->buscarEvaluacionesParciales($this->usuario['id']);
					$this->ponerFechaHEnEvaluacionesParciales();
					$this->seccionPorMostrar=1;
					$this->pantalla = 'vistas/inicioUsuario.php';
					break;
				case 'reiniciar':
					$this->seccionPorMostrar=1;
					$this->arrHoteles=$this->data->buscarHotelesDeUsuario($this->usuario['id']);
					$this->ponerFechaHEnHotelesUsuario();
					$this->arrEvaluacionesParciales=$this->data->buscarEvaluacionesParciales($this->usuario['id']);
					$this->ponerFechaHEnEvaluacionesParciales();
					$this->pantalla = 'vistas/inicioUsuario.php';
					break;
				case 'regresarAResultados':
					$this->pantalla = 'vistas/cuestionarios/resultados.php';
					break;
				case 'ensenarResultadosParticulares':
					$this->itemSeleccionado=$post['item'];
					$this->pantalla = 'vistas/cuestionarios/resultadosSeccion.php';
					break;
					
				// recargar cuestionarios
				case 'traerCuestionario':
					$this->idEvaluacion=$post['item'];
					$this->cargarCuestionario($this->idEvaluacion);
					//$this->arrRespuestas=$this->calcularRespuestas();
					$this->pantalla="vistas/cuestionarios/resultados.php";
					break;
				case 'traerCuestionarioParcial':
					$this->idEvaluacionTmp=$post['item'];
					$datosParciales=$this->data->traerCuestionarioParcial($this->idEvaluacionTmp);
					$this->idDefinitivoHotel=$datosParciales['idHotel'];
					
					// todo: unserialize resuelto
					$arrTmp=unserialize($datosParciales['arregloSerializado']);
					$this->arrCuestionario=$this->reconstruirArregloDeSerializacion($arrTmp);
					
					$this->seccionPorMostrar=$datosParciales['ultimaSeccionLlenada']+1;
					$this->pantalla="vistas/cuestionarios/secciones2_6.php";
					break;
					
				// pdf
				case 'hacerReporte':
					$this->hacerPdfReporte();
					break;
				case 'descargarRespuesta':
					$this->idEvaluacion=$post['item'];
					//$this->idEvaluacion=$post['item'];
					$arrTmp=$this->cargarCuestionarioPdf($this->idEvaluacion);
					
					$this->hacerPdfRespuesta($arrTmp);
					break;
					
				// borrar
				case 'razurarCuestionario':
					$this->cuestionarioRazurado=$this->razurarArregloParaSerializacion();
					break;
				case 'reconstruirCuestionario':
					$cuestionarioReconstruido=$this->reconstruirArregloDeSerializacion();
					break;
			}
		}
		
		// calculo
		
		function inicializarHotel()
		{
			$this->nombreHotel='';
			$this->estadoHotel='';
			$this->municipioHotel='';
			$this->tipoHotel='';
			$this->vocacionHotel='';
			$this->noCuartos='';
			$this->cuartosDisponibles='';
			$this->cuartosOcupados='';
			$this->tarifa='';
			$this->noHuespedes='';
			$this->revpar='';
			$this->costoCuartoOcupado='';
			$this->noColaboradores='';
			$this->porcentajeHotelero='';
			$this->porcentajeVacacional='';
			$this->porcentajeOtras='';
			$this->anosOperando='';
			$this->esCadena='';
			$this->idHotel='';
			
		}
		
		function normalizarResultados()
		{
			for($x=0;$x<count($this->arrRespuestas);$x++){
				if($this->arrRespuestas[$x]['totalObtenido']>$this->arrRespuestas[$x]['totalPosible']) $this->arrRespuestas[$x]['totalObtenido']=$this->arrRespuestas[$x]['totalPosible'];
			}
		}
		
		function calcularPuntajeFinal()
		{
			$totalObtenido=0;
			$totalPosible=0;
			for($x=0;$x<count($this->arrRespuestas);$x++){
				$totalObtenido+=$this->arrRespuestas[$x]['totalObtenido'];
				$totalPosible+=$this->arrRespuestas[$x]['totalPosible'];
			}
			//$resultado=
		}
		
		function definirCamposPonderacion()
		{
			$idTamano='';
			for($x=count($this->arrTamanosHotel)-1;$x>=0;$x--){
				if($this->noCuartos>=$this->arrTamanosHotel[$x]['minimo']){
					$idTamano=$this->arrTamanosHotel[$x]['id'];
					break;
				}
			}
			if(!empty($idTamano)) {
				$nombreCampo = "valor_" . $this->tipoHotel . "_" . $idTamano . "_" . $this->vocacionHotel . "_" . $this->esCadena;
			}else{
				$nombreCampo="No se anotaron los datos necesarios para efectuar el calculo.";
			}
			return($nombreCampo);
		}
		
		function recabarPonderaciones($campoPonderacion)
		{
			$ponderacionesTemas=$this->data->traerPonderacionesTemas($campoPonderacion);
			$ponderacionesPreguntas=$this->data->traerPonderacionesPreguntas($campoPonderacion);
			
			$this->integrarPonderacionTema($ponderacionesTemas);
			$this->integrarPonderacionPregunta($ponderacionesPreguntas);
		}
		
		function integrarPonderacionPregunta($ponderacionesPreguntas){
			for($x=0;$x<count($this->arrCuestionario);$x++){
				for($y=0;$y<count($this->arrCuestionario[$x]['temas']);$y++){
					for($z=0;$z<count($this->arrCuestionario[$x]['temas'][$y]['preguntas']);$z++){
						for($h=0;$h<count($ponderacionesPreguntas);$h++) {
							if($ponderacionesPreguntas[$h]['id']==$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['id']){
								$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['ponderacion']=$ponderacionesPreguntas[$h]['ponderacion'];
								break;
							}
						}
					}
				}
			}
		}
		
		function integrarPonderacionTema($ponderacionesTemas)
		{
				for($x=0;$x<count($this->arrCuestionario);$x++){
					for($y=0;$y<count($this->arrCuestionario[$x]['temas']);$y++){
						for($h=0;$h<count($ponderacionesTemas);$h++) {
							if($ponderacionesTemas[$h]['id']==$this->arrCuestionario[$x]['temas'][$y]['id']){
								$this->arrCuestionario[$x]['temas'][$y]['ponderacion']=$ponderacionesTemas[$h]['ponderacion'];
								break;
							}
						}
					}
				}
		}
		
		function revisarCompletitud()
		{
			$correcto=1;
			for($x=0;$x<count($this->arrCuestionario);$x++) {
				for ($y = 0; $y < count($this->arrCuestionario[$x]['temas']); $y++) {
					for ($z = 0; $z < count($this->arrCuestionario[$x]['temas'][$y]['preguntas']); $z++) {
						if($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['tipo']=='radioButton') {
							if ($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['idRespuestaUsuario'] < 1) $correcto = 0;
						}
					}
				}
			}
			return($correcto);
		}
		
		function llenarRespuestasBorrar()
		{
			for($x=0;$x<count($this->arrCuestionario);$x++){
				$totalPreguntas=0;
				$totalContestada=0;
				for($y=0;$y<count($this->arrCuestionario[$x]['temas']);$y++){
					$cuantas=(count($this->arrCuestionario[$x]['temas'][$y]['preguntas'])-1);
					$cuantasContestadas=$cuantas;
					$totalPreguntas+=$cuantas;
					$totalContestada+=$cuantasContestadas;
					for($z=0;$z<count($this->arrCuestionario[$x]['temas'][$y]['preguntas']);$z++){
						if($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['tipo']=='radioButton') {
							$cuantas2 = count($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas']) - 1;
							$cual = rand(0, $cuantas2);
							$id = $this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas'][$cual]['id'];
							$valor = $this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas'][$cual]['valorPonderado'];
							$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['idRespuestaUsuario'] = $id;
							$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['valorRespuestaUsuario'] = $valor;
						}
					}
				}
				$porcentaje=$totalContestada/$totalPreguntas*100;
				$this->arrCuestionario[$x]['porcentajeContestado']=number_format($porcentaje,0);
				
			}
		}
		
		function llenarAlgunasRespuestasBarras()
		{
			for($x=0;$x<count($this->arrCuestionario);$x++){
				$totalPreguntas=0;
				$totalContestada=0;
				for($y=0;$y<count($this->arrCuestionario[$x]['temas']);$y++){
					$cuantas=(count($this->arrCuestionario[$x]['temas'][$y]['preguntas'])-1);
					$cuantasContestadas=rand(0,$cuantas);
					$totalPreguntas+=$cuantas;
					$totalContestada+=$cuantasContestadas;
					for($z=0;$z<$cuantasContestadas;$z++){
						$cuantas2=count($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas'])-1;
						$cual=rand(0,$cuantas2);
						$id=$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas'][$cual]['id'];
						$valor=$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas'][$cual]['valorPonderado'];
						$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['idRespuestaUsuario']=$id;
						$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['valorRespuestaUsuario']=$valor;
					}
				}
				$porcentaje=$totalContestada/$totalPreguntas*100;
				$this->arrCuestionario[$x]['porcentajeContestado']=number_format($porcentaje,0);
			}
		}
		
		function llenarDelPostSeccion1($post)
		{
			if (isset($post['nombre'])) $this->nombreHotel = $post['nombre'];
			if (isset($post['estados'])) $this->estadoHotel = $post['estados'];
			if (isset($post['municipios'])) $this->municipioHotel = $post['municipios'];
			if (isset($post['tipo'])) $this->tipoHotel = $post['tipo'];
			if (isset($post['noCuartos'])) $this->noCuartos = $post['noCuartos'];
			if (isset($post['vocacion'])) $this->vocacionHotel = $post['vocacion'];
			if (isset($post['cuartosDisponibles'])) $this->cuartosDisponibles = $post['cuartosDisponibles'];
			if (isset($post['cuartosOcupados'])) $this->cuartosOcupados = $post['cuartosOcupados'];
			if (isset($post['tarifa'])) $this->tarifa = $post['tarifa'];
			if (isset($post['noHuespedes'])) $this->noHuespedes = $post['noHuespedes'];
			if (isset($post['revpar'])) $this->revpar = $post['revpar'];
			if (isset($post['costoCuartoOcupado'])) $this->costoCuartoOcupado = $post['costoCuartoOcupado'];
			if (isset($post['noColaboradores'])) $this->noColaboradores = $post['noColaboradores'];
			if (isset($post['anosOperando'])) $this->anosOperando = $post['anosOperando'];
			if (isset($post['porcentajeHotelero'])) $this->porcentajeHotelero = $post['porcentajeHotelero'];
			if (isset($post['porcentajeVacacional'])) $this->porcentajeVacacional = $post['porcentajeVacacional'];
			if (isset($post['porcentajeOtras'])) $this->porcentajeOtras = $post['porcentajeOtras'];
			if (isset($post['cadena'])) $this->esCadena = $post['cadena'];
			if (isset($post['alimentos'])) $this->alimentos = $post['alimentos'];
		}
		
		function validarSeccion1Completa()
		{
			$error=0;
			if(empty($this->nombreHotel)) $error=1;
			if($this->estadoHotel=='Seleccione') $error=1;
			if($this->municipioHotel=='Seleccione') $error=1;
			if($this->tipoHotel=='Seleccione') $error=1;
			if($this->vocacionHotel=='Seleccione') $error=1;
			if($this->alimentos=='Seleccione') $error=1;
			if(empty($this->noCuartos) || $this->noCuartos<1) $error=1;
			if(empty($this->cuartosDisponibles) || $this->cuartosDisponibles<1) $error=1;
			if(empty($this->cuartosOcupados) || $this->cuartosOcupados<1) $error=1;
			if(empty($this->tarifa) || $this->tarifa<1) $error=1;
			if(empty($this->noHuespedes) || $this->noHuespedes<1) $error=1;
			if(empty($this->revpar)) $error=1;
			if(empty($this->costoCuartoOcupado) || $this->costoCuartoOcupado<1) $error=1;
			if(empty($this->noColaboradores) || $this->noColaboradores<1) $error=1;
			if(empty($this->anosOperando) || $this->anosOperando<1) $error=1;
			
			if($this->porcentajeHotelero<0) {
				$error=1;
			}else if($this->porcentajeVacacional<0) {
				$error=1;
			}else if($this->porcentajeOtras<0) {
				$error=1;
			}else if($this->porcentajeHotelero+$this->porcentajeVacacional+$this->porcentajeOtras!=100){
				$error=1;
			}
		
			
			if($this->esCadena !=0 && $this->esCadena !=1) $error=1;
			
			if($error==1) $error="Falto anotar uno de los datoso necesarios para hacer los cálculos. Por favor revise el formulario.";
			return($error);
		}
		
		function validarSeccionCompleta()
		{
			$error=array();
			for($x=0;$x<count($this->arrCuestionario);$x++) {
				$seccionAValidar=$this->seccionPorMostrar-1;
				if ($this->arrCuestionario[$x]['id'] == $seccionAValidar) {
					for ($y = 0; $y < count($this->arrCuestionario[$x]['temas']); $y++) {
						for ($z = 0; $z < count($this->arrCuestionario[$x]['temas'][$y]['preguntas']); $z++) {
							 if($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['tipo']=='checkBoxes'){
							 
							 }else if($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['tipo']=='radioButton'){
								if($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['idRespuestaUsuario']==''){
									$error[]=$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['nombre'];
								}
							 }else if($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['tipo']=='calculo'){
								if($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas']['2']['respuestaAnotada']!=1){
									if($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas']['0']['respuestaAnotada']<1 || $this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas']['1']['respuestaAnotada']<1){
										$error[]=$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['nombre'];
									}
								}
							 }else if($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['tipo']=='numero'){
								 if(empty($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['idRespuestaUsuario']) && $this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['idRespuestaUsuario'] != 0){
								//if(empty($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['idRespuestaUsuario'])){
									$error[]=$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['nombre'];
								}
							 }
						}
					}
				}
			}
			return($error);
		}
		
		function llenarDelPost($post)
		{
			foreach ($post as $key=>$value){
				if(substr($key,0,5)=="input"){
					$cachos=explode("_",$key);
					$categoria=$cachos['1'];
					$tema=$cachos['2'];
					$pregunta=$cachos['3'];
					if($this->arrCuestionario[$categoria]['temas'][$tema]['preguntas'][$pregunta]['tipo']=="booleano"){
						for ($x = 0; $x < count($this->arrCuestionario[$categoria]['temas'][$tema]['preguntas'][$pregunta]['respuestas']); $x++) {
							if ($this->arrCuestionario[$categoria]['temas'][$tema]['preguntas'][$pregunta]['respuestas'][$x]['nombre'] == $value) {
								$id = $this->arrCuestionario[$categoria]['temas'][$tema]['preguntas'][$pregunta]['respuestas'][$x]['nombre'];
								$valorPonderado = $this->arrCuestionario[$categoria]['temas'][$tema]['preguntas'][$pregunta]['respuestas'][$x]['valorPonderado'];
								$this->arrCuestionario[$categoria]['temas'][$tema]['preguntas'][$pregunta]['idRespuestaUsuario'] = $id;
								$this->arrCuestionario[$categoria]['temas'][$tema]['preguntas'][$pregunta]['valorRespuestaUsuario'] = $valorPonderado;
							}
						}
					}else {
						for ($x = 0; $x < count($this->arrCuestionario[$categoria]['temas'][$tema]['preguntas'][$pregunta]['respuestas']); $x++) {
							if ($this->arrCuestionario[$categoria]['temas'][$tema]['preguntas'][$pregunta]['respuestas'][$x]['id'] == $value) {
								$id = $this->arrCuestionario[$categoria]['temas'][$tema]['preguntas'][$pregunta]['respuestas'][$x]['id'];
								$valorPonderado = $this->arrCuestionario[$categoria]['temas'][$tema]['preguntas'][$pregunta]['respuestas'][$x]['valorPonderado'];
								$this->arrCuestionario[$categoria]['temas'][$tema]['preguntas'][$pregunta]['idRespuestaUsuario'] = $id;
								$this->arrCuestionario[$categoria]['temas'][$tema]['preguntas'][$pregunta]['valorRespuestaUsuario'] = $valorPonderado;
							}
						}
					}
				}else if(substr($key,0,6)=="numero"){
					$cachos=explode("_",$key);
					$this->arrCuestionario[$cachos['1']]['temas'][$cachos['2']]['preguntas'][$cachos['3']]['idRespuestaUsuario']=$value;
					$valor='0';
					if($value>2){
						$valor="1";
					}else if($value>1){
						$valor=".60";
					}else if($value>0){
						$valor=".30";
					}else{
						$valor='0';
					}
					$this->arrCuestionario[$cachos['1']]['temas'][$cachos['2']]['preguntas'][$cachos['3']]['valorRespuestaUsuario']=$valor;
				}else if(substr($key,0,8)=="calculo_"){
					//if(isset($post))
					$cachos=explode("_",$key);
					$this->arrCuestionario[$cachos['1']]['temas'][$cachos['2']]['preguntas'][$cachos['3']]['respuestas'][$cachos['4']]['respuestaAnotada']=$value;
				}
			}
			
			// poner valores de checkBoxes
			$idSeccion=$this->seccionPorMostrar-1;
			for($x=0;$x<count($this->arrCuestionario);$x++){
				if($this->arrCuestionario[$x]['id']==$idSeccion){
					for($y=0;$y<count($this->arrCuestionario[$x]['temas']);$y++){
						for($z=0;$z<count($this->arrCuestionario[$x]['temas'][$y]['preguntas']);$z++){
							if($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['tipo']=='checkBoxes'){
								$cuantasContestadas=0;
								for($q=0;$q<count($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas']);$q++){
									$nombreCampo="respuestaCheckBox_".$x."_".$y."_".$z."_".$q;
									if(isset($post[$nombreCampo])){
										$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas'][$q]['respuestaAnotada']=1;
										$cuantasContestadas++;
									}else{
										$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas'][$q]['respuestaAnotada']=0;
									}
								}
								$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['idRespuestaUsuario']=$cuantasContestadas;
							}
						}
					}
				}
			}
			
			if($idSeccion==1){
				if(isset($post['calculo_0_2_2_2'])){
					$this->arrCuestionario['0']['temas']['2']['preguntas']['2']['respuestas']['2']['respuestaAnotada']=1;
				}else{
					$this->arrCuestionario['0']['temas']['2']['preguntas']['2']['respuestas']['2']['respuestaAnotada']=0;
				}
			}
			
			//$this->data->updateCuestionarioTmp($this->arrCuestionario,$this->idCuestionarioTmp);
		}
		
		function definirPonderacionAUsar()
		{
			switch($this->tipoHotel){
				case '1':
					$campoValoracion="ponderacionMontana";
					break;
				case '2':
					$campoValoracion="ponderacionPlaya";
					break;
				case '3':
					$campoValoracion="ponderacionComunidad";
					break;
				case '4':
					$campoValoracion="ponderacionMagico";
					break;
				case '5':
					$campoValoracion="ponderacionCiudad";
					break;
				default:
					$campoValoracion="ponderacionMontana";
					break;
			}
			return($campoValoracion);
		}
		
		function calcularRespuestas()
		{
			$arrRespuestas=array();
			
			// construccion de array de respuestas y poner valores en preguntas
			for($x=0;$x<count($this->arrCuestionario);$x++){
				for($y=0;$y<count($this->arrCuestionario[$x]['temas']);$y++){
					for($z=0;$z<count($this->arrCuestionario[$x]['temas'][$y]['preguntas']);$z++){
						$arrRespuestas[$x]['id'] = $this->arrCuestionario[$x]['id'];
						$arrRespuestas[$x]['nombre'] = $this->arrCuestionario[$x]['nombre'];
						$arrRespuestas[$x]['nombreCorto'] = $this->arrCuestionario[$x]['nombreCorto'];
						$arrRespuestas[$x]['temas'][$y]['id'] = $this->arrCuestionario[$x]['temas'][$y]['id'];
						$arrRespuestas[$x]['temas'][$y]['nombre'] = $this->arrCuestionario[$x]['temas'][$y]['nombre'];
						$arrRespuestas[$x]['temas'][$y]['ponderacion'] = $this->arrCuestionario[$x]['temas'][$y]['ponderacion'];
						$arrRespuestas[$x]['temas'][$y]['puntuacion'] = 0.00;
						$arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['id'] = $this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['id'];
						$arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['nombre'] = $this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['nombre'];
						$arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['tipo'] = $this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['tipo'];
						$arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['ponderacion'] = $this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['ponderacion'];
						if($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['tipo']=='radioButton') {
							$idRespuesta = $this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['idRespuestaUsuario'];
							$valorRespuesta = $this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['valorRespuestaUsuario'];
							$arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['idRespuesta'] = $idRespuesta;
							$arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['valorRespuesta'] = $valorRespuesta;
						}
						else if($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['tipo']=='checkBoxes') {
							$cuantos=$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['idRespuestaUsuario'];
							if($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['id']==1){
								if($cuantos>6){
									$ponderacion=1;
								}else if($cuantos>3){
									$ponderacion=.6;
								}else if($cuantos>0){
									$ponderacion=.3;
								}else{
									$ponderacion=0;
								}
							}else if($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['id']==6){
								if($cuantos==0){
									$ponderacion=0;
								}else if($cuantos==1){
									$ponderacion=.25;
								}else if($cuantos==2){
									$ponderacion=.5;
								}else if($cuantos==3){
									$ponderacion=.75;
								}else{
									$ponderacion=1;
								}
							}else if($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['id']==13){
								if($cuantos==0){
									$ponderacion=0;
								}else if($cuantos==1){
									$ponderacion=.3;
								}else if($cuantos==2){
									$ponderacion=.6;
								}else{
									$ponderacion=1;
								}
							}else if($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['id']==21){
								if($cuantos==0){
									$ponderacion=0;
								}else if($cuantos==1){
									$ponderacion=.3;
								}else if($cuantos==2){
									$ponderacion=.6;
								}else{
									$ponderacion=1;
								}
							}else if($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['id']==65){
								if($cuantos>5){
									$ponderacion=1;
								}else if($cuantos>2){
									$ponderacion=.6;
								}else if($cuantos>0){
									$ponderacion=.3;
								}else{
									$ponderacion=0;
								}
							}
							$arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['valorRespuesta'] = $ponderacion;
							
						}
						else if($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['tipo']=='numero') {
							$cuantos=$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['idRespuestaUsuario'];
							if($cuantos==0){
								$ponderacion=0;
							}else if($cuantos==1){
								$ponderacion=.3;
							}else if($cuantos==2){
								$ponderacion=.6;
							}else{
								$ponderacion=1;
							}
							$arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['valorRespuesta'] = $ponderacion;
						}
						else if($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['tipo']=='calculo') {
							$cantidadMaxima=$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas']['0']['respuestaAnotada'];
							$cantidadMinima=$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas']['1']['respuestaAnotada'];
							$nosabe=$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas']['2']['respuestaAnotada'];
							if($nosabe==1 || $cantidadMaxima==0 || $cantidadMinima==0) {
								$arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['valorRespuesta'] = '0';
							}else {
								$razon = $cantidadMinima / $cantidadMaxima;
								if($razon<0.05){
									$ponderacion=0;
								}else if($razon<0.075){
									$ponderacion=.25;
								}else if($razon<0.1){
									$ponderacion=.5;
								}else{
									$ponderacion=1;
								}
								$arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['valorRespuesta'] = $ponderacion;
							}
						}
					}
				}
			}
			
			// calcular valores de temas
			for($x=0;$x<count($arrRespuestas);$x++){
				for($y=0;$y<count($arrRespuestas[$x]['temas']);$y++){
					$totalValorCalculadoTema=0;
					for($z=0;$z<count($arrRespuestas[$x]['temas'][$y]['preguntas']);$z++){
						$valorRespuesta=$arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['valorRespuesta'];
						$valorPonderacion=$arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['ponderacion'];
						$valor=$valorPonderacion*$valorRespuesta;
						$totalValorCalculadoTema+=$valor;
					}
					$arrRespuestas[$x]['temas'][$y]['puntuacion']=$totalValorCalculadoTema;
					$arrRespuestas[$x]['temas'][$y]['porcentaje']=$totalValorCalculadoTema/$arrRespuestas[$x]['temas'][$y]['ponderacion']*10;
				}
			}
			
			// calcular valores de categorias
			$sumaDeTotalesPosibles=0;
			$sumaDeTotalesObtenidos=0;
			for($x=0;$x<count($arrRespuestas);$x++){
				$totalValorCalculadoTema=0;
				$maximoPosible=0;
				for($y=0;$y<count($arrRespuestas[$x]['temas']);$y++){
					$maximoPosible+=$arrRespuestas[$x]['temas'][$y]['ponderacion'];
					$totalValorCalculadoTema+=$arrRespuestas[$x]['temas'][$y]['puntuacion'];
				}
				$total=$totalValorCalculadoTema/$maximoPosible*10;
				$porcentajeBarra=$total*10;
				// valores para calcular el global del cuestionario
				$sumaDeTotalesPosibles+=$maximoPosible;
				$sumaDeTotalesObtenidos+=$totalValorCalculadoTema;
				
				$arrRespuestas[$x]['totalPosible']=$maximoPosible;
				$arrRespuestas[$x]['totalObtenido']=$totalValorCalculadoTema;
				$arrRespuestas[$x]['puntuacion']=$total;
				$arrRespuestas[$x]['porcentajeBarra']=$porcentajeBarra;
			}
			$this->puntajeFinal=$sumaDeTotalesObtenidos/$sumaDeTotalesPosibles*10;
			return($arrRespuestas);
		}
		
		function ponerFechaHEnHotelesUsuario()
		{
			for($x=0;$x<count($this->arrHoteles);$x++){
				for($y=0;$y<count($this->arrHoteles[$x]['evaluaciones']);$y++) {
					$this->arrHoteles[$x]['evaluaciones'][$y]['fechaH'] = $this->fx->transformarFechaDMY($this->arrHoteles[$x]['evaluaciones'][$y]['fecha']);
				}
			}
		}
		
		function ponerFechaHEnEvaluacionesParciales()
		{
			for($x=0;$x<count($this->arrEvaluacionesParciales);$x++){
				$this->arrEvaluacionesParciales[$x]['fechaH']=$this->fx->transformarFechaDMY($this->arrEvaluacionesParciales[$x]['fecha']);
			}
		}
		
		// cargar cuestionario
		function cargarCuestionario($idEvaluacion)
		{
			$arrDatosHotel=$this->data->getDatosHotel($idEvaluacion);
			$this->idDefinitivoHotel=$arrDatosHotel['id'];
			$this->nombreHotel=$arrDatosHotel['nombreHotel'];
			$this->estadoHotel=$arrDatosHotel['estadoHotel'];
			$this->municipioHotel=$arrDatosHotel['municipioHotel'];
			$this->tipoHotel=$arrDatosHotel['tipoHotel'];
			$this->vocacionHotel=$arrDatosHotel['vocacion'];
			$this->noCuartos=$arrDatosHotel['noCuartos'];
			$this->cuartosDisponibles=$arrDatosHotel['cuartosDisponibles'];
			$this->cuartosOcupados=$arrDatosHotel['cuartosOcupados'];
			$this->tarifa=$arrDatosHotel['tarifa'];
			$this->noHuespedes=$arrDatosHotel['noHuespedes'];
			$this->costoCuartoOcupado=$arrDatosHotel['costoCuartoOcupado'];
			$this->noColaboradores=$arrDatosHotel['noColaboradores'];
			$this->anosOperando=$arrDatosHotel['anosOperando'];
			$this->porcentajeHotelero=$arrDatosHotel['porcentajeHotelero'];
			$this->porcentajeVacacional=$arrDatosHotel['porcentajeVacacional'];
			$this->porcentajeOtras=$arrDatosHotel['porcentajeOtras'];
			$this->esCadena=$arrDatosHotel['esCadena'];
			$this->revpar=$arrDatosHotel['revpar'];
			$this->puntajeFinal=$arrDatosHotel['puntuacion'];
			$this->alimentos=$arrDatosHotel['alimentos'];
			$datos=$this->data->traerCuestionario($idEvaluacion);
			
			$arrTmp=$this->reconstruirArregloDeSerializacion($datos['cuestionario']);
			$this->arrCuestionario=$arrTmp;
			// todo: unserialize validar si sale bien esto
			$arrRespuestas=$this->reconstruirArregloRespuestasDeSerializacion($datos['respuestas']);
			$this->arrRespuestas=$arrRespuestas;
		}
		
		// pdf
		
		function cargarCuestionarioPdf($idEvaluacion)
		{
			$arrDatosHotel=$this->data->getDatosHotelParaPdf($idEvaluacion);
			
			$this->idDefinitivoHotel=$arrDatosHotel['id'];
			$this->nombreHotel=$arrDatosHotel['nombreHotel'];
			$this->estadoHotel=$arrDatosHotel['estadoHotel'];
			$this->municipioHotel=$arrDatosHotel['municipioHotel'];
			$this->tipoHotel=$arrDatosHotel['tipoHotel'];
			$this->vocacionHotel=$arrDatosHotel['vocacion'];
			$this->noCuartos=$arrDatosHotel['noCuartos'];
			$this->cuartosDisponibles=$arrDatosHotel['cuartosDisponibles'];
			$this->cuartosOcupados=$arrDatosHotel['cuartosOcupados'];
			$this->tarifa=$arrDatosHotel['tarifa'];
			$this->noHuespedes=$arrDatosHotel['noHuespedes'];
			$this->costoCuartoOcupado=$arrDatosHotel['costoCuartoOcupado'];
			$this->noColaboradores=$arrDatosHotel['noColaboradores'];
			$this->anosOperando=$arrDatosHotel['anosOperando'];
			$this->porcentajeHotelero=$arrDatosHotel['porcentajeHotelero'];
			$this->porcentajeVacacional=$arrDatosHotel['porcentajeVacacional'];
			$this->porcentajeOtras=$arrDatosHotel['porcentajeOtras'];
			$this->esCadena=$arrDatosHotel['esCadena'];
			$this->revpar=$arrDatosHotel['revpar'];
			$this->puntajeFinal=$arrDatosHotel['puntuacion'];
			$this->alimentos=$arrDatosHotel['alimentos'];
			
			
			$datos=$this->data->traerCuestionario($idEvaluacion);
			$arrTmp=$this->reconstruirArregloDeSerializacion($datos['cuestionario']);
			$this->arrCuestionario=$arrTmp;
			// todo: unserialize validar si sale bien esto
			$arrRespuestas=$this->reconstruirArregloRespuestasDeSerializacion($datos['respuestas']);
			$this->arrRespuestas=$arrRespuestas;
			return($arrDatosHotel);
		}
		
		function hacerGrafica($avancePorcentaje)
		{
			// definir nombre aleatorio
			$aleatorio=rand(1,100000000);
			$nombre="grafica".$aleatorio.".jpg";
			$nombreConPath="graficas/".$nombre;
			
			// crear imagen
			$image=imagecreate(200, 200);
			
			// definir colores
			$colorWhite=imagecolorallocate($image, 255, 255, 255);
			$colorGrey=imagecolorallocate($image, 229, 237, 251);//229–237–251
			$colorBlue=imagecolorallocate($image, 0, 81, 241); //0–81–241
			$colorNegro=imagecolorallocate($image, 0, 0, 0);
			// circulo gris de fondo
			imagefilledellipse( $image , 100 , 100 , 190 , 190 ,  $colorGrey );
			
			// arco azul con % de avance
			$arco= (360*$avancePorcentaje/100) - 90;
			imagefilledarc (  $image , 100 , 100, 190 , 190  , -90, $arco,  $colorBlue , IMG_ARC_PIE );
			
			// 20 lineas en angulo
			imagesetthickness($image, 7);
			$xOrigen=100;
			$yOrigen=100;
			$largo=100;
			$grados=-90;
			$xDestino=$xOrigen + $largo * cos(pi() * $grados / 180);
			$yDestino=$yOrigen + $largo *(sin( pi() * $grados /180));
			imageline (  $image ,  $xOrigen ,  $yOrigen ,  $xDestino ,  $yDestino ,  $colorWhite);
			for($x=0;$x<20;$x++){
				$grados+=-18;
				$xDestino=$xOrigen + $largo * cos(pi() * $grados / 180);
				$yDestino=$yOrigen + $largo *(sin( pi() * $grados /180));
				imageline (  $image ,  $xOrigen ,  $yOrigen ,  $xDestino ,  $yDestino ,  $colorWhite);
			}
			
			// circulo blanco central para dar apariencia de dona
			imagefilledellipse ( $image , 100 , 100 , 140 , 140 ,  $colorWhite );
			
			// poner numero en el centro
			// Path a la fuente
			$font_path = 'tipografia/OpenSans-Bold.ttf';
			
			// texto a imprimir
			$text = number_format($avancePorcentaje/10,2);
			
			// imprimir en imagen
			imagettftext($image, 25, 0, 60, 112, $colorNegro, $font_path, $text);
			
			
			// grabado de imagen
			imagejpeg($image,$nombreConPath);
			return($nombreConPath);
		}
	
		function hacerPdfRespuesta($arrTmp)
		{
			$nombreArchivo="pdf/ensayo.pdf";
			$respuestasPdf = new Respuestas('P','mm','letter');
			
			$respuestasPdf->ponerDatosIniciales($arrTmp);
			$respuestasPdf->ponerDatos($this->arrCuestionario);
			// pagina 1
			$respuestasPdf->AddPage();
			$respuestasPdf->ponerLogo();
			$respuestasPdf->ponerPag1();
			
			// pagina 2
			$respuestasPdf->AddPage();
			$respuestasPdf->ponerLogo();
			$respuestasPdf->ponerPagina2();
			
			$respuestasPdf->Output($nombreArchivo,"D",true);
		}
		
		function hacerPdfReporte()
		{
			// hacer array arrDatos con porcentajes
			$arrDatos=array();
			$arrDatos['porcentajeTotal']=number_format($this->puntajeFinal*10,2);
			for($x=0;$x<count($this->arrRespuestas);$x++) {
				$nombreSeccion="seccion".$this->arrRespuestas[$x]['nombreCorto'];
				$arrDatos[$nombreSeccion]=number_format($this->arrRespuestas[$x]['puntuacion']*10,2);
				for ($y = 0; $y < count($this->arrRespuestas[$x]['temas']); $y++) {
					$nombreTema="tema_".$this->fx->convertirAASCII($this->arrRespuestas[$x]['temas'][$y]['nombre']);
					$arrDatos[$nombreTema]=number_format($this->arrRespuestas[$x]['temas'][$y]['porcentaje']*10,2);
				}
			}
			
			// todo: quitar esto cuando las cifras del calculo esten bien
			//$arrDatosAjustados=$this->ajustarDatosMaximosBorrar($arrDatos);
			//$arrDatos=$arrDatosAjustados;
			// todo: fin de quitar cuando esten bien las cifras
			
			
			$nombreArchivo="pdf/ensayo.pdf";
			
			$resultadosPdf = new PdfResultados('P','mm','letter');
			$resultadosPdf->ponerLeyendas($this->arrLeyendas);
			$resultadosPdf->nombreHotel=$this->nombreHotel;
			$resultadosPdf->tamanoHotel=$this->data->getTextoTamanoHotel($this->noCuartos);
			$resultadosPdf->tipoHotel=$this->data->getTextoTipoHotel($this->tipoHotel);
			$nombreEstado='';
			for($x=0;$x<count($this->arrestados);$x++){
				if($this->arrestados[$x]['id']==$this->estadoHotel){
					$nombreEstado=$this->arrestados[$x]['nombre'];
				}
			}
			
			$resultadosPdf->tipoHotel=$this->data->getTextoTipoHotel($this->tipoHotel);
			$resultadosPdf->estadoHotel=$nombreEstado;
			
			
			
			$resultadosPdf->arrDatos=$arrDatos;
			$resultadosPdf->graficaGeneral=$this->hacerGrafica($arrDatos['porcentajeTotal']);
			$resultadosPdf->graficaPersonas=$this->hacerGrafica($arrDatos['seccionPersonas']);
			$resultadosPdf->graficaPaz=$this->hacerGrafica($arrDatos['seccionPaz']);
			$resultadosPdf->graficaProsperidad=$this->hacerGrafica($arrDatos['seccionProsperidad']);
			$resultadosPdf->graficaPlaneta=$this->hacerGrafica($arrDatos['seccionPlaneta']);
			$resultadosPdf->graficaPaternariato=$this->hacerGrafica($arrDatos['seccionAlianzas']);
			
			// pagina 1
			$resultadosPdf->AddPage();
			$resultadosPdf->ponerLogo();
			$resultadosPdf->ponerDesc1();
			$resultadosPdf->ponerTexto1();
			$resultadosPdf->ponerCuadroGeneral();
			$resultadosPdf->ponerCuadroPersonas();
			
			// pagina 2
			$resultadosPdf->AddPage();
			$resultadosPdf->ponerCuadroPaz();
			$resultadosPdf->ponerCuadroProsperidad();
			
			// pagina 3
			$resultadosPdf->AddPage();
			$resultadosPdf->ponerCuadroPlaneta();
			$resultadosPdf->ponerCuadroPaternariato();
			$resultadosPdf->ponerCuadroInfIzq();
			$resultadosPdf->ponerCuadroInfDer();
			
			$resultadosPdf->Output($nombreArchivo,"D",true);

		}
		
		function ajustarDatosMaximosBorrar($arrDatos)
		{
			
			$arrDatos['tema_Accesibilidad']=($arrDatos['tema_Accesibilidad']>100) ? '100' : $arrDatos['tema_Accesibilidad'];
			$arrDatos['tema_Igualdad_de_genero']=($arrDatos['tema_Igualdad_de_genero']>100) ? '100' : $arrDatos['tema_Igualdad_de_genero'];
			$arrDatos['tema_Trabajo_decente_e_inclusion']=($arrDatos['tema_Trabajo_decente_e_inclusion']>100) ? '100' : $arrDatos['tema_Trabajo_decente_e_inclusion'];
			$arrDatos['tema_Educacion']=($arrDatos['tema_Educacion']>100) ? '100' : $arrDatos['tema_Educacion'];
			$arrDatos['seccionPersonas']=($arrDatos['tema_Accesibilidad']+$arrDatos['tema_Igualdad_de_genero']+$arrDatos['tema_Trabajo_decente_e_inclusion']+$arrDatos['tema_Educacion'])/4;
			
			$arrDatos['tema_Conducta_etica']=($arrDatos['tema_Conducta_etica']>100) ? '100' : $arrDatos['tema_Conducta_etica'];
			$arrDatos['tema_Corrupcion']=($arrDatos['tema_Corrupcion']>100) ? '100' : $arrDatos['tema_Corrupcion'];
			$arrDatos['tema_Fomento_y_proteccion_del_patrimonio_cultural_tangible_e_intangible']=($arrDatos['tema_Fomento_y_proteccion_del_patrimonio_cultural_tangible_e_intangible']>100) ? '100' : $arrDatos['tema_Fomento_y_proteccion_del_patrimonio_cultural_tangible_e_intangible'];
			$arrDatos['tema_Relacion_con_grupos_de_interes']=($arrDatos['tema_Relacion_con_grupos_de_interes']>100) ? '100' : $arrDatos['tema_Relacion_con_grupos_de_interes'];
			$arrDatos['seccionPaz']=($arrDatos['tema_Conducta_etica']+$arrDatos['tema_Corrupcion']+$arrDatos['tema_Fomento_y_proteccion_del_patrimonio_cultural_tangible_e_intangible']+$arrDatos['tema_Relacion_con_grupos_de_interes'])/4;
			
			$arrDatos['tema_Desarrollo_comunitario']=($arrDatos['tema_Desarrollo_comunitario']>100) ? '100' : $arrDatos['tema_Desarrollo_comunitario'];
			$arrDatos['tema_Empleo_en_general']=($arrDatos['tema_Empleo_en_general']>100) ? '100' : $arrDatos['tema_Empleo_en_general'];
			$arrDatos['tema_Colaboradores_locales']=($arrDatos['tema_Colaboradores_locales']>100) ? '100' : $arrDatos['tema_Colaboradores_locales'];
			$arrDatos['tema_Cadena_de_valor_prospera']=($arrDatos['tema_Cadena_de_valor_prospera']>100) ? '100' : $arrDatos['tema_Cadena_de_valor_prospera'];
			$arrDatos['tema_Generacion_economica_local']=($arrDatos['tema_Generacion_economica_local']>100) ? '100' : $arrDatos['tema_Generacion_economica_local'];
			$arrDatos['seccionProsperidad']=($arrDatos['tema_Desarrollo_comunitario']+$arrDatos['tema_Empleo_en_general']+$arrDatos['tema_Colaboradores_locales']+$arrDatos['tema_Cadena_de_valor_prospera']+$arrDatos['tema_Generacion_economica_local'])/5;
			
			$arrDatos['tema_Proteccion_de_la_biodiversidad']=($arrDatos['tema_Proteccion_de_la_biodiversidad']>100) ? '100' : $arrDatos['tema_Proteccion_de_la_biodiversidad'];
			$arrDatos['tema_Manejo__reduccion_y_tratamiento_de_residuos']=($arrDatos['tema_Manejo__reduccion_y_tratamiento_de_residuos']>100) ? '100' : $arrDatos['tema_Manejo__reduccion_y_tratamiento_de_residuos'];
			$arrDatos['tema_Manejo__reduccion_y_tratamiento_de_agua']=($arrDatos['tema_Manejo__reduccion_y_tratamiento_de_agua']>100) ? '100' : $arrDatos['tema_Manejo__reduccion_y_tratamiento_de_agua'];
			$arrDatos['tema_Manejo_y_reduccion_de_energia']=($arrDatos['tema_Manejo_y_reduccion_de_energia']>100) ? '100' : $arrDatos['tema_Manejo_y_reduccion_de_energia'];
			$arrDatos['tema_Cambio_climatico']=($arrDatos['tema_Cambio_climatico']>100) ? '100' : $arrDatos['tema_Cambio_climatico'];
			$arrDatos['tema_Cadena_de_suministro_planeta']=($arrDatos['tema_Cadena_de_suministro_planeta']>100) ? '100' : $arrDatos['tema_Cadena_de_suministro_planeta'];
			$arrDatos['tema_Planeacion_y_diseno_del_destino']=($arrDatos['tema_Planeacion_y_diseno_del_destino']>100) ? '100' : $arrDatos['tema_Planeacion_y_diseno_del_destino'];
			$arrDatos['seccionPlaneta']=($arrDatos['tema_Proteccion_de_la_biodiversidad']+$arrDatos['tema_Manejo__reduccion_y_tratamiento_de_residuos']+$arrDatos['tema_Manejo__reduccion_y_tratamiento_de_agua']+ $arrDatos['tema_Manejo_y_reduccion_de_energia']+$arrDatos['tema_Cambio_climatico']+$arrDatos['tema_Cadena_de_suministro_planeta']+$arrDatos['tema_Planeacion_y_diseno_del_destino'])/7;
			
			$arrDatos['tema_Para_la_gestion_y_operacion_interna']=($arrDatos['tema_Para_la_gestion_y_operacion_interna']>100) ? '100' : $arrDatos['tema_Para_la_gestion_y_operacion_interna'];
			$arrDatos['tema_En_proyectos_externos']=($arrDatos['tema_En_proyectos_externos']>100) ? '100' : $arrDatos['tema_En_proyectos_externos'];
			$arrDatos['tema_Con_clientes']=($arrDatos['tema_Con_clientes']>100) ? '100' : $arrDatos['tema_Con_clientes'];
			$arrDatos['seccionAlianzas']=($arrDatos['tema_Para_la_gestion_y_operacion_interna']+$arrDatos['tema_En_proyectos_externos']+$arrDatos['tema_Con_clientes'])/3;
			return($arrDatos);
		}
		
		// upload archivo soporte
		function subirArchivoSoporte($post,$files)
		{
			$error='';
			$nombreOriginal=$files['archivoSoporte']['name'];
			$partes = pathinfo($nombreOriginal);
			$tipoExtension=$partes['extension'];
			$nombreSinEspacios=$this->fx->convertirAASCII($partes['filename']);
			$nombreAleatorio=$this->fx->hacerAlfanumericoAleatorio(10);
			if (strlen($tipoExtension)>0){
				$nombreArchivo=$nombreSinEspacios."_".$nombreAleatorio.".".$tipoExtension;
			} else {
				$nombreArchivo=$nombreSinEspacios."_".$nombreAleatorio;
			}
			$aDonde="tmp/".$nombreArchivo;
			if(move_uploaded_file ( $files['archivoSoporte']['tmp_name'], "$aDonde" )){
				$this->arrDocumentosSoporte[]=array('idPregunta'=>$this->idPregunta,'nombreArchivo'=>$post['nombreArchivo'],'nombreTmp'=>$nombreArchivo);
			}else{
				$error="No se pudo subir el documento. Por favor vuelva a intentar.";
			}
			return($error);
		}
		
		function acomodarSoportes($idHotel,$arrDocumentosSoporte)
		{
			$rutaDefinitiva="soportes/".$idHotel."/";
			if(!file_exists($rutaDefinitiva)) {
				$error=mkdir($rutaDefinitiva);
				chmod($rutaDefinitiva, 0777);
				if($error) {
					$error='';
				}else{
					$error="No se pudo crear directorio de documentos para el proyecto. Por favor vuelva a intentar.";
				}
			}
			
			if(empty($error)) {
				for ($x = 0; $x < count($arrDocumentosSoporte); $x++) {
					$rutaPregunta = $rutaDefinitiva . $arrDocumentosSoporte[$x]['idPregunta']."/";
					if (!file_exists($rutaPregunta)) {
						$error = mkdir($rutaPregunta);
						chmod($rutaPregunta, 0777);
						if ($error) {
							//$error = '';
							$nombreTmp='tmp/'.$arrDocumentosSoporte[$x]['nombreTmp'];
							$nombreDefinitivo=$rutaPregunta.$arrDocumentosSoporte[$x]['nombreTmp'];
							$error=rename("$nombreTmp", "$nombreDefinitivo");
							if($error){
								//$error = '';
								$error=$this->data->grabarSoporte($idHotel,$arrDocumentosSoporte[$x]['idPregunta'],$arrDocumentosSoporte[$x]['nombreArchivo'],$nombreDefinitivo);
							}else{
								$error = "No se pudo cambiar el documento de folder. Por favor vuelva a intentar.";
							}
						} else {
							$error = "No se pudo crear directorio de documentos para el proyecto. Por favor vuelva a intentar.";
						}
					}
				}
			}
			return($error);
		}
		
		function acomodarArchivosSoporte()
		{
			$rutaDefinitiva="soportes/".$this->idEvaluacionTmp."/";
			if(!file_exists($rutaDefinitiva)) {
				$error=mkdir($rutaDefinitiva);
				chmod($rutaDefinitiva, 0777);
				if($error) {
					$error='';
				}else{
					$error="No se pudo crear directorio de documentos para el proyecto. Por favor vuelva a intentar.";
				}
			}
			if(empty($error)) {
				for ($x = 0; $x < count($this->arrDocumentosSoporte); $x++) {
					$rutaPregunta = $rutaDefinitiva . $this->arrDocumentosSoporte[$x]['idPregunta']."/";
					if (!file_exists($rutaPregunta)) {
						$error = mkdir($rutaPregunta);
						chmod($rutaPregunta, 0777);
						if ($error) {
							//$error = '';
							$nombreTmp='tmp/'.$this->arrDocumentosSoporte[$x]['nombreTmp'];
							$nombreDefinitivo=$rutaPregunta.$this->arrDocumentosSoporte[$x]['nombreTmp'];
							$error=rename("$nombreTmp", "$nombreDefinitivo");
							if($error){
								//$error = '';
								$error=$this->data->grabarSoporte($this->idEvaluacionTmp,$this->arrDocumentosSoporte[$x]['idPregunta'],$this->arrDocumentosSoporte[$x]['nombreArchivo'],$nombreDefinitivo);
							}else{
								$error = "No se pudo cambiar el documento de folder. Por favor vuelva a intentar.";
							}
						} else {
							$error = "No se pudo crear directorio de documentos para el proyecto. Por favor vuelva a intentar.";
						}
					}
				}
			}
			return($error);
			
		}
		
		// plan de accion
		function actualizarPostPlanDeAccion($post)
		{
			if(isset($post['resultadoPersonas'])) $this->resultadoPersonas= $post['resultadoPersonas'];
			if(isset($post['resultadoPaz'])) $this->resultadoPaz= $post['resultadoPaz'];
			if(isset($post['resultadoProsperidad'])) $this->resultadoProsperidad= $post['resultadoProsperidad'];
			if(isset($post['resultadoPlaneta'])) $this->resultadoPlaneta= $post['resultadoPlaneta'];
			if(isset($post['resultadoAlianzas'])) $this->resultadoAlianzas= $post['resultadoAlianzas'];
			
			foreach ($post as $key=>$value){
				// personas
				if(substr($key,0,13)=='accionPersona'){
					$cachos=explode("_",$key);
					$indice=$cachos["1"];
					$this->arrAccionesPersonasPlan[$indice]['accion']=$value;
				}
				
				if(substr($key,0,16)=='indicadorPersona'){
					$cachos=explode("_",$key);
					$indice=$cachos["1"];
					$this->arrAccionesPersonasPlan[$indice]['indicador']=$value;
				}
				
				if(substr($key,0,18)=='responsablePersona'){
					$cachos=explode("_",$key);
					$indice=$cachos["1"];
					$this->arrAccionesPersonasPlan[$indice]['responsable']=$value;
				}
				
				if(substr($key,0,12)=='fechaPersona'){
					$cachos=explode("_",$key);
					$indice=$cachos["1"];
					$this->arrAccionesPersonasPlan[$indice]['fecha']=$value;
				}
				
				// paz
				if(substr($key,0,9)=='accionPaz'){
					$cachos=explode("_",$key);
					$indice=$cachos["1"];
					$this->arrAccionesPazPlan[$indice]['accion']=$value;
				}
				
				if(substr($key,0,12)=='indicadorPaz'){
					$cachos=explode("_",$key);
					$indice=$cachos["1"];
					$this->arrAccionesPazPlan[$indice]['indicador']=$value;
				}
				
				if(substr($key,0,14)=='responsablePaz'){
					$cachos=explode("_",$key);
					$indice=$cachos["1"];
					$this->arrAccionesPazPlan[$indice]['responsable']=$value;
				}
				
				if(substr($key,0,8)=='fechaPaz'){
					$cachos=explode("_",$key);
					$indice=$cachos["1"];
					$this->arrAccionesPazPlan[$indice]['fecha']=$value;
				}
				
				// prosperiodad
				if(substr($key,0,17)=='accionProsperidad'){
					$cachos=explode("_",$key);
					$indice=$cachos["1"];
					$this->arrAccionesProsperidadPlan[$indice]['accion']=$value;
				}
				
				if(substr($key,0,20)=='indicadorProsperidad'){
					$cachos=explode("_",$key);
					$indice=$cachos["1"];
					$this->arrAccionesProsperidadPlan[$indice]['indicador']=$value;
				}
				
				if(substr($key,0,22)=='responsableProsperidad'){
					$cachos=explode("_",$key);
					$indice=$cachos["1"];
					$this->arrAccionesProsperidadPlan[$indice]['responsable']=$value;
				}
				
				if(substr($key,0,16)=='fechaProsperidad'){
					$cachos=explode("_",$key);
					$indice=$cachos["1"];
					$this->arrAccionesProsperidadPlan[$indice]['fecha']=$value;
				}
				
				// planeta
				if(substr($key,0,13)=='accionPlaneta'){
					$cachos=explode("_",$key);
					$indice=$cachos["1"];
					$this->arrAccionesPlanetaPlan[$indice]['accion']=$value;
				}
				
				if(substr($key,0,16)=='indicadorPlaneta'){
					$cachos=explode("_",$key);
					$indice=$cachos["1"];
					$this->arrAccionesPlanetaPlan[$indice]['indicador']=$value;
				}
				
				if(substr($key,0,18)=='responsablePlaneta'){
					$cachos=explode("_",$key);
					$indice=$cachos["1"];
					$this->arrAccionesPlanetaPlan[$indice]['responsable']=$value;
				}
				
				if(substr($key,0,12)=='fechaPlaneta'){
					$cachos=explode("_",$key);
					$indice=$cachos["1"];
					$this->arrAccionesPlanetaPlan[$indice]['fecha']=$value;
				}
				
				// alianzas
				if(substr($key,0,14)=='accionAlianzas'){
					$cachos=explode("_",$key);
					$indice=$cachos["1"];
					$this->arrAccionesAlianzasPlan[$indice]['accion']=$value;
				}
				
				if(substr($key,0,17)=='indicadorAlianzas'){
					$cachos=explode("_",$key);
					$indice=$cachos["1"];
					$this->arrAccionesAlianzasPlan[$indice]['indicador']=$value;
				}
				
				if(substr($key,0,19)=='responsableAlianzas'){
					$cachos=explode("_",$key);
					$indice=$cachos["1"];
					$this->arrAccionesAlianzasPlan[$indice]['responsable']=$value;
				}
				
				if(substr($key,0,13)=='fechaAlianzas'){
					$cachos=explode("_",$key);
					$indice=$cachos["1"];
					$this->arrAccionesAlianzasPlan[$indice]['fecha']=$value;
				}
			}
		}
		
		// razurar arreglo
		
		function razurarArregloParaSerializacion()
		{
			$cuestionarioRazurado=$this->arrCuestionario;
			for($x=0;$x<count($cuestionarioRazurado);$x++){
				unset($cuestionarioRazurado[$x]['nombre']);
				unset($cuestionarioRazurado[$x]['nombreCorto']);
				for($y=0;$y<count($cuestionarioRazurado[$x]['temas']);$y++){
					unset($cuestionarioRazurado[$x]['temas'][$y]['nombre']);
					for($z=0;$z<count($cuestionarioRazurado[$x]['temas'][$y]['preguntas']);$z++){
						unset($cuestionarioRazurado[$x]['temas'][$y]['preguntas'][$z]['nombre']);
						unset($cuestionarioRazurado[$x]['temas'][$y]['preguntas'][$z]['ayuda']);
						for($q=0;$q<count($cuestionarioRazurado[$x]['temas'][$y]['preguntas'][$z]['respuestas']);$q++){
							unset($cuestionarioRazurado[$x]['temas'][$y]['preguntas'][$z]['respuestas'][$q]['nombre']);
						}
					}
				}
			}
			return($cuestionarioRazurado);
		}
		
		function razurarRespuestas()
		{
			$respuestasRazurado=$this->arrRespuestas;
			for($x=0;$x<count($respuestasRazurado);$x++){
				unset($respuestasRazurado[$x]['nombre']);
				unset($respuestasRazurado[$x]['nombreCorto']);
				for($y=0;$y<count($respuestasRazurado[$x]['temas']);$y++){
					unset($respuestasRazurado[$x]['temas'][$y]['nombre']);
					for($z=0;$z<count($respuestasRazurado[$x]['temas'][$y]['preguntas']);$z++){
						unset($respuestasRazurado[$x]['temas'][$y]['preguntas'][$z]['nombre']);
					}
				}
			}
			return($respuestasRazurado);
		}
		
		function reconstruirArregloDeSerializacion($cuestionarioRazurado)
		{
			$arrTmp=$cuestionarioRazurado;
			for($x=0;$x<count($arrTmp);$x++){
				$arrTmp[$x]['nombre']=$this->arrCuestionario[$x]['nombre'];
				$arrTmp[$x]['nombreCorto']=$this->arrCuestionario[$x]['nombreCorto'];
				for($y=0;$y<count($arrTmp[$x]['temas']);$y++){
					$arrTmp[$x]['temas'][$y]['nombre']=$this->arrCuestionario[$x]['temas'][$y]['nombre'];
					for($z=0;$z<count($arrTmp[$x]['temas'][$y]['preguntas']);$z++){
						$arrTmp[$x]['temas'][$y]['preguntas'][$z]['nombre']=$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['nombre'];
						$arrTmp[$x]['temas'][$y]['preguntas'][$z]['ayuda']=$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['ayuda'];
						for($q=0;$q<count($arrTmp[$x]['temas'][$y]['preguntas'][$z]['respuestas']);$q++){
							$arrTmp[$x]['temas'][$y]['preguntas'][$z]['respuestas'][$q]['nombre']=$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas'][$q]['nombre'];
						}
					}
				}
			}
			return($arrTmp);
		}
		
		function reconstruirArregloRespuestasDeSerializacion($respuestasRazurado)
		{
			$arrTmp=$respuestasRazurado;
			for($x=0;$x<count($arrTmp);$x++){
				$arrTmp[$x]['nombre']=$this->arrCuestionario[$x]['nombre'];
				$arrTmp[$x]['nombreCorto']=$this->arrCuestionario[$x]['nombreCorto'];
				for($y=0;$y<count($arrTmp[$x]['temas']);$y++){
					$arrTmp[$x]['temas'][$y]['nombre']=$this->arrCuestionario[$x]['temas'][$y]['nombre'];
					for($z=0;$z<count($arrTmp[$x]['temas'][$y]['preguntas']);$z++){
						$arrTmp[$x]['temas'][$y]['preguntas'][$z]['nombre']=$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['nombre'];
					}
				}
			}
			return($arrTmp);
		}
		
		
	}
