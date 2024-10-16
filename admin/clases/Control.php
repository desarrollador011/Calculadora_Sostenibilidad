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
//	use PhpOffice\PhpSpreadsheet\IOFactory;
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	
	class Control
	{
		var $data;
		var $fx;
		var $pantalla="views/login.php";
		var $usuario;
		var $logueado=0;
		//var $nuevoRegistro=array();
		var $pantallaSubirEvidencia=0;
		var $idPregunta;
		// arreglos
		var $arrHoteles=array();
		var $arrTamanosHotel=array();
		var $arrestados=array();
		//var $tipoReporte;
		var $arrEvaluaciones=array();
		var $arrEvaluadores=array();
		var $arrPlanes=array();
		var $arrEvidencias=array();
		
		var $arrCuestionario=array();
		var $arrRespuestas=array();
		var $puntajeFinal;
		var $arrLeyendas=array();
		var $arrTiposHoteles=array();
		var $grabarAlFinal=0;
		var $tipoHotel;
		var $nombreHotel;
		var $tamanoHotel;
		var $municipioHotel;
		var $estadoHotel;
		var $seccionPorMostrar=2;
		var $itemSeleccionado;
		
		var $arrSecciones=array();
		var $indiceSeccionPorMostrar='0';
		var $idEnEvaluacion;
		
		
		var $arrSoportes=array();
		// pdf
		/**
		 * @var PdfResultados
		 *
		 */
		var $resultadosPdf;
		
		// soportes
		var $arrDocumentosSoporte=array();
		
		// plan
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
		
		// arreglos dashboard
		var $arrDestinoHotel=array();
		
		// temporales
		var $queryErrado;
		
		//////////////////////
		
		function __construct()
		{
			$this->data = new Data(SERVIDOR,SERVIDOR_USUARIO,SERVIDOR_CLAVE,SERVIDOR_DB);
			$this->fx=new Fx();
			$this->hacerArreglosIniciales();
		}
		
		function __destruct()
		{
		
		}
		
		function hacerConexionMysql()
		{
			$this->data->hacerConexionMysql(SERVIDOR,SERVIDOR_USUARIO,SERVIDOR_CLAVE,SERVIDOR_DB);
		}
		
		function hacerArreglosIniciales()
		{
			$this->arrTamanosHotel=$this->data->hacerArregloTamanosHotel();
			$this->arrestados=$this->data->hacerArregloEstados();
			$this->arrCuestionario=$this->data->hacerArregloPreguntasCompleto();
			$this->arrLeyendas=$this->data->getLeyendas();
			$this->arrTiposHoteles=$this->data->getTipos();
			
			$this->arrDestinoHotel=$this->data->hacerResumenTipo();
			
			if($this->usuario['rol']=='admin'){
				$this->arrSecciones=array();
				$this->arrSecciones[]=array('id'=>'dashboard','titulo'=>'Dashboard');
				$this->arrSecciones[]=array('id'=>'impacto','titulo'=>'Impacto');
				$this->arrSecciones[]=array('id'=>'autoEvaluacionesAdmin','titulo'=>'Autoevaluaciones');
				$this->arrSecciones[]=array('id'=>'planes','titulo'=>'Planes de Accion');
				$this->arrEvaluaciones=$this->data->hacerArregloEvaluacionesAdmin();
				$this->arrPlanes=$this->data->hacerArregloPlanesAdmin();
				$this->arrEvaluadores=$this->data->hacerArrEvaluadores();
			}else if ($this->usuario['rol']=='evaluador'){
				$this->arrSecciones=array();
//				$this->arrSecciones[]=array('id'=>'dashboard','titulo'=>'Dashboard');
//				$this->arrSecciones[]=array('id'=>'impacto','titulo'=>'Impacto');
				$this->arrSecciones[]=array('id'=>'autoEvaluaciones','titulo'=>'Autoevaluaciones');
				$this->arrSecciones[]=array('id'=>'planes','titulo'=>'Planes de Accion');
				$this->arrEvaluaciones=$this->data->hacerArregloEvaluaciones($this->usuario['id']);
			}
			
			$this->seleccionarContenido();
		}
		
		function mostrarPantalla()
		{
			if($this->logueado == false){
				include('views/login.php');
			}else {
				include('views/template.php');
			}
//			if (DEBUG == 1) {
//				include('views/general/debug.php');
//			}
		
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
				case 'salir':
					$this->logueado = false;
					$this->pantalla = 'views/login.php';
					break;
				case 'login':
					$usuario = $this->data->validarLogin($post['usuario'], $post['clave']);
					if (isset($usuario['error'])) {
						$this->logueado = false;
						$this->fx->dispararAlerta($usuario['error']);
					} else {
						$this->logueado = true;
						$this->usuario=$usuario;
						//$this->arrHoteles=$this->data->buscarHotelesDeUsuario($this->usuario['id']);
						$this->hacerArreglosIniciales();
						$this->seleccionarContenido();
					}
					break;
				case 'home':
					$this->evaluarPostHome($post);
					break;
				case 'registro':
					$this->pantalla = 'vistas/completarRegistro.php';
					break;
				case 'completarRegistro':
					$insercion=$this->data->agregarUsuario($post['nombres'],$post['paterno'],$post['materno'],$post['cadena'],$post['usuarioReg'],$post['claveReg']);
					if(isset($insercion['error'])){
						$this->fx->dispararAlerta($insercion['error']);
						$this->pantalla = 'vistas/general/login.php';
					}else{
						$this->usuario = $this->data->getUsuario($insercion['idInsertado']);
						$this->arrHoteles=$this->data->buscarHotelesDeUsuario($this->usuario['id']);
						$this->pantalla = 'vistas/inicioUsuario.php';
					}
					break;
				case 'agregarCuestionario':
					$this->grabarAlFinal=1;
					$this->seccionPorMostrar=1;
					$this->pantalla = 'vistas/cuestionarios/seccion1.php';
					$this->arrDocumentosSoporte=array();
					break;
				case 'ensayarCuestionario':
					$this->grabarAlFinal=0;
					$this->seccionPorMostrar=1;
					$this->pantalla = 'vistas/cuestionarios/seccion1.php';
					break;
				case 'ponerSiguienteSeccion':
					if($this->seccionPorMostrar==1){
						$error=$this->llenarDelPostSeccion1($post);
						if($error!="0") {
							$this->fx->dispararAlerta($error);
							$this->pantalla = 'vistas/cuestionarios/seccion1.php';
						}else{
							$this->seccionPorMostrar=2;
							$this->pantalla="vistas/cuestionarios/secciones2_6.php";
						}
					}else{
						$this->llenarDelPost($post);
						$this->seccionPorMostrar+=1;
						$this->pantalla="vistas/cuestionarios/secciones2_6.php";
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
					$this->llenarDelPostSeccion1($post);
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
					$this->data->grabarPlan(
						$this->idHotel,$this->resultadoPersonas,
						$this->resultadoPaz,
						$this->resultadoProsperidad,
						$this->resultadoPlaneta,
						$this->resultadoAlianzas,
						$this->arrAccionesPersonasPlan,
						$this->arrAccionesPazPlan,
						$this->arrAccionesProsperidadPlan,
						$this->arrAccionesPlanetaPlan,
						$this->arrAccionesAlianzasPlan);
					break;
					
				// calculo
				case 'grabarCuestionario':
					$this->llenarDelPost($post);
					$completo=$this->revisarCompletitud();
					if($completo==1){
						$this->arrRespuestas=$this->calcularRespuestas();
						if($this->grabarAlFinal==1){
							$queryFallado=$this->data->grabarCuestionario1($this->usuario['id'],$this->nombreHotel,$this->tamanoHotel,$this->estadoHotel,$this->municipioHotel,$this->tipoHotel,$this->definirPonderacionAUsar(),$this->arrRespuestas);
							if($queryFallado>0){
								$this->idHotel=$queryFallado;
								if(count($this->arrDocumentosSoporte)>0) {
									$error=$this->acomodarSoportes($queryFallado,$this->arrDocumentosSoporte);
									if(!empty($error)){
										$this->fx->dispararAlerta($error);
									}
								}
							}else{
								$this->fx->dispararAlerta("No se pudo grabar el cuestionario. Por favor vuelva a intentar.");
							}
						}
						$this->pantalla="vistas/cuestionarios/resultados.php";
					}else{
						$this->fx->dispararAlerta("No se respondieron todas las preguntas");
						$this->seccionPorMostrar=1;
						$this->pantalla = 'vistas/cuestionarios/seccion1.php';
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
					$this->seccionPorMostrar=1;
					$this->pantalla = 'vistas/inicioUsuario.php';
					break;
				case 'reiniciar':
					$this->seccionPorMostrar=1;
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
					
					$this->cargarCuestionario($post['item']);
					$this->arrRespuestas=$this->calcularRespuestas();
					$this->pantalla="vistas/cuestionarios/resultados.php";
					break;
					
				// pdf
				case 'hacerReporte':
					$this->hacerPdfReporte();
					break;
					
				// excel
				case 'bajarExcel':
					$nombreHotel=$this->arrEvaluaciones[$post['item']]['nombreHotel'];
					$fecha=$this->arrEvaluaciones[$post['item']]['fecha'];
					$cuestionario=$this->reconstruirArregloDeSerializacion(unserialize($this->arrEvaluaciones[$post['item']]['cuestionarioSerializado']));
					$respuestas=$this->reconstruirArregloRespuestasDeSerializacion(unserialize($this->arrEvaluaciones[$post['item']]['respuestasSerializado']));
					$this->hacerExcel($nombreHotel,$fecha,$cuestionario,$respuestas);
					break;
				case "bajarExcelPlan":
					$nombreHotel=$this->arrPlanes[$post['item']]['nombreHotel'];
					$fecha=$this->arrPlanes[$post['item']]['fecha'];
					$datosPlan=$this->data->getDatosPlan($this->arrPlanes[$post['item']]['id']);
//					$cuestionario=$this->reconstruirArregloDeSerializacion(unserialize($this->arrEvaluaciones[$post['item']]['cuestionarioSerializado']));
//					$respuestas=$this->reconstruirArregloRespuestasDeSerializacion(unserialize($this->arrEvaluaciones[$post['item']]['respuestasSerializado']));
					$this->hacerExcelPlan($nombreHotel,$fecha,$datosPlan);
					break;
				case 'mostrarEvidencias':
					$id=$this->arrEvaluaciones[$post['item']]['id'];
					$this->arrEvidencias=$this->data->getEvidenciasAutoevaluacion($id);
					$this->pantalla="views/evidencias.php";
					break;
				case 'regresarAAutoevaluaciones':
					$this->pantalla="views/autoEvaluacionesAdmin.php";
					break;
			}
		}
		
		function evaluarPostHome($post)
		{
			switch($post['subaccion']){
				case 'seleccionarSeccionPorMostrar':
					$this->indiceSeccionPorMostrar=$post['item'];
					$this->seleccionarContenido();
					break;
				case 'asignarEvaluador':
					$nombreMenu='evaluador_'.$post['item'];
					$idEvaluador=$post[$nombreMenu];
					$idEvaluacion=$this->arrEvaluaciones[$post['item']]['id'];
					$error=$this->data->ponerEvaluador($idEvaluacion,$idEvaluador);
					if(!empty($error)){
						$this->fx->dispararAlerta($error);
					}else{
						$this->arrEvaluaciones=$this->data->hacerArregloEvaluacionesAdmin();
//						$this->arrEvaluaciones[$post['item']]['idRevisor']=$idEvaluador;
					}
					break;
				case 'hacerEvaluacion':
					// todo: traer evaluacion
					$idEvaluacion=$this->arrEvaluaciones[$post['item']]['id'];
					$resultado=$this->data->traerEvaluacion($idEvaluacion);
					$this->arrCuestionario=unserialize($resultado['0']['cuestionarioSerializado']);
					$this->idEnEvaluacion=$resultado['0']['id'];
					
					$this->arrSoportes=$this->data->hacerArrSoportes($idEvaluacion);
					
					$this->pantalla = 'views/evaluacion.php';
					// todo: agregar a arrCuestionario nuevos campos de valores
					
					
					break;
				case 'grabarCambiosEvaluacion':
					//echo 'jom';
					
					$this->llenarDelPostCompleto($post);
					$error=$this->validarCuestionarioCompleto();
					
					if(count($error)>0){
						$texto='Faltó constestar las siguientes preguntas\\n';
						for($x=0;$x<count($error);$x++){
							$texto.=$error[$x]."\\n";
						}
						$this->fx->dispararAlerta($texto);
						$this->pantalla = 'views/evaluacion.php';
					}else{
						$error=$this->data->grabarEvaluacion($this->idEnEvaluacion,$this->arrCuestionario);
						if(empty($error)){
							//$this->seccionPorMostrar+=1;
							$this->pantalla = 'views/autoEvaluaciones.php';
						}else{
							$this->fx->dispararAlerta($error);
							$this->pantalla = 'views/evaluacion.php';
						}
					}
					
					break;
			}
		}
		
		
		
		function seleccionarContenido()
		{
			$texto=$this->arrSecciones[$this->indiceSeccionPorMostrar]['id'].".php";

			$this->pantalla="views/$texto";
		}
		// calculo
		
		function llenarDelPostCompleto($post)
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
					$this->arrCueponerSiguienteSeccionstionario[$cachos['1']]['temas'][$cachos['2']]['preguntas'][$cachos['3']]['valorRespuestaUsuario']=$value;
				}else if(substr($key,0,8)=="calculo_"){
					//if(isset($post))
					$cachos=explode("_",$key);
					$this->arrCuestionario[$cachos['1']]['temas'][$cachos['2']]['preguntas'][$cachos['3']]['respuestas'][$cachos['4']]['respuestaAnotada']=$value;
				}
			}
			
			// poner valores de checkBoxes
//			$idSeccion=$this->seccionPorMostrar-1;
			for($x=0;$x<count($this->arrCuestionario);$x++){
				//if($this->arrCuestionario[$x]['id']==$idSeccion){
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
				//}
			}
			
			//if($idSeccion==1){
			if(isset($post['calculo_0_2_2_2'])){
				$this->arrCuestionario['0']['temas']['2']['preguntas']['2']['respuestas']['2']['respuestaAnotada']=1;
			}else{
				$this->arrCuestionario['0']['temas']['2']['preguntas']['2']['respuestas']['2']['respuestaAnotada']=0;
			}
			//}
			
			//$this->data->updateCuestionarioTmp($this->arrCuestionario,$this->idCuestionarioTmp);
		}
		
		function validarCuestionarioCompleto()
		{
			$error=array();
			for($x=0;$x<count($this->arrCuestionario);$x++) {
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
							if(empty($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['idRespuestaUsuario'])){
								$error[]=$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['nombre'];
							}
						}
					}
				}
				
			}
			return($error);
		}
		
		function revisarCompletitud()
		{
			$correcto=1;
			for($x=0;$x<count($this->arrCuestionario);$x++) {
				for ($y = 0; $y < count($this->arrCuestionario[$x]['temas']); $y++) {
					for ($z = 0; $z < count($this->arrCuestionario[$x]['temas'][$y]['preguntas']); $z++) {
						if($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['idRespuestaUsuario']<1) $correcto=0;
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
			if(isset($post['nombre'])) $this->nombreHotel=$post['nombre'];
			if(isset($post['tamano'])) $this->tamanoHotel=$post['tamano'];
			if(isset($post['estados'])) $this->estadoHotel=$post['estados'];
			if(isset($post['municipio'])) $this->municipioHotel=$post['municipio'];
			if(isset($post['tipo'])) $this->tipoHotel=$post['tipo'];
			
			$error=0;
			if(empty($post['nombre']) || empty($post['municipio']) || $post['tamano']=="Selecciones" || $post['tipo']=="Selecciones" || $post['estados']=="Selecciones" ){
			$error="Falto anotar uno de los datoso solicitados. Por favor revise el formulario.";
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
				}
			}
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
			$campoValoracion=$this->definirPonderacionAUsar();
			$arrRespuestas=array();
			
			// construccion de array de respuestas y poner valores en preguntas
			for($x=0;$x<count($this->arrCuestionario);$x++){
				for($y=0;$y<count($this->arrCuestionario[$x]['temas']);$y++){
					for($z=0;$z<count($this->arrCuestionario[$x]['temas'][$y]['preguntas']);$z++){
						
						$idRespuesta=$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['idRespuestaUsuario'];
						$valorRespuesta=$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['valorRespuestaUsuario'];
						
						$arrRespuestas[$x]['id']=$this->arrCuestionario[$x]['id'];
						$arrRespuestas[$x]['nombre']=$this->arrCuestionario[$x]['nombre'];
						$arrRespuestas[$x]['nombreCorto']=$this->arrCuestionario[$x]['nombreCorto'];
						
						$arrRespuestas[$x]['temas'][$y]['id']=$this->arrCuestionario[$x]['temas'][$y]['id'];
						$arrRespuestas[$x]['temas'][$y]['nombre']=$this->arrCuestionario[$x]['temas'][$y]['nombre'];
						$arrRespuestas[$x]['temas'][$y]['ponderacionMontana']=$this->arrCuestionario[$x]['temas'][$y]['ponderacionMontana'];
						$arrRespuestas[$x]['temas'][$y]['ponderacionPlaya']=$this->arrCuestionario[$x]['temas'][$y]['ponderacionPlaya'];
						$arrRespuestas[$x]['temas'][$y]['ponderacionComunidad']=$this->arrCuestionario[$x]['temas'][$y]['ponderacionComunidad'];
						$arrRespuestas[$x]['temas'][$y]['ponderacionMagico']=$this->arrCuestionario[$x]['temas'][$y]['ponderacionMagico'];
						$arrRespuestas[$x]['temas'][$y]['ponderacionCiudad']=$this->arrCuestionario[$x]['temas'][$y]['ponderacionCiudad'];
						$arrRespuestas[$x]['temas'][$y]['puntuacion']=0.00;
						
						$arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['id']=$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['id'];
						$arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['nombre']=$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['nombre'];
						
						$arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['ponderacionMontana']=$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['ponderacionMontana'];
						$arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['ponderacionPlaya']=$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['ponderacionPlaya'];
						$arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['ponderacionComunidad']=$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['ponderacionComunidad'];
						$arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['ponderacionMagico']=$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['ponderacionMagico'];
						$arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['ponderacionCiudad']=$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['ponderacionCiudad'];
						
						$arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['idRespuesta']=$idRespuesta;
						$arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['valorRespuesta']=$valorRespuesta;
					}
				}
			}
			
			// calcular valores de temas
			for($x=0;$x<count($arrRespuestas);$x++){
				for($y=0;$y<count($arrRespuestas[$x]['temas']);$y++){
					$totalValorCalculadoTema=0;
					for($z=0;$z<count($arrRespuestas[$x]['temas'][$y]['preguntas']);$z++){
						$valorRespuesta=$arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['valorRespuesta'];
						$valorPonderacion=$arrRespuestas[$x]['temas'][$y]['preguntas'][$z][$campoValoracion];
						$valor=$valorPonderacion*$valorRespuesta;
						$totalValorCalculadoTema+=$valor;
					}
					$arrRespuestas[$x]['temas'][$y]['puntuacion']=$totalValorCalculadoTema;
					$arrRespuestas[$x]['temas'][$y]['porcentaje']=$totalValorCalculadoTema/$arrRespuestas[$x]['temas'][$y][$campoValoracion]*10;
				}
			}
			
			// calcular valores de categorias
			$sumaDeTotalesPosibles=0;
			$sumaDeTotalesObtenidos=0;
			for($x=0;$x<count($arrRespuestas);$x++){
				$totalValorCalculadoTema=0;
				$maximoPosible=0;
				for($y=0;$y<count($arrRespuestas[$x]['temas']);$y++){
					$maximoPosible+=$arrRespuestas[$x]['temas'][$y][$campoValoracion];
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
		
		// cargar cuestionario
		function cargarCuestionario($idEvaluacion)
		{
			$arrDatosHotel=$this->data->getDatosHotel($idEvaluacion);
			$this->nombreHotel=$arrDatosHotel['nombre'];
			$this->tamanoHotel=$arrDatosHotel['idTamano'];
			$this->estadoHotel=$arrDatosHotel['idEstado'];
			$this->municipioHotel=$arrDatosHotel['municipio'];
			$this->tipoHotel=$arrDatosHotel['idTipo'];
			
			$this->arrCuestionario=$this->data->hacerArregloPreguntasCompleto();
			$arrDatosTraidos=$this->data->getRespuestas($idEvaluacion);
			
			for($x=0;$x<count($this->arrCuestionario);$x++){
				for($y=0;$y<count($this->arrCuestionario[$x]['temas']);$y++){
					for($z=0;$z<count($this->arrCuestionario[$x]['temas'][$y]['preguntas']);$z++){
						for($p=0;$p<count($arrDatosTraidos);$p++){
							if ($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['id']==$arrDatosTraidos[$p]['idPregunta']){
								$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['idRespuestaUsuario']=$arrDatosTraidos[$p]['idRespuesta'];
								$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['valorRespuestaUsuario']=$arrDatosTraidos[$p]['valorRespuesta'];
							}
						}
					}
				}
			}
		}
		
		// pdf
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
			$text = number_format($avancePorcentaje,2);
			
			// imprimir en imagen
			imagettftext($image, 25, 0, 60, 112, $colorNegro, $font_path, $text);
			
			
			// grabado de imagen
			imagejpeg($image,$nombreConPath);
			return($nombreConPath);
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
			
			$nombreArchivo="pdf/ensayo.pdf";
			
			$resultadosPdf = new PdfResultados('P','mm','letter');
			$resultadosPdf->ponerLeyendas($this->arrLeyendas);
			$resultadosPdf->nombreHotel=$this->nombreHotel;
			$resultadosPdf->tamanoHotel=$this->data->getTextoTamanoHotel($this->tamanoHotel);
			$resultadosPdf->tipoHotel=$this->data->getTextoTipoHotel($this->tipoHotel);
			$nombreEstado='';
			for($x=0;$x<count($this->arrestados);$x++){
				if($this->arrestados[$x]['id']=$this->estadoHotel){
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
			$resultadosPdf->graficaPaternariato=$this->hacerGrafica($arrDatos['seccionPaternariato']);
			
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
		
		// serilizaciones
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
		
		// excel
		
		function hacerExcel($nombre,$fecha,$cuestionario,$respuestas)
		{
			
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$renglon=1;
			
			$celda="A".$renglon;
			$sheet->setCellValue("$celda", $nombre);
			$renglon++;
			
			$celda="A".$renglon;
			$sheet->setCellValue("$celda", $fecha);
			$renglon++;
			
			for($x=0;$x<count($cuestionario);$x++){
				$celda="A".$renglon;
				$sheet->setCellValue("$celda", $cuestionario[$x]['nombre']);
				$renglon++;
				for($y=0;$y<count($cuestionario[$x]['temas']);$y++){
					$celda="B".$renglon;
					$sheet->setCellValue("$celda", $cuestionario[$x]['temas'][$y]['nombre']);
					$renglon++;
					for($z=0;$z<count($cuestionario[$x]['temas'][$y]['preguntas']);$z++){
						$celda="C".$renglon;
						$sheet->setCellValue("$celda", $cuestionario[$x]['temas'][$y]['preguntas'][$z]['nombre']);
						//$renglon++;
						$respuestaEscogida='';
						switch($cuestionario[$x]['temas'][$y]['preguntas'][$z]['tipo']){
							case 'checkBoxes':
								$texto='';
								for($q=0;$q<count($cuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas']);$q++){
									if($cuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas'][$q]['respuestaAnotada']==1){
										if(!empty($texto)) $texto.=', ';
										$texto.=$cuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas'][$q]['nombre'];
									}
								}
								$respuestaEscogida=$texto;
								break;
							case 'radioButton':
								for($q=0;$q<count($cuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas']);$q++){
									if($cuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas'][$q]['id']  ==  $cuestionario[$x]['temas'][$y]['preguntas'][$z]['idRespuestaUsuario']){
										$respuestaEscogida=$cuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas'][$q]['nombre'];
									}
								}
								break;
							case 'calculo':
								if($cuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas']['2']['respuestaAnotada']==1){
									$respuestaEscogida=$cuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas']['2']['nombre'];
								}else{
									$maximo=$respuestaEscogida=$cuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas']['0']['respuestaAnotada'];
									$minimo=$respuestaEscogida=$cuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas']['1']['respuestaAnotada'];
									$proporcion=$minimo/$maximo*100;
									$respuestaEscogida=$maximo." - ".$minimo."($proporcion%)";
								}
								break;
							case 'numero':
								
								$respuestaUsuario=$cuestionario[$x]['temas'][$y]['preguntas'][$z]['valorRespuestaUsuario'];
								if($respuestaUsuario>2){
									$indice=3;
								}else if($respuestaUsuario==2){
									$indice=2;
								}else if($respuestaUsuario==1){
									$indice=1;
								}else{
									$indice=0;
								}
								$respuestaEscogida=$cuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas'][$indice]['nombre'];
								break;
								
								
						}
						$celda="D".$renglon;
						$sheet->setCellValue("$celda", $respuestaEscogida);
						$renglon++;
					}
				}
			}
			$writer = new Xlsx($spreadsheet);
			$nombre=$nombre.".xlsx";
			$writer->save('php://output');
			
		}
	
		function hacerExcelPlan($nombre,$fecha,$datosPlan)
		{
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$renglon=1;
			
			$celda="A".$renglon;
			$sheet->setCellValue("$celda", $datosPlan['nombreHotel']);
			$renglon++;
			$celda="A".$renglon;
			$sheet->setCellValue("$celda", $datosPlan['fecha']);
			
			// personas
			$renglon++;
			$renglon++;
			$celda="A".$renglon;
			$sheet->setCellValue("$celda", "Personas");
			$renglon++;
			$celda="A".$renglon;
			$sheet->setCellValue("$celda", $datosPlan['resultadoPersonas']);
			
			$renglon++;
			$renglon++;
			$sheet->setCellValue("A".$renglon, 'No.');
			$sheet->setCellValue("B".$renglon, 'Acciones');
			$sheet->setCellValue("C".$renglon, 'Indicadores');
			$sheet->setCellValue("D".$renglon, 'Responsable');
			$sheet->setCellValue("E".$renglon, 'Lapso de implementación');
			
			for($x=0;$x<count($datosPlan['personas']);$x++){
				$y=$x+1;
				$renglon++;
				$sheet->setCellValue("A".$renglon, $y);
				$sheet->setCellValue("B".$renglon, $datosPlan['personas'][$x]['accion']);
				$sheet->setCellValue("C".$renglon, $datosPlan['personas'][$x]['indicador']);
				$sheet->setCellValue("D".$renglon, $datosPlan['personas'][$x]['responsable']);
				$sheet->setCellValue("E".$renglon, $datosPlan['personas'][$x]['fecha']);
			}
			
			// paz
			$renglon++;
			$renglon++;
			$celda="A".$renglon;
			$sheet->setCellValue("$celda", "Paz");
			$renglon++;
			$celda="A".$renglon;
			$sheet->setCellValue("$celda", $datosPlan['resultadoPaz']);
			
			$renglon++;
			$renglon++;
			$sheet->setCellValue("A".$renglon, 'No.');
			$sheet->setCellValue("B".$renglon, 'Acciones');
			$sheet->setCellValue("C".$renglon, 'Indicadores');
			$sheet->setCellValue("D".$renglon, 'Responsable');
			$sheet->setCellValue("E".$renglon, 'Lapso de implementación');
			
			for($x=0;$x<count($datosPlan['paz']);$x++){
			$y=$x+1;
			$renglon++;
			$sheet->setCellValue("A".$renglon, $y);
			$sheet->setCellValue("B".$renglon, $datosPlan['paz'][$x]['accion']);
			$sheet->setCellValue("C".$renglon, $datosPlan['paz'][$x]['indicador']);
			$sheet->setCellValue("D".$renglon, $datosPlan['paz'][$x]['responsable']);
			$sheet->setCellValue("E".$renglon, $datosPlan['paz'][$x]['fecha']);
		}
			
			// Prosperidad
			$renglon++;
			$renglon++;
			$celda="A".$renglon;
			$sheet->setCellValue("$celda", "Prosperidad");
			$renglon++;
			$celda="A".$renglon;
			$sheet->setCellValue("$celda", $datosPlan['resultadoProsperidad']);
			
			$renglon++;
			$renglon++;
			$sheet->setCellValue("A".$renglon, 'No.');
			$sheet->setCellValue("B".$renglon, 'Acciones');
			$sheet->setCellValue("C".$renglon, 'Indicadores');
			$sheet->setCellValue("D".$renglon, 'Responsable');
			$sheet->setCellValue("E".$renglon, 'Lapso de implementación');
			
			for($x=0;$x<count($datosPlan['prosperidad']);$x++){
				$y=$x+1;
				$renglon++;
				$sheet->setCellValue("A".$renglon, $y);
				$sheet->setCellValue("B".$renglon, $datosPlan['prosperidad'][$x]['accion']);
				$sheet->setCellValue("C".$renglon, $datosPlan['prosperidad'][$x]['indicador']);
				$sheet->setCellValue("D".$renglon, $datosPlan['prosperidad'][$x]['responsable']);
				$sheet->setCellValue("E".$renglon, $datosPlan['prosperidad'][$x]['fecha']);
			}
			
			// Planeta
			$renglon++;
			$renglon++;
			$celda="A".$renglon;
			$sheet->setCellValue("$celda", "Planeta");
			$renglon++;
			$celda="A".$renglon;
			$sheet->setCellValue("$celda", $datosPlan['resultadoPlaneta']);
			
			$renglon++;
			$renglon++;
			$sheet->setCellValue("A".$renglon, 'No.');
			$sheet->setCellValue("B".$renglon, 'Acciones');
			$sheet->setCellValue("C".$renglon, 'Indicadores');
			$sheet->setCellValue("D".$renglon, 'Responsable');
			$sheet->setCellValue("E".$renglon, 'Lapso de implementación');
			
			for($x=0;$x<count($datosPlan['planeta']);$x++){
				$y=$x+1;
				$renglon++;
				$sheet->setCellValue("A".$renglon, $y);
				$sheet->setCellValue("B".$renglon, $datosPlan['planeta'][$x]['accion']);
				$sheet->setCellValue("C".$renglon, $datosPlan['planeta'][$x]['indicador']);
				$sheet->setCellValue("D".$renglon, $datosPlan['planeta'][$x]['responsable']);
				$sheet->setCellValue("E".$renglon, $datosPlan['planeta'][$x]['fecha']);
			}
			
			// Alianzas
			$renglon++;
			$renglon++;
			$celda="A".$renglon;
			$sheet->setCellValue("$celda", "Alianzas");
			$renglon++;
			$celda="A".$renglon;
			$sheet->setCellValue("$celda", $datosPlan['resultadoAlianzas']);
			
			$renglon++;
			$renglon++;
			$sheet->setCellValue("A".$renglon, 'No.');
			$sheet->setCellValue("B".$renglon, 'Acciones');
			$sheet->setCellValue("C".$renglon, 'Indicadores');
			$sheet->setCellValue("D".$renglon, 'Responsable');
			$sheet->setCellValue("E".$renglon, 'Lapso de implementación');
			
			for($x=0;$x<count($datosPlan['alianzas']);$x++){
				$y=$x+1;
				$renglon++;
				$sheet->setCellValue("A".$renglon, $y);
				$sheet->setCellValue("B".$renglon, $datosPlan['alianzas'][$x]['accion']);
				$sheet->setCellValue("C".$renglon, $datosPlan['alianzas'][$x]['indicador']);
				$sheet->setCellValue("D".$renglon, $datosPlan['alianzas'][$x]['responsable']);
				$sheet->setCellValue("E".$renglon, $datosPlan['alianzas'][$x]['fecha']);
			}
			
			$writer = new Xlsx($spreadsheet);
			$nombre="Plan_".$nombre.".xlsx";
			$writer->save('php://output');
		}
		
		// evidencias
		function mostrarEvidencias($id)
		{
		
		}
	}
