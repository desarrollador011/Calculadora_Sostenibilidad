<?php
$arrPersonas=array();
$arrPaz=array();
$arrProsperidad=array();
$arrPlaneta=array();
$arrAlianzas=array();

for($x=0;$x<count($this->planDeAccion['acciones']);$x++){
	switch ($this->planDeAccion['acciones'][$x]['categoria']){
		case 'prosperidad';
			$arrProsperidad[]=$this->planDeAccion['acciones'][$x];
			break;
		case 'planeta';
			$arrPlaneta[]=$this->planDeAccion['acciones'][$x];
			break;
		case 'alianzas';
			$arrAlianzas[]=$this->planDeAccion['acciones'][$x];
			break;
		case 'personas';
			$arrPersonas[]=$this->planDeAccion['acciones'][$x];
			break;
		case 'paz';
			$arrPaz[]=$this->planDeAccion['acciones'][$x];
			break;
	}
}
?>
<div class="row">
	<!--	<div class="col-sm-1">-->
	<!--	-->
	<!--	</div>-->
	<div class="col-sm-12">
		<br>
		<div class="card mx-auto redondeadaSinAltura">
			<div class="row">
				<div class="col-sm-12 titulo centrado">
					Plan de acción para incrementar la contribución del hotel en las 5 PS de la sostenibilidad
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-12 tituloHotelPlan centrado">
					<?php echo ($this->planDeAccion['nombreHotel']);  ?>
				</div>
				
			</div>
			
			
			
			
			<!-- personas-->
			<?php $textoAyuda="Algunos ejemplos de resultados en este pilar son:
1. Al finalizar el día 60, se habrán señalizado al menos dos áreas de estacionamiento dedicados a personas con discapacidad.<br><br>
2. Al finalizar el día 30, se habrá acordado una nueva política de igualdad de género para posiciones de liderazgo en el hotel.<br><br>
3. Al finalizar el día 90, se habrá acordado y dado a conocer un programa de desarrollo profesional para el personal."; ?>
			
			<div class="row">
				<div class="col-sm-2 textoCarta centrado">
					<img src="imagenes/personas.gif" height="40px">
				</div>
				<div class="col-sm-10 tituloCuadrito">
					
					<div class="row">
						<div class="col-sm-10 tituloPlan">Personas</div>
						<div class="col-sm-2 tituloPlan">&nbsp;</div>
					</div>
					<div class="row">
						<div class="col-sm-10 textoCarta negritas">
							En este eje se propone que todos actuemos desde el ámbito de nuestra vida cotidiana para erradicar la pobreza extrema y el hambre, en todas sus dimensiones y desde sus causas, para que las personas puedan alcanzar su máximo potencial en un marco de equidad y dignidad
							<?php echo "<a href=\"#\" data-toggle=\"popover\" title=\"Ayuda\" data-content=\"".$textoAyuda.");\"><img src=\"http://sustainability-calculator.hasselbit.com/wp-content/uploads/sites/6/2017/02/info-sign.png\" width=\"25\"></a>"; ?>
						</div>
						<div class="col-sm-2 tituloCuadrito">&nbsp;</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2 textoCarta centrado">
					&nbsp;
				</div>
				<div class="col-sm-9 tituloCuadrito">
					¿Cuál es el resultado que planeas lograr en un lapso de 60 a 90 días?
				</div>
				<div class="col-sm-1 textoCarta">
					&nbsp
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-2 textoCarta centrado">
					&nbsp;
				</div>
				<div class="col-sm-9 tituloCuadrito">
					<?php echo ($this->planDeAccion['resultadoPersonas']); ?>
				</div>
				<div class="col-sm-1 textoCarta">
					&nbsp;
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-2 textoCarta centrado">
					&nbsp;
				</div>
				<div class="col-sm-9 textoCarta negritas">
					<table class="table">
						<thead class="thead-dark">
						<tr>
							<th>No.</th>
							<th>Acciones</th>
							<th>Indicadores</th>
							<th>Responsable</th>
							<th>Lapso de implementación</th>
						</tr>
						</thead>
						<tbody>
						<?php
						for($x=0;$x<count($arrPersonas);$x++){
//							$accionPersona="accionPersona_$x";
//							$indicadorPersona="indicadorPersona_$x";
//							$responsablePersona="responsablePersona_$x";
//							$fechaPersona="fechaPersona_$x";
							$indice=$x+1;
							echo "<tr>";
							echo "<td>";
							echo "$indice";
							echo "</td>";
							echo "<td>";
								echo ($arrPersonas[$x]['accion']);
							echo "</td>";
							echo "<td>";
								echo ($arrPersonas[$x]['indicador']);
							echo "</td>";
							echo "<td>";
								echo ($arrPersonas[$x]['responsable']);
							echo "</td>";
							echo "<td>";
								echo ($arrPersonas[$x]['fecha']);
							echo "</td>";
							echo "</tr>";
						} ?>
						
						</tbody>
					</table>
				</div>
				<div class="col-sm-1 textoCarta">
					&nbsp;
				</div>
			</div>
			<!-- fin persona-->
			
			
			<!-- paz-->
			
			<?php $textoAyuda="A continuación, mostramos algunos ejemplos de resultados en este pilar:
1.  Al finalizar el día 45, se acuerda y da conocer entre colaboradores una política de combate a la trata de personas y del respeto a los derechos de los niños y las niñas.
2. Al finalizar el día 60, se publica la primera cartelera cultural del vecindario que se actualizará cada mes estará disponible en las habitaciones del hotel.
3.  A partir del día 30, se establece y comunica la acción trimestral a favor del desarrollo sostenible en la que colabora el hotel junto con organizaciones de la sociedad civil del lugar donde se localiza el hotel.
"; ?>
			<div class="row">
				<div class="col-sm-2 textoCarta centrado">
					<img src="imagenes/paz.png" height="40px">
				</div>
				<div class="col-sm-10 tituloCuadrito">
					
					<div class="row">
						<div class="col-sm-10 tituloPlan">Paz</div>
						<div class="col-sm-2 tituloPlan">&nbsp;</div>
					
					</div>
					<div class="row">
						<div class="col-sm-10 textoCarta negritas">
							Este pilar reconoce que ningún nivel de desarrollo será sostenible si las naciones no viven en paz entre ellas y al interior de sus territorios. La promoción de la paz y la justicia es requisito indispensable para la dignidad humana. Un mundo libre de violencia, lejos del miedo y la impunidad, comprometiéndose a construir sociedades justas e inclusivas.
							<?php echo "<a href=\"#\" data-toggle=\"popover\" title=\"Ayuda\" data-content=\"".$textoAyuda.");\"><img src=\"http://sustainability-calculator.hasselbit.com/wp-content/uploads/sites/6/2017/02/info-sign.png\" width=\"25\"></a>"; ?>
						</div>
						<div class="col-sm-2 tituloCuadrito">&nbsp;</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2 textoCarta centrado">
					&nbsp;
				</div>
				<div class="col-sm-9 tituloCuadrito">
					¿Cuál es el resultado que planeas lograr en un lapso de 60 a 90 días?
				</div>
				<div class="col-sm-1 textoCarta">
					&nbsp;
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2 textoCarta centrado">
					&nbsp;
				</div>
				<div class="col-sm-9 tituloCuadrito">
					<?php echo ($this->planDeAccion['resultadoPaz']); ?>
				</div>
				<div class="col-sm-1 textoCarta">
					&nbsp;
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2 textoCarta centrado">
					&nbsp;
				</div>
				<div class="col-sm-9 textoCarta negritas">
					<table class="table">
						<thead class="thead-dark">
						<tr>
							<th>No.</th>
							<th>Acciones</th>
							<th>Indicadores</th>
							<th>Responsable</th>
							<th>Lapso de implementación</th>
						</tr>
						</thead>
						<tbody>
						<?php
						for($x=0;$x<count($arrPersonas);$x++){
							$indice=$x+1;
							echo "<tr>";
							echo "<td>";
								echo "$indice";
							echo "</td>";
							echo "<td>";
								echo ($arrPaz[$x]['accion']);
							echo "</td>";
							echo "<td>";
								echo ($arrPaz[$x]['indicador']);
							echo "</td>";
							echo "<td>";
								echo ($arrPaz[$x]['responsable']);
							echo "</td>";
							echo "<td>";
								echo ($arrPaz[$x]['fecha']);
							echo "</td>";
							echo "</tr>";
						} ?>
						
						</tbody>
					</table>
				</div>
				<div class="col-sm-1 textoCarta">
					&nbsp;
				</div>
			</div>
			<!-- fin paz-->
			
			<!-- prosperidad-->
			<?php $textoAyuda="A continuación, mostramos algunos ejemplos de resultados en este pilar:
1.  A partir del día 60, se incrementa en un 10% el porcentaje de alimentos adquiridos de proveedores que se encuentran a 20 km o menos de distancia del hotel.
2. A partir del día 30, se establece una política de proveeduría local y responsable que incentive la integración de proveedores que se encuentren a 20 km o menos de distancia del hotel.
3. Al finalizar el día 30, se establecen los procedimientos para medir las compras responsables del hotel.
"; ?>
			<div class="row">
				<div class="col-sm-2 textoCarta centrado">
					<img src="imagenes/prosperidad.png" height="40px">
				</div>
				<div class="col-sm-10 tituloCuadrito">
					
					<div class="row">
						<div class="col-sm-10 tituloPlan">Prosperidad</div>
						<div class="col-sm-2 tituloPlan">&nbsp;</div>
					
					</div>
					<div class="row">
						<div class="col-sm-10 textoCarta negritas">
							No es suficiente con erradicar la pobreza, la Agenda 2030 contempla no dejar a nadie atrás en la senda del desarrollo, en pos de un mundo donde todos y todas tengan acceso a vidas productivas y satisfactorias, beneficiándose del progreso económico, tecnológico y social
							<?php echo "<a href=\"#\" data-toggle=\"popover\" title=\"Ayuda\" data-content=\"".$textoAyuda.");\"><img src=\"http://sustainability-calculator.hasselbit.com/wp-content/uploads/sites/6/2017/02/info-sign.png\" width=\"25\"></a>"; ?>
						</div>
						<div class="col-sm-2 tituloCuadrito">&nbsp;</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2 textoCarta centrado">
					&nbsp;
				</div>
				<div class="col-sm-9 tituloCuadrito">
					¿Cuál es el resultado que planeas lograr en un lapso de 60 a 90 días?
				</div>
				<div class="col-sm-1 textoCarta">
					&nbsp;
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-2 textoCarta centrado">
					&nbsp
				</div>
				<div class="col-sm-9 tituloCuadrito">
					<?php echo ($this->planDeAccion['resultadoProsperidad']); ?>
				</div>
				<div class="col-sm-1 textoCarta">
					&nbsp;
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2 textoCarta centrado">
					&nbsp;
				</div>
				<div class="col-sm-9 textoCarta negritas">
					<table class="table">
						<thead class="thead-dark">
						<tr>
							<th>No.</th>
							<th>Acciones</th>
							<th>Indicadores</th>
							<th>Responsable</th>
							<th>Lapso de implementación</th>
						</tr>
						</thead>
						<tbody>
						<?php
						for($x=0;$x<count($arrPersonas);$x++){
							$indice=$x+1;
							echo "<tr>";
							echo "<td>";
								echo "$indice";
							echo "</td>";
							echo "<td>";
								echo ($arrProsperidad[$x]['accion']);
							echo "</td>";
							echo "<td>";
								echo ($arrProsperidad[$x]['indicador']);
							echo "</td>";
							echo "<td>";
								echo ($arrProsperidad[$x]['responsable']);
							echo "</td>";
							echo "<td>";
								echo ($arrProsperidad[$x]['fecha']);
							echo "</td>";
							echo "</tr>";
						} ?>
						
						</tbody>
					</table>
				</div>
				<div class="col-sm-1 textoCarta">
					&nbsp;
				</div>
			</div>
			<!-- fin prosperidad-->
			
			<!-- Planeta-->
			<?php $textoAyuda="A continuación, mostramos algunos ejemplos de resultados en este pilar:
1. A partir del día 45, se establece un procedimiento para la separación y reciclaje de residuos de metal y cartón y se hace composta con residuos orgánicos.
2. A partir del día 30, se incrementa el 10 % la capacidad instalada de energía generada con paneles solares dentro del hotel.
3. A partir del día 45, se instalan sistemas de captación de agua de lluvia para utilizarla en jardinería y se cuantifica su uso.
"; ?>
			<div class="row">
				<div class="col-sm-2 textoCarta centrado">
					<img src="imagenes/planeta.png" height="40px">
				</div>
				<div class="col-sm-10 tituloCuadrito">
					
					<div class="row">
						<div class="col-sm-10 tituloPlan">Planeta</div>
						<div class="col-sm-2 tituloPlan">&nbsp;</div>
					
					</div>
					<div class="row">
						<div class="col-sm-10 textoCarta negritas">
							El cambio climático ya tiene amlias repercusiones en la economía y en las sociedades y requiere de acciones urgentes para no comprometer las necesidades de las generaciones futuras. Los gobiernos acordaron proteger al planeta de la degradación ambiental, lograr un consumo y producción sostenibles, así como administrar mejor los recursos naturales
							<?php echo "<a href=\"#\" data-toggle=\"popover\" title=\"Ayuda\" data-content=\"".$textoAyuda.");\"><img src=\"http://sustainability-calculator.hasselbit.com/wp-content/uploads/sites/6/2017/02/info-sign.png\" width=\"25\"></a>"; ?>
						</div>
						<div class="col-sm-2 tituloCuadrito">&nbsp;</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2 textoCarta centrado">
					&nbsp;
				</div>
				<div class="col-sm-9 tituloCuadrito">
					¿Cuál es el resultado que planeas lograr en un lapso de 60 a 90 días?
				</div>
				<div class="col-sm-1 textoCarta">
					&nbsp;
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-2 textoCarta centrado">
					&nbsp
				</div>
				<div class="col-sm-9 tituloCuadrito">
					<?php echo ($this->planDeAccion['resultadoPlaneta']); ?>
				</div>
				<div class="col-sm-1 textoCarta">
					&nbsp;
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-2 textoCarta centrado">
					&nbsp;
				</div>
				<div class="col-sm-9 textoCarta negritas">
					<table class="table">
						<thead class="thead-dark">
						<tr>
							<th>No.</th>
							<th>Acciones</th>
							<th>Indicadores</th>
							<th>Responsable</th>
							<th>Lapso de implementación</th>
						</tr>
						</thead>
						<tbody>
						<?php
						for($x=0;$x<count($arrPersonas);$x++){
							$indice=$x+1;
							echo "<tr>";
							echo "<td>";
								echo "$indice";
							echo "</td>";
							echo "<td>";
								echo ($arrPlaneta[$x]['accion']);
							echo "</td>";
							echo "<td>";
								echo ($arrPlaneta[$x]['indicador']);
							echo "</td>";
							echo "<td>";
								echo ($arrPlaneta[$x]['responsable']);
							echo "</td>";
							echo "<td>";
								echo ($arrPlaneta[$x]['fecha']);
							echo "</td>";
							echo "</tr>";
						} ?>
						
						</tbody>
					</table>
				</div>
				<div class="col-sm-1 textoCarta">
					&nbsp;
				</div>
			</div>
			<!-- fin Planeta-->
			
			<!-- Alianzas-->
			<?php $textoAyuda="A continuación, mostramos algunos ejemplos de resultados en este pilar:
1. A partir del día 30 se establece una nueva alianza orientada al desarrollo sostenible en la localidad donde se encuentran el hotel.
2. A partir del día 30, se lanza una campaña trimestral de concientización sobre el desarrollo sostenible dirigida a huéspedes, colaboradores, aliados y vecinos.
3. A partir del día 60, se colabora y comunica las iniciativas externas en las que participa el hotel relacionadas con el desarrollo sostenible.
"; ?>
			<div class="row">
				<div class="col-sm-2 textoCarta centrado">
					<img src="imagenes/paternariato.png" height="40px">
				</div>
				<div class="col-sm-10 tituloCuadrito">
					
					<div class="row">
						<div class="col-sm-10 tituloPlan">Alianzas</div>
						<div class="col-sm-2 tituloPlan">&nbsp;</div>
					
					</div>
					<div class="row">
						<div class="col-sm-10 textoCarta negritas">
							Ante retos globales es indispensable movilizar recursos de toda fuente disponible, más allá de las finanzas públicas. Se impulsarán mecanismos de cooperación internacional y alianzas con el sector privado, vigilando que dichos recursos se ejerzan de forma eficiente en beneficio de los más vulnerables.
							<?php echo "<a href=\"#\" data-toggle=\"popover\" title=\"Ayuda\" data-content=\"".$textoAyuda.");\"><img src=\"http://sustainability-calculator.hasselbit.com/wp-content/uploads/sites/6/2017/02/info-sign.png\" width=\"25\"></a>"; ?>
						</div>
						<div class="col-sm-2 tituloCuadrito">&nbsp;</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2 textoCarta centrado">
					&nbsp;
				</div>
				<div class="col-sm-9 tituloCuadrito">
					¿Cuál es el resultado que planeas lograr en un lapso de 60 a 90 días?
				</div>
				<div class="col-sm-1 textoCarta">
					&nbsp;
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2 textoCarta centrado">
					&nbsp
				</div>
				<div class="col-sm-9 tituloCuadrito">
					<?php echo ($this->planDeAccion['resultadoAlianzas']); ?>
				</div>
				<div class="col-sm-1 textoCarta">
					&nbsp;
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2 textoCarta centrado">
					&nbsp;
				</div>
				<div class="col-sm-9 textoCarta negritas">
					<table class="table">
						<thead class="thead-dark">
						<tr>
							<th>No.</th>
							<th>Acciones</th>
							<th>Indicadores</th>
							<th>Responsable</th>
							<th>Lapso de implementación</th>
						</tr>
						</thead>
						<tbody>
						<?php
						for($x=0;$x<count($arrPersonas);$x++){
							$indice=$x+1;
							echo "<tr>";
							echo "<td>";
								echo "$indice";
							echo "</td>";
							echo "<td>";
								echo ($arrAlianzas[$x]['accion']);
							echo "</td>";
							echo "<td>";
								echo ($arrAlianzas[$x]['indicador']);
							echo "</td>";
							echo "<td>";
								echo ($arrAlianzas[$x]['responsable']);
							echo "</td>";
							echo "<td>";
								echo ($arrAlianzas[$x]['fecha']);
							echo "</td>";
							echo "</tr>";
						} ?>
						
						</tbody>
					</table>
				</div>
				<div class="col-sm-1 textoCarta">
					&nbsp;
				</div>
			</div>
			<!-- fin Alianzas-->
			
			<!-- botones-->
			<div class="row">
				<div class="col-sm-2 textoCarta centrado">
					&nbsp;
				</div>
				<div class="col-sm-9 textoCarta negritas">
					<?php $this->fx->ponerBoton('irAInicio', null, null, 'Regresar', null, null, null, "btn estiloBoton", "0", null, null, null); ?>
				</div>
				<div class="col-sm-1 textoCarta">
					&nbsp;
				</div>
			</div>
			<br>
			<!-- fin botones-->
		</div>
	</div>
</div>
