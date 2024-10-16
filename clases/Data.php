<?php
	/**
	 * Created by PhpStorm.
	 * User: jom
	 * Date: 10/21/18
	 * Time: 4:49 PM
	 */
	
	class Data
	{
		/**
		 * @var mysqli
		 *
		 */
		var $db;
		
		
		/////////////////////////////
		
		function __construct($mysqlServidor,$mysqlUser,$mysqlClave,$mysqlDb)
		{
			$this->hacerConexionMysql($mysqlServidor,$mysqlUser,$mysqlClave,$mysqlDb);
		}
		
		function __destruct()
		{
		
		}
		
		
		
		// generales
		function hacerConexionMysql($mysqlServidor, $mysqlUser, $mysqlClave, $mysqlDb)
		{
			$this->db = new mysqli($mysqlServidor, $mysqlUser,$mysqlClave, $mysqlDb);
			$this->db->query("SET NAMES utf8");
		}
		
		function validarLogin($usuario,$clave)
		{
			$datosUsuario=array();
			$sql="select count(*) as cuantos from usuarios where usuario='".$usuario."' && clave='".$clave."' ";
			$resultado=$this->db->query($sql);
			$linea=$resultado->fetch_assoc();
			if($linea['cuantos']==1) {
				$sql1="select * from usuarios where usuario='".$usuario."' && clave='".$clave."' ";
				$resultado1=$this->db->query($sql1);
				$datosUsuario=$resultado1->fetch_assoc();
			}else if($linea['cuantos']>1) {
				$datosUsuario['error']="El usuario indicado esta registrado varias veces.\\n Por favor comuniquese con el administrador del sitio.";
			} else{
				$datosUsuario['error']="El usuario indicado no esta en nuestra base de datos. \\n Por favor regístrese.";
			}
			
			return($datosUsuario);
		}
		
		function validarLoginGet($get)
		{
			$datosUsuario=array();
			$sql="select count(*) as cuantos from usuarios where nombreGet='".$get['nombre']."' && usuarioGet='".$get['usuario']."'  ";
			$resultado=$this->db->query($sql);
			$linea=$resultado->fetch_assoc();
			if($linea['cuantos']==1) {
				$sql1="select * from usuarios where nombreGet='".$get['nombre']."' && usuarioGet='".$get['usuario']."'  ";
				$resultado1=$this->db->query($sql1);
				$datosUsuario=$resultado1->fetch_assoc();
			}else if($linea['cuantos']>1) {
				$datosUsuario['error']="El usuario indicado esta registrado varias veces.\\n Por favor comuniquese con el administrador del sitio.";
			} else{
				$this->insertarUsuarioDelGet($get['nombre'],$get['usuario']);
				$sql1="select * from usuarios where nombreGet='".$get['nombre']."' && usuarioGet='".$get['usuario']."'  ";
				$resultado1=$this->db->query($sql1);
				$datosUsuario=$resultado1->fetch_assoc();
			}
			
			return($datosUsuario);
		}
		
		function insertarUsuarioDelGet($nombre,$usuario)
		{
			$sql2="insert into usuarios set nombreGet='".$nombre."', usuarioGet='".$usuario."'";
			$this->db->query($sql2);
		}
		
		function getUsuario($id)
		{
			$sql1="select * from usuarios where id=$id";
			$resultado1=$this->db->query($sql1);
			$datosUsuario=$resultado1->fetch_assoc();
			return($datosUsuario);
		}
		
		function registrarNuevoUsuario($usuario,$clave)
		{
			$sql="select count(*) as cuantos from usuarios where usuario='".$usuario."' || clave='".$clave."' ";
			$resultado=$this->db->query($sql);
			$linea=$resultado->fetch_assoc();
			if($linea['cuantos']>0) {
				$insercion['error']="El nombre o clave de usauario ya han sido usados. \\n Por favor cambielos.";
			}else{
				$sql="insert into usuarios(usuario,clave) values('".$usuario."','".$clave."')";
				$this->db->query($sql);
				$insercion['idInsertado']=$this->db->insert_id;
			}
			return($insercion);
		}
		
		function editarUsuario($nombres,$paterno,$materno,$cadena,$id)
		{
			$sql="update usuarios set nombres='".$nombres."',paterno='".$paterno."',materno='".$materno."',cadena='".$cadena."' where id=$id";
			$resultado=$this->db->query($sql);
			return($resultado);
		}
		
		function agregarUsuario($nombres,$paterno,$materno,$cadena,$usuario,$clave)
		{
			$insercion=array();
			$sql="select count(*) as cuantos from usuarios where usuario='".$usuario."' || clave='".$clave."' ";
			$resultado=$this->db->query($sql);
			$linea=$resultado->fetch_assoc();
			if($linea['cuantos']>0) {
				$insercion['error']="El nombre o clave de usauario ya han sido usados. \\n Por favor cambielos.";
			}else{
				$sql="insert into usuarios(nombres,paterno,materno,cadena,usuario,clave)
					values('".$nombres."','".$paterno."','".$materno."','".$cadena."','".$usuario."','".$clave."')";
				if($this->db->query($sql)){
					$insercion['idInsertado'] = $this->db->insert_id;
				}else{
					$insercion['error']="No se pudo grabar el regsitro. Por favor intentelo nuevamente.";
					$insercion['error']=$sql;
				}
			}
			return($insercion);
		}
		
		function buscarHotelesDeUsuario($idUsuario)
		{
			$arrTmp=array();
			$sql="select hotel.*,catEstados.nombre as nombreEstado, municipios.nombre as nombreMunicipio,catTipoHotel.nombre as nombreTipo from hotel
					left join catEstados  on hotel.estadoHotel = catEstados.id
    				left join municipios  on hotel.municipioHotel = municipios.id
					left join catTipoHotel  on catTipoHotel.id = hotel.tipoHotel
					where hotel.idUsuario=$idUsuario order by id";
			$resultado=$this->db->query($sql);
			while($linea=$resultado->fetch_assoc()){
				$arrTmp[]=$linea;
			}
			
			for($x=0;$x<count($arrTmp);$x++){
				$arrTmp1=array();
				$sql1="select id,fecha,puntuacion, respuestasSerializado from evaluaciones where idHotel=".$arrTmp[$x]['id'];
				$resultado1=$this->db->query($sql1);
				while($linea1=$resultado1->fetch_assoc()){
					
					// todo: unserialize resuelto
					$arrRespuestas=unserialize($linea1['respuestasSerializado']);
					//$arrRespuestasNormalizadas=$this->reconstruirArregloRespuestasDeSerializacion($arrRespuestas);
					$arrRespuestasPuntuales=array();
					for($y=0;$y<count($arrRespuestas);$y++){
						$arrRespuestasPuntuales[]=$arrRespuestas[$y]['puntuacion'];
					}
					$linea1['respuestasPuntuales']=$arrRespuestasPuntuales;
					$arrTmp1[]=$linea1;
				}
				$arrTmp[$x]['evaluaciones']=$arrTmp1;
			}
			for($x=0;$x<count($arrTmp);$x++){
				for($y=0;$y<count($arrTmp[$x]['evaluaciones']);$y++){
					$arrTmp2=array();
					$sql2="select id,idEvaluacion from planes where idEvaluacion=".$arrTmp[$x]['evaluaciones'][$y]['id'];
					$resultado2=$this->db->query($sql2);
					while($linea2=$resultado2->fetch_assoc()){
						$arrTmp2[]=$linea2;
					}
					$arrTmp[$x]['evaluaciones'][$y]['planes']=$arrTmp2;
				}
			}
			
			
			return($arrTmp);
		}
		
		function buscarEvaluacionesParciales($idUsuario)
		{
			$arrTmp=array();
			$sql="select evaluacionTmp.*,
				catEstados.nombre as nombreEdo,
				municipios.nombre as nombreMun
				from evaluacionTmp
				left join catEstados on catEstados.id=evaluacionTmp.estadoHotel
				left join municipios on municipios.id=evaluacionTmp.municipioHotel
				where idUsuario=$idUsuario and ultimaSeccionLlenada<6";
			$resultado=$this->db->query($sql);
			while($linea=$resultado->fetch_assoc()){
				$arrTmp[]=$linea;
			}
			
			return($arrTmp);
		}
		
		function hacerArregloTamanosHotel()
		{
			$arrTmp=array();
			$sql="select * from catTamanosHotel order by id";
			$resultado=$this->db->query($sql);
			while($linea=$resultado->fetch_assoc()){
				$arrTmp[]=$linea;
			}
			
			return($arrTmp);
		}
		
		function hacerArregloVocaciones()
		{
			$arrTmp=array();
			$sql="select * from vocaciones order by id";
			$resultado=$this->db->query($sql);
			while($linea=$resultado->fetch_assoc()){
				$arrTmp[]=$linea;
			}
			
			return($arrTmp);
		}
		
		function hacerArregloAlimentos()
		{
			$arrTmp=array();
			$sql="select * from planAlimentos order by id";
			$resultado=$this->db->query($sql);
			while($linea=$resultado->fetch_assoc()){
				$arrTmp[]=$linea;
			}
			
			return($arrTmp);
		}
		
		function hacerArregloEstados()
		{
			$arrTmp=array();
			$sql="select id,idEstado,nombre from catEstados order by id";
			$resultado=$this->db->query($sql);
			while($linea=$resultado->fetch_assoc()){
				$arrTmp[]=$linea;
			}
			
			return($arrTmp);
		}
		
		function hacerArregloMunicipios()
		{
			$arrTmp=array();
			$sql="select  id,estado as categoria,nombre from municipios order by id";
			$resultado=$this->db->query($sql);
			while($linea=$resultado->fetch_assoc()){
				$arrTmp[]=$linea;
			}
			return($arrTmp);
		}
		
		function hacerArregloPreguntasCompleto()
		{
			$arrCategorias=array();
			$sql0="select id ,nombre,nombreCorto from categorias order by orden";
			$resultado=$this->db->query($sql0);
			while($linea=$resultado->fetch_assoc()){
				$arrCategorias[]=$linea;
			}
			
			$arrTemas=array();
			$sql1="select id,idCategoria,nombre,orden,'' as ponderacion from tema order by orden";
			$resultado=$this->db->query($sql1);
			while($linea=$resultado->fetch_assoc()){
				$arrTemas[]=$linea;
			}
			
			$arrPreguntas=array();
			$sql2="select id,idCategoria,idTema,nombre,orden,tipo,ayuda,'' as ponderacion, '' as valorRespuestaUsuario, '' as idRespuestaUsuario from pregunta order by orden";
			$resultado=$this->db->query($sql2);
			while($linea=$resultado->fetch_assoc()){
				$arrPreguntas[]=$linea;
			}
			
			$arrRespuestas=array();
			$sql3="select id,idPregunta ,respuesta as nombre,valorPonderado from respuesta order by orden";
			$resultado=$this->db->query($sql3);
			while($linea=$resultado->fetch_assoc()){
				$linea['respuestaAnotada']='';
				$arrRespuestas[]=$linea;
			}
			
			
			// insertar respuestas en preguntas
			$idResp=0;
			$arrResp=array();
			for($x=0;$x<=count($arrRespuestas);$x++){
				if($x==count($arrRespuestas)){
					for ($y = 0; $y < count($arrPreguntas); $y++) {
						if ($arrPreguntas[$y]['id'] == $idResp) {
							$arrPreguntas[$y]['respuestas'] = $arrResp;
						}
					}
				}else {
					if ($arrRespuestas[$x]['idPregunta'] != $idResp) {
						if ($x == 0) {
							$idResp = $arrRespuestas[$x]['idPregunta'];
							$arrResp[] = $arrRespuestas[$x];
						} else {
							for ($y = 0; $y < count($arrPreguntas); $y++) {
								if ($arrPreguntas[$y]['id'] == $idResp) {
									$arrPreguntas[$y]['respuestas'] = $arrResp;
								}
							}
							$idResp = $arrRespuestas[$x]['idPregunta'];
							$arrResp = array();
							$arrResp[] = $arrRespuestas[$x];
						}
					} else {
						$arrResp[] = $arrRespuestas[$x];
					}
				}
			}
			
			
			// insertar preguntas en temas
			$idPreg=0;
			$arrPreg=array();
			for($x=0;$x<=count($arrPreguntas);$x++){
				if($x==count($arrPreguntas)){
					for ($y = 0; $y < count($arrTemas); $y++) {
						if ($arrTemas[$y]['id'] == $idPreg) {
							$arrTemas[$y]['preguntas'] = $arrPreg;
						}
					}
				}else {
					if ($arrPreguntas[$x]['idTema'] != $idPreg) {
						if ($x == 0) {
							$idPreg = $arrPreguntas[$x]['idTema'];
							$arrPreg[] = $arrPreguntas[$x];
						} else {
							for ($y = 0; $y < count($arrTemas); $y++) {
								if ($arrTemas[$y]['id'] == $idPreg) {
									$arrTemas[$y]['preguntas'] = $arrPreg;
								}
							}
							$idPreg = $arrPreguntas[$x]['idTema'];
							$arrPreg = array();
							$arrPreg[] = $arrPreguntas[$x];
						}
					} else {
						$arrPreg[] = $arrPreguntas[$x];
					}
				}
			}
			
			// insertar temas en categorias
			$idTema=0;
			$arrT=array();
			for($x=0;$x<=count($arrTemas);$x++){
				if($x==count($arrTemas)){
					for ($y = 0; $y < count($arrCategorias); $y++) {
						if ($arrCategorias[$y]['id'] == $idTema) {
							$arrCategorias[$y]['temas'] = $arrT;
						}
					}
				}else {
					if ($arrTemas[$x]['idCategoria'] != $idTema) {
						if ($x == 0) {
							$idTema = $arrTemas[$x]['idCategoria'];
							$arrT[] = $arrTemas[$x];
						} else {
							for ($y = 0; $y < count($arrCategorias); $y++) {
								if ($arrCategorias[$y]['id'] == $idTema) {
									$arrCategorias[$y]['temas'] = $arrT;
								}
							}
							$idTema = $arrTemas[$x]['idCategoria'];
							$arrT = array();
							$arrT[] = $arrTemas[$x];
						}
					} else {
						$arrT[] = $arrTemas[$x];
					}
				}
			}
			
			return($arrCategorias);
		}
		
		function buscarHotel($id)
		{
			$sql="select * from hotel where id=$id";
			$resultado=$this->db->query($sql);
			$linea=$resultado->fetch_assoc();
			return($linea);
		}
		
		// calculo
		function traerPonderacionesTemas($campoPonderacion)
		{
			$arrTmp=array();
			$sql="select id,".$campoPonderacion." as ponderacion from tema";
			$resultado=$this->db->query($sql);
			while($linea=$resultado->fetch_assoc()){
				$arrTmp[]=$linea;
			}
			return($arrTmp);
		}
		
		function traerPonderacionesPreguntas($campoPonderacion)
		{
			$arrTmp=array();
			$sql="select id,".$campoPonderacion." as ponderacion from pregunta";
			$resultado=$this->db->query($sql);
			while($linea=$resultado->fetch_assoc()){
				$arrTmp[]=$linea;
			}
			return($arrTmp);
		}
		
		function getTipos()
		{
			$arrTmp=array();
			$sql="select id,nombre from catTipoHotel order by id";
			$resultado=$this->db->query($sql);
			while($linea=$resultado->fetch_assoc()){
				$arrTmp[]=$linea;
			}
			return($arrTmp);
		}
		
		function getTextoTamanoHotel($noCuartos)
		{
			$sql="select nombre from catTamanosHotel where minimo<=$noCuartos and maximo>=$noCuartos";
			$resultado=$this->db->query($sql);
			$linea=$resultado->fetch_assoc();
			return($linea['nombre']);
		}
		
		function getTextoTipoHotel($id)
		{
			$sql="select nombre from catTipoHotel where id=$id";
			$resultado=$this->db->query($sql);
			$linea=$resultado->fetch_assoc();
			return($linea['nombre']);
		}
		
		// borrar
		function grabarCuestionario($idUsusario,$nombreHotel,$tamanoHotel,$estadoHotel,$municipioHotel,$tipoHotel,$campoValoracion,$arrRespuestas)
		{
			/*
			$this->db->begin_transaction();
			$queryFallado='';
			$correcto=1;
		
			// insertar en hotel
			$sqlInsertHotel="insert into hotel(idUsuario, nombre, idTamano, idEstado, municipio, idTipo) values(
            '".$idUsusario."',
            '".$nombreHotel."',
            '".$tamanoHotel."',
            '".$estadoHotel."',
            '".$municipioHotel."',
            '".$tipoHotel."')";
			
			if(!$this->db->query($sqlInsertHotel)) {
				$correcto = 0;
				$queryFallado = $sqlInsertHotel;
			}else {
				$idInsertadoHotel = $this->db->insert_id;
				$sqlEvaluaciones = "insert into evaluaciones(idHotel, fecha, idUsuario) values(
					'" . $idInsertadoHotel . "',
					'" . HOY_MYSQL . "',
					'" . $idUsusario . "')";
				if (!$this->db->query($sqlEvaluaciones)) {
					$correcto = 0;
					$queryFallado = $sqlEvaluaciones;
				} else {
					$idInsertadoEvaluaciones = $this->db->insert_id;
					for ($x = 0; $x < count($arrRespuestas); $x++) {
						$sqlSecciones = "insert into resultadosSecciones(idEvaluaciones, idSeccion, puntuacionSeccion, totalObtenidoSeccion, totalPosibeSeccion) values ('" . $idInsertadoEvaluaciones . "','" . $arrRespuestas[$x]['id'] . "','" . $arrRespuestas[$x]['puntuacion'] . "','" . $arrRespuestas[$x]['totalObtenido'] . "','" . $arrRespuestas[$x]['totalPosible'] . "')";
						if (!$this->db->query($sqlSecciones)) {
							$correcto = 0;
							$queryFallado = $sqlSecciones;
						} else {
							$idInsertadoSeccion = $this->db->insert_id;
							for ($y = 0; $y < count($arrRespuestas[$x]['temas']); $y++) {
								$sqlTemas = "insert into resultadosTemas(idResultadosSecciones, idTema, ponderacion, porcentaje, puntuacion) values ('" . $idInsertadoSeccion . "','" . $arrRespuestas[$x]['temas'][$y]['id'] . "','" . $arrRespuestas[$x]['temas'][$y][$campoValoracion] . "','" . $arrRespuestas[$x]['temas'][$y]['porcentaje'] . "','" . $arrRespuestas[$x]['temas'][$y]['puntuacion'] . "')";
								if (!$this->db->query($sqlTemas)) {
									$correcto = 0;
									$queryFallado = $sqlTemas;
								} else {
									$idInsertadoTema = $this->db->insert_id;
									for ($z = 0; $z < count($arrRespuestas[$x]['temas'][$y]['preguntas']); $z++) {
										$sqlPreguntas = "insert into resultadosPreguntas(idResultadoTema, idPregunta, idRespuesta, ponderacion, valorRespuesta)
												values('" . $idInsertadoTema . "',
												'" . $arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['id'] . "',
												'" . $arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['idRespuesta'] . "',
												'" . $arrRespuestas[$x]['temas'][$y]['preguntas'][$z][$campoValoracion] . "',
												'" . $arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['valorRespuesta'] . "')";
										if (!$this->db->query($sqlPreguntas)) {
											$correcto = 0;
											$queryFallado = $sqlTemas;
										}
									}
								}
							}
						}
					}
				}
			}
			if($correcto==1) {
				$this->db->commit();
			}else{
				$this->db->rollback();
			}
			return($queryFallado);
			*/
		}
		
		// borrar
//		function grabarCuestionario1($idUsuario, $nombreHotel , $estadoHotel , $municipioHotel , $tipoHotel , $vocacionHotel ,
//									 $noCuartos , $cuartosDisponibles , $cuartosOcupados , $tarifa , $noHuespedes ,
//									 $revpar , $costoCuartoOcupado , $noColaboradores , $porcentajeHotelero ,
//									 $porcentajeVacacional , $porcentajeOtras , $anosOperando , $campoValoracion, $arrRespuestas)
//
//		{
//			$this->db->begin_transaction();
//			//$queryFallado='';
//			$correcto=1;
//
//			$sumaTotalesObtenidos=0;
//			$sumaTotalesPosibles=0;
//			for($x=0;$x<count($arrRespuestas);$x++){
//				$sumaTotalesObtenidos+=$arrRespuestas[$x]['totalObtenido'];
//				$sumaTotalesPosibles+=$arrRespuestas[$x]['totalPosible'];
//			}
//			$puntuacionTotal=$sumaTotalesObtenidos/$sumaTotalesPosibles*10;
//
//			// insertar en hotel
//			$sqlInsertHotel="insert into hotel (idUsuario,nombre ,idEstado ,idMunicipio ,idTipo ,vocacion ,noCuartos ,
//					cuartosDisponibles ,cuartosOcupados ,tarifa ,noHuespedes ,revpar ,costoCuartoOcupado ,noColaboradores ,
//					porcentajeHotelero ,porcentajeVacacional ,porcentajeOtras ,anosOperando) values ('".$idUsuario."',
//					'".$nombreHotel ."','".$estadoHotel ."','".$municipioHotel ."','".$tipoHotel ."','".$vocacionHotel ."',
//					'".$noCuartos ."','".$cuartosDisponibles ."','".$cuartosOcupados ."','".$tarifa ."','".$noHuespedes ."',
//					'".$revpar ."','".$costoCuartoOcupado ."','".$noColaboradores ."','".$porcentajeHotelero ."',
//					'".$porcentajeVacacional ."','".$porcentajeOtras ."','".$anosOperando ."')";
//
//			if(!$this->db->query($sqlInsertHotel)) {
//				$correcto = 0;
//				$queryFallado = "No se pudo grabar el hotel. Por favor vuelva a intentar.";
//			}else {
//				$idInsertadoHotel = $this->db->insert_id;
//				$sqlEvaluaciones = "insert into evaluaciones(idHotel, fecha, idUsuario,puntuacion) values(
//					'" . $idInsertadoHotel . "',
//					'" . HOY_MYSQL . "',
//					'" . $idUsuario . "',
//					'" . $puntuacionTotal . "')";
//				if (!$this->db->query($sqlEvaluaciones)) {
//					$correcto = 0;
//					$queryFallado = "No se pudo grabar la evaluación. Por favor vuelva a intentar.";
//				} else {
//					$idInsertadoEvaluaciones = $this->db->insert_id;
//					$valores='';
//					for ($x = 0; $x < count($arrRespuestas); $x++) {
//						for ($y = 0; $y < count($arrRespuestas[$x]['temas']); $y++) {
//							for ($z = 0; $z < count($arrRespuestas[$x]['temas'][$y]['preguntas']); $z++) {
//								if(!empty($valores)) $valores.=", ";
//								if(!isset($arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['idRespuesta'])){
//									$idRespuesta=0;
//								}else{
//									$idRespuesta=$arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['idRespuesta'];
//								}
//								$valores.="('" . $idInsertadoEvaluaciones . "',
//										'" . $arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['id'] . "',
//										'" . $idRespuesta . "',
//										'" . $arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['ponderacion'] . "',
//										'" . $arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['valorRespuesta'] . "')";
//							}
//						}
//					}
//					$sqlPreguntas = "insert into resultadosPreguntas(idEvaluacion, idPregunta, idRespuesta, ponderacion, valorRespuesta) values $valores";
//					if (!$this->db->query($sqlPreguntas)) {
//						$correcto = 0;
//						$queryFallado = "No se pudieron grabar las respuestas. Por favor vuelva a intentar.";
//					}
//				}
//			}
//			if($correcto==1) {
//				$this->db->commit();
//				$queryFallado=$idInsertadoHotel;
//			}else{
//				$this->db->rollback();
////				$queryFallado=0;
//			}
//			return($queryFallado);
//		}
		
		function grabarSoporte($idEvaluacionTmp,$idPregunta,$nombreArchivo,$ruta)
		{
			$sql= "insert into soportes(idEvalTmp,idPregunta,nombre,ruta) values(
                '" .$idEvaluacionTmp."',
                '".$idPregunta."',
                '".$nombreArchivo."',
                '".$ruta."')";
			if($this->db->query($sql)){
				$error='';
			}else{
				$error='No se pudo grabar el soporte en la tabla';
			}
			
			return($error);
		}
		
		function incializarAutoevaluacion($idUsuario,$idDefinitivoHotel,$nombreHotel, $estadoHotel, $municipioHotel, $tipoHotel,$vocacionHotel, $noCuartos, $cuartosDisponibles,
										  $cuartosOcupados, $tarifa, $noHuespedes, $revpar, $costoCuartoOcupado, $noColaboradores,
										  $anosOperando, $porcentajeHotelero, $porcentajeVacacional, $porcentajeOtras, $esCadena,$alimentos)
		{
			if($idDefinitivoHotel=='nuevo') {
				
				$idDefinitivoHotel=0;
			}
			$sql="insert into evaluacionTmp(idHotel,idUsuario,fecha,nombreHotel, estadoHotel, municipioHotel, tipoHotel, vocacion, noCuartos, cuartosDisponibles,
                          cuartosOcupados, tarifa, noHuespedes, revpar, costoCuartoOcupado, noColaboradores,
							anosOperando, porcentajeHotelero, porcentajeVacacional, porcentajeOtras, esCadena,alimentos,ultimaSeccionLlenada) values
					('".$idDefinitivoHotel."','".$idUsuario."','".HOY_MYSQL."','".$nombreHotel."','".$estadoHotel."','".$municipioHotel."','".$tipoHotel."','".$vocacionHotel."',
					'".$noCuartos."','".$cuartosDisponibles."','".$cuartosOcupados."','".$tarifa."',
					'".$noHuespedes."','".$revpar."','".$costoCuartoOcupado."','".$noColaboradores."',
					'".$anosOperando."','".$porcentajeHotelero."','".$porcentajeVacacional."',
					'".$porcentajeOtras."','".$esCadena."','".$alimentos."','1')";
			if($this->db->query($sql)){
				$idInsertado=$this->db->insert_id;
			}else{
				$idInsertado="Error: No se pudo grabar datos temporales. Por favor intente de nuevo.";
			}
			return($idInsertado);
		}
		
		function actualizarEvaluacionTemporal($idEvaluacionTmp,$arrCuestionario,$seccion)
		{
			//HOY_MYSQL
			// todo: serialize resuelto
			$arregloSerializado=serialize($arrCuestionario);
			$sql="update evaluacionTmp set
			fecha='".HOY_MYSQL."',
			arregloSerializado='".$arregloSerializado."', ultimaSeccionLlenada=$seccion
			where id=$idEvaluacionTmp";
			if($this->db->query($sql)){
				$error='';
//				if($seccion==6){
//					if(isset($))
//				}
			}else{
				$error="No se pudo grabar en tabla temporal en cuestionario";
			}
			return($error);
		}
		
//		function updateCuestionarioTmp($arrCuestionario,$idCuestionarioTmp)
//		{
			// todo: serialize comentado
//			$arregloSerializado=serialize($arrCuestionario);
//			$sql="update evaluacionTmp set arregloSerializado='".$arregloSerializado."', fecha='".HOY_MYSQL."' where id=$idCuestionarioTmp";
//		}
		
		function traerCuestionarioParcial($id)
		{
			$sql="select * from evaluacionTmp where id=$id";
			$resultado=$this->db->query($sql);
			$linea=$resultado->fetch_assoc();
			return($linea);
		}
		
		function inicializarHotelDefinitivo($idTmp)
		{
				$sql="insert into hotel (idUsuario, fecha, nombreHotel, estadoHotel, municipioHotel, tipoHotel, vocacion, noCuartos, cuartosDisponibles, cuartosOcupados, tarifa, noHuespedes, revpar, costoCuartoOcupado, noColaboradores, anosOperando, porcentajeHotelero, porcentajeVacacional, porcentajeOtras, esCadena, alimentos, ultimaSeccionLlenada)
					select idUsuario, fecha, nombreHotel, estadoHotel, municipioHotel, tipoHotel, vocacion, noCuartos, cuartosDisponibles, cuartosOcupados, tarifa, noHuespedes, revpar, costoCuartoOcupado, noColaboradores, anosOperando, porcentajeHotelero, porcentajeVacacional, porcentajeOtras, esCadena, alimentos, ultimaSeccionLlenada
					from evaluacionTmp where id=$idTmp";
				if($this->db->query($sql)){
					$idInsertado=$this->db->insert_id;
				}else{
					$idInsertado="Error: No se pudo grabar el hotel. Por favor intente de nuevo";
				}
				return($idInsertado);
		}
		
		function grabarEvaluacion($idInsertado,$idEvaluacionTmp,$arrRespuestas,$comentarios,$puntajeFinal='0')
		{
			$error='';
			$sql="select arregloSerializado from evaluacionTmp where id=$idEvaluacionTmp";
			$resultado=$this->db->query($sql);
			$linea=$resultado->fetch_assoc();
			$cuestionarioSerializado=$linea['arregloSerializado'];
			// todo: serialize resuelto
			$respuestasSerializadas=serialize($arrRespuestas);
			$sql1="insert into evaluaciones set idHotel=$idInsertado,fecha='".HOY_MYSQL."', cuestionarioSerializado='".$cuestionarioSerializado."', respuestasSerializado='".$respuestasSerializadas."', comentarios='".$comentarios."', puntuacion='".$puntajeFinal."'";
			if($this->db->query($sql1)){
				$idInsertado=$this->db->insert_id;
				$error=$idInsertado;
				$sql2="select count(*) as cuantos from soportes where idEvalTmp=$idEvaluacionTmp";
				$resultado=$this->db->query($sql2);
				$linea=$resultado->fetch_assoc();
				if($linea['cuantos']>0){
					$sql3="update soportes set idEvalDef=$idInsertado where idEvalTmp=$idEvaluacionTmp";
					if(!$this->db->query($sql3)){
						$error="No se pudieron actualizar los soportes. Por favor vuelva a intentar.";
					}
				}
			}else{
				$error="No se pudo grabar la evaluacion. Por favor vuelva a intentarlo";
			}
			return($error);
		}
		
		// get respuestas
		function getRespuestas($idEvaluacion)
		{
			$arrTmp=array();
			$sql="select * from resultadosPreguntas where idEvaluacion=$idEvaluacion order by id";
			$resultado=$this->db->query($sql);
			while($linea=$resultado->fetch_assoc()){
				$arrTmp[]=$linea;
			}
			
			return($arrTmp);
		}
		
		function getDatosHotel($idEvaluacion)
		{
			$sql="select hotel.*,evaluaciones.puntuacion
				from evaluaciones
				left join hotel on evaluaciones.idHotel=hotel.id
				where evaluaciones.id=$idEvaluacion";
			$resultado=$this->db->query($sql);
			$linea=$resultado->fetch_assoc();
			return($linea);
		}

		function getDatosHotelParaPdf($idEvaluacion)
		{
			$sql="select hotel.*,
				evaluaciones.puntuacion,evaluaciones.fecha,
				catEstados.nombre as nombreEstado,
				municipios.nombre as nombreMpo,
				catTipoHotel.nombre as nombreTipo,
				vocaciones.nombre as nombreVocacion,
				planAlimentos.nombre as nombreAlimentos
				from evaluaciones
				left join hotel on evaluaciones.idHotel=hotel.id
				left join catEstados on catEstados.id=hotel.estadoHotel
				left join municipios on municipios.id=hotel.municipioHotel
				left join catTipoHotel on catTipoHotel.id=hotel.tipoHotel
				left join  vocaciones on vocaciones.id=hotel.vocacion
				left join  planAlimentos on planAlimentos.id=hotel.alimentos
				where evaluaciones.id=$idEvaluacion";
			$resultado=$this->db->query($sql);
			$linea=$resultado->fetch_assoc();
			return($linea);
		}
		
		
		// pdf
		function getLeyendas()
		{
			$arrTmp=array();
			$sql="select * from textos ";
			$resultado=$this->db->query($sql);
			while($linea=$resultado->fetch_assoc()){
				$arrTmp[$linea['etiqueta']]=$linea['texto'];
			}
			
			return($arrTmp);
		}
		
		// plan
		function grabarPlan($idHotel,$idEvaluacion,$resultadoPersonas, $resultadoPaz, $resultadoProsperidad, $resultadoPlaneta, $resultadoAlianzas,
						$arrAccionesPersonasPlan, $arrAccionesPazPlan, $arrAccionesProsperidadPlan, $arrAccionesPlanetaPlan, $arrAccionesAlianzasPlan)
		{
			$error='';
			$sql1="insert into planes(idHotel,idEvaluacion, resultadoPersonas, resultadoPaz, resultadoProsperidad, resultadoPlaneta, resultadoAlianzas) values
				('".$idHotel."','".$idEvaluacion."','".$resultadoPersonas."','".$resultadoPaz."','".$resultadoProsperidad."','".$resultadoPlaneta."','".$resultadoAlianzas."')";
			if($this->db->query($sql1)){
				$idInsertado=$this->db->insert_id;
				$textoValores='';
				for($x=0;$x<count($arrAccionesPersonasPlan);$x++){
					if(!empty($textoValores)) $textoValores.=",";
					$textoValores.="($idInsertado,'personas','".$arrAccionesPersonasPlan[$x]['accion']."', '".$arrAccionesPersonasPlan[$x]['indicador']."', '".$arrAccionesPersonasPlan[$x]['responsable']."', '".$arrAccionesPersonasPlan[$x]['fecha']."')";
				}
				for($x=0;$x<count($arrAccionesPazPlan);$x++){
					if(!empty($textoValores)) $textoValores.=",";
					$textoValores.="($idInsertado,'paz','".$arrAccionesPazPlan[$x]['accion']."', '".$arrAccionesPazPlan[$x]['indicador']."', '".$arrAccionesPazPlan[$x]['responsable']."', '".$arrAccionesPazPlan[$x]['fecha']."')";
				}
				for($x=0;$x<count($arrAccionesProsperidadPlan);$x++){
					if(!empty($textoValores)) $textoValores.=",";
					$textoValores.="($idInsertado,'prosperidad','".$arrAccionesProsperidadPlan[$x]['accion']."', '".$arrAccionesProsperidadPlan[$x]['indicador']."', '".$arrAccionesProsperidadPlan[$x]['responsable']."', '".$arrAccionesProsperidadPlan[$x]['fecha']."')";
				}
				for($x=0;$x<count($arrAccionesPlanetaPlan);$x++){
					if(!empty($textoValores)) $textoValores.=",";
					$textoValores.="($idInsertado,'planeta','".$arrAccionesPlanetaPlan[$x]['accion']."', '".$arrAccionesPlanetaPlan[$x]['indicador']."', '".$arrAccionesPlanetaPlan[$x]['responsable']."', '".$arrAccionesPlanetaPlan[$x]['fecha']."')";
				}
				for($x=0;$x<count($arrAccionesAlianzasPlan);$x++){
					if(!empty($textoValores)) $textoValores.=",";
					$textoValores.="($idInsertado,'alianzas','".$arrAccionesAlianzasPlan[$x]['accion']."', '".$arrAccionesAlianzasPlan[$x]['indicador']."', '".$arrAccionesAlianzasPlan[$x]['responsable']."', '".$arrAccionesAlianzasPlan[$x]['fecha']."')";
				}
				
				$sql2="insert into accionesPlan(idPlan, categoria, accion, indicador, responsable, fecha) values $textoValores";
				if(!$this->db->query($sql2)){
					$error="No se pudo grabar el Plan. Por favor intente de nuevo";
				}
			}else{
				$error="No se pudo grabar el Plan. Por favor intente de nuevo";
			}
			return($error);
		}
		
		function traerPlan($id)
		{
			$sql="select planes.*,
       		hotel.nombreHotel
       		from planes
			left join hotel on hotel.id=planes.idHotel
			where planes.id=$id";
			$resultado=$this->db->query($sql);
			$linea=$resultado->fetch_assoc();
			
			$arrTmp=array();
			$sql1="select * from accionesPlan where idPlan=$id order by id";
			$resultado1=$this->db->query($sql1);
			while($linea1=$resultado1->fetch_assoc()){
				$arrTmp[]=$linea1;
			}
			$linea['acciones']=$arrTmp;
			return($linea);
		}
		
		// historial
		function traerCuestionario($idEvaluacion)
		{
//			$arrTmp=array();
			$sql="select cuestionarioSerializado, respuestasSerializado from evaluaciones where id=$idEvaluacion";
			$resultado=$this->db->query($sql);
			$linea=$resultado->fetch_assoc();
			// todo: unserialize resuelto
			$cuestionario=unserialize($linea['cuestionarioSerializado']);
			
			// todo: unserialize pendiente de revision
			$respuestas=unserialize($linea['respuestasSerializado']);
			$datos=array('cuestionario'=>$cuestionario, 'respuestas'=>$respuestas);
			return($datos);
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
