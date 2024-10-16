<?php
for($x=0;$x<count($this->arrCuestionario);$x++){?>
	<br>
	<!-- Sección 2-->
	<div class="col-sm-12">
		<div class="card mx-auto ">
			<div class="card-header  bg-secondary text-white">
				<?php
				//todo: poner resultado aqui
				echo ($this->arrCuestionario[$x]['nombre']);
				?>
			</div>
			<div class="card-body textoCarta">
				<?php
				for($y=0;$y<count($this->arrCuestionario[$x]['temas']);$y++) {
					echo '<h5 class="card-title">';
					echo($this->arrCuestionario[$x]['temas'][$y]['nombre']."<br>");
					echo "</h5>";
					echo "<br>&nbsp;";
					for($z=0;$z<count($this->arrCuestionario[$x]['temas'][$y]['preguntas']);$z++){
						for($q=0;$q<count($this->arrSoportes);$q++){
							for($r=0;$r<count($this->arrSoportes[$q]);$r++){
								if($this->arrSoportes[$q]['idPregunta']== $this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z['id']]){
									$adenda="";
								}else {
									$adenda='';
								}
							}
						
						}
						echo  '<h6 class="card-subtitle mb-2 text-muted">';
//						echo($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['nombre']." &nbsp;&nbsp;&nbsp;$adenda<br>");
						echo($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['nombre']);
						echo '</h6>';
						$nombreInput = "input_".$x."_".$y."_".$z;
						if ($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['tipo'] == 'radioButton') {
							$this->fx->ponerRadioButtonsEnLinea($nombreInput, $this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas'], $this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['idRespuestaUsuario'], 'estiloRadioButton', null, null, null, null);
							echo "<br><br>";
						}else if ($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['tipo'] == 'booleano'){
							$this->fx->ponerRadioButtonsEnLinea($nombreInput, $this->arrSiNo, $this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['idRespuestaUsuario'], 'estiloRadioButton', null, null, null, null);
							echo "<br><br>";
						}else if($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['tipo'] == 'checkBoxes'){
							for($pp=0;$pp<count($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas']);$pp++){
								$nombreRespuesta="respuestaCheckBox_".$x."_".$y."_".$z."_".$pp;
								$leyenda=$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas'][$pp]['nombre'];
								$valor="1";
								$seleccionado=$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas'][$pp]['respuestaAnotada'];
								$this->fx->ponerCheckBox($nombreRespuesta,$leyenda,$valor,$seleccionado,null,null,null,null,null, null);
								echo "<br>";
							}
							echo "<br>";
						}else if($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['tipo'] == 'calculo'){
							for($t=0;$t<count($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas']);$t++){
								$nombreInput = "calculo_" . $x . "_" . $y . "_" . $z . "_" . $t;
								if($t==2){
									$seleccionado=$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas'][$t]['respuestaAnotada'];
									$this->fx->ponerCheckBox($nombreInput,$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas'][$t]['nombre'],"1",$seleccionado,null,null,null,null,null, null);
								}else {
									$valor = $this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas'][$t]['respuestaAnotada'];
									echo($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas'][$t]['nombre'] . "&nbsp;&nbsp;&nbsp;");
									$this->fx->ponerInput('text', $nombreInput, '15', '10', $valor, 'estiloRadioButton', 'Cantidad', null, null, null, null, null, null);
								}
								echo "<br>";
							}
							echo "<br>";
							
						}else if($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['tipo'] == 'numero'){
							$nombreInput = "numero_".$x."_".$y."_".$z;
							$valor=$this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['valorRespuestaUsuario'];
							$this->fx->ponerInput('text',$nombreInput,'15','3',$valor,'estiloRadioButton','Cantidad',null,null,null,null,null,null);
							echo "<br>";
						}
					}
				}
				?>
			
			</div>
			<div class="card-footer">
			</div>
		</div>
	</div>
	<?php
}

echo '<div class="card-footer ">';
$this->fx->ponerBoton('home','grabarCambiosEvaluacion',null, 'Grabar cambios', null, null,null, 'btn btn-dark', '0', null, null, null);
echo "   ";
//$this->fx->ponerBoton('llenarValores',null,null, 'Llenar valores aleatorios', null, null,null, 'btn btn-dark', '0', null, null, null);
echo '</div>';
?>
