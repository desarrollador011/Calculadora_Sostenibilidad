<?php

/**
 *
 * Helper para inserción y funcionamiento de elementos de formularios
 *
 * PHP Version 5.6.16
 *
 * @copyright 2019  Dédalo (http://www.dedalo.com.mx)
 *
 *
 * @author  Javier Oñate Mendía (Dédalo)
 */


/**
 *
 * Helper para inserción y funcionamiento de elementos de formularios
 *
 * Clase FxFormularios
 *
 * @package COTRAMEX
 * @author  Javier Oñate Mendía (Dédalo)
 */

class Fx
{
	/**
	 * Getter del nombre de formulario
     *
	 * @return string
	 */
	function getFormulario()
	{
		return(NOMBRE_FORMULARIO);
	}

	/**
	 *
	 * Función para insertar un campo de texto
	 *
	 * @param $tipo
	 * @param $nombre
	 * @param $tamano
	 * @param $max
	 * @param $valor
	 * @param null $clase
	 * @param null $sugerencia
	 * @param null $id
	 * @param null $enviarFormulario
	 * @param null $foco
	 * @param null $accion
	 * @param null $subaccion
	 * @param null $item
	 */
	function ponerInput($tipo,$nombre,$tamano,$max,$valor,$clase=null,$sugerencia=null,$id=null,$enviarFormulario=null,$foco=null,$accion=null,$subaccion=null,$item=null)
	{
		$valorId=($id!=null) ? "id='".$id."' " : "";
		$accionTxt = ($accion!='') ? "document.".NOMBRE_FORMULARIO.".accion.value='".$accion."';" : "";
		$subAccionTxt = ($subaccion!='') ? "document.".NOMBRE_FORMULARIO.".subaccion.value='".$subaccion."';" : "";
		$itemTxt = ($item!='') ? "document.".NOMBRE_FORMULARIO.".item.value='".$item."';" : "";
		$valorEnviar=($enviarFormulario!=null) ? " onchange=\"javascript:".$accionTxt.$subAccionTxt.$itemTxt."document.".NOMBRE_FORMULARIO.".submit();\" " : "";
		$valorFoco=($foco!=null) ? " autofocus='".$foco."' " : "";
		$valorClase=($clase!=null) ? " class='".$clase."' " : "";
		$valorSugerencia=($sugerencia!=null) ?  " placeholder='".$sugerencia."' " : "";
		echo "<input type='".$tipo."' name='".$nombre."' $valorId size='".$tamano."' maxlength='".$max."' value='".$valor."'$valorClase $valorFoco $valorEnviar $valorSugerencia>";
	}


	/**
	 *
	 * Funcion para insertar un botón
	 *
	 * @param      $accion
	 * @param      $subaccion
	 * @param      $item
	 * @param      $etiqueta
	 * @param      $imagen
	 * @param      $anchoImagen
	 * @param      $altoImagen
	 * @param      $clase
	 * @param      $borde
	 * @param null $subitem
	 */
	function ponerBoton($accion, $subaccion, $item, $etiqueta, $imagen, $anchoImagen, $altoImagen, $clase, $borde, $subitem=null,$id=null,$funcionOnClick=null)
	{
		$accionTxt = ($accion!='') ? "document.".NOMBRE_FORMULARIO.".accion.value='".$accion."';" : "";
		$subAccionTxt = ($subaccion!='') ? "document.".NOMBRE_FORMULARIO.".subaccion.value='".$subaccion."';" : "";
		$itemTxt = ($item!='') ? "document.".NOMBRE_FORMULARIO.".item.value='".$item."';" : "";
		$subItemTxt=($subitem!=null) ? "document.".NOMBRE_FORMULARIO.".subItem.value='".$subitem."';" : "";
		$idTxt=($id!=null) ? " document.".NOMBRE_FORMULARIO.".id.value=' ".$id."';" : "";
		$onClickTxt=($funcionOnClick!=null) ? " onclick=\"$funcionOnClick();\" " : "";
		$submitTxt="document.".NOMBRE_FORMULARIO.".submit();\"";
		if($imagen!=''){
			$anchoTxt=($anchoImagen!='') ? " width='".$anchoImagen."' " : "";
			$altoTxt=($altoImagen!='') ? " height='".$altoImagen."' " : "";
			$claseTxt=($clase!='') ? " class='".$clase."' " : "";
			$bordeTxt=($borde!='') ? " border='".$borde."' " : "";
			$etiquetaTxt=($etiqueta!='') ? " alt='".$etiqueta."' " : "";
			$etiquetaDef="<img src='"."$imagen' $anchoTxt$altoTxt$claseTxt$bordeTxt$etiquetaTxt $onClickTxt>";
			echo "<a href=\"javascript:$accionTxt$subAccionTxt$itemTxt$subItemTxt$idTxt$submitTxt>";
			echo("$etiquetaDef");
			echo "</a>";
		}else{
			$claseTxt=($clase!='') ? " class='".$clase."' " : "";
			echo "<a href=\"javascript:$accionTxt$subAccionTxt$itemTxt$subItemTxt$idTxt$submitTxt$claseTxt>";
			echo "$etiqueta";
			
			echo("</a>");
		}
	}
	
	function ponerBotonNuevaPagina($accion, $subaccion, $item, $etiqueta, $imagen, $anchoImagen, $altoImagen, $clase, $borde, $subitem=null,$id=null,$funcionOnClick=null)
	{
		$accionTxt = ($accion!='') ? "document.".NOMBRE_FORMULARIO.".accion.value='".$accion."';" : "";
		$subAccionTxt = ($subaccion!='') ? "document.".NOMBRE_FORMULARIO.".subaccion.value='".$subaccion."';" : "";
		$itemTxt = ($item!='') ? "document.".NOMBRE_FORMULARIO.".item.value='".$item."';" : "";
		$subItemTxt=($subitem!=null) ? "document.".NOMBRE_FORMULARIO.".subItem.value='".$subitem."';" : "";
		$idTxt=($id!=null) ? " document.".NOMBRE_FORMULARIO.".id.value=' ".$id."';" : "";
		$onClickTxt=($funcionOnClick!=null) ? " onclick=\"$funcionOnClick();\" " : "";
		$submitTxt="document.".NOMBRE_FORMULARIO.".submit();\"";
		if($imagen!=''){
			$anchoTxt=($anchoImagen!='') ? " width='".$anchoImagen."' " : "";
			$altoTxt=($altoImagen!='') ? " height='".$altoImagen."' " : "";
			$claseTxt=($clase!='') ? " class='".$clase."' " : "";
			$bordeTxt=($borde!='') ? " border='".$borde."' " : "";
			$etiquetaTxt=($etiqueta!='') ? " alt='".$etiqueta."' " : "";
			$etiquetaDef="<img src='"."$imagen' $anchoTxt$altoTxt$claseTxt$bordeTxt$etiquetaTxt $onClickTxt>";
			echo "<a href=\"javascript:$accionTxt$subAccionTxt$itemTxt$subItemTxt$idTxt$submitTxt\"  target=\"_blank\">";
			echo("$etiquetaDef");
			echo "</a>";
		}else{
			$claseTxt=($clase!='') ? " class='".$clase."' " : "";
			echo "<a href=\"javascript:$accionTxt$subAccionTxt$itemTxt$subItemTxt$idTxt$submitTxt$claseTxt\"  target=\"_blank\">";
			echo "$etiqueta";
			
			echo("</a>");
		}
	}
	function ponerBotonNuevaHoja($accion, $subaccion, $item, $etiqueta, $imagen, $anchoImagen, $altoImagen, $clase, $borde, $subitem=null)
	{
		$accionTxt = ($accion!='') ? "document.".NOMBRE_FORMULARIO.".accion.value='".$accion."';" : "";
		$subAccionTxt = ($subaccion!='') ? "document.".NOMBRE_FORMULARIO.".subaccion.value='".$subaccion."';" : "";
		$itemTxt = ($item!='') ? "document.".NOMBRE_FORMULARIO.".item.value='".$item."';" : "";
		$subItemTxt=($subitem!=null) ? "document.".NOMBRE_FORMULARIO.".subItem.value='".$subitem."';" : "";
		$submitTxt="document.".NOMBRE_FORMULARIO.".submit();\"";
		$destino="target='_blank'";
		if($imagen!=''){
			$anchoTxt=($anchoImagen!='') ? " width='".$anchoImagen."' " : "";
			$altoTxt=($altoImagen!='') ? " height='".$altoImagen."' " : "";
			$claseTxt=($clase!='') ? " class='".$clase."' " : "";
			$bordeTxt=($borde!='') ? " border='".$borde."' " : "";
			$etiquetaTxt=($etiqueta!='') ? " alt='".$etiqueta."' " : "";
			$etiquetaDef="<img src='"."$imagen' $anchoTxt$altoTxt$claseTxt$bordeTxt$etiquetaTxt>";
			
			echo "<a href=\"javascript:$accionTxt$subAccionTxt$itemTxt$subItemTxt$submitTxt>";
			echo("$etiquetaDef");
			echo "</a>";
		}else{
			$claseTxt=($clase!='') ? " class='".$clase."' " : "";
			echo "<a href=\"javascript:$accionTxt$subAccionTxt$itemTxt$subItemTxt$submitTxt$claseTxt  $destino>";
			echo "$etiqueta";
			echo("</a>");
		}
	}
	
	/**
 	 *
	 * Función para insertar un menú desplegable de una sola selección
	 *
	 * @param $nombre
	 * @param $titulo
	 * @param $arreglo
	 * @param $valorCategoria
	 * @param $valor
	 * @param null $accion
	 * @param null $subaccion
	 * @param null $item
	 * @param null $clase
	 * @param null $enviarFormulario
	 */
	function ponerMenu($nombre,$titulo,$arreglo,$valorCategoria,$valor,$accion=null,$subaccion=null,$item=null,$clase=null,$enviarFormulario=null,$foco=null)
	{
		$accionTxt = ($accion!=null) ? "document.".NOMBRE_FORMULARIO.".accion.value='".$accion."';" : "";
		$subAccionTxt = ($subaccion!=null) ? "document.".NOMBRE_FORMULARIO.".subaccion.value='".$subaccion."';" : "";
		$itemTxt = ($item!=null) ? "document.".NOMBRE_FORMULARIO.".item.value='".$item."';" : "";
		$submitTxt="document.".NOMBRE_FORMULARIO.".submit();\"";
		$claseTxt=($clase!=null) ? " class='".$clase."' " :'' ;
		$onChangeTxt=($enviarFormulario!=null) ? "onChange=\"javascript:$accionTxt$subAccionTxt$itemTxt$submitTxt" : '';
		$tituloTxt=($titulo !=null) ? "<option value=\"$titulo\" >$titulo</option>" : '';
		$textoFoco=($foco!=null) ? " autofocus " : "";
		echo "<select $textoFoco name='".$nombre."' id='".$nombre."' ";
		echo " $onChangeTxt";
		echo " $claseTxt>";
		echo "$tituloTxt";

		for($x=0;$x<count($arreglo);$x++){
			if ($valorCategoria==null) {
				$seleccionTxt = ($arreglo[$x]['id']==$valor) ? " selected " : '';
				echo "<option value=\"".$arreglo[$x]['id']."\" $seleccionTxt>".$arreglo[$x]['nombre']."</option>";
			}else if ($valorCategoria!=null and $valorCategoria==$arreglo[$x]['categoria']){
				$seleccionTxt = ($arreglo[$x]['id']==$valor) ? " selected " : '';
				echo "<option value=\"".$arreglo[$x]['id']."\" $seleccionTxt>".$arreglo[$x]['nombre']."</option>";
			}
		}
		echo "</select>";
	}

	/**
	 *
	 * Función para insertar un menú desplegable de una sola selección con selección de idioma
	 *
	 * @param      $nombre
	 * @param      $titulo
	 * @param      $arreglo
	 * @param      $idioma
	 * @param      $valorCategoria
	 * @param      $valor
	 * @param null $accion
	 * @param null $subaccion
	 * @param null $item
	 * @param null $clase
	 * @param null $enviarFormulario
	 */
	function ponerMenuIdioma($nombre, $titulo, $arreglo, $idioma, $valorCategoria, $valor, $accion=null, $subaccion=null, $item=null, $clase=null, $enviarFormulario=null)
	{
		$accionTxt = ($accion!=null) ? "document.".NOMBRE_FORMULARIO.".accion.value='".$accion."';" : "";
		$subAccionTxt = ($subaccion!=null) ? "document.".NOMBRE_FORMULARIO.".subaccion.value='".$subaccion."';" : "";
		$itemTxt = ($item!=null) ? "document.".NOMBRE_FORMULARIO.".item.value='".$item."';" : "";
		$submitTxt="document.".NOMBRE_FORMULARIO.".submit();\"";
		$claseTxt=($clase!=null) ? " class='".$clase."' " :'' ;
		$onChangeTxt=($enviarFormulario!=null) ? "onChange=\"javascript:$accionTxt$subAccionTxt$itemTxt$submitTxt" : '';
		$tituloTxt=($titulo !=null) ? "<option value=\"$titulo\" >$titulo</option>" : '';

		echo "<select name='".$nombre."' id='".$nombre."' ";
		echo " $onChangeTxt";
		echo " $claseTxt>";
		echo "$tituloTxt";

		for($x=0;$x<count($arreglo);$x++){
			if ($valorCategoria==null) {
				$seleccionTxt = ($arreglo[$x]['id']==$valor) ? " selected " : '';
				echo "<option value=\"".$arreglo[$x]['id']."\" $seleccionTxt>".$arreglo[$x][$idioma]."</option>";
			}else if ($valorCategoria!=null and $valorCategoria==$arreglo[$x]['categoria']){
				$seleccionTxt = ($arreglo[$x]['id']==$valor) ? " selected " : '';
				echo "<option value=\"".$arreglo[$x]['id']."\" $seleccionTxt>".$arreglo[$x][$idioma]."</option>";
			}
		}
		echo "</select>";
	}

	/**
	 *
	 * Función para insertar un menú desplegable de una sola selección filtrado
	 *
	 * @param      $nombre
	 * @param      $titulo
	 * @param      $arreglo
	 * @param      $valor
	 * @param null $clase
	 * @param null $filtro
	 */
	function ponerMenuFiltrado($nombre, $arreglo, $valor, $clase=null, $filtro=null)
	{
		$filtroSinAcentos=$this->quitarAcentos($filtro);
		$claseTxt=($clase!=null) ? " class='".$clase."' " :'' ;

		echo "<select name='".$nombre."' id='".$nombre."' $claseTxt >";

		for($x=0;$x<count($arreglo);$x++){
			$seleccionTxt = ($arreglo[$x]['id']==$valor) ? " selected " : '';
			if($arreglo[$x]['id']==0){
				echo "<option value=\"".$arreglo[$x]['id']."\" $seleccionTxt>".$arreglo[$x]['nombre']."</option>";
			} else if(strlen($filtro)>0){
				$nombreSinAcentos=$this->quitarAcentos($arreglo[$x]['nombre']);
				if(strpos($nombreSinAcentos,$filtroSinAcentos)!==false){
					echo "<option value=\"".$arreglo[$x]['id']."\" $seleccionTxt>".$arreglo[$x]['nombre']."</option>";
				}
			}else{
				echo "<option value=\"".$arreglo[$x]['id']."\" $seleccionTxt>".$arreglo[$x]['nombre']."</option>";
			}
		}
		echo "</select>";
	}

	/**
	 *
	 * Función para quitar acentos de un string
	 *
	 * @param $string
	 *
	 * @return string
	 */
	function quitarAcentos($string) {
		return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8'))), ' '));
	}

	/**
 	 *
	 * Función para insertar un menú desplegable de opción múltiple
	 *
	 * @param $nombre
	 * @param $titulo
	 * @param $arreglo
	 * @param $valorCategoria
	 * @param $valor
	 * @param null $accion
	 * @param null $subaccion
	 * @param null $item
	 * @param null $clase
	 * @param null $enviarFormulario
	 * @param $multiple
	 * @param int $renglones
	 */
	function ponerMenuMultiple($nombre,$titulo,$arreglo,$valorCategoria,$valor,$accion=null,$subaccion=null,$item=null,$clase=null,$enviarFormulario=null,$multiple=null,$renglones=8)
	{
		$valoresSeleccionados=array();
		for ($z=0;$z<count($valor);$z++){
			$valoresSeleccionados[]=$valor[$z];
		}

		$accionTxt = ($accion!=null) ? "document.".NOMBRE_FORMULARIO.".accion.value='".$accion."';" : "";
		$subAccionTxt = ($subaccion!=null) ? "document.".NOMBRE_FORMULARIO.".subaccion.value='".$subaccion."';" : "";
		$itemTxt = ($item!=null) ? "document.".NOMBRE_FORMULARIO.".item.value='".$item."';" : "";
		$submitTxt="document.".NOMBRE_FORMULARIO.".submit();\"";
		$claseTxt=($clase!=null) ? " class='".$clase."' " :'' ;
		$esMultiple=($multiple!=null) ? "multiple='multiple'" : "";
		$onChangeTxt=($enviarFormulario!=null) ? "onChange=\"javascript:$accionTxt$subAccionTxt$itemTxt$submitTxt" : '';
		$cuantosRenglones=($multiple!=null) ? "size='".$renglones."'" : '';
		$tituloTxt=($titulo !=null) ? "<option value=\"0\" >$titulo</option>" : '';

		echo "<select name='".$nombre."[]' id='".$nombre."' $cuantosRenglones $esMultiple $onChangeTxt $claseTxt>";
		echo "$tituloTxt";

		for($x=0;$x<count($arreglo);$x++){
			if ($valorCategoria==null) {
				$seleccionTxt = (in_array($arreglo[$x]['id'], $valoresSeleccionados)) ? " selected " : '';
				echo "<option value=\"".$arreglo[$x]['id']."\" $seleccionTxt>".$arreglo[$x]['nombre']."</option>";
			}else if ($valorCategoria!=null and $valorCategoria==$arreglo[$x]['categoria']){
				$seleccionTxt = ($arreglo[$x]['id']==$valor) ? " selected " : '';
				echo "<option value=\"".$arreglo[$x]['id']."\" $seleccionTxt>".$arreglo[$x]['nombre']."</option>";
			}
		}
		echo "</select>";
	}

	/**
	 *
	 * Función para insertar un menú de varios renglones y una sola opción
	 *
	 * @param $nombre
	 * @param $titulo
	 * @param $arreglo
	 * @param $valorCategoria
	 * @param $valor
	 * @param null $accion
	 * @param null $subaccion
	 * @param null $item
	 * @param null $clase
	 * @param null $enviarFormulario
	 * @param $multiple
	 * @param int $renglones
	 */
	function ponerMenuRenglones($nombre,$titulo,$arreglo,$valorCategoria,$valor,$accion=null,$subaccion=null,$item=null,$clase=null,$enviarFormulario=null,$multiple=null,$renglones=8)
	{
		$accionTxt = ($accion!=null) ? "document.".NOMBRE_FORMULARIO.".accion.value='".$accion."';" : "";
		$subAccionTxt = ($subaccion!=null) ? "document.".NOMBRE_FORMULARIO.".subaccion.value='".$subaccion."';" : "";
		$itemTxt = ($item!=null) ? "document.".NOMBRE_FORMULARIO.".item.value='".$item."';" : "";
		$submitTxt="document.".NOMBRE_FORMULARIO.".submit();\"";
		$claseTxt=($clase!=null) ? " class='".$clase."' " :'' ;
		$esMultiple=($multiple!=null) ? "multiple='multiple'" : "";
		$onChangeTxt=($enviarFormulario!=null) ? "onChange=\"javascript:$accionTxt$subAccionTxt$itemTxt$submitTxt" : '';
		$cuantosRenglones=($multiple!=null) ? "size='".$renglones."'" : '';
		$tituloTxt=($titulo !=null) ? "<option value=\"0\" >$titulo</option>" : '';

		echo "<select name='".$nombre."[]' id='".$nombre."' $cuantosRenglones $esMultiple $onChangeTxt $claseTxt>";

		echo "$tituloTxt";

		for($x=0;$x<count($arreglo);$x++){
			if ($valorCategoria==null) {
				$seleccionTxt = ($arreglo[$x]['id']==$valor) ? " selected " : '';
				echo "<option value=\"".$arreglo[$x]['id']."\" $seleccionTxt>".utf8_encode($arreglo[$x]['nombre'])."</option>";
			}else if ($valorCategoria!=null and $valorCategoria==$arreglo[$x]['categoria']){
				$seleccionTxt = ($arreglo[$x]['id']==$valor) ? " selected " : '';
				echo "<option value=\"".$arreglo[$x]['id']."\" $seleccionTxt>".$arreglo[$x]['nombre']."</option>";
			}
		}
		echo "</select>";
	}

	/**
 	 *
	 * Función para insertar un área de texto
	 *
	 * @param $nombre
	 * @param $columnas
	 * @param $filas
	 * @param null $clase
	 * @param null $valor
	 */
	function ponerAreaTexto($nombre,$columnas,$filas,$clase=null,$valor=null)
	{
		$claseTxt=($clase!=null) ? " class='".$clase."' " : '';
		$valorTxt=($valor!=null) ? " $valor " : '';
		echo "<textarea name='".$nombre."' cols='".$columnas."' rows='".$filas."' $claseTxt >".$valorTxt."</textarea>";
	}

	/**
  	 *
	 * Función para insertar un checkBox
	 *
	 * @param $nombre
	 * @param $leyenda
	 * @param $valor
	 * @param $seleccionado
	 * @param null $accion
	 * @param null $subaccion
	 * @param null $item
	 * @param null $clase
	 * @param null $enviarFormulario
	 */
	function ponerCheckBox($nombre,$leyenda,$valor,$seleccionado,$accion=null,$subaccion=null,$item=null,$clase=null,$enviarFormulario=null, $id=null)
	{
		$idTxt=($id!=null) ? " id='".$id."' " : ' ' ;
		$leyendaTxt=(strlen($leyenda)>0) ? $leyenda : '';
		$claseTxt=($clase!=null) ? "class='".$clase."'" : '' ;
		$marcado=($seleccionado==1) ? ' checked ' : '';
		$accionTxt=($accion!=null) ? "document.".NOMBRE_FORMULARIO.".accion.value='".$accion."';" : '';
		$subacionTxt=($subaccion!=null) ? "document.".NOMBRE_FORMULARIO.".subaccion.value='".$subaccion."';" : '';
		$itemTxt=($item!=null) ? "document.".NOMBRE_FORMULARIO.".item.value='".$item."';" : '';
		$onChangeTxt=($enviarFormulario!=null) ? " onchange=\"javascript:".$accionTxt.$subacionTxt.$itemTxt."document.".NOMBRE_FORMULARIO.".submit();\" " : "";
		echo "<input name='".$nombre."' type='checkbox' value='".$valor."' $idTxt $marcado $onChangeTxt $claseTxt> $leyendaTxt </input>";
	}
	
	
	function ponerCheckBoxes($nombre,$arreglo,$leyenda,$valor,$accion=null,$subaccion=null,$item=null,$clase=null,$enviarFormulario=null)
	{
		//$leyendaTxt=(strlen($leyenda)>0) ? $leyenda : '';
		$claseTxt=($clase!=null) ? "class='".$clase."'" : '' ;
		//$marcado=($seleccionado==1) ? ' checked ' : '';
		$accionTxt=($accion!=null) ? "document.".NOMBRE_FORMULARIO.".accion.value='".$accion."';" : '';
		$subacionTxt=($subaccion!=null) ? "document.".NOMBRE_FORMULARIO.".subaccion.value='".$subaccion."';" : '';
		$itemTxt=($item!=null) ? "document.".NOMBRE_FORMULARIO.".item.value='".$item."';" : '';
		$onChangeTxt=($enviarFormulario!=null) ? " onchange=\"javascript:".$accionTxt.$subacionTxt.$itemTxt."document.".NOMBRE_FORMULARIO.".submit();\" " : "";
		
		for ($x=0;$x<count($arreglo);$x++){
			$marcado=($arreglo[$x]['id']==$valor)? " checked " : '';
			$leyendaTxt=(strlen($arreglo[$x]['nombre'])>0) ? $leyenda : '';
			echo "<input name='".$nombre."' type='checkbox' value='".$valor."' $marcado $onChangeTxt $claseTxt> $leyendaTxt </input>";
		}
		
		
	}
	


	/**
  	 *
	 * Función para insertar un grupo de Radio Buttons
	 *
	 * @param $nombre
	 * @param $arreglo
	 * @param $valor
	 * @param null $clase
	 * @param null $accion
	 * @param null $subaccion
	 * @param null $item
	 * @param null $enviarFormulario
	 */
	function ponerRadioButtons($nombre,$arreglo,$valor,$clase=null,$accion=null,$subaccion=null,$item=null,$enviarFormulario=null)
	{
		$claseTxt=($clase!=null) ? "<div class='".$clase."'>" : '' ;
		$claseTxtFin=($clase!=null) ? "</div>" : '' ;

		$accionTxt=($accion!=null) ? "document.".NOMBRE_FORMULARIO.".accion.value='".$accion."';" : '';
		$subacionTxt=($subaccion!=null) ? "document.".NOMBRE_FORMULARIO.".subaccion.value='".$subaccion."';" : '';
		$itemTxt=($item!=null) ? "document.".NOMBRE_FORMULARIO.".item.value='".$item."';" : '';
		$cambioTxt=($enviarFormulario!=null) ? " onchange=\"javascript:".$accionTxt.$subacionTxt.$itemTxt."document.".NOMBRE_FORMULARIO.".submit();\" " : "";

		echo "$claseTxt";
		for ($x=0;$x<count($arreglo);$x++){
			$marcado=($arreglo[$x]['id']==$valor)? " checked " : '';
			echo " &nbsp;&nbsp;&nbsp;<input type='radio' name='".$nombre."' value='".$arreglo[$x]['id']."' $marcado $cambioTxt>&nbsp;&nbsp;&nbsp;".$arreglo[$x]['nombre'];
			
			echo "<br>";
		}
		echo "$claseTxtFin";
	}
	
	function ponerRadioButtonsCampoExtra($nombre,$arreglo,$valor,$clase=null,$accion=null,$subaccion=null,$item=null,$enviarFormulario=null)
	{
//
		
		$claseTxt=($clase!=null) ? "<div class='".$clase."'>" : '' ;
		$claseTxtFin=($clase!=null) ? "</div>" : '' ;
		
		$accionTxt=($accion!=null) ? "document.".NOMBRE_FORMULARIO.".accion.value='".$accion."';" : '';
		$subacionTxt=($subaccion!=null) ? "document.".NOMBRE_FORMULARIO.".subaccion.value='".$subaccion."';" : '';
		$itemTxt=($item!=null) ? "document.".NOMBRE_FORMULARIO.".item.value='".$item."';" : '';
		$cambioTxt=($enviarFormulario!=null) ? " onchange=\"javascript:".$accionTxt.$subacionTxt.$itemTxt."document.".NOMBRE_FORMULARIO.".submit();\" " : "";
		
		echo "$claseTxt";
		for ($x=0;$x<count($arreglo);$x++){
			$nombreCampo=$nombre."_".$arreglo[$x]['id'];
			$nombreExtra=$nombreCampo."_extra";
			$marcado=($arreglo[$x]['id']==$valor)? " checked " : '';
			echo " &nbsp;&nbsp;&nbsp;<input name='".$nombre."' type='radio' value='".$arreglo[$x]['id']."' $marcado $cambioTxt>&nbsp;&nbsp;&nbsp;".$arreglo[$x]['nombre'];
			if($arreglo[$x]['tipoRespuesta']=='radioButton_texto'){
				echo "&nbsp;&nbsp;&nbsp;<input type='text' name='".$nombreExtra."'  size='30' maxlength='100' value='' class='inputGeneral'";
			}
			//echo "<br>";
		}
		echo "$claseTxtFin";
	}
	
	function ponerCheckBoxesCampoExtra($nombre,$arreglo,$valor,$clase=null,$accion=null,$subaccion=null,$item=null,$enviarFormulario=null)
	{
		$claseTxt=($clase!=null) ? "<div class='".$clase."'>" : '' ;
		$claseTxtFin=($clase!=null) ? "</div>" : '' ;
		
		$accionTxt=($accion!=null) ? "document.".NOMBRE_FORMULARIO.".accion.value='".$accion."';" : '';
		$subacionTxt=($subaccion!=null) ? "document.".NOMBRE_FORMULARIO.".subaccion.value='".$subaccion."';" : '';
		$itemTxt=($item!=null) ? "document.".NOMBRE_FORMULARIO.".item.value='".$item."';" : '';
		$cambioTxt=($enviarFormulario!=null) ? " onchange=\"javascript:".$accionTxt.$subacionTxt.$itemTxt."document.".NOMBRE_FORMULARIO.".submit();\" " : "";
		
		echo "$claseTxt";
		for ($x=0;$x<count($arreglo);$x++){
			$nombreCampo=$nombre."_".$arreglo[$x]['id'];
			$nombreExtra=$nombreCampo."_extra";
			$marcado=($arreglo[$x]['id']==$valor)? " checked " : '';
			echo " &nbsp;&nbsp;&nbsp;<input name='".$nombreCampo."' type='checkbox' value='".$arreglo[$x]['id']."' $marcado $cambioTxt>&nbsp;&nbsp;&nbsp;".$arreglo[$x]['nombre'];
			if($arreglo[$x]['tipoRespuesta']=='checkBox_texto'){
				echo "&nbsp;&nbsp;&nbsp;<input type='text' name='".$nombreExtra."'  size='30' maxlength='100' value='' class='inputGeneral'";
				
			}
			//echo "<br>";
		}
		echo "$claseTxtFin";
	}
	
	/**
	 *
	 * Función para insertar un grupo de Radio Buttons en la misma linea
	 *
	 * @param      $nombre
	 * @param      $arreglo
	 * @param      $valor
	 * @param null $clase
	 * @param null $accion
	 * @param null $subaccion
	 * @param null $item
	 * @param null $enviarFormulario
	 */
	function ponerRadioButtonsEnLinea($nombre, $arreglo, $valor, $clase=null, $accion=null, $subaccion=null, $item=null, $enviarFormulario=null)
	{
		$claseTxt=($clase!=null) ? "<span class='".$clase."'>" : '' ;
		$claseTxtFin=($clase!=null) ? "</span>" : '' ;

		$accionTxt=($accion!=null) ? "document.".NOMBRE_FORMULARIO.".accion.value='".$accion."';" : '';
		$subacionTxt=($subaccion!=null) ? "document.".NOMBRE_FORMULARIO.".subaccion.value='".$subaccion."';" : '';
		$itemTxt=($item!=null) ? "document.".NOMBRE_FORMULARIO.".item.value='".$item."';" : '';
		$cambioTxt=($enviarFormulario!=null) ? " onchange=\"javascript:".$accionTxt.$subacionTxt.$itemTxt."document.".NOMBRE_FORMULARIO.".submit();\" " : "";

		echo "$claseTxt";
		for ($x=0;$x<count($arreglo);$x++){
			$marcado=($arreglo[$x]['id']==$valor)? " checked " : '';
			echo " &nbsp;&nbsp;&nbsp;<input name='".$nombre."' type='radio' value='".$arreglo[$x]['id']."' $marcado $cambioTxt>&nbsp;&nbsp;&nbsp;".$arreglo[$x]['nombre'];
		}
		echo "$claseTxtFin";
	}

	/**
	 *
	 * Función para insertar un grupo de Radio Buttons en la misma linea con selección de idioma
	 *
	 * @param      $nombre
	 * @param      $arreglo
	 * @param      $idioma
	 * @param      $valor
	 * @param null $clase
	 * @param null $accion
	 * @param null $subaccion
	 * @param null $item
	 * @param null $enviarFormulario
	 */
	function ponerRadioButtonsEnLineaIdiomas($nombre, $arreglo, $idioma, $valor, $clase=null, $accion=null, $subaccion=null, $item=null, $enviarFormulario=null)
	{
		$claseTxt=($clase!=null) ? "<div class='".$clase."'>" : '' ;
		$claseTxtFin=($clase!=null) ? "</div>" : '' ;

		$accionTxt=($accion!=null) ? "document.".NOMBRE_FORMULARIO.".accion.value='".$accion."';" : '';
		$subacionTxt=($subaccion!=null) ? "document.".NOMBRE_FORMULARIO.".subaccion.value='".$subaccion."';" : '';
		$itemTxt=($item!=null) ? "document.".NOMBRE_FORMULARIO.".item.value='".$item."';" : '';
		$cambioTxt=($enviarFormulario!=null) ? " onchange=\"javascript:".$accionTxt.$subacionTxt.$itemTxt."document.".NOMBRE_FORMULARIO.".submit();\" " : "";

		echo "$claseTxt";
		for ($x=0;$x<count($arreglo);$x++){
			$marcado=($arreglo[$x]['id']==$valor)? " checked " : '';
			echo " &nbsp;&nbsp;&nbsp;<input name='".$nombre."' type='radio' value='".$arreglo[$x]['id']."' $marcado $cambioTxt>&nbsp;&nbsp;&nbsp;".$arreglo[$x][$idioma];
		}
		echo "$claseTxtFin";
	}

	/**
	 *
	 * Función para insertar un grupo de Radio Buttons en la misma linea con selección de idioma y
	 * modificador de visibilidad de otros elementos del formulario
	 *
	 * @param      $nombre
	 * @param      $item
	 * @param      $valorActual
	 * @param null $clase
	 * @param      $idioma
	 */
	function ponerRadioButtonsOcultadores($nombre, $item, $valorActual, $clase=null, $idioma=null)
	{
		$textoSi=($idioma=='espanol')? 'Si' : 'Yes';
		$textoNo=($idioma=='espanol')? 'No' : 'No';
		echo "<div class='".$clase."'>";
			$marcado = 	($valorActual=='1') ? " checked " : "";
			echo "<input name=\"$nombre\" value=\"1\" onclick=\"toggle_visibility('".$item."','on');\"  type=\"radio\" $marcado>&nbsp;&nbsp;&nbsp;$textoSi";
			$marcado = 	($valorActual=='0') ? " checked " : "";
			echo "&nbsp;&nbsp;&nbsp;<input name=\"$nombre\" value=\"0\" onclick=\"toggle_visibility('".$item."','off');\"  type=\"radio\" $marcado>&nbsp;&nbsp;&nbsp;$textoNo";
		echo "</div>";
	}

	/**
	 *
	 * Genera un string pseudoaleatorio del largo especificado
	 *
	 * @param $largo
	 *
	 * @return string
	 */
	function hacerAlfanumericoAleatorio($largo)
	{
		$caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$texto = '';
		for ($x = 0; $x < $largo; $x++) {
			$texto .= $caracteres[rand(0, strlen($caracteres) - 1)];
		}
		return($texto);
	}

	/**
	 *
	 * Elimina caracteres acentuados, eñes y caracteres raros
	 *
	 * @param $texto
	 *
	 * @return string
	 */
	function convertirAASCII($texto)
	{
        return strtr(utf8_decode($texto),
        utf8_decode(
        'ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ& ,'),
        'SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy___');
	}

	/**
  	 *
	 * Función para cambiar formato de fecha de (año-mes-dia) a (dia-mes-año)
	 *
	 * @param $fecha
	 * @return string
	 */
	function transformarFechaDMY($fecha)
	{
		$ano=substr($fecha,0,4);
		$mes=substr($fecha,5,2);
		$dia=substr($fecha,8,2);
		$nuevaFecha="$dia-$mes-$ano";
		return ($nuevaFecha);
	}

	/**
  	 *
	 * Función para calcular los dias transcurridos entre dos fechas
	 *
	 * @param $inicio
	 * @param $fin
	 * @return float
	 */
	function diasTranscurridos($inicio,$fin)
	{
		$start = strtotime($inicio);
		$end = strtotime($fin);
		$days_between = ceil(abs($end - $start) / 86400);
		return($days_between);
	}

	function restarAnos($anos)
	{
		$fechaNacimiento = strtotime("-$anos years");
		$fechaBien = date('Y-m-d', $fechaNacimiento);
		return $fechaBien;
	}
	
	/**
  	 *
	 * Función para enseñar un arreglo para debugueo
	 *
	 * @param $arreglo
	 * @param $nombre
	 */
	function ensenarArreglo($arreglo,$nombre)
	{
		echo "<div class='debugeo'>";
		print "<pre>";
		echo "<br>$nombre  <BR>";
		print_r($arreglo);
		print "</pre>";
		echo "</div>";
	}

	/**
	 *
	 * Función para insertar un menú desplegable con categorias de agrupación
	 * de práctica y criterios
	 *
	 * @param      $arreglo
	 * @param null $clase
	 */
	function ponerMenuJerarquico($arreglo)
	{
		$titulo="Elija criterio";
		//$claseTxt=($clase!=null) ? " class='".$clase."' " :'' ;
		echo "<select name='menuPracticaCriterio' id='menuPracticaCriterio'  >";
		echo "<option value='".$titulo."' >$titulo</option>";
		for($x=0;$x<count($arreglo);$x++){
			echo "<option value='".$arreglo[$x]['id']."' ><div class='tituloSeccion'>".$arreglo[$x]['nombrePractica']."</div></option>";
			for($y=0;$y<count($arreglo[$x]['criterios']);$y++){
				echo "<option value='".$arreglo[$x]['criterios'][$y]['criterioId']."'><div class='tituloSeccion'>"."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$arreglo[$x]['criterios'][$y]['nombre']."</div></option>";
			}
		}
		echo "</select>";
	}

	/**
	 *
	 * Función para insertar un menú desplegable con categorias de agrupación
	 * de categoría y prácticas
	 *
	 * @param      $arreglo
	 * @param null $clase
	 */
	function ponerMenuPracticasPendientes($arreglo)
	{
		$titulo="Elija practica";
		//$claseTxt=($clase!=null) ? " class='".$clase."' " :'' ;
		echo "<select name='menuPracticaPendiente' id='menuPracticaPendiente'  >";
		echo "<option value='".$titulo."' >$titulo</option>";
		for($x=0;$x<count($arreglo);$x++){
			echo "<option value='noSeleccionable' ><div class='tituloSeccion'>".$arreglo[$x]['nombreCategoria']."</div></option>";
			for($y=0;$y<count($arreglo[$x]['practicas']);$y++){
				if($arreglo[$x]['practicas'][$y]['idEstatus'] == '') {
					echo "<option value='".$arreglo[$x]['practicas'][$y]['idPractica']."'><div class='tituloSeccion'>"."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$arreglo[$x]['practicas'][$y]['nombrePractica']."</div></option>";
				}
			}
		}
		echo "</select>";
	}
	
	function validarFecha($fecha) // 06/03/2018
	{
		$arrfecha=$this->separarFecha($fecha, 'd-m-Y','/');
		if ($arrfecha['dia']<1 or $arrfecha['mes']<1 or strlen($arrfecha['ano'])!=4){
			$resultado=0;
		}else{
			$resultado=(checkdate ($arrfecha['mes'],$arrfecha['dia'],$arrfecha['ano'] )) ? $arrfecha['ano']."-".$arrfecha['mes']."-".$arrfecha['dia'] :'0';
		}
		
		return($resultado);
	}
	
	function separarFecha($fecha,$formato,$separador)
	{
		$resultado=array();
		$origen=explode("$separador", $fecha);
		switch($formato){
			case 'd-m-Y':
				$dia=$origen[0];
				$mes=$origen[1];
				$ano=$origen[2];
				break;
			case 'm-d-Y':
				$dia=$origen[1];
				$mes=$origen[0];
				$ano=$origen[2];
				break;
			case 'Y-m-d':
				$dia=$origen[2];
				$mes=$origen[1];
				$ano=$origen[0];
				break;
		}
		$resultado['dia']=$dia;
		$resultado['mes']=$mes;
		$resultado['ano']=$ano;
		return($resultado);
	}
	
	function traducirFecha($fecha,$formatoInicial,$formatoFinal, $separadorInicial, $separadorFinal)
	{
		$arrFecha=$this->separarFecha($fecha, $formatoInicial, $separadorInicial);
		
		switch($formatoFinal) {
			case 'd-m-Y':
				$fechaFinal = $arrFecha['dia'] . "$separadorFinal" . $arrFecha['mes'] . "$separadorFinal" . $arrFecha['ano'];
				break;
			case 'm-d-Y':
				$fechaFinal = $arrFecha['mes'] . "$separadorFinal" . $arrFecha['dia'] . "$separadorFinal" . $arrFecha['ano'];
				break;
			case 'Y-m-d':
				$fechaFinal = $arrFecha['ano'] . "$separadorFinal" . $arrFecha['mes'] . "$separadorFinal" . $arrFecha['dia'];
				break;
		}
		
		return ($fechaFinal);
	}
	
	function validarCorreo($correo)
	{
		// inicializar valor de retorno
		
		$correoValido = FALSE;
		
		// asegurar que no se paso un valor vacio
		
		if (!empty($correo))
		{
			// sacar partes del correo
			
			$dominio = ltrim(stristr($correo, '@'), '@') . '.';
			$usuario   = stristr($correo, '@', TRUE);
			
			// validar la direccion
			
			if (!empty($usuario) && !empty($dominio) && checkdnsrr($dominio)) {
				$correoValido = TRUE;
			}
		}
		return $correoValido;
	}
	
	function restarAnosAFecha($anos,$fecha=null)
	{
		if($fecha==null){
			$fecha=HOY;
		}
		$nuevoTiempo="$fecha -$anos year";
		$fechaBuscada=  strtotime($nuevoTiempo);
		return $fechaBuscada;
		
	}
	
	function dispararAlerta($texto)
	{
		echo "<script type=\"text/javascript\">alert(\"$texto\");</script>";
	}
}
