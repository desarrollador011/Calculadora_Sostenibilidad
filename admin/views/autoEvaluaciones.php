<?php
?>

<!-- Main content -->

<table id="evaluaciones" class="display" style="width:100%">
	<thead>
	<tr>
		<th>&nbsp;</th>
		<th>Hotel</th>
		<th>Fecha</th>
		
        <th></th>
	</tr>
	</thead>
	<tbody>
	
	<?PHP if(!empty($this->arrEvaluaciones)) {
		for ($x = 0; $x < count($this->arrEvaluaciones); $x++) {
			$nombreMenu='evaluador_'.$x;
			?>
			<tr>
				<td>&nbsp;</td>
				<td><?php echo($this->arrEvaluaciones[$x]['nombreHotel']); ?></td>
				<td><?php echo($this->arrEvaluaciones[$x]['fecha']); ?></td>
				<td><?php $this->fx->ponerBoton('home', 'hacerEvaluacion',"$x" , 'Hacer evaluación', null, null, null, "btn btn-warning btn-xs", '0', null); ?></td>
				
			</tr>
		<?php }
	}
	?>
	</tbody>
	<tfoot>
	<tr>
		<th>&nbsp;</th>
		<th>Hotel</th>
		<th>Fecha</th>
		<th>Usuario</th>
		<th>Evaluador</th>
	</tr>
	</tfoot>
</table>
