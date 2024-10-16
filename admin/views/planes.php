<?php
?>

<!-- Main content -->

<table id="planesAdmin" class="display" style="width:100%">
	<thead>
	<tr>
		<th>Hotel </th>
		<th>Fecha</th>
		<th></th>
	</tr>
	</thead>
	<tbody>
	
	<?PHP if(!empty($this->arrPlanes)) {
		for ($x = 0; $x < count($this->arrPlanes); $x++) {
			$nombreMenu='plan_'.$x;
			?>
			<tr>
				
				<td><?php echo($this->arrPlanes[$x]['id']."-".$this->arrPlanes[$x]['nombreHotel']); ?></td>
				<td><?php echo($this->arrPlanes[$x]['fecha']); ?></td>
				<td><?php $this->fx->ponerBoton('bajarExcelPlan', '', "$x", 'Hacer hoja de calculo', null, null, null, '', '0', null,null,null); ?></td>
			</tr>
		<?php }
	}
	?>
	</tbody>
	<tfoot>
	<tr>
		<th>Hotel</th>
		<th>Fecha</th>
		<th></th>
		
	</tr>
	</tfoot>
</table>



