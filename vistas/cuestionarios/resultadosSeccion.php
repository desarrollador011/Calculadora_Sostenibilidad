<?php
$indice=$this->itemSeleccionado;

switch($this->arrRespuestas[$indice]['nombreCorto']){
    case 'Personas':
        $imagen="imagenes/personas.gif";
        break;
	case 'Paz':
		$imagen="imagenes/paz.png";
		break;
	case 'Prosperidad':
		$imagen="imagenes/prosperidad.png";
		break;
	case 'Planeta':
		$imagen="imagenes/planeta.png";
		break;
	case 'Alianzas':
		$imagen="imagenes/paternariato.png";
		break;
	
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
                <div class="col-sm-2 titulo centrado ">
                    <h5><?php echo ($this->arrRespuestas[$indice]['nombreCorto']); ?></h5>
                </div>
                <div class="col-sm-2 titulo centrado ">
                    <div class="card mx-auto redondeada muyPequena">
                        <div class="centrado">
                            <img src="<?php echo ($imagen); ?>" width="30px" height="30px">
                        </div>
                        <div class="progress" style="height:10px">
                            <div class="progress-bar" style="width:<?php echo($this->arrRespuestas[$indice]['porcentajeBarra']."%"); ?>;height:10px;  background-color:#00adef !important;"></div>
                        </div>
                        <div class="centrado">
							<?php echo (number_format($this->arrRespuestas[$indice]['puntuacion'],2)) ; ?>
                        </div>
                    </div>
                </div>
				<div class="col-sm-6 titulo centrado ">
					<div class="row textoPredefinido">
...
					</div>
                </div>
                <div class="col-sm-2 titulo centrado "></div>
            </div>


            <div class="row">
				<?php
                for($y=0;$y<count($this->arrRespuestas[$indice]['temas']);$y++){
					$porcentaje=$this->arrRespuestas[$indice]['temas'][$y]['porcentaje']*10;
					?>
                    <div class="col-sm-2   ">
                        <div class="subTitulo">
                            <?php echo ($this->arrRespuestas[$indice]['temas'][$y]['nombre']) ; ?>
                        </div>
                        <div class="dato">
							<?php echo (number_format($this->arrRespuestas[$indice]['temas'][$y]['porcentaje'],2)); ?>
                        </div>

                        <div class="progress" style="height:5px">
                            <div class="progress-bar" style="width:<?php echo($porcentaje."%"); ?>;height:10px; background-color:#00adef !important;"></div>
                        </div>
                    </div>
				<?php } ?>
            </div>
            <br>
            <div class="row">

            
			
                <div class="col-sm-6 centrado">
                    <?php $this->fx->ponerBoton('regresarAResultados',null,null,'Regresar',null,null,null,'btn estiloBoton','0',null,null,null); ?>
                </div>
                
                <div class="col-sm-6 centrado ">
                    <?php $this->fx->ponerBoton('hacerReporte',null,$indice,'Hacer reporte',null,null,null,'btn estiloBoton','0',null,null,null); ?>
                </div>
            </div>
				
		</div>
	</div>
	<div class="col-sm-1 ">
	</div>
</div>
