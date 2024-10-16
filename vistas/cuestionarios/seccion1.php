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
		<div class="card mx-auto redondeada" style="background-color:#ffe9d5;">
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
						<h6 class="card-subtitle mb-2 text-muted derecha"> Nombre
                            <a href="#" data-toggle="popover" data-trigger="focus" title="Nombre " data-content="Nombre comercial o marca con la que opera el hotel"><img src="imagenes/botonAyuda.png" width="25"></a>
                        </h6>
					</div>
					<div class="col-sm-6">
						<?php $this->fx->ponerInput('text','nombre','60','100',$this->nombreHotel,'estiloRadioButton','Nombre del hotel',null,null,null,null,null,null); ?>
					</div>
				</div>
				<br>
                <!-- Estado-->
                <div class="row">
                    <div class="col-sm-6">
                        <h6 class="card-subtitle mb-2 text-muted derecha">Estado
                            <a href="#" data-toggle="popover"  data-trigger="focus"  title="Entidad federativa " data-content="Seleccione la entidad federativa en donde se localiza este hotel"><img src="imagenes/botonAyuda.png" width="25"></a>
                        </h6>
                    </div>
                    <div class="col-sm-6">
						<?php $this->fx->ponerMenu('estados','Seleccione',$this->arrestados,null,$this->estadoHotel,'actualizarEstado',null,null,'estiloRadioButton','1'); ?>
                    </div>
                </div>
                <br>

                <!-- Municipio-->
                <div class="row">
                    <div class="col-sm-6">
                        <h6 class="card-subtitle mb-2 text-muted derecha">Municipio
                            <a href="#" data-toggle="popover" data-trigger="focus" title="Municipio " data-content="Seleccione el municipio en donde se localiza este hotel"><img src="imagenes/botonAyuda.png" width="25"></a>
                        </h6>
                    </div>
                    <div class="col-sm-6">
                        
                        <?php $this->fx->ponerMenu('municipios','Seleccione',$this->arrMunicipios,$this->estadoHotel,$this->municipioHotel,null,null,null,'estiloRadioButton',null,null)  ;
						//ponerMenu($nombre,$titulo,$arreglo,$valorCategoria,$valor,$accion=null,$subaccion=null,$item=null,$clase=null,$enviarFormulario=null,$foco=null)
                        ?>
                    </div>
                </div>
                <br>

                <!-- tipo-->
                <div class="row">
                    <div class="col-sm-6 ">
                        <h6 class="card-subtitle mb-2 text-muted derecha"> Tipo de destino
                            <a href="#" data-toggle="popover" data-trigger="focus" title="Destino " data-content="Considere las siguientes definiciones de destino:
                            Playa: Hotel localizado a 3 kilómetros de la orilla de la línea de costa del mar, lagunas costeras, ríos y lagos
                            Zona Rural: En localidades con menos de 5,000 habitantes
                            Pueblo mágico: Pueblos o ciudades que denominación de pueblo mágico, excluyendo a los que se encuentran en la definición de playa
                            Ciudad: En localidades con más de 5,001 habitantes "><img src="imagenes/botonAyuda.png" width="25"></a>
                        </h6>
                    </div>
                    <div class="col-sm-6">
						<?php $this->fx->ponerMenu('tipo','Seleccione',$this->arrTiposHoteles,null,$this->tipoHotel,null,null,null,'estiloRadioButton',null,'1') ; ?>
                    </div>
                </div>
                <br>

                <!-- Vocación de servicio-->
                <div class="row">
                    <div class="col-sm-6 ">
                        <h6 class="card-subtitle mb-2 text-muted derecha"> Vocación de servicio del hotel
                            <a href="#" data-toggle="popover" data-trigger="focus" title="Vocación de servicio " data-content="Considere las siguientes definiciones de vocaciones de servicio:
                            Boutique: Orientados hacia el aislamiento e los huéspedes de su vida cotidiana, con servicios estilizados y personalizados, con amenidades como áreas para practicar yoga, spa, no suelen recibir familias con hijos, enfatizan la exclusividad.
                            Vacacional: Orientado a la recreación, por lo que suelen tener bar, discoteca, albercas, áreas de juegos.
                            Negocios: Hotel con habitaciones útiles para descansar y trabajar, pueden tener salones de reuniones y centros de negocios.
                            Eventos y convenciones: Cuentan con varios salones medianos y grandes (para más de 200 personas) y 2 a 3 cajones de estacionamiento por cada habitación.
                            Rústico: Tipo bungalows cabañas o centros de recreación para actividades recreativas al aire libre y fuera del hotel (por ejemplo para practicar pesca deportiva, surfing, avistamiento de fauna silvestre. Cuando se encuentran en ciudades,
                            Centro de ciudad: son hoteles modestos, con acabados sencillos y sin amenidades su mercado son viajeros casuales en el sitio (por ejemplo, quienes asisten a una reunión familiar). "><img src="imagenes/botonAyuda.png" width="25"></a>
                        </h6>
                    </div>
                    <div class="col-sm-6">
						<?php $this->fx->ponerMenu('vocacion','Seleccione',$this->arrVocaciones,null,$this->vocacionHotel,null,null,null,'estiloRadioButton',null,'1') ; ?>
                    </div>
                </div>
                <br>

                <!-- NUEVO: alimentos-->
                <div class="row">
                    <div class="col-sm-6 ">
                        <h6 class="card-subtitle mb-2 text-muted derecha"> ¿De qué manera se incluyen los alimentos en su hotel?
                            <a href="#" data-toggle="popover" data-trigger="focus" title="Vocación de servicio " data-content="Elija la opción que mejor refleje la provisión de alimentos en el hotel."><img src="imagenes/botonAyuda.png" width="25"></a>
                        </h6>
                    </div>
                    <div class="col-sm-6">
						<?php $this->fx->ponerMenu('alimentos','Seleccione',$this->arrAlimentos,null,$this->alimentos,null,null,null,'estiloRadioButton',null,'1') ; ?>
                    </div>
                </div>
                <br>
                
                <!-- Número total de cuartos-->
				<div class="row">
					<div class="col-sm-6">
						<h6 class="card-subtitle mb-2 text-muted derecha"> Número total de cuartos
                            <a href="#" data-toggle="popover" data-trigger="focus" title="Número total de cuartos" data-content="El total de habitaciones que cuenta el hotel para recibir huéspedes"><img src="imagenes/botonAyuda.png" width="25"></a>
                        </h6>
					</div>
					<div class="col-sm-6">
						<?php $this->fx->ponerInput('number','noCuartos','15','4',$this->noCuartos,'estiloRadioButton','Número de cuartos',null,null,null,null,null,null); ?>
					</div>
				</div>
				<br>
				
				<!-- Cuartos disponibles promedio-->
				<div class="row">
					<div class="col-sm-6">
						<h6 class="card-subtitle mb-2 text-muted derecha"> Cuartos disponibles promedio
                            <a href="#" data-toggle="popover" data-trigger="focus" title="Cuartos disponibles promedio" data-content="El total de habitaciones que efectivamente se pueden ofrecer a los huéspedes."><img src="imagenes/botonAyuda.png" width="25"></a>
                        </h6>
					</div>
					<div class="col-sm-6">
						<?php $this->fx->ponerInput('number','cuartosDisponibles','15','4',$this->cuartosDisponibles,'estiloRadioButton','Disponibles',null,null,null,null,null,null); ?>
					</div>
				</div>
				<br>
				
				<!-- Cuartos ocupados promedio-->
				<div class="row">
					<div class="col-sm-6">
						<h6 class="card-subtitle mb-2 text-muted derecha"> Cuartos ocupados promedio
                            <a href="#" data-toggle="popover" data-trigger="focus" title="Cuartos ocupados promedio" data-content="El promedio mensual de habitaciones utilizadas por los huéspedes."><img src="imagenes/botonAyuda.png" width="25"></a>
                        </h6>
					</div>
					<div class="col-sm-6">
						<?php $this->fx->ponerInput('number','cuartosOcupados','15','3',$this->cuartosOcupados,'estiloRadioButton','Ocupados',null,null,null,null,null,null); ?>
					</div>
				</div>
				<br>
				
				<!-- Tarifa promedio-->
				<div class="row">
					<div class="col-sm-6">
						<h6 class="card-subtitle mb-2 text-muted derecha"> Tarifa promedio (en pesos)
                            <a href="#" data-toggle="popover" data-trigger="focus" title="Tarifa promedio" data-content="Anotar sin centavos ni separación en miles (por ejemplo 2000) para dos mil pesos la noche."><img src="imagenes/botonAyuda.png" width="25"></a>
                        </h6>
					</div>
					<div class="col-sm-6">
						<?php $this->fx->ponerInput('number','tarifa','15','10',$this->tarifa,'estiloRadioButton','Tarifa',null,null,null,null,null,null); ?>
					</div>
				</div>
				<br>
				
				<!-- Huéspedes atendidos en el último año-->
				<div class="row">
					<div class="col-sm-6">
						<h6 class="card-subtitle mb-2 text-muted derecha"> Huéspedes atendidos en el último año
                            <a href="#" data-toggle="popover" data-trigger="focus" title="Huéspedes atendidos en el último año" data-content="El número total de huéspedes atendidos en el año."><img src="imagenes/botonAyuda.png" width="25"></a>
                        </h6>
					</div>
					<div class="col-sm-6">
						<?php $this->fx->ponerInput('number','noHuespedes','15','10',$this->noHuespedes,'estiloRadioButton','Huespedes',null,null,null,null,null,null); ?>
					</div>
				</div>
				<br>
				
				<!-- REVPAR-->
				<div class="row">
					<div class="col-sm-6">
						<h6 class="card-subtitle mb-2 text-muted derecha"> REVPAR
                            <a href="#" data-toggle="popover" data-trigger="focus" title="REVPAR" data-content="Valor de los últimos 12 meses. Este es un acrónimo en inglés para Revenue Per Avaliable Room, el Ingreso por habitación disponible. Para calcular este valor puede consultar el siguiente vínculo:
<a href='https://www.cesae.es/blog/revpar-un-indicador-clave-para-el-sector-hotelero'  target='_blank'>www.cesae.es</a>" data-html="true"><img src="imagenes/botonAyuda.png" width="25"></a>
                        </h6>
					</div>
					<div class="col-sm-6">
						<?php $this->fx->ponerInput('number','revpar','15','10',$this->revpar,'estiloRadioButton','REVPAR',null,null,null,null,null,null); ?>
					</div>
				</div>
				<br>
				
				<!-- Costo por cuarto ocupado-->
				<div class="row">
					<div class="col-sm-6">
						<h6 class="card-subtitle mb-2 text-muted derecha"> Costo por cuarto ocupado
                            <a href="#" data-toggle="popover" data-trigger="focus" title="Costo por cuarto ocupado" data-content="El valor en pesos (sin centavos ni separación de miles) del costo de cada cuarto que es utilizado por los huéspedes."><img src="imagenes/botonAyuda.png" width="25"></a>
                        </h6>
					</div>
					<div class="col-sm-6">
						<?php $this->fx->ponerInput('number','costoCuartoOcupado','15','10',$this->costoCuartoOcupado,'estiloRadioButton','Costo cuarto',null,null,null,null,null,null); ?>
					</div>
				</div>
				<br>
				
				<!-- Número total de colaboradores-->
				<div class="row">
					<div class="col-sm-6">
						<h6 class="card-subtitle mb-2 text-muted derecha"> Número total de colaboradores
                            <a href="#" data-toggle="popover" data-trigger="focus" title="Número total de colaboradores" data-content="Número total de personas contratadas directamente por el hotel o en contratos de tercerización, practicantes y prestadores de servicio social que laboran en el hotel."><img src="imagenes/botonAyuda.png" width="25"></a>
                        </h6>
					</div>
					<div class="col-sm-6">
						<?php $this->fx->ponerInput('number','noColaboradores','15','10',$this->noColaboradores,'estiloRadioButton','Colaboradores',null,null,null,null,null,null); ?>
					</div>
				</div>
				<br>
				
				<!-- Número de años operando el hotel-->
				<div class="row">
					<div class="col-sm-6">
						<h6 class="card-subtitle mb-2 text-muted derecha"> Número de años operando el hotel
                            <a href="#" data-toggle="popover" data-trigger="focus" title="Número de años operando" data-content="Número total de personas contratadas directamente por el hotel o en contratos de tercerización, practicantes y prestadores de servicio social que laboran en el hotel."><img src="imagenes/botonAyuda.png" width="25"></a>
                        </h6>
					</div>
					<div class="col-sm-6">
						<?php $this->fx->ponerInput('number','anosOperando','15','3',$this->anosOperando,'estiloRadioButton','Años',null,null,null,null,null,null); ?>
					</div>
				</div>
				<br>

                <!-- es cadena-->
                <div class="row">
                    <div class="col-sm-6 ">
                        <h6 class="card-subtitle mb-2 text-muted derecha"> Pertenece a una cadena? <!--span style="text-decoration: underline;" title="">
      <img src="imagenes/botonAyuda.png" width="25">

</span--></h6>
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
						<h6 class="card-subtitle mb-2 text-muted centrado"> Distribución porcentual del negocio de los servicios de hospedaje
                            <a href="#" data-toggle="popover" data-trigger="focus" title="Distribución porcentual del negocio de los servicios de hospedaje" data-content="El porcentaje de habitaciones que se administran como hotel, como renta vacacional u otra modalidad. El total debe sumar 100% "><img src="imagenes/botonAyuda.png" width="25"></a>
                        </h6>
					</div>
				</div>
				<br>
				
				<!-- % que es hotelero-->
				<div class="row">
					<div class="col-sm-6">
						<h6 class="card-subtitle mb-2 text-muted derecha"> % que es hotelero
                            <a href="#" data-toggle="popover" data-trigger="focus" title="% hotelero" data-content="Anotar números sin decimales ni el símbolo de %."><img src="imagenes/botonAyuda.png" width="25"></a>
                        </h6>
					</div>
					<div class="col-sm-6">
						<?php $this->fx->ponerInput('number','porcentajeHotelero','15','3',$this->porcentajeHotelero,'estiloRadioButton','% hotelero',null,null,null,null,null,null); ?>
					</div>
				</div>
				<br>
				
				<!-- % que es renta vacacional-->
				<div class="row">
					<div class="col-sm-6">
						<h6 class="card-subtitle mb-2 text-muted derecha"> % que es renta vacacional
                            <a href="#" data-toggle="popover" data-trigger="focus" title="% renta vacacional" data-content="Anotar números sin decimales ni el símbolo de %."><img src="imagenes/botonAyuda.png" width="25"></a>
                        </h6>
					</div>
					<div class="col-sm-6">
						<?php $this->fx->ponerInput('number','porcentajeVacacional','15','3',$this->porcentajeVacacional,'estiloRadioButton','% vacacional',null,null,null,null,null,null); ?>
					</div>
				</div>
				<br>
				
				
				<!-- % que es de otras modalidades de hospedaje-->
				<div class="row">
					<div class="col-sm-6">
						<h6 class="card-subtitle mb-2 text-muted derecha"> % que es de otras modalidades de hospedaje
                            <a href="#" data-toggle="popover" data-trigger="focus" title="% otras modalidades de hospedaje" data-content="Anotar números sin decimales ni el símbolo de %."><img src="imagenes/botonAyuda.png" width="25"></a>
                        </h6>
					</div>
					<div class="col-sm-6">
						<?php $this->fx->ponerInput('number','porcentajeOtras','15','3',$this->porcentajeOtras,'estiloRadioButton','% otros',null,null,null,null,null,null); ?>
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
