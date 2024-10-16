<?php

//for($x=0;$x<count($this->arrEvidencias);$x++){
//  echo ("<a href='".$this->arrEvidencias[$x]['ruta']."'>".$this->arrEvidencias[$x]['nombre']."</a><br>");
//}

?>
<!-- Main content -->

<table id="evidenciasAdmin" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Pregunta </th>
            <th>Evidencia</th>
        </tr>
    </thead>
    <tbody>




	<?PHP if(!empty($this->arrEvidencias)) {
		for ($x = 0; $x < count($this->arrEvidencias); $x++) {
			//$nombreMenu='evaluador_'.$x;
			?>
            <tr>

                <td><?php echo($this->arrEvidencias[$x]['pregunta']); ?></td>
                <td><?php echo ("<a href='http://localhost/".RUTA_SOPORTES.$this->arrEvidencias[$x]['ruta']."'>".$this->arrEvidencias[$x]['nombre']."</a><br>"); ?></td>
                
            </tr>
		<?php }
	}
	?>
    </tbody>
    <tfoot>
    <tr>
        <th>Pregunta </th>
        <th>Evidencia</th>
    </tr>
    </tfoot>
</table>
<?php
$this->fx->ponerBoton('regresarAAutoevaluaciones', '', "$x", 'Regresar', null, null, null, '', '0', null, null, null);
?>
