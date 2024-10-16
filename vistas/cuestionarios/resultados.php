<?php

$estrellasAmarillas=floor($this->puntajeFinal/2);
$estrellasNegras=5-$estrellasAmarillas;
$textoEstrellas='';
for($x=0;$x<$estrellasAmarillas;$x++){
	$textoEstrellas.=' <span class="fa fa-star checked"></span>';
}
for($x=0;$x<$estrellasNegras;$x++){
	$textoEstrellas.=' <span class="fa fa-star"></span>';
}

for($x=0;$x<count($this->arrRespuestas);$x++){
    switch($this->arrRespuestas[$x]['nombreCorto']){
        case 'Personas':
            $itemPersonas=$x;
            break;
		case 'Paz':
			$itemPaz=$x;
			break;
		case 'Prosperidad':
			$itemProsperidad=$x;
			break;
		case 'Planeta':
			$itemPlaneta=$x;
			break;
		case 'Alianzas':
			$itemPaternariato=$x;
			break;
    }
}

?>

<?php
//include_once ('vistas/general/cabeza.php');
?>

<div class="row">
    <div class="col-sm-1 ">
    </div>
    <div class="col-sm-10">
        <br>
        <div class="card mx-auto redondeada">
            <div class="row">
                <div class="col-sm-12 titulo centrado">
					Resultados
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 titulo centrado ">
                    <div class="row angosto">
                        <h5>¡Muchas felicidades por completar los datos de la calculadora!</h5>
                        
                        <div class="card-subtitle mb-2 text-muted textoPredefinido ">
                            En una escala de 0 a 10, en donde 0 significa ninguna contribución del hotel hacia el logro de la agenda 2030 y 10 significa una total contribución de las operaciones del hotel a favor del logro de la Agenda 2030.  A continuación, se muestran las contribuciones que las operaciones de su hotel hacen hacia el logro de la Agenda 2030 en cada uno de sus pilares. Si desea conocer más detalles en cada uno de los temas de estos pilares dele clic en “Ver más” o genere un reporte dándole clic en “Hacer reporte”.
                            Posteriormente, puede elaborar un plan de acción y también solicitar una evaluación detallada por un especialista en la Agenda 2030.
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-1 "></div>
                        <div class="col-sm-2 ">
                            <div class="card mx-auto redondeada pequena">
                                <div class="centrado tituloCuadrito">
									<?php echo ($this->arrRespuestas[$itemPersonas]['nombreCorto']); ?>
                                </div>
                                <div class="centrado">
                                    <img src="imagenes/personas.gif" width="70px" height="70px">
                                </div>
                                <div class="progress" style="height:10px">
                                    <div class="progress-bar" style="width:<?php echo($this->arrRespuestas[$itemPersonas]['porcentajeBarra']."%"); ?>;height:10px;  background-color:#00adef !important;"></div>
                                </div>
                                <div class="centrado">
									<?php echo (number_format($this->arrRespuestas[$itemPersonas]['puntuacion'],2)) ; ?>
                                </div>
                            </div>
                            <div class="centrado">
								<?php $this->fx->ponerBoton('ensenarResultadosParticulares',null,"$itemPersonas",'Ver más',null,null,null,'letraVerMas','0',null,null,null); ?>
                            </div>
                        </div>
                        <div class="col-sm-2 ">
                            <div class="card mx-auto redondeada pequena">
                                <div class="centrado tituloCuadrito">
									<?php echo ($this->arrRespuestas[$itemPaz]['nombreCorto']); ?>
                                </div>
                                <div class="centrado">
                                    <img src="imagenes/paz.png" width="70px" height="70px">
                                </div>
                                <div class="progress" style="height:10px">
                                    <div class="progress-bar azulHotel" style="width:<?php echo($this->arrRespuestas[$itemPaz]['porcentajeBarra']."%"); ?>; height:10px; background-color:#00adef !important;"></div>
                                </div>
                                <div class="centrado">
									<?php echo (number_format($this->arrRespuestas[$itemPaz]['puntuacion'],2)) ; ?>
                                </div>
                            </div>
                            <div class="centrado">
								<?php $this->fx->ponerBoton('ensenarResultadosParticulares',null,"$itemPaz",'Ver más',null,null,null,'letraVerMas','0',null,null,null); ?>
                            </div>
                        </div>
                        <div class="col-sm-2 ">
                            <div class="card mx-auto redondeada pequena">
                                <div class="centrado tituloCuadrito">
									<?php echo ($this->arrRespuestas[$itemProsperidad]['nombreCorto']); ?>
                                </div>
                                <div class="centrado">
                                    <img src="imagenes/prosperidad.png" width="70px" height="70px">
                                </div>
                                <div class="progress" style="height:10px">
                                    <div class="progress-bar" style="width:<?php echo($this->arrRespuestas[$itemProsperidad]['porcentajeBarra']."%"); ?>; height:10px; background-color:#00adef !important;"></div>
                                </div>
                                <div class="centrado">
									<?php echo (number_format($this->arrRespuestas[$itemProsperidad]['puntuacion'],2)) ; ?>
                                </div>
                            </div>
                            <div class="centrado">
								<?php $this->fx->ponerBoton('ensenarResultadosParticulares',null,"$itemProsperidad",'Ver más',null,null,null,'letraVerMas','0',null,null,null); ?>
                            </div>
                        </div>
                        <div class="col-sm-2 ">
                            <div class="card mx-auto redondeada pequena">
                                <div class="centrado tituloCuadrito">
									<?php echo ($this->arrRespuestas[$itemPlaneta]['nombreCorto']); ?>
                                </div>
                                <div class="centrado">
                                    <img src="imagenes/planeta.png" width="70px" height="70px">
                                </div>
                                <div class="progress" style="height:10px">
                                    <div class="progress-bar" style="width:<?php echo($this->arrRespuestas[$itemPlaneta]['porcentajeBarra']."%"); ?>; height:10px; background-color:#00adef !important;"></div>
                                </div>
                                <div class="centrado">
									<?php echo (number_format($this->arrRespuestas[$itemPlaneta]['puntuacion'],2)) ; ?>
                                </div>
                            </div>
                            <div class="centrado">
								<?php $this->fx->ponerBoton('ensenarResultadosParticulares',null,"$itemPlaneta",'Ver más',null,null,null,'letraVerMas','0',null,null,null); ?>
                            </div>
                        </div>
                        <div class="col-sm-2 ">
                            <div class="card mx-auto redondeada pequena">
                                <div class="centrado tituloCuadrito">
									<?php echo ($this->arrRespuestas[$itemPaternariato]['nombreCorto']); ?>
                                </div>
                                <div class="centrado">
                                    <img src="imagenes/paternariato.png" width="70px" height="70px">
                                </div>
                                <div class="progress" style="height:10px">
                                    <div class="progress-bar" style="width:<?php echo($this->arrRespuestas[$itemPaternariato]['porcentajeBarra']."%"); ?>;height:10px; background-color:#00adef !important;"></div>
                                </div>
                                <div class="centrado">
									<?php echo (number_format($this->arrRespuestas[$itemPaternariato]['puntuacion'],2)) ; ?>
                                </div>
                            </div>
                            <div class="centrado">
								<?php $this->fx->ponerBoton('ensenarResultadosParticulares',null,"$itemPaternariato",'Ver más',null,null,null,'letraVerMas','0',null,null,null); ?>
                            </div>
                        </div>
                        <div class="col-sm-1 "></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 centrado">
						    <?php $this->fx->ponerBoton('regresar',null,null,'Regresar',null,null,null,'btn estiloBoton','0',null,null,null); ?>
                        </div>
                        
                        <div class="col-sm-4 centrado ">
							<?php $this->fx->ponerBoton('hacerReporte',null,null,'Hacer reporte',null,null,null,'btn estiloBoton','0',null,null,null); ?>
                        </div>
                        <div class="col-sm-4 centrado ">
							<?php $this->fx->ponerBoton('hacerPlanAccion',null,null,'Hacer plan de acción',null,null,null,'btn estiloBoton','0',null,null,null); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-1 ">
    </div>
</div>








































