<!-- tabla con registro de hoteles del usuario-->

<div class="row">
    <div class="col-sm-2">
         <img src="imagenes/odscircle.png" width="70%" align="right"/>
    </div>
    <div class="col-sm-8" class=" textoCarta centrado">
        <h3>Calculadora de sostenibilidad en turismo </h3>
        <h3>Bienvenido (a)</h3>

Al dar clic en “Calcular con autoevaluación”, se presenta la primera de seis secciones de formularios sobre las operaciones de su hotel. Al finalizar los formularios, obtendrá los valores de sus contribuciones a la sostenibilidad de acuerdo a la Agenda 2030, y podrá generar un reporte detallado y posteriormente generar un plan de acción, así como solicitar asesoría o evaluación de un especialista en la agenda 2030. En caso de dudas, puede descargar y consultar el manual de usuario.
    </div>
    <div class="col-sm-2">
    </div>
</div>
<!--evaluaciones completas-->
<div class="row">
    <div class="col-sm-2">    </div>
    <div class="col-sm-8">
        <br>
        <div class="card mx-auto redondeada">
            <div class="card-body textoCarta">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="card-subtitle mb-2 text-muted centrado">
                            Lista de hoteles asociados a usted
                        </h4>
                    </div>
                </div>
				<?php for($x=0;$x<count($this->arrHoteles);$x++){?>
                    <div class="row">
                        <div class="col-sm-8">
							<?php echo ($this->arrHoteles[$x]['nombreHotel']) ; ?>
                        </div>
                        <div class="col-sm-4">
						    <?php $this->fx->ponerBoton('nuevaEvaluacion',null,$this->arrHoteles[$x]['id'],'Nueva evaluación',null,null,null,'btn btn-xs btn-dark','0',null,null,null); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-11">
							<?php echo ($this->arrHoteles[$x]['nombreEstado']."/".$this->arrHoteles[$x]['nombreMunicipio']) ; ?>
                        </div>
                    </div>
                    <?php for($y=0;$y<count($this->arrHoteles[$x]['evaluaciones']);$y++){ ?>
                        <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10">Evaluacion &nbsp;
								<?php $this->fx->ponerBoton('traerCuestionario',null,$this->arrHoteles[$x]['evaluaciones'][$y]['id'],$this->arrHoteles[$x]['evaluaciones'][$y]['fechaH'],null,null,null,'negritas','0',null,null,null); ?>
								<?php echo (" - ".$this->arrHoteles[$x]['evaluaciones'][$y]['puntuacion']." puntos") ; ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-2">Personas &nbsp;<br>
								<?php echo (number_format($this->arrHoteles[$x]['evaluaciones'][$y]['respuestasPuntuales'][0],2)) ; ?>
                            </div>
                            <div class="col-sm-2">Paz &nbsp;<br>
								<?php echo (number_format($this->arrHoteles[$x]['evaluaciones'][$y]['respuestasPuntuales'][1],2)) ; ?>
                            </div>
                            <div class="col-sm-2">Prosperidad &nbsp;<br>
								<?php echo (number_format($this->arrHoteles[$x]['evaluaciones'][$y]['respuestasPuntuales'][2],2)) ; ?>
                            </div>
                            <div class="col-sm-2">Planeta &nbsp;<br>
								<?php echo (number_format($this->arrHoteles[$x]['evaluaciones'][$y]['respuestasPuntuales'][3],2)) ; ?>
                            </div>
                            <div class="col-sm-2">Alianzas &nbsp;<br>
								<?php echo (number_format($this->arrHoteles[$x]['evaluaciones'][$y]['respuestasPuntuales'][4],2)) ; ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 centrado">
                                <?php $this->fx->ponerBoton('descargarRespuesta',null,$this->arrHoteles[$x]['evaluaciones'][$y]['id'],'Descargar respuestas',null,null,null,'negritas','0',null,null,null); ?>
                            </div>
                        </div>
      
      
						<?php for($z=0;$z<count($this->arrHoteles[$x]['evaluaciones'][$y]['planes']);$z++){ ?>
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9">
									<?php $this->fx->ponerBoton('traerPlan',null,$this->arrHoteles[$x]['evaluaciones'][$y]['planes'][$z]['id'],"Plan de acción",null,null,null,'negritas','0',null,null,null); ?>
                                </div>
                            </div>
						<?php } ?>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-sm-2"></div>
</div>

<!--evaluaciones parciales-->
<div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-8">
        <br>
        <div class="card mx-auto redondeada">
            <div class="card-body textoCarta">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="card-subtitle mb-2 text-muted centrado">
                            Lista de autoevaluaciones parciales
                        </h4>
                    </div>
                </div>
                <?php for($x=0;$x<count($this->arrEvaluacionesParciales);$x++){?>
                    <div class="row">
                        <div class="col-sm-12">
                            <?php echo ($this->arrEvaluacionesParciales[$x]['nombreHotel']) ; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-11">
                            <?php echo ($this->arrEvaluacionesParciales[$x]['nombreEdo']."/".$this->arrEvaluacionesParciales[$x]['nombreMun']) ; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <?php $this->fx->ponerBoton('traerCuestionarioParcial',null,$this->arrEvaluacionesParciales[$x]['id'],$this->arrEvaluacionesParciales[$x]['fechaH'],null,null,null,'','0',null,null,null); ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-sm-2"></div>
</div>

<!--botones-->
<br>
<div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-4 centrado">
        <a href="vistas/manual.pdf" class="btn estiloBoton">Descargar manual de usuario</a>
    </div>
    <div class="col-sm-4 centrado">
		<?php $this->fx->ponerBoton('agregarCuestionario',null,null,'Autoevaluación',null,null,null,'btn estiloBoton','0',null,null,null); ?>
    </div>
    <div class="col-sm-2"></div>
</div>







