<!-- tabla con registro de hoteles del usuario-->
<?php //include_once ('vistas/general/cabeza.php') ?>

<!--<div class="w3-row">-->
<!--  <div class="w3-col m2" >.</div>-->
<!--  <div class="w3-col m2 w3-light-grey w3-justify w3-padding-32 w3-row-padding" >-->
<!--    <h5><img src="imagenes/calculadora-150x150.png" alt="" width="85" height="85" sizes="(max-width: 85px) 100vw, 85px" />Calcular el impacto</h5><p>Medir a través de una calculadora de sostenibilidad el impacto que tienen las operaciones del hotel a favor de los ODS y a la Agenda 2030. Esta calculadora agrega los impactos de más de 50 indicadores que provienen de 70 preguntas y documentos de evidencias.</p>-->
<!--  </div>-->
<!--  <div class="w3-col m2 w3-justify w3-padding-32 w3-row-padding">-->
<!--    <h5><img src="imagenes/checklist_azul-gris-230x269.png" alt="" width="73" height="85" sizes="(max-width: 73px) 100vw, 73px" />Analizar las operaciones</h5><p>Identificar los temas en donde las operaciones del hotel tiene mayores contribuciones a la <a href="index.html%3Fp=15.html">Agenda 2030</a> e identificar cuales son las áreas de oportunidad para mejorar estas contribuciones. Con <a href="index.html%3Fp=16.html">buenas prácticas en hoteles</a>, conocer acciones específicas que el hotel puede implementar.</p>-->
<!--  </div>-->
<!--  <div class="w3-col m2 w3-light-grey  w3-justify w3-padding-32 w3-row-padding">-->
<!--    <h5><img src="imagenes/calendario_azul-1-150x150.png" alt="" width="90" height="90"  sizes="(max-width: 90px) 100vw, 90px" />Elaborar Plan de acción</h5><p>Tomar las decisiones sobre las acciones que mejorarán el impacto del hotel hacia la agenda 2030, establecer los plazos en los que se contará con resultados verificables y asignar responsables y  recursos que se requieran para cumplir con las acciones</p>-->
<!--  </div>-->
<!--  <div class="w3-col m2 w3-justify w3-padding-32 w3-row-padding">-->
<!--    <h5><img  src="imagenes/financial-blue-150x150.png" alt="" width="85" height="85" sizes="(max-width: 85px) 100vw, 85px" />Evaluar los cambios</h5><p>Evaluar los cambios obtenidos con los resultados del plan y apoyar la mejora continua de las operaciones del hotel al identificar de manera periódica nuevas áreas de oportunidad.</p>-->
<!--  </div>-->
<!--    <div class="w3-col m2" >.</div>-->
<!--  </div>-->
<div class="row">
    <div class="col-sm-1">
    </div>
    <div class="col-sm-10" class=" textoCarta centrado">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
    </div>
    <div class="col-sm-1">
    </div>
</div>
    
    <div class="row">
    <div class="col-sm-1">
    </div>
    <div class="col-sm-10">
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
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-sm">
                            <table class="table table-borderless" >
                                <thead class="thead-white">
                                <tr>
                                    <th class="textoCarta negritas">
                                        Hotel
                                    </th>
                                    <th class="textoCarta negritas">
                                        Estado
                                    </th>
                                    <th class="textoCarta negritas">
                                        Municipio
                                    </th>
                                    <th class="textoCarta negritas">
                                        Tipo
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
								<?php for($x=0;$x<count($this->arrHoteles);$x++){?>
                                    <tr>
                                        <td>
											<?php //$this->fx->ponerBoton('traerCuestionario',null,$this->arrHoteles[$x]['id'],$this->arrHoteles[$x]['nombre'],null,null,null,'','0',null,null,null); ?>
											<?php echo ($this->arrHoteles[$x]['nombre']) ; ?>
                                        </td>
                                        <td>
											<?php echo ($this->arrHoteles[$x]['nombreEstado']) ; ?>
                                        </td>
                                        <td class="sinRayaInferior">
											<?php echo ($this->arrHoteles[$x]['municipio']) ; ?>
                                        </td>
                                        <td>
											<?php echo ($this->arrHoteles[$x]['nombreTipo']) ; ?>
                                        </td>
                                    </tr>
                                    <?php for($y=0;$y<count($this->arrHoteles[$x]['evaluaciones']);$y++){ ?>
                                    <tr>
                                        <td>
                                            &nbsp;
                                        </td>
                                        <td>
											<?php $this->fx->ponerBoton('traerCuestionario',null,$this->arrHoteles[$x]['evaluaciones'][$y]['id'],$this->arrHoteles[$x]['evaluaciones'][$y]['fecha'],null,null,null,'','0',null,null,null); ?>
											<?php echo (" - ".$this->arrHoteles[$x]['evaluaciones'][$y]['puntuacion']) ; ?>
                                        </td>
                                        <td>
											&nbsp;
                                        </td>
                                        <td>
                                            &nbsp;
                                        </td>
                                    </tr>
									<?php } ?>
								<?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="col-sm-3 centrado">
						<?php $this->fx->ponerBoton('salir',null,null,'Logout',null,null,null,'btn estiloBoton','0',null,null,null); ?>
                    </div>
                    <div class="col-sm-3 centrado">
						<?php $this->fx->ponerBoton('agregarCuestionario',null,null,'Calcular con revisión de evidencias',null,null,null,'btn estiloBoton','0',null,null,null); ?>
                    </div>
                    <div class="col-sm-3 centrado">
                        <a href="manual.pdf" class="btn estiloBoton">Descargar manual de usuario</a>
                    </div>
                    <div class="col-sm-3 centrado">
						<?php $this->fx->ponerBoton('ensayarCuestionario',null,null,'Realizar una autoevaluación',null,null,null,'btn estiloBoton','0',null,null,null); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-1">
    </div>
</div>





