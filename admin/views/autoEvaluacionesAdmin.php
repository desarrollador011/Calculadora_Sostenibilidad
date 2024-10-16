<?php
?>

<!-- Main content -->

<table id="evaluacionesAdmin" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Hotel </th>
            <th>Fecha</th>
            <th>Usuario</th>
            <th>Evaluador</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    
    <?PHP if(!empty($this->arrEvaluaciones)) {
        for ($x = 0; $x < count($this->arrEvaluaciones); $x++) {
            $nombreMenu='evaluador_'.$x;
        ?>
            <tr>
            
                <td><?php echo($this->arrEvaluaciones[$x]['nombreHotel']." - ".$this->arrEvaluaciones[$x]['id']); ?></td>
                <td><?php echo($this->arrEvaluaciones[$x]['fecha']); ?></td>
                <td><?php echo($this->arrEvaluaciones[$x]['nombreUsuario']); ?></td>
                <td><?php
                    $this->fx->ponerMenu($nombreMenu,'Seleccione',$this->arrEvaluadores,null,$this->arrEvaluaciones[$x]['idRevisor'],'home','asignarEvaluador',"$x",null,'1');
                        //ponerMenu($nombreMenu,$titulo,$arreglo,$valorCategoria,$valor,$accion=null,$subaccion=null,$item=null,$clase=null,$enviarFormulario=null,$foco=null)
                    //echo($this->arrEvaluaciones[$x]['idRevisor']);
                    ?></td>
                <td><?php $this->fx->ponerBoton('bajarExcel', '', "$x", 'Hacer hoja de calculo', null, null, null, '', '0', null,null,null); ?></td>
                <td><?php $this->fx->ponerBoton('mostrarEvidencias', '', "$x", 'Evidencias', null, null, null, '', '0', null,null,null); ?></td>
            </tr>
        <?php }
    }
    ?>
    </tbody>
    <tfoot>
        <tr>
            
            <th>Hotel</th>
            <th>Fecha</th>
            <th>Usuario</th>
            <th>Evaluador</th>
            <th></th>
            <th></th>
        </tr>
    </tfoot>
</table>


