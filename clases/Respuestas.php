<?php
require_once('fpdf/fpdf.php');

class Respuestas extends FPDF
{
	var $logo="imagenes/respuestasHeader.png";
	var $anchoLogo=197;
	var $altoLogo=28;
	var $logoX=12;
	var $logoY=7;
	var $arrDatosInciales=array();
	var $arrDatos=array();
	var $margen1=20;
	var $margen2=105;
	var $margen3=25;
	var $margen4=30;
	var $margen5=50;
	var $inicioVertical=40;
	
	
	
	var $fondo="imagenes/fondo.jpg";
	var $descripcion1="imagenes/descripcion1.png";
	
	
//	var $inicioVertical=104;
	var $offsetVertical=0;
	var $arrLeyendas=array();
	
	// datos hotel
	var $tipoHotel;
	var $nombreHotel;
	var $tamanoHotel;
	var $municipioHotel;
	var $estadoHotel;
	
	// graficas
	var $graficaGeneral;
	var $graficaPersonas;
	var $graficaPaz;
	var $graficaProsperidad;
	var $graficaPlaneta;
	var $graficaPaternariato;
	
	// logos
	var $personasLogo="imagenes/personas.gif";
	var $pazLogo="imagenes/paz.png";
	var $prosperidadLogo="imagenes/prosperidad.png";
	var $planetaLogo="imagenes/planeta.png";
	var $paternariatoLogo="imagenes/paternariato.png";
	
	///////////////
	
	function ponerLogo()
	{
		$this->Image($this->logo,$this->logoX,$this->logoY,$this->anchoLogo,$this->altoLogo);
	}
	
	function ponerDatosIniciales($arrTmp)
	{
		$this->arrDatosInciales=$arrTmp;
	}
	
	
	function ponerDatos($arrDatos)
	{
		$this->arrDatos=$arrDatos;
	}
	
	function ponerPag1()
	{
		$this->SetTextColor(0,0,0);
		$this->SetFont('Helvetica','B',14);
		
		// nombre hotel
		$this->SetXY($this->margen1,$this->inicioVertical);
		$nombreHotel="Hotel: ".utf8_decode($this->arrDatosInciales['nombreHotel']);
		$this->MultiCell(120, 7, $nombreHotel , 0, "L", false);
		
		// fecha
		$horizontal=$this->margen1+120;
		$this->SetXY($horizontal,$this->inicioVertical);
		$fecha="Fecha: ".utf8_decode($this->arrDatosInciales['fecha']);
		$this->MultiCell(60, 7,$fecha , 0, "L", false);
		
		// lista de valores
		$this->SetFont('Helvetica','B',10);
		
		$vertical=$this->inicioVertical+20;
		$this->SetXY($this->margen1,$vertical);
		$this->MultiCell(85, 9,utf8_decode("Nombre del hotel" ), 0, "L", false);
		$this->setXY($this->margen2,$vertical);
		$this->MultiCell(95, 9,utf8_decode($this->arrDatosInciales['nombreHotel']) , 0, "L", false);
		
		$vertical=$this->getY();
		$this->SetXY($this->margen1,$vertical);
		$this->MultiCell(85, 9,utf8_decode("Estado") , 0, "L", false);
		$this->setXY($this->margen2,$vertical);
		$this->MultiCell(95, 9,utf8_decode($this->arrDatosInciales['nombreEstado']) , 0, "L", false);
		
		$vertical=$this->getY();
		$this->SetXY($this->margen1,$vertical);
		$this->MultiCell(85, 9,utf8_decode("Municipio") , 0, "L", false);
		$this->setXY($this->margen2,$vertical);
		$this->MultiCell(95, 9,utf8_decode($this->arrDatosInciales['nombreMpo']) , 0, "L", false);
		
		$vertical=$this->getY();
		$this->SetXY($this->margen1,$vertical);
		$this->MultiCell(85, 9,utf8_decode("Tipo de destino") , 0, "L", false);
		$this->setXY($this->margen2,$vertical);
		$this->MultiCell(95, 9,utf8_decode($this->arrDatosInciales['nombreTipo']) , 0, "L", false);
		
		$vertical=$this->getY();
		$this->SetXY($this->margen1,$vertical);
		$this->MultiCell(85, 9,utf8_decode("Vocación de servicio") , 0, "L", false);
		$this->setXY($this->margen2,$vertical);
		$this->MultiCell(95, 9,utf8_decode($this->arrDatosInciales['nombreVocacion']) , 0, "L", false);
		
		$vertical=$this->getY();
		$this->SetXY($this->margen1,$vertical);
		$this->MultiCell(85, 9,utf8_decode("De que manera se incluyen los alimentos ") , 0, "L", false);
		$this->setXY($this->margen2,$vertical);
		$this->MultiCell(95, 9,utf8_decode($this->arrDatosInciales['nombreAlimentos']) , 0, "L", false);
		
		$vertical=$this->getY();
		$this->SetXY($this->margen1,$vertical);
		$this->MultiCell(85, 9,utf8_decode("Número total de cuartos") , 0, "L", false);
		$this->setXY($this->margen2,$vertical);
		$this->MultiCell(95, 9,utf8_decode($this->arrDatosInciales['noCuartos']) , 0, "L", false);
		
		$vertical=$this->getY();
		$this->SetXY($this->margen1,$vertical);
		$this->MultiCell(85, 9,utf8_decode("Cuartos disponibles promedio") , 0, "L", false);
		$this->setXY($this->margen2,$vertical);
		$this->MultiCell(95, 9,utf8_decode($this->arrDatosInciales['cuartosDisponibles']) , 0, "L", false);
		
		$vertical=$this->getY();
		$this->SetXY($this->margen1,$vertical);
		$this->MultiCell(85, 9,utf8_decode("Cuartos ocupados promedio") , 0, "L", false);
		$this->setXY($this->margen2,$vertical);
		$this->MultiCell(95, 9,utf8_decode($this->arrDatosInciales['cuartosOcupados']) , 0, "L", false);
		
		$vertical=$this->getY();
		$this->SetXY($this->margen1,$vertical);
		$this->MultiCell(85, 9,utf8_decode("Tarifa promedio") , 0, "L", false);
		$this->setXY($this->margen2,$vertical);
		$this->MultiCell(95, 9,number_format($this->arrDatosInciales['tarifa'],2,'.',',') , 0, "L", false);
		
		$vertical=$this->getY();
		$this->SetXY($this->margen1,$vertical);
		$this->MultiCell(85, 9,utf8_decode("Número de huespedes atendidos el último año") , 0, "L", false);
		$this->setXY($this->margen2,$vertical);
		$this->MultiCell(95, 9,utf8_decode($this->arrDatosInciales['noHuespedes']) , 0, "L", false);
		
		$vertical=$this->getY();
		$this->SetXY($this->margen1,$vertical);
		$this->MultiCell(85, 9,utf8_decode("REVPAR") , 0, "L", false);
		$this->setXY($this->margen2,$vertical);
		$this->MultiCell(95, 9,utf8_decode($this->arrDatosInciales['revpar']) , 0, "L", false);
		
		$vertical=$this->getY();
		$this->SetXY($this->margen1,$vertical);
		$this->MultiCell(85, 9,utf8_decode("Costo por cuarto ocupado") , 0, "L", false);
		$this->setXY($this->margen2,$vertical);
		$this->MultiCell(95, 9,number_format($this->arrDatosInciales['costoCuartoOcupado'],2,'.',','), 0, "L", false);
		
		$vertical=$this->getY();
		$this->SetXY($this->margen1,$vertical);
		$this->MultiCell(85, 9,utf8_decode("Número total de colaboradores") , 0, "L", false);
		$this->setXY($this->margen2,$vertical);
		$this->MultiCell(95, 9,utf8_decode($this->arrDatosInciales['noColaboradores']) , 0, "L", false);
		
		$vertical=$this->getY();
		$this->SetXY($this->margen1,$vertical);
		$this->MultiCell(85, 9,utf8_decode("Número de años operando") , 0, "L", false);
		$this->setXY($this->margen2,$vertical);
		$this->MultiCell(95, 9,utf8_decode($this->arrDatosInciales['anosOperando']) , 0, "L", false);
		
		$vertical=$this->getY();
		$this->SetXY($this->margen1,$vertical);
		$this->MultiCell(180, 7,utf8_decode("Distribución porcentual del negocio de los servicios de hospedaje") , 0, "L", false);
		
		$vertical=$this->getY();
		$this->SetXY($this->margen1,$vertical);
		$this->MultiCell(85, 9,utf8_decode("% que es hotelero") , 0, "L", false);
		$this->setXY($this->margen2,$vertical);
		$valor=number_format($this->arrDatosInciales['porcentajeHotelero'],0,'.',',')."%";
		$this->MultiCell(95, 9,$valor , 0, "L", false);
		
		$vertical=$this->getY();
		$this->SetXY($this->margen1,$vertical);
		$this->MultiCell(85, 9,utf8_decode("% que es vacional") , 0, "L", false);
		$this->setXY($this->margen2,$vertical);
		$valor=number_format($this->arrDatosInciales['porcentajeVacacional'],0,'.',',')."%";
		$this->MultiCell(95, 9,$valor , 0, "L", false);
		
		$vertical=$this->getY();
		$this->SetXY($this->margen1,$vertical);
		$this->MultiCell(85, 9,utf8_decode("% que es de otras modalidades") , 0, "L", false);
		$this->setXY($this->margen2,$vertical);
		$valor=number_format($this->arrDatosInciales['porcentajeOtras'],0,'.',',')."%";
		$this->MultiCell(95, 9,$valor , 0, "L", false);
	}
	
	function ponerPagina2()
	{
		
		$this->SetTextColor(0,0,0);
		$this->SetFont('Helvetica','B',11);
		$this->SetXY($this->margen1,$this->inicioVertical);
		$this->MultiCell(100, 7, utf8_decode("Pilar de la agenda 2030") , 0, "L", false);
		
		
		//$this->SetTextColor(0,0,0);
		for($x=0;$x<count($this->arrDatos);$x++){
			// nombre de categoria
			$this->SetTextColor(4,130,155);
			$this->SetFont('Helvetica','B',12);
			$vertical=$this->getY();
			$this->SetXY($this->margen1,$vertical);
			$this->MultiCell(160, 7, utf8_decode($this->arrDatos[$x]['nombreCorto']) , 0, "L", false);
			
			// nombre de tema
			for($y=0;$y<count($this->arrDatos[$x]['temas']);$y++){
				$this->SetTextColor(0,0,0);
				$this->SetFont('Helvetica','B',10);
				$vertical=$this->getY();
				$this->SetXY($this->margen3,$vertical);
				$this->MultiCell(155, 7, utf8_decode($this->arrDatos[$x]['temas'][$y]['nombre']) , 0, "L", false);
				
				// pregunta
				for($z=0;$z<count($this->arrDatos[$x]['temas'][$y]['preguntas']);$z++){
					$this->SetTextColor(100,100,100);
					$this->SetFont('Helvetica','',10);
					$vertical=$this->getY();
					$this->SetXY($this->margen4,$vertical);
					$this->MultiCell(150, 5, utf8_decode($this->arrDatos[$x]['temas'][$y]['preguntas'][$z]['nombre']) , 0, "L", false);
					$vertical=$this->getY();
					$this->SetXY($this->margen5,$vertical);
					$textoRespuesta=$this->construirRespuesta($this->arrDatos[$x]['temas'][$y]['preguntas'][$z]);
					$this->MultiCell(130, 5, utf8_decode($textoRespuesta) , 0, "L", false);
					$this->setY($this->getY()+5);
					
				}
			}
		}
	}
	///////////////
	
	
	
	function construirRespuesta($arreglo)
	{
		$respuestaEscogida='';
		switch($arreglo['tipo']){
			case 'checkBoxes':
				$texto='';
				for($q=0;$q<count($arreglo['respuestas']);$q++){
					if($arreglo['respuestas'][$q]['respuestaAnotada']==1){
						if(!empty($texto)) $texto.=', ';
						$texto.=$arreglo['respuestas'][$q]['nombre'];
					}
				}
				$respuestaEscogida=$texto;
				break;
			case 'radioButton':
				for($q=0;$q<count($arreglo['respuestas']);$q++){
					if($arreglo['respuestas'][$q]['id']  ==  $arreglo['idRespuestaUsuario']){
						$respuestaEscogida=$arreglo['respuestas'][$q]['nombre'];
					}
				}
				break;
			case 'calculo':
				if($arreglo['respuestas']['2']['respuestaAnotada']==1){
					$respuestaEscogida=$arreglo['respuestas']['2']['nombre'];
				}else{
					$maximo=$respuestaEscogida=$arreglo['respuestas']['0']['respuestaAnotada'];
					$minimo=$respuestaEscogida=$arreglo['respuestas']['1']['respuestaAnotada'];
					$proporcion=$minimo/$maximo*100;
					$respuestaEscogida=$maximo." - ".$minimo."($proporcion%)";
				}
				break;
			case 'numero':

				$respuestaUsuario=$arreglo['valorRespuestaUsuario'];
				if($respuestaUsuario>2){
					$indice=3;
				}else if($respuestaUsuario==2){
					$indice=2;
				}else if($respuestaUsuario==1){
					$indice=1;
				}else{
					$indice=0;
				}
				$respuestaEscogida=$arreglo['respuestas'][$indice]['nombre'];
				break;
			default:
				$respuestaEscogida='Por definir';
				break;
		}
		return($respuestaEscogida);
	}
	
	function ponerFondo()
	{
	$this->Image($this->fondo,'0','0','215.9','279.4');
	//		$this->Image($this->logo,$this->logoX,$this->logoY,$this->anchoLogo,$this->altoLogo);
	}
	

	
	function ponerDesc1()
	{
	$this->Image($this->descripcion1,'12.5','54','197','33');
	}
	
	function ponerTexto1()
	{
	$hoy=date('d-m-Y');
	$this->SetTextColor(0,0,0);
	
	// datos generales en encabezado
	$this->SetFont('Helvetica','B',10);
	$this->SetXY(44,33);
	$texto="Hotel: ";
	$this->MultiCell(132, 5, utf8_decode($texto) , 0, "L", false);
	$this->SetXY(110,33);
	$texto="Tamaño: ";
	$this->MultiCell(132, 5, utf8_decode($texto) , 0, "L", false);
	
	$this->SetFont('Helvetica','',10);
	$this->SetXY(55,33);
	//        $textoFecha="Krystal Cancún";
	$this->MultiCell(132, 5, utf8_decode($this->nombreHotel) , 0, "L", false);
	$this->SetFont('Helvetica','',10);
	$this->SetXY(130,33);
	//$textoFecha="Grande-mas-de-151-habitaciones";
	$this->MultiCell(128, 5, utf8_decode($this->tamanoHotel) , 0, "L", false);
	
	///////////////////////////
	$this->SetXY(44,44);
	$this->SetFont('Helvetica','B',10);
	$texto="Localización: ";
	$this->MultiCell(132, 5, utf8_decode($texto) , 0, "L", false);
	$this->SetXY(110,44);
	$texto="Fecha de evaluación: ";
	$this->MultiCell(132, 5, utf8_decode($texto) , 0, "L", false);
	
	$this->SetFont('Helvetica','',10);
	$this->SetXY(70,44);
	//		$textoEstado="Cancún, Quintana Roo";
	$this->MultiCell(132, 5, utf8_decode($this->estadoHotel) , 0, "L", false);
	$this->SetFont('Helvetica','',10);
	$this->SetXY(150,44);
	//		$textoFecha="11-07-2019";
	$this->MultiCell(132, 5, utf8_decode($hoy) , 0, "L", false);
	
	$nuevaY=$this->GetY();
	$nuevaY+=45;
	
	// titulo antes de recuadro general
	$this->SetTextColor(41,194,253);//41–194–253
	$this->SetFont('Helvetica','B',11);
	$this->SetXY(14,$nuevaY);
	$texto="Aqui está la evaluación del desempeño de tu hotel de acuerdo con tus respuestas en la calculadora";
	$this->MultiCell(190, 5, utf8_decode($texto) , 0, "L", false);
	}
	
	function ponerCuadroGeneral()
	{
	$xRecuadro=12;
	$yRecuadro=$this->inicioVertical;
	$this->SetLineWidth(.75);
	$this->SetDrawColor(41,194,253);
	
	// perimetro general
	$this->Rect($xRecuadro, $yRecuadro, 197, 62 ,"D");
	$this->offsetVertical+=68;
	
	// titulo recuadro general
	$this->SetTextColor(41,194,253);//41–194–253
	$this->SetFont('Helvetica','B',13);
	$this->SetXY(91,109);
	$texto="Resultados del impacto en general";
	$this->MultiCell(100, 7, utf8_decode($texto) , 0, "L", false);
	
	// textos
	$this->SetTextColor(0,0,0);
	$this->SetFont('Helvetica','B',10);
	$this->SetXY(55.5,120);
	$this->MultiCell(153, 6, utf8_decode($this->arrLeyendas['general1']) , 0, "L", false);
	
	$this->SetFont('Helvetica','',10);
	$this->SetXY(55.5,142);
	$this->MultiCell(153, 5, utf8_decode($this->arrLeyendas['general2']) , 0, "L", false);
	
	// grafica
	$this->Image($this->graficaGeneral,16,115.7,33.5,33.5);
	}
	
	function ponerCuadroPersonas()
	{
	$xRecuadro=12;
	$yRecuadro=$this->inicioVertical+$this->offsetVertical;
	$yLogo=$yRecuadro+1;
	$yTitulo=$yRecuadro+5.5;
	$yTexto1=$yRecuadro+19;
	$yTexto2=$yRecuadro+39;
	$yTuResultado=$yRecuadro+6.5;
	$yObjetivos=$yRecuadro+38;
	$yObjetivos1=$yRecuadro+50;
	$yObjetivos2=$yRecuadro+64.5;
	$yObjetivos3=$yRecuadro+79;
	
	$xBarraPuntaje1=104;
	$yBarraPuntaje1=$yRecuadro+58;
	$yBarraPuntaje2=$yBarraPuntaje1+8;
	$yBarraPuntaje3=$yBarraPuntaje2+8;
	$yBarraPuntaje4=$yBarraPuntaje3+8;
	
	// perimetro personas
	$this->Rect($xRecuadro, $yRecuadro, 197, 95 ,"D");
	
	// logo
	$this->Image($this->personasLogo,94,$yLogo,16,16);
	
	// titulo personas
	$this->SetTextColor(41,194,253);//41–194–253
	$this->SetFont('Helvetica','B',13);
	$this->SetXY(122,$yTitulo);
	$texto="Personas";
	$this->MultiCell(100, 7, utf8_decode($texto) , 0, "L", false);
	
	// primer texto
	$this->SetTextColor(0,0,0);
	$this->SetFont('Helvetica','',10);
	$this->SetXY(55.5,$yTexto1);
	$this->MultiCell(153, 5, utf8_decode($this->arrLeyendas['personas1']) , 0, "L", false);
	
	// segundo texto
	$this->SetXY(55.5,$yTexto2);
	$this->MultiCell(153, 5, utf8_decode($this->arrLeyendas['personas2']) , 0, "L", false);
	
	// texto tu resultado
	$this->SetXY(22.5,$yTuResultado);
	$this->SetFont('Helvetica','B',10);
	$this->SetTextColor(125,125,125);
	$this->MultiCell(35, 5, utf8_decode("Tu resultado") , 0, "L", false);
	
	// texto objetivos
	$this->SetXY(13,$yObjetivos);
	$this->SetFont('Helvetica','B',9);
	$this->SetTextColor(125,125,125);
	$this->MultiCell(40, 5, utf8_decode("Objetivos del desarrollo sostenible en este pilar") , 0, "C", false);
	
	// logos objetivos
	$this->Image($this->logoObjetivo1,17.5,$yObjetivos1,14.5,13.5);
	$this->Image($this->logoObjetivo2,33,$yObjetivos1,14.5,13.5);
	$this->Image($this->logoObjetivo3,17.5,$yObjetivos2,14.5,13.5);
	$this->Image($this->logoObjetivo5,33,$yObjetivos2,14.5,13.5);
	$this->Image($this->logoObjetivo4,17.5,$yObjetivos3,14.5,13.5);
	
	// titulos de temas
	$this->SetFont('Helvetica','B',9);
	$this->SetTextColor(41,194,253);
	
	$this->SetXY(52,$yBarraPuntaje1-.5);
	$this->MultiCell(50, 5, utf8_decode("Educación") , 0, "R", false);
	$this->SetXY(52,$yBarraPuntaje2-.5);
	$this->MultiCell(50, 5, utf8_decode("Trabajo digno e incluyente") , 0, "R", false);
	$this->SetXY(52,$yBarraPuntaje3-.5);
	$this->MultiCell(50, 5, utf8_decode("Género") , 0, "R", false);
	$this->SetXY(52,$yBarraPuntaje4-.5);
	$this->MultiCell(50, 5, utf8_decode("Accesibilidad") , 0, "R", false);
	
	// barras de puntaje
	// calculo
	
	$porcentajeEducacion=$this->arrDatos['tema_Educacion']*80/100;
	$porcentajeTrabajo=$this->arrDatos['tema_Trabajo_decente_e_inclusion']*80/100;
	$porcentajeGenero=$this->arrDatos['tema_Igualdad_de_genero']*80/100;
	$porcentajeAccesibilidad=$this->arrDatos['tema_Accesibilidad']*80/100;
	
	
	$this->SetLineWidth(.25);
	$this->SetFillColor(230,230,230);
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje1, 80, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje2, 80, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje3, 80, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje4, 80, 4 ,"DF");
	
	$this->SetFillColor(41,194,253);
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje1, $porcentajeEducacion, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje2, $porcentajeTrabajo, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje3, $porcentajeGenero, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje4, $porcentajeAccesibilidad, 4 ,"DF");
	
	$this->SetLineWidth(.75);
	
	// grafica
	$this->Image($this->graficaPersonas,21,$yTuResultado+5,25,25);
	}
	
	function ponerCuadroPaz()
	{
	$this->offsetVertical=0;
	$this->inicioVertical=16;
	$this->SetLineWidth(.75);
	$this->SetDrawColor(41,194,253);
	$xRecuadro=12;
	$yRecuadro=$this->inicioVertical+$this->offsetVertical;
	$yLogo=$yRecuadro+1;
	$yTitulo=$yRecuadro+5.5;
	$yTexto1=$yRecuadro+24;
	$yTexto2=$yRecuadro+49;
	$yTuResultado=$yRecuadro+6.5;
	$yObjetivos=$yRecuadro+54;
	$yObjetivos1=$yRecuadro+68.5;
	
	$xBarraPuntaje1=114;
	$yBarraPuntaje1=$yRecuadro+62;
	$yBarraPuntaje2=$yBarraPuntaje1+8;
	$yBarraPuntaje3=$yBarraPuntaje2+8;
	$yBarraPuntaje4=$yBarraPuntaje3+8;
	$yBarraPuntaje5=$yBarraPuntaje4+8;
	$yBarraPuntaje6=$yBarraPuntaje5+8;
	
	// perimetro
	$this->Rect($xRecuadro, $yRecuadro, 197, 108 ,"D");
	
	// logo
	$this->Image($this->pazLogo,94,$yLogo,20,20);
	
	// titulo
	$this->SetTextColor(41,194,253);//41–194–253
	$this->SetFont('Helvetica','B',13);
	$this->SetXY(122,$yTitulo);
	$texto="Paz";
	$this->MultiCell(100, 7, utf8_decode($texto) , 0, "L", false);
	
	// primer texto
	$this->SetTextColor(0,0,0);
	$this->SetFont('Helvetica','',10);
	$this->SetXY(55.5,$yTexto1);
	$this->MultiCell(153, 5, utf8_decode($this->arrLeyendas['paz1']) , 0, "L", false);
	
	// segundo texto
	$this->SetXY(55.5,$yTexto2);
	$this->MultiCell(153, 5, utf8_decode($this->arrLeyendas['paz2']) , 0, "L", false);
	
	// texto tu resultado
	$this->SetXY(22.5,$yTuResultado);
	$this->SetFont('Helvetica','B',10);
	$this->SetTextColor(125,125,125);
	$this->MultiCell(35, 5, utf8_decode("Tu resultado") , 0, "L", false);
	
	// texto objetivos
	$this->SetXY(13,$yObjetivos);
	$this->SetFont('Helvetica','B',9);
	$this->SetTextColor(125,125,125);
	$this->MultiCell(40, 5, utf8_decode("Objetivos del desarrollo sostenible en este pilar") , 0, "C", false);
	
	// logos objetivos
	$this->Image($this->logoObjetivo16,18,$yObjetivos1,24,23);
	
	// grafica
	$this->Image($this->graficaPaz,21,$yTuResultado+10,25,25);
	
	// titulos de temas
	$this->SetFont('Helvetica','B',9);
	$this->SetTextColor(41,194,253);
	
	$this->SetXY(52,$yBarraPuntaje1-.5);
	$this->MultiCell(60, 5, utf8_decode("Relación con grupos de interés") , 0, "R", false);
	$this->SetXY(52,$yBarraPuntaje2-.5);
	$this->MultiCell(60, 5, utf8_decode("Protección del patrimonio cultural") , 0, "R", false);
	$this->SetXY(52,$yBarraPuntaje3-.5);
	$this->MultiCell(60, 5, utf8_decode("Corrupción") , 0, "R", false);
	$this->SetXY(52,$yBarraPuntaje4-.5);
	$this->MultiCell(60, 5, utf8_decode("Conducta ética") , 0, "R", false);
	$this->SetXY(52,$yBarraPuntaje5-.5);
	$this->MultiCell(60, 5, utf8_decode("Paz") , 0, "R", false);
	$this->SetXY(52,$yBarraPuntaje6-.5);
	//$this->MultiCell(60, 5, utf8_decode("") , 0, "R", false);
	
	
	// barras de puntaje
	// calculo
	
	$porcentajeGruposInteres=$this->arrDatos['tema_Relacion_con_grupos_de_interes']*80/100;
	$porcentajePatrimonioCultural=$this->arrDatos['tema_Fomento_y_proteccion_del_patrimonio_cultural_tangible_e_intangible']*80/100;
	//$porcentajeIntercambios=$this->arrDatos['tema_Fomentar_intercambios_culturales']*80/100;
	$porcentajeCorrupcion=$this->arrDatos['tema_Corrupcion']*80/100;
	$porcentajeEtica=$this->arrDatos['tema_Conducta_etica']*80/100;
	$porcentajePaz=$this->arrDatos['seccionPaz']*80/100;
	
	
	
	$this->SetLineWidth(.25);
	$this->SetFillColor(230,230,230);
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje1, 80, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje2, 80, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje3, 80, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje4, 80, 4 ,"DF");
	//		$this->Rect($xBarraPuntaje1, $yBarraPuntaje5, 80, 4 ,"DF");
	//		$this->Rect($xBarraPuntaje1, $yBarraPuntaje6, 80, 4 ,"DF");
	
	$this->SetFillColor(41,194,253);
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje1, $porcentajeGruposInteres, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje2, $porcentajePatrimonioCultural, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje3, $porcentajeCorrupcion, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje4, $porcentajeEtica, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje5, $porcentajePaz, 4 ,"DF");
	//$this->Rect($xBarraPuntaje1, $yBarraPuntaje6, , 4 ,"DF");
	
	$this->SetLineWidth(.75);
	
	}
	
	function ponerCuadroProsperidad()
	{
	$this->offsetVertical=119;
	$this->inicioVertical=16;
	$this->SetLineWidth(.75);
	$this->SetDrawColor(41,194,253);
	$xRecuadro=12;
	$yRecuadro=$this->inicioVertical+$this->offsetVertical;
	$yLogo=$yRecuadro+1;
	$yTitulo=$yRecuadro+5.5;
	$yTexto1=$yRecuadro+24;
	$yTexto2=$yRecuadro+44;
	$yTuResultado=$yRecuadro+6.5;
	$yObjetivos=$yRecuadro+50;
	
	$yObjetivos1=$yRecuadro+65;
	$yObjetivos2=$yRecuadro+79.5;
	$yObjetivos3=$yRecuadro+94;
	
	
	$xBarraPuntaje1=114;
	$yBarraPuntaje1=$yRecuadro+62;
	$yBarraPuntaje2=$yBarraPuntaje1+8;
	$yBarraPuntaje3=$yBarraPuntaje2+8;
	$yBarraPuntaje4=$yBarraPuntaje3+8;
	$yBarraPuntaje5=$yBarraPuntaje4+8;
	
	
	// perimetro
	$this->Rect($xRecuadro, $yRecuadro, 197, 110 ,"D");
	
	// logo
	$this->Image($this->prosperidadLogo,94,$yLogo,14,14);
	
	// titulo
	$this->SetTextColor(41,194,253);//41–194–253
	$this->SetFont('Helvetica','B',13);
	$this->SetXY(122,$yTitulo);
	$textoFecha="Prosperidad";
	$this->MultiCell(100, 7, utf8_decode($textoFecha) , 0, "L", false);
	
	// primer texto
	$this->SetTextColor(0,0,0);
	$this->SetFont('Helvetica','',10);
	$this->SetXY(55.5,$yTexto1);
	$this->MultiCell(153, 5, utf8_decode($this->arrLeyendas['prosperidad1']) , 0, "L", false);
	
	// segundo texto
	$this->SetXY(55.5,$yTexto2);
	$this->MultiCell(153, 5, utf8_decode($this->arrLeyendas['prosperidad2']) , 0, "L", false);
	
	// texto tu resultado
	$this->SetXY(22.5,$yTuResultado);
	$this->SetFont('Helvetica','B',10);
	$this->SetTextColor(125,125,125);
	$this->MultiCell(35, 5, utf8_decode("Tu resultado") , 0, "L", false);
	
	// texto objetivos
	$this->SetXY(13,$yObjetivos);
	$this->SetFont('Helvetica','B',9);
	$this->SetTextColor(125,125,125);
	$this->MultiCell(40, 5, utf8_decode("Objetivos del desarrollo sostenible en este pilar") , 0, "C", false);
	
	// logos objetivos
	$this->Image($this->logoObjetivo7,17.5,$yObjetivos1,14.5,13.5);
	$this->Image($this->logoObjetivo8,33,$yObjetivos1,14.5,13.5);
	$this->Image($this->logoObjetivo9,17.5,$yObjetivos2,14.5,13.5);
	$this->Image($this->logoObjetivo10,33,$yObjetivos2,14.5,13.5);
	$this->Image($this->logoObjetivo11,17.5,$yObjetivos3,14.5,13.5);
	
	// grafica
	$this->Image($this->graficaProsperidad,21,$yTuResultado+10,25,25);
	
	// titulos de temas
	$this->SetFont('Helvetica','B',9);
	$this->SetTextColor(41,194,253);
	
	$this->SetXY(52,$yBarraPuntaje1-.5);
	$this->MultiCell(60, 5, utf8_decode("Generación económica general") , 0, "R", false);
	$this->SetXY(52,$yBarraPuntaje2-.5);
	$this->MultiCell(60, 5, utf8_decode("Cadena de valor prospera") , 0, "R", false);
	$this->SetXY(52,$yBarraPuntaje3-.5);
	$this->MultiCell(60, 5, utf8_decode("Colaboradores locales") , 0, "R", false);
	$this->SetXY(52,$yBarraPuntaje4-.5);
	$this->MultiCell(60, 5, utf8_decode("Empleo en general") , 0, "R", false);
	$this->SetXY(52,$yBarraPuntaje5-.5);
	$this->MultiCell(60, 5, utf8_decode("Desarrollo comunitario") , 0, "R", false);
	
	// barras de puntaje
	// calculo
	
	$porcentajeGeneracionEconomica=$this->arrDatos['tema_Generacion_economica_local']*80/100;
	$porcentajeCadenaValor=$this->arrDatos['tema_Cadena_de_valor_prospera']*80/100;
	$porcentajeColaboradores=$this->arrDatos['tema_Colaboradores_locales']*80/100;
	$porcentajeEmpleo=$this->arrDatos['tema_Empleo_en_general']*80/100;
	$porcentajeDesarrolloComunitario=$this->arrDatos['tema_Desarrollo_comunitario']*80/100;
	
	$this->SetLineWidth(.25);
	$this->SetFillColor(230,230,230);
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje1, 80, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje2, 80, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje3, 80, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje4, 80, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje5, 80, 4 ,"DF");
	
	$this->SetFillColor(41,194,253);
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje1, $porcentajeGeneracionEconomica, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje2, $porcentajeCadenaValor, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje3, $porcentajeColaboradores, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje4, $porcentajeEmpleo, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje5, $porcentajeDesarrolloComunitario, 4 ,"DF");
	
	$this->SetLineWidth(.75);
	}
	
	function ponerCuadroPlaneta()
	{
	$this->offsetVertical=0;
	$this->inicioVertical=10;
	$this->SetLineWidth(.75);
	$this->SetDrawColor(41,194,253);
	$xRecuadro=12;
	$yRecuadro=$this->inicioVertical+$this->offsetVertical;
	$yLogo=$yRecuadro+1;
	$yTitulo=$yRecuadro+5.5;
	$yTexto1=$yRecuadro+19;
	$yTexto2=$yRecuadro+44;
	$yTuResultado=$yRecuadro+6.5;
	$yObjetivos=$yRecuadro+50;
	
	$yObjetivos1=$yRecuadro+65;
	$yObjetivos2=$yRecuadro+79.5;
	$yObjetivos3=$yRecuadro+94;
	
	
	$xBarraPuntaje1=114;
	$yBarraPuntaje1=$yRecuadro+62;
	$yBarraPuntaje2=$yBarraPuntaje1+8;
	$yBarraPuntaje3=$yBarraPuntaje2+8;
	$yBarraPuntaje4=$yBarraPuntaje3+8;
	$yBarraPuntaje5=$yBarraPuntaje4+8;
	$yBarraPuntaje6=$yBarraPuntaje5+8;
	$yBarraPuntaje7=$yBarraPuntaje6+8;
	
	// perimetro
	$this->Rect($xRecuadro, $yRecuadro, 197, 120 ,"D");
	
	// logo
	$this->Image($this->planetaLogo,94,$yLogo,14,14);
	
	// titulo
	$this->SetTextColor(41,194,253);//41–194–253
	$this->SetFont('Helvetica','B',13);
	$this->SetXY(122,$yTitulo);
	$textoFecha="Planeta";
	$this->MultiCell(100, 7, utf8_decode($textoFecha) , 0, "L", false);
	
	// primer texto
	$this->SetTextColor(0,0,0);
	$this->SetFont('Helvetica','',10);
	$this->SetXY(55.5,$yTexto1);
	$this->MultiCell(153, 5, utf8_decode($this->arrLeyendas['planeta1']) , 0, "L", false);
	
	// segundo texto
	$this->SetXY(55.5,$yTexto2);
	$this->MultiCell(153, 5, utf8_decode($this->arrLeyendas['planeta2']) , 0, "L", false);
	
	// texto tu resultado
	$this->SetXY(22.5,$yTuResultado);
	$this->SetFont('Helvetica','B',10);
	$this->SetTextColor(125,125,125);
	$this->MultiCell(35, 5, utf8_decode("Tu resultado") , 0, "L", false);
	
	// texto objetivos
	$this->SetXY(13,$yObjetivos);
	$this->SetFont('Helvetica','B',9);
	$this->SetTextColor(125,125,125);
	$this->MultiCell(40, 5, utf8_decode("Objetivos del desarrollo sostenible en este pilar") , 0, "C", false);
	
	// logos objetivos
	$this->Image($this->logoObjetivo6,17.5,$yObjetivos1,14.5,13.5);
	$this->Image($this->logoObjetivo12,33,$yObjetivos1,14.5,13.5);
	$this->Image($this->logoObjetivo15,17.5,$yObjetivos2,14.5,13.5);
	$this->Image($this->logoObjetivo13,33,$yObjetivos2,14.5,13.5);
	$this->Image($this->logoObjetivo14,17.5,$yObjetivos3,14.5,13.5);
	
	// grafica
	$this->Image($this->graficaPlaneta,21,$yTuResultado+10,25,25);
	
	// titulos de temas
	$this->SetFont('Helvetica','B',9);
	$this->SetTextColor(41,194,253);
	
	$this->SetXY(52,$yBarraPuntaje1-.5);
	$this->MultiCell(60, 5, utf8_decode("Planeación y diseño del destino") , 0, "R", false);
	$this->SetXY(52,$yBarraPuntaje2-.5);
	$this->MultiCell(60, 5, utf8_decode("Cadena de suministro") , 0, "R", false);
	$this->SetXY(52,$yBarraPuntaje3-.5);
	$this->MultiCell(60, 5, utf8_decode("Cambio climático") , 0, "R", false);
	$this->SetXY(52,$yBarraPuntaje4-.5);
	$this->MultiCell(60, 5, utf8_decode("Manejo y reducción de energía") , 0, "R", false);
	$this->SetXY(52,$yBarraPuntaje5-.5);
	$this->MultiCell(60, 5, utf8_decode("Manejo de consumo de agua") , 0, "R", false);
	$this->SetXY(52,$yBarraPuntaje6-.5);
	$this->MultiCell(60, 5, utf8_decode("Manejo de residuos") , 0, "R", false);
	$this->SetXY(52,$yBarraPuntaje7-.5);
	$this->MultiCell(60, 5, utf8_decode("Protección a la biodiversidad") , 0, "R", false);
	
	// barras de puntaje
	// calculo
	
	$porcentajeDisenoDestino=$this->arrDatos['tema_Planeacion_y_diseno_del_destino']*80/100;
	$porcentajeSuministro=$this->arrDatos['tema_Cadena_de_suministro_planeta']*80/100;
	$porcentajeCambioClimatico=$this->arrDatos['tema_Cambio_climatico']*80/100;
	$porcentajeEmergia=$this->arrDatos['tema_Manejo_y_reduccion_de_energia']*80/100;
	$porcentajeAgua=$this->arrDatos['tema_Manejo__reduccion_y_tratamiento_de_agua']*80/100;
	$porcentajeResiduos=$this->arrDatos['tema_Manejo__reduccion_y_tratamiento_de_residuos']*80/100;
	$porcentajeBiodiversidad=$this->arrDatos['tema_Proteccion_de_la_biodiversidad']*80/100;
	
	$this->SetLineWidth(.25);
	$this->SetFillColor(230,230,230);
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje1, 80, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje2, 80, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje3, 80, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje4, 80, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje5, 80, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje6, 80, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje7, 80, 4 ,"DF");
	
	
	$this->SetFillColor(41,194,253);
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje1, $porcentajeDisenoDestino, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje2, $porcentajeSuministro, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje3, $porcentajeCambioClimatico, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje4, $porcentajeEmergia, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje5, $porcentajeAgua, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje6, $porcentajeResiduos, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje7, $porcentajeBiodiversidad, 4 ,"DF");
	
	$this->SetLineWidth(.75);
	}
	
	function ponerCuadroPaternariato()
	{
	$this->offsetVertical=128;
	$this->inicioVertical=10;
	$this->SetLineWidth(.75);
	$this->SetDrawColor(41,194,253);
	$xRecuadro=12;
	$yRecuadro=$this->inicioVertical+$this->offsetVertical;
	$yLogo=$yRecuadro+1;
	$yTitulo=$yRecuadro+5.5;
	$yTexto1=$yRecuadro+19;
	$yTexto2=$yRecuadro+44;
	$yTuResultado=$yRecuadro+6.5;
	$yObjetivos=$yRecuadro+54;
	$yObjetivos1=$yRecuadro+65;
	
	$xBarraPuntaje1=114;
	$yBarraPuntaje1=$yRecuadro+62;
	$yBarraPuntaje2=$yBarraPuntaje1+8;
	$yBarraPuntaje3=$yBarraPuntaje2+8;
	
	
	// perimetro
	$this->Rect($xRecuadro, $yRecuadro, 197, 93 ,"D");
	
	// logo
	$this->Image($this->paternariatoLogo,94,$yLogo,14,14);
	
	// titulo
	$this->SetTextColor(41,194,253);//41–194–253
	$this->SetFont('Helvetica','B',13);
	$this->SetXY(122,$yTitulo);
	$textoFecha="Alianzas (Paternariato)";
	$this->MultiCell(100, 7, utf8_decode($textoFecha) , 0, "L", false);
	
	// primer texto
	$this->SetTextColor(0,0,0);
	$this->SetFont('Helvetica','',10);
	$this->SetXY(55.5,$yTexto1);
	$this->MultiCell(153, 5, utf8_decode($this->arrLeyendas['alianzas1']) , 0, "L", false);
	
	// segundo texto
	$this->SetXY(55.5,$yTexto2);
	$this->MultiCell(153, 5, utf8_decode($this->arrLeyendas['alianzas2']) , 0, "L", false);
	
	// texto tu resultado
	$this->SetXY(22.5,$yTuResultado);
	$this->SetFont('Helvetica','B',10);
	$this->SetTextColor(125,125,125);
	$this->MultiCell(35, 5, utf8_decode("Tu resultado") , 0, "L", false);
	
	// texto objetivos
	$this->SetXY(13,$yObjetivos);
	$this->SetFont('Helvetica','B',9);
	$this->SetTextColor(125,125,125);
	$this->MultiCell(40, 5, utf8_decode("Objetivos del desarrollo sostenible en este pilar") , 0, "C", false);
	
	// logos objetivos
	$this->Image($this->logoObjetivo17,18,$yObjetivos1,24,23);
	
	// grafica
	$this->Image($this->graficaPaternariato,21,$yTuResultado+10,25,25);
	
	// titulos de temas
	$this->SetFont('Helvetica','B',9);
	$this->SetTextColor(41,194,253);
	
	$this->SetXY(52,$yBarraPuntaje1-.5);
	$this->MultiCell(60, 5, utf8_decode("Con clientes") , 0, "R", false);
	$this->SetXY(52,$yBarraPuntaje2-.5);
	$this->MultiCell(60, 5, utf8_decode("En proyectos hacia el exterior") , 0, "R", false);
	$this->SetXY(52,$yBarraPuntaje3-.5);
	$this->MultiCell(60, 5, utf8_decode("Para la operación y gestión interna") , 0, "R", false);
	
	
	// barras de puntaje
	// calculo
	
	$porcentajeClientes=$this->arrDatos['tema_Con_clientes']*80/100;
	$porcentajeExterior=$this->arrDatos['tema_En_proyectos_externos']*80/100;
	$porcentajeInterna=$this->arrDatos['tema_Para_la_gestion_y_operacion_interna']*80/100;
	
	$this->SetLineWidth(.25);
	$this->SetFillColor(230,230,230);
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje1, 80, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje2, 80, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje3, 80, 4 ,"DF");
	
	$this->SetFillColor(41,194,253);
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje1, $porcentajeClientes, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje2, $porcentajeExterior, 4 ,"DF");
	$this->Rect($xBarraPuntaje1, $yBarraPuntaje3, $porcentajeInterna, 4 ,"DF");
	
	
	$this->SetLineWidth(.75);
	}
	
	function ponerCuadroInfIzq()
	{
	$this->offsetVertical=228;
	$this->inicioVertical=10;
	$xRecuadro=12;
	$yRecuadro=$this->inicioVertical+$this->offsetVertical;
	$this->SetTextColor(255,255,255);//41–194–253
	$this->SetFont('Helvetica','',10);
	$this->SetLineWidth(.75);
	$this->SetDrawColor(41,194,253);
	
	$texto=utf8_decode("Con estos resultados puedes elaborar un plan para incrementar el impacto de las operaciones del hotel hacia los objetivos del desarrollo sostenible");
	$this->SetXY($xRecuadro,$yRecuadro-.5);
	$this->MultiCell(85, 5, $texto , 1, "L", true);
	}
	
	function ponerCuadroInfDer()
	{
	$this->offsetVertical=228;
	$this->inicioVertical=10;
	$xRecuadro=124;
	$yRecuadro=$this->inicioVertical+$this->offsetVertical;
	$this->SetTextColor(255,255,255);//41–194–253
	$this->SetFont('Helvetica','',10);
	$this->SetLineWidth(.75);
	$this->SetDrawColor(41,194,253);
	
	$texto=utf8_decode("Mayores informes \n Joel Narvaez \n joel.narvaez@undp.org");
	$this->SetXY($xRecuadro,$yRecuadro-.5);
	$this->MultiCell(85, 5, $texto , 1, "L", true);
	}
	
	function ponerRenglon($leyenda,$valor,$cantidad=null)
{
$xValor=184;
$xLeyenda=164;
$xCantidad=143;
$anchoValor=20;
$anchoCantidad=20;
$anchoLeyenda=20;
$alto=4;

if($cantidad!=null){
$this->SetFont('Arial','',10);
$this->SetTextColor(0,0,0);
$this->SetX($xCantidad);
$this->Cell($anchoCantidad,$alto,$cantidad,0,0,"R",false);
}
$this->SetFont('Arial','',6);
$this->SetTextColor(0,0,0);
$this->SetX($xLeyenda);
$this->Cell($anchoLeyenda,$alto,$leyenda,0,0,"L",false);

$this->SetFont('Arial','',10);
$this->SetTextColor(0,0,0);
$this->SetX($xValor);
$this->Cell($anchoValor,$alto,$valor,0,1,"R",false);

}

}
