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
			$sql="select count(*) as cuantos from revisores where usuario='".$usuario."' && clave='".$clave."' ";
			$resultado=$this->db->query($sql);
			$linea=$resultado->fetch_assoc();
			if($linea['cuantos']==1) {
				$sql1="select * from revisores where usuario='".$usuario."' && clave='".$clave."' ";
				$resultado1=$this->db->query($sql1);
				
				$datosUsuario=$resultado1->fetch_assoc();
				$datosUsuario['nombreCompleto']=$datosUsuario['nombres']." ".$datosUsuario['paterno']." ".$datosUsuario['materno'];
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
			$sql="select hotel.*,catEstados.nombre as nombreEstado,catTipoHotel.nombre as nombreTipo from hotel
					left join catEstados  on hotel.estadoHotel= catEstados.id
					left join catTipoHotel  on catTipoHotel.id = hotel.tipoHotel
					where hotel.idUsuario=$idUsuario order by id";
			$resultado=$this->db->query($sql);
			while($linea=$resultado->fetch_assoc()){
				$arrTmp[]=$linea;
			}
			
			for($x=0;$x<count($arrTmp);$x++){
				$arrTmp1=array();
				$sql1="select id,fecha,puntuacion from evaluaciones where idHotel=".$arrTmp[$x]['id'];
				$resultado1=$this->db->query($sql1);
				while($linea1=$resultado1->fetch_assoc()){
					$arrTmp1[]=$linea1;
				}
				$arrTmp[$x]['evaluaciones']=$arrTmp1;
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
		
		function hacerArregloEstados()
		{
			$arrTmp=array();
			$sql="select id,nombre from catEstados order by id";
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
			$sql1="select * from tema order by orden";
			$resultado=$this->db->query($sql1);
			while($linea=$resultado->fetch_assoc()){
				$arrTemas[]=$linea;
			}
			
			$arrPreguntas=array();
			$sql2="select pregunta.*, '' as valorRespuestaUsuario, '' as idRespuestaUsuario from pregunta order by orden";
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
		
		// calculo
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
		
		function getTextoTamanoHotel($id)
		{
			$sql="select nombre from catTamanosHotel where id=$id";
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
		
		function grabarCuestionario1($idUsusario,$nombreHotel,$tamanoHotel,$estadoHotel,$municipioHotel,$tipoHotel,$campoValoracion,$arrRespuestas)
		{
			$this->db->begin_transaction();
			//$queryFallado='';
			$correcto=1;
			
			$sumaTotalesObtenidos=0;
			$sumaTotalesPosibles=0;
			for($x=0;$x<count($arrRespuestas);$x++){
				$sumaTotalesObtenidos+=$arrRespuestas[$x]['totalObtenido'];
				$sumaTotalesPosibles+=$arrRespuestas[$x]['totalPosible'];
			}
			$puntuacionTotal=$sumaTotalesObtenidos/$sumaTotalesPosibles*10;
			
			// insertar en hotel
			$sqlInsertHotel="insert into hotel(idUsuario, nombreHotel, estadoHotel, municipioHotel, tipoHotel) values(
            '".$idUsusario."',
            '".$nombreHotel."',
            '".$estadoHotel."',
            '".$municipioHotel."',
            '".$tipoHotel."')";
			
			if(!$this->db->query($sqlInsertHotel)) {
				$correcto = 0;
				//$queryFallado = "No se pudo grabar el hotel. Por favor vuelva a intentar.";
			}else {
				$idInsertadoHotel = $this->db->insert_id;
				$sqlEvaluaciones = "insert into evaluaciones(idHotel, fecha, idUsuario,puntuacion) values(
					'" . $idInsertadoHotel . "',
					'" . HOY_MYSQL . "',
					'" . $idUsusario . "',
					'" . $puntuacionTotal . "')";
				if (!$this->db->query($sqlEvaluaciones)) {
					$correcto = 0;
					//$queryFallado = "No se pudo grabar la evaluación. Por favor vuelva a intentar.";
				} else {
					$idInsertadoEvaluaciones = $this->db->insert_id;
					$valores='';
					for ($x = 0; $x < count($arrRespuestas); $x++) {
						for ($y = 0; $y < count($arrRespuestas[$x]['temas']); $y++) {
							for ($z = 0; $z < count($arrRespuestas[$x]['temas'][$y]['preguntas']); $z++) {
								if(!empty($valores)) $valores.=", ";
								$valores.="('" . $idInsertadoEvaluaciones . "',
										'" . $arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['id'] . "',
										'" . $arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['idRespuesta'] . "',
										'" . $arrRespuestas[$x]['temas'][$y]['preguntas'][$z][$campoValoracion] . "',
										'" . $arrRespuestas[$x]['temas'][$y]['preguntas'][$z]['valorRespuesta'] . "')";
							}
						}
					}
					$sqlPreguntas = "insert into resultadosPreguntas(idEvaluacion, idPregunta, idRespuesta, ponderacion, valorRespuesta) values $valores";
					if (!$this->db->query($sqlPreguntas)) {
						$correcto = 0;
						//$queryFallado = "No se pudieron grabar las respuestas. Por favor vuelva a intentar.";
					}
				}
			}
			if($correcto==1) {
				$this->db->commit();
				$queryFallado=$idInsertadoHotel;
			}else{
				$this->db->rollback();
				$queryFallado=0;
			}
			return($queryFallado);
		}
		
		function grabarSoporte($idHotel,$idPregunta,$nombreArchivo,$ruta)
		{
			$sql="insert into soportes(idHotel,idPregunta,nombre,ruta) values(
                '".$idHotel."',
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
			$sql="select hotel.*
				from evaluaciones
				left join hotel on evaluaciones.idHotel=hotel.id
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
		function grabarPlan($idHotel,$resultadoPersonas, $resultadoPaz, $resultadoProsperidad, $resultadoPlaneta, $resultadoAlianzas,
						$arrAccionesPersonasPlan, $arrAccionesPazPlan, $arrAccionesProsperidadPlan, $arrAccionesPlanetaPlan, $arrAccionesAlianzasPlan)
		{
			$sql1="insert into planes(idHotel, resultadoPersonas, resultadoPaz, resultadoProsperidad, resultadoPlaneta, resultadoAlianzas) values
				('".$idHotel."','".$resultadoPersonas."','".$resultadoPaz."','".$resultadoProsperidad."','".$resultadoPlaneta."','".$resultadoAlianzas."')";
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
				$this->db->query($sql2);
			}
		}
		
		// dashboard
		function hacerResumenTipo()
		{
			$arrTmp=array();
			$sql="select count(hotel.id) as cuantos,
			catTipoHotel.nombre
			from hotel
			left join catTipoHotel on catTipoHotel.id=hotel.tipoHotel
			group by hotel.tipoHotel";
			$resultado=$this->db->query($sql);
			while($linea=$resultado->fetch_assoc()){
				$arrTmp[]=$linea;
			}
			return($arrTmp);
		}
		
		// administrador
		function hacerArregloEvaluacionesAdmin()
		{
			$arrTmp=array();
			$sql="select evaluaciones.*,
				hotel.nombreHotel as nombreHotel,
				concat(usuarios.nombres,' ',usuarios.paterno,' ',usuarios.materno) as nombreUsuario
				from evaluaciones
				left join hotel on hotel.id=evaluaciones.idHotel
				left join usuarios on usuarios.id=evaluaciones.idUsuario
				order by id";
			$resultado=$this->db->query($sql);
			while($linea=$resultado->fetch_assoc()){
				$arrTmp[]=$linea;
			}
			
			return($arrTmp);
		}
		
		function hacerArrEvaluadores()
		{
			$arrTmp=array();
			$sql="select id,concat(nombres,' ',paterno, ' ', materno) as nombre from revisores where rol='evaluador' order by id";
			$resultado=$this->db->query($sql);
			while($linea=$resultado->fetch_assoc()){
				$arrTmp[]=$linea;
			}
			
			return($arrTmp);
		}
		
		function hacerArregloPlanesAdmin()
		{
			$arrTmp=array();
			$sql="select planes.id ,planes.idHotel,planes.idEvaluacion, evaluaciones.fecha,
       				hotel.nombreHotel as nombreHotel
					from planes
					left join evaluaciones on evaluaciones.id=planes.idEvaluacion
					left join hotel on hotel.id=planes.idHotel
					order by planes.id";
			$resultado=$this->db->query($sql);
			while($linea=$resultado->fetch_assoc()){
				$arrTmp[]=$linea;
			}
			
			return($arrTmp);
		}
		
		function ponerEvaluador($idEvaluacion,$idEvaluador)
		{
			$error='';
			$sql="update evaluaciones set idRevisor=$idEvaluador where id=$idEvaluacion";
			if(!$this->db->query($sql)) $error='No se pudo actualizar el evaluador para la evaluación. Por favor vuelva a intentar.';
			
			return($error);
		}
		
		function getDatosPlan($id)
		{
			$sql="select planes.* , evaluaciones.fecha,
       				hotel.nombreHotel as nombreHotel
					from planes
					left join evaluaciones on evaluaciones.id=planes.idEvaluacion
					left join hotel on hotel.id=planes.idHotel
					where planes.id=$id";
			
//			$sql="select * from planes where id=$id";
			$resultado=$this->db->query($sql);
			$linea=$resultado->fetch_assoc();
			
			$arrPersonas=array();
			$arrPaz=array();
			$arrProsperidad=array();
			$arrPlaneta=array();
			$arrAlianzas=array();
			$sql1="select * from accionesPlan where idPlan=$id order by categoria,id";
			
			$resultado1=$this->db->query($sql1);
			while($linea1=$resultado1->fetch_assoc()){
				switch($linea1['categoria']){
					case 'personas':
						$arrPersonas[]=$linea1;
						break;
					case 'paz':
						$arrPaz[]=$linea1;
						break;
					case 'prosperidad':
						$arrProsperidad[]=$linea1;
						break;
					case 'planeta':
						$arrPlaneta[]=$linea1;
						break;
					case 'alianzas':
						$arrAlianzas[]=$linea1;
						break;
				}
				
			}
			$linea['personas']=$arrPersonas;
			$linea['paz']=$arrPaz;
			$linea['prosperidad']=$arrProsperidad;
			$linea['planeta']=$arrPlaneta;
			$linea['alianzas']=$arrAlianzas;
				return($linea);
		}
		
		function getEvidenciasAutoevaluacion($id)
		{
			$arrTmp=array();
			$sql="select soportes.*, pregunta.nombre as pregunta
				from soportes
				left join pregunta on pregunta.id=soportes.idPregunta
				where soportes.idEvalDef=$id";
			$resultado=$this->db->query($sql);
			while($linea=$resultado->fetch_assoc()){
				$arrTmp[]=$linea;
			}
			
			return($arrTmp);
		}
		
		// evaluador
		function hacerArregloEvaluaciones($idRevisor)
		{
			$arrTmp=array();
			//$sql="select * from evaluaciones where idRevisor='".$idRevisor."' order by id";
			
			$sql="select evaluaciones.*,
				hotel.nombreHotel as nombreHotel,
				concat(usuarios.nombres,' ',usuarios.paterno,' ',usuarios.materno) as nombreUsuario
				from evaluaciones
				left join hotel on hotel.id=evaluaciones.idHotel
				left join usuarios on usuarios.id=evaluaciones.idUsuario
				where idRevisor='".$idRevisor."' order by id";
			
			
			$resultado=$this->db->query($sql);
			while($linea=$resultado->fetch_assoc()){
				$arrTmp[]=$linea;
			}
			
			return($arrTmp);
		}
		
		function traerEvaluacion($id)
		{
			$arrTmp=array();
			$sql="select id, cuestionarioSerializado from evaluaciones where id = $id";
			$resultado=$this->db->query($sql);
			$linea=$resultado->fetch_assoc();
			$arrTmp[]=$linea;
			return($arrTmp);
		}
		
		function hacerArrSoportes($idEvaluacion)
		{
			$arrTmp=array();
			$sql="select * from soportes where idEvalDef=$idEvaluacion";
			$resultado=$this->db->query($sql);
			while($linea=$resultado->fetch_assoc()){
				$arrTmp[]=$linea;
			}
			return($arrTmp);
			
		}
		
		function grabarEvaluacion($idEvaluacion,$arrCuestionario)
		{
			//HOY_MYSQL
			$arregloSerializado=serialize($arrCuestionario);
			$sql="update evaluaciones set
			fecha='".HOY_MYSQL."',
			cuestionarioEvaluadorSerializado='".$arregloSerializado."'
			where id=$idEvaluacion";
			if($this->db->query($sql)){
				$error='';
			}else{
				$error="No se pudo grabar en tabla temporal en cuestionario";
			}
			return($error);
		}
		
	}
