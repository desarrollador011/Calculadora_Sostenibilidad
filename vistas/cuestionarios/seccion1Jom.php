<!-- LOGIN-->
<?php //include_once ('vistas/general/cabeza.php')
$arrBoleano[]=array('id'=>"0",'nombre'=>'No');
$arrBoleano[]=array('id'=>"1",'nombre'=>'Si');

?>
<div class="row">
	<div class="col-sm-1 ">
	</div>
	<div class="col-sm-10">
		<br>
		<div class="card mx-auto redondeada">
			<div class="card-body textoCarta">
				<div class="row">
					<div class="col-sm-12 titulo ">
						Sección 1. Datos generales
					</div>
				</div>
				<br>
                <!-- nombre-->
				<div class="row">
					<div class="col-sm-6">
						<h6 class="card-subtitle mb-2 text-muted derecha"> Nombre</h6>
					</div>
					<div class="col-sm-6">
						<?php $this->fx->ponerInput('text','nombre','60','100',$this->nombreHotel,'estiloRadioButton','Nombre del hotel',null,null,null,null,null,null); ?>
					</div>
				</div>
				<br>
                <!-- Estado-->
                <div class="row">
                    <div class="col-sm-6">
                        <h6 class="card-subtitle mb-2 text-muted derecha">Estado</h6>
                    </div>
                    <div class="col-sm-6">
						<?php $this->fx->ponerMenu('estados','Seleccione',$this->arrestados,null,$this->estadoHotel,'actualizarEstado',null,null,'estiloRadioButton','1'); ?>
                    </div>
                </div>
                <br>

                <!-- Municipio-->
                <div class="row">
                    <div class="col-sm-6">
                        <h6 class="card-subtitle mb-2 text-muted derecha">Municipio</h6>
                    </div>
                    <div class="col-sm-6">
                        
                        <?php $this->fx->ponerMenu('municipios',null,$this->arrMunicipios,$this->estadoHotel,$this->municipoHotel,null,null,null,'estiloRadioButton',null,null)  ; ?>
                        
						
                    </div>
                </div>
                <br>

                <!-- tipo-->
                <div class="row">
                    <div class="col-sm-6 ">
                        <h6 class="card-subtitle mb-2 text-muted derecha"> Tipo de destino </h6>
                    </div>
                    <div class="col-sm-6">
						<?php $this->fx->ponerMenu('tipo','Seleccione',$this->arrTiposHoteles,null,$this->tipoHotel,null,null,null,'estiloRadioButton',null,'1') ; ?>
                    </div>
                </div>
                <br>

                <!-- Vocación de servicio-->
                <div class="row">
                    <div class="col-sm-6 ">
                        <h6 class="card-subtitle mb-2 text-muted derecha"> Vocación de servicio </h6>
                    </div>
                    <div class="col-sm-6">
						<?php $this->fx->ponerMenu('vocacion','Seleccione',$this->arrVocaciones,null,$this->vocacionHotel,null,null,null,'estiloRadioButton',null,'1') ; ?>
                    </div>
                </div>
                <br>


                <!-- Número total de cuartos-->
				<div class="row">
					<div class="col-sm-6">
						<h6 class="card-subtitle mb-2 text-muted derecha"> Número total de cuartos</h6>
					</div>
					<div class="col-sm-6">
						<?php $this->fx->ponerInput('text','noCuartos','15','3',$this->noCuartos,'estiloRadioButton','Número de cuartos',null,null,null,null,null,null); ?>
					</div>
				</div>
				<br>
				
				<!-- Cuartos disponibles promedio-->
				<div class="row">
					<div class="col-sm-6">
						<h6 class="card-subtitle mb-2 text-muted derecha"> Cuartos disponibles promedio</h6>
					</div>
					<div class="col-sm-6">
						<?php $this->fx->ponerInput('text','cuartosDisponibles','15','3',$this->cuartosDisponibles,'estiloRadioButton','Disponibles',null,null,null,null,null,null); ?>
					</div>
				</div>
				<br>
				
				<!-- Cuartos ocupados promedio-->
				<div class="row">
					<div class="col-sm-6">
						<h6 class="card-subtitle mb-2 text-muted derecha"> Cuartos ocupados promedio</h6>
					</div>
					<div class="col-sm-6">
						<?php $this->fx->ponerInput('text','cuartosOcupados','15','3',$this->cuartosOcupados,'estiloRadioButton','Ocupados',null,null,null,null,null,null); ?>
					</div>
				</div>
				<br>
				
				<!-- Tarifa promedio-->
				<div class="row">
					<div class="col-sm-6">
						<h6 class="card-subtitle mb-2 text-muted derecha"> Tarifa promedio (en pesos)</h6>
					</div>
					<div class="col-sm-6">
						<?php $this->fx->ponerInput('text','tarifa','15','10',$this->tarifa,'estiloRadioButton','Tarifa',null,null,null,null,null,null); ?>
					</div>
				</div>
				<br>
				
				<!-- Huéspedes atendidos en el último año-->
				<div class="row">
					<div class="col-sm-6">
						<h6 class="card-subtitle mb-2 text-muted derecha"> Huéspedes atendidos en el último año</h6>
					</div>
					<div class="col-sm-6">
						<?php $this->fx->ponerInput('text','noHuespedes','15','10',$this->noHuespedes,'estiloRadioButton','Huespedes',null,null,null,null,null,null); ?>
					</div>
				</div>
				<br>
				
				<!-- REVPAR-->
				<div class="row">
					<div class="col-sm-6">
						<h6 class="card-subtitle mb-2 text-muted derecha"> REVPAR</h6>
					</div>
					<div class="col-sm-6">
						<?php $this->fx->ponerInput('text','revpar','15','10',$this->revpar,'estiloRadioButton','REVPAR',null,null,null,null,null,null); ?>
					</div>
				</div>
				<br>
				
				<!-- Costo por cuarto ocupado-->
				<div class="row">
					<div class="col-sm-6">
						<h6 class="card-subtitle mb-2 text-muted derecha"> Costo por cuarto ocupado</h6>
					</div>
					<div class="col-sm-6">
						<?php $this->fx->ponerInput('text','costoCuartoOcupado','15','10',$this->costoCuartoOcupado,'estiloRadioButton','Costo cuarto',null,null,null,null,null,null); ?>
					</div>
				</div>
				<br>
				
				<!-- Número total de colaboradores-->
				<div class="row">
					<div class="col-sm-6">
						<h6 class="card-subtitle mb-2 text-muted derecha"> Número total de colaboradores</h6>
					</div>
					<div class="col-sm-6">
						<?php $this->fx->ponerInput('text','noColaboradores','15','10',$this->noColaboradores,'estiloRadioButton','Colaboradores',null,null,null,null,null,null); ?>
					</div>
				</div>
				<br>
				
				<!-- Número de años operando el hotel-->
				<div class="row">
					<div class="col-sm-6">
						<h6 class="card-subtitle mb-2 text-muted derecha"> Número de años operando el hotel</h6>
					</div>
					<div class="col-sm-6">
						<?php $this->fx->ponerInput('text','anosOperando','15','3',$this->anosOperando,'estiloRadioButton','Años',null,null,null,null,null,null); ?>
					</div>
				</div>
				<br>

                <!-- es cadena-->
                <div class="row">
                    <div class="col-sm-6 ">
                        <h6 class="card-subtitle mb-2 text-muted derecha"> Pertenece a una cadena? </h6>
                    </div>
                    <div class="col-sm-6">
						<?php
						$this->fx->ponerRadioButtonsEnLinea('cadena', $arrBoleano, $this->esCadena, 'estiloRadioButton', null, null, null, null);
                        //$this->fx->ponerMenu('cadena','Seleccione',$this->arrBoleano,null,$this->esCadena,null,null,null,'estiloRadioButton',null,'1') ; ?>
                    </div>
                </div>
                <br>
                
                
                
				<!-- Distribución porcentual del negocio-->
				<div class="row">
					<div class="col-sm-12">
						<h6 class="card-subtitle mb-2 text-muted centrado"> Distribución porcentual del negocio de los servicios de hospedaje</h6>
					</div>
				</div>
				<br>
				
				<!-- % que es hotelero-->
				<div class="row">
					<div class="col-sm-6">
						<h6 class="card-subtitle mb-2 text-muted derecha"> % que es hotelero</h6>
					</div>
					<div class="col-sm-6">
						<?php $this->fx->ponerInput('text','porcentajeHotelero','15','3',$this->porcentajeHotelero,'estiloRadioButton','% hotelero',null,null,null,null,null,null); ?>
					</div>
				</div>
				<br>
				
				<!-- % que es renta vacacional-->
				<div class="row">
					<div class="col-sm-6">
						<h6 class="card-subtitle mb-2 text-muted derecha"> % que es renta vacacional</h6>
					</div>
					<div class="col-sm-6">
						<?php $this->fx->ponerInput('text','porcentajeVacacional','15','3',$this->porcentajeVacacional,'estiloRadioButton','% vacacional',null,null,null,null,null,null); ?>
					</div>
				</div>
				<br>
				
				
				<!-- % que es de otras modalidades de hospedaje-->
				<div class="row">
					<div class="col-sm-6">
						<h6 class="card-subtitle mb-2 text-muted derecha"> % que es de otras modalidades de hospedaje</h6>
					</div>
					<div class="col-sm-6">
						<?php $this->fx->ponerInput('text','porcentajeOtras','15','3',$this->porcentajeOtras,'estiloRadioButton','% otros',null,null,null,null,null,null); ?>
					</div>
				</div>
				<br>
				<br>
				<br>
				
				<div class="row">
					<div class="col-sm-4 centrado">
						<?php $this->fx->ponerBoton('reiniciar',null,null,'Reiniciar',null,null,null,'btn estiloBoton','0',null,null,null); ?>
					</div>
                    <div class="col-sm-4 centrado">
						<?php //$this->fx->ponerBoton('salir',null,null,'Logout',null,null,null,'btn estiloBoton','0',null,null,null); ?>
                    </div>
					<div class="col-sm-4 centrado">
						<?php $this->fx->ponerBoton('ponerSiguienteSeccion',null,null,'Sección 2',null,null,null,'btn estiloBoton','0',null,null,null); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-1 ">
	</div>
</div>
