
<div class="row">
	<div class="col-sm-2"></div>
	<div class="col-sm-8">
		<br>
		<div class="card mx-auto ">
			<div class="card-header bg-dark text-white ">
				Cuestionario
			</div>
			
			
			<div class="card-body textoCarta">
				<?php
				$this->fx->ponerBoton('llenarValores',null,null, 'Llenar todos lo valores aleatorios', null, null,null, 'btn btn-dark', '0', null, null, null);
				echo "    ";
				$this->fx->ponerBoton('llenarAlgunosValores',null,null, 'Llenar algunos valores aleatorios', null, null,null, 'btn btn-dark', '0', null, null, null);
				echo "    ";
				$this->fx->ponerBoton('grabarCuestionario',null,null, 'Calcular', null, null,null, 'btn btn-dark', '0', null, null, null);
				echo "    ";
				$this->fx->ponerBoton('salir',null,null, 'Logout', null, null,null, 'btn btn-dark', '0', null, null, null);
				?>
				
				<br>
				<!-- Sección 1. Datos generales-->
				<div class="col-sm-12">
					<div class="card mx-auto ">
						<div class="card-header  bg-secondary text-white">
							Sección 1. Datos generales
						</div>
						<div class="card-body textoCarta">
							<div class="row">
								<div class="col-sm-2">
									<h6 class="card-subtitle mb-2 text-muted"> Nombre</h6>
								</div>
								<div class="col-sm-8">
									<?php $this->fx->ponerInput('text','nombre','60','100',$this->nombreHotel,'estiloRadioButton','Nombre del hotel',null,null,null,null,null,null); ?>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-2">
									<h6 class="card-subtitle mb-2 text-muted"> Tamano</h6>
								</div>
								<div class="col-sm-8">
									<?php $this->fx->ponerMenu('tamano','Seleccione',$this->arrTamanosHotel,null,$this->tamanoHotel,null,null,null,'estiloRadioButton',null,null); ?>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-2">
									<h6 class="card-subtitle mb-2 text-muted">Estado</h6>
								</div>
								<div class="col-sm-8">
									<?php $this->fx->ponerMenuMultiple('estados','Seleccione',$this->arrestados,null,$this->arrEstadosSeleccionados,null,null,null,'estiloRadioButton',null,'1',$renglones=8) ?>
								
								</div>
							</div>
							<div class="row">
								<div class="col-sm-2 ">
									<h6 class="card-subtitle mb-2 text-muted"> Municipio </h6>
								</div>
								<div class="col-sm-8">
									<?php $this->fx->ponerInput('text','municipio','60','100',$this->municipioHotel,'estiloRadioButton','Municipios',null,null,null,null,null,null); ?>
								</div>
							</div>
                            <div class="row">
                                <div class="col-sm-2 ">
                                    <h6 class="card-subtitle mb-2 text-muted"> Lugar donde se ubica </h6>
                                </div>
                                <div class="col-sm-8">
									<?php $this->fx->ponerMenu('tipo','Seleccione',$this->arrTiposHoteles,null,$this->tipoHotel,null,null,null,'estiloRadioButton',null,'1') ;
//									ponerMenu($nombre,$titulo,$arreglo,$valorCategoria,$valor,$accion=null,$subaccion=null,$item=null,$clase=null,$enviarFormulario=null,$foco=null)
									?>
                                </div>
                            </div>
						</div>
						<div class="card-footer">
							<div class="progress" style="height:30px">
								<div class="progress-bar" style="width:40%;height:30px"></div>
							</div>
						</div>
					</div>
				</div>
				
				
				
				
				
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
									for($z=0;$z<count($this->arrCuestionario[$x]['temas'][$y]['preguntas']);$z++){
										echo  '<h6 class="card-subtitle mb-2 text-muted">';
										echo($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['nombre']."<br>");
										echo '</h6>';
										
										$nombreInput = "input_".$x."_".$y."_".$z;
										
										if ($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['tipo'] == 'radioButton') {
											$this->fx->ponerRadioButtonsEnLinea($nombreInput, $this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['respuestas'], $this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['idRespuestaUsuario'], 'estiloRadioButton', null, null, null, null);
											echo "<br><br>";
										}else if ($this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['tipo'] == 'booleano'){
											$this->fx->ponerRadioButtonsEnLinea($nombreInput, $this->arrSiNo, $this->arrCuestionario[$x]['temas'][$y]['preguntas'][$z]['idRespuestaUsuario'], 'estiloRadioButton', null, null, null, null);
											echo "<br><br>";
										}
									}
								}
								?>
							
							</div>
							<div class="card-footer">
								<div class="progress" style="height:30px">
									
									<div class="progress-bar" style="width:<?php echo ($this->arrCuestionario[$x]['porcentajeContestado']."%"); ?>;height:30px"></div>
								</div>
							</div>
						</div>
					</div>
					<?php
				}
				
				echo '<div class="card-footer ">';
				$this->fx->ponerBoton('grabarCuestionario',null,null, 'Calcular', null, null,null, 'btn btn-dark', '0', null, null, null);
				echo "   ";
				$this->fx->ponerBoton('llenarValores',null,null, 'Llenar valores aleatorios', null, null,null, 'btn btn-dark', '0', null, null, null);
				echo '</div>';
				?>
			
			
			
			
			
			
			
			</div>
		</div>
	</div>
	<div class="col-sm-2"></div>
	
