<!-- LOGIN-->
<?php
//include_once ('vistas/general/cabeza.php');

if($this->seccionPorMostrar==6){
	$seccionId=$this->seccionPorMostrar-2;
	$nombreBoton="Calcular";
	$accion="grabarCuestionario";
	
}else{
	$seccionId=$this->seccionPorMostrar-2;
	$siguienteSeccion=$this->seccionPorMostrar+1;
	$nombreBoton="Guardar e ir a la sección ".$siguienteSeccion;
	$accion="ponerSiguienteSeccion";
//	$accion="ponerSeccion2";
}


if ($this->pantallaSubirEvidencia == 1) {
	include('vistas/cuestionarios/subirEvidencia.php');
}
?>
<div class="row">
	<div class="col-sm-1">
 
	</div>
	<div class="col-sm-10">
		<br>
		<div class="card mx-auto redondeadaSinAltura"  style="background-color:#ffe9d5;">
				<div class="row">
					<div class="col-sm-12 titulo ">&nbsp;&nbsp;&nbsp;&nbsp;
                       <?php echo $this->arrCuestionario[$seccionId]['nombre']; ?>
					</div>
				</div>
				<br>
                <?php
                
				for($y=0;$y<count($this->arrCuestionario[$seccionId]['temas']);$y++) {
                    echo '<div class="row">';
                        echo '<div class="col-sm-12">';
                            echo '<h4 class="card-subtitle mb-2 text-muted ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                echo ($this->arrCuestionario[$seccionId]['temas'][$y]['nombre']);
                            echo '</h4>';
                        echo '</div>';
					echo '</div>';
                    echo '<br>';
                    for($z=0;$z<count($this->arrCuestionario[$seccionId]['temas'][$y]['preguntas']);$z++){
						$subaccion=$seccionId.'_'.$y.'_'.$z;
						$textoAyuda=$this->arrCuestionario[$seccionId]['temas'][$y]['preguntas'][$z]['ayuda'];
                        echo '<div class=row>';
						    echo '<div class="col-sm-1">';
                            echo '</div>';
                            echo '<div class="col-sm-10">';
                                echo  '<h6 class="card-subtitle mb-2 text-muted">';
                                    echo($this->arrCuestionario[$seccionId]['temas'][$y]['preguntas'][$z]['nombre']);
                                    echo "&nbsp;&nbsp;&nbsp;";
						            $this->fx->ponerBoton('subirEvidencia', $subaccion, null, null, 'imagenes/subirEvidencia.gif', '16', null, null, null, null,null,null);
                                    if(!empty($this->arrCuestionario[$seccionId]['temas'][$y]['preguntas'][$z]['ayuda'])){
										echo "&nbsp;&nbsp;&nbsp;";
										echo "<a href=\"#\" data-toggle=\"popover\" data-trigger=\"focus\" title=\"Ayuda\" data-content=\"".$textoAyuda." \" data-html=\"true\"><img src=\"http://sustainability-calculator.hasselbit.com/wp-content/uploads/sites/6/2017/02/info-sign.png\" width=\"25\"></a>";
//                                        $this->fx->ponerBoton('abrirAyuda', $subaccion, null, null, 'imagenes/botonAyuda.png', '16', null, null, null, null,null,null);
										echo "<br>";
                                    }
                                echo '</h6>';
                                
                                $nombreInput = "input_".$seccionId."_".$y."_".$z;
                                
                                if ($this->arrCuestionario[$seccionId]['temas'][$y]['preguntas'][$z]['tipo'] == 'radioButton') {
                                    $this->fx->ponerRadioButtonsEnLinea($nombreInput, $this->arrCuestionario[$seccionId]['temas'][$y]['preguntas'][$z]['respuestas'], $this->arrCuestionario[$seccionId]['temas'][$y]['preguntas'][$z]['idRespuestaUsuario'], 'estiloRadioButton', null, null, null, null);
                                    echo "<br><br>";
                                }else if ($this->arrCuestionario[$seccionId]['temas'][$y]['preguntas'][$z]['tipo'] == 'booleano'){
                                    $this->fx->ponerRadioButtonsEnLinea($nombreInput, $this->arrSiNo, $this->arrCuestionario[$seccionId]['temas'][$y]['preguntas'][$z]['idRespuestaUsuario'], 'estiloRadioButton', null, null, null, null);
                                    echo "<br><br>";
                                }else if($this->arrCuestionario[$seccionId]['temas'][$y]['preguntas'][$z]['tipo'] == 'checkBoxes'){
                                    for($pp=0;$pp<count($this->arrCuestionario[$seccionId]['temas'][$y]['preguntas'][$z]['respuestas']);$pp++){
                                        $nombreRespuesta="respuestaCheckBox_".$seccionId."_".$y."_".$z."_".$pp;
                                    	$leyenda=$this->arrCuestionario[$seccionId]['temas'][$y]['preguntas'][$z]['respuestas'][$pp]['nombre'];
										$valor="1";
										$seleccionado=$this->arrCuestionario[$seccionId]['temas'][$y]['preguntas'][$z]['respuestas'][$pp]['respuestaAnotada'];
												$this->fx->ponerCheckBox($nombreRespuesta,$leyenda,$valor,$seleccionado,null,null,null,null,null, null);
												echo "<br>";
                                    }
									echo "<br>";
								}else if($this->arrCuestionario[$seccionId]['temas'][$y]['preguntas'][$z]['tipo'] == 'calculo'){
                                    for($t=0;$t<count($this->arrCuestionario[$seccionId]['temas'][$y]['preguntas'][$z]['respuestas']);$t++){
										$nombreInput = "calculo_" . $seccionId . "_" . $y . "_" . $z . "_" . $t;
                                        if($t==2){
											$seleccionado=$this->arrCuestionario[$seccionId]['temas'][$y]['preguntas'][$z]['respuestas'][$t]['respuestaAnotada'];
											$this->fx->ponerCheckBox($nombreInput,$this->arrCuestionario[$seccionId]['temas'][$y]['preguntas'][$z]['respuestas'][$t]['nombre'],"1",$seleccionado,null,null,null,null,null, null);
                                        }else {
											$valor = $this->arrCuestionario[$seccionId]['temas'][$y]['preguntas'][$z]['respuestas'][$t]['respuestaAnotada'];
											echo($this->arrCuestionario[$seccionId]['temas'][$y]['preguntas'][$z]['respuestas'][$t]['nombre'] . "&nbsp;&nbsp;&nbsp;");
											$this->fx->ponerInput('number', $nombreInput, '15', '10', $valor, 'estiloRadioButton', 'Cantidad', null, null, null, null, null, null);
										}
										echo "<br>";
                                    }
									echo "<br>";
									
								}else if($this->arrCuestionario[$seccionId]['temas'][$y]['preguntas'][$z]['tipo'] == 'numero'){
									$nombreInput = "numero_".$seccionId."_".$y."_".$z;
									$valor=$this->arrCuestionario[$seccionId]['temas'][$y]['preguntas'][$z]['valorRespuestaUsuario'];
                                    $this->fx->ponerInput('number',$nombreInput,'15','3',$valor,'estiloRadioButton','Cantidad',null,null,null,null,null,null);
								}
                            echo '</div>';
						    echo '<div class="col-sm-1">';
						    echo '</div>';
						echo '</div>';
					} ?>
				<?php }


				if($this->seccionPorMostrar==6){
					echo '<div class="row">';
                        echo '<div class="col-sm-1">';
                        echo '</div>';
                        echo '<div class="col-sm-11">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                            echo '<h4 class="card-subtitle mb-2 text-muted ">';
                             echo "Comentarios";
                            echo "</h4>";
				        echo '</div>';
				    echo '</div>';
        
				    echo '<div class="row">';
                        echo '<div class="col-sm-1">';
                        echo '</div>';
                        echo '<div class="col-sm-11">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                            $this->fx->ponerAreaTexto('comentarios',100,4,'estiloRadioButton',null);
                        echo '</div>';
                    echo '</div>';
                 }
                 ?>
				<br>
                <div class="row">
                    <div class="col-sm-12 centrado">
						<?php //$this->fx->ponerBoton('llenarValores',null,null,'llenar datos',null,null,null,'btn estiloBoton','0',null,null,null); ?>
						<?php $this->fx->ponerMenu('regresar','Ir a sección',$this->arrRegresos,null,$this->estadoHotel,'cambiarDeSeccion',null,null,'estiloRadioButton','1'); ?>
                    </div>
                </div>
                <br>
				<div class="row">
					<div class="col-sm-4 centrado">
						<?php $this->fx->ponerBoton('reiniciar',null,null,'Reiniciar',null,null,null,'btn estiloBoton','0',null,null,null); ?>
					</div>
                    <div class="col-sm-4 centrado">
						<?php if ($nombreBoton!='Calcular'){
							$this->fx->ponerBoton('guardarSalir',null,null,'Guardar avances y salir',null,null,null,'btn estiloBoton','0',null,null,null);
						}else{
							echo "&nbsp;";
						} ?>
                    </div>
					<div class="col-sm-4 centrado">
						<?php $this->fx->ponerBoton($accion,null,null,$nombreBoton,null,null,null,'btn estiloBoton','0',null,null,null); ?>
					</div>
				</div>
            <br>
		</div>
	</div>
	<div class="col-sm-1">
	</div>
</div>
















