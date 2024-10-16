<!--completar registros-->
<?php //include_once ('vistas/general/cabeza.php')?>
<div class="row">
    <div class="col-sm-1">
    </div>
    <div class="col-sm-10">
        <br>
        <div class="card mx-auto redondeada">
            <div class="card-body textoCarta">
                <div class="row">
                    <div class="titulo centrado"> Por favor anote sus datos</div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-6">
                        <h6 class="card-subtitle mb-2 text-muted derecha"> Nombres</h6>
                    </div>
                    <div class="col-sm-6">
						<?php $this->fx->ponerInput('text','nombres','50','50','','estiloRadioButton','Nombres',null,null,null,null,null,null); ?>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-6">
                        <h6 class="card-subtitle mb-2 text-muted derecha"> Apellido paterno</h6>
                    </div>
                    <div class="col-sm-6">
						<?php $this->fx->ponerInput('text','paterno','50','50','','estiloRadioButton','Paterno',null,null,null,null,null,null); ?>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-6">
                        <h6 class="card-subtitle mb-2 text-muted derecha"> Apellido materno</h6>
                    </div>
                    <div class="col-sm-6">
						<?php $this->fx->ponerInput('text','materno','50','50','','estiloRadioButton','Materno',null,null,null,null,null,null); ?>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-6">
                        <h6 class="card-subtitle mb-2 text-muted derecha"> Si pertenece a una cadena</h6>
                    </div>
                    <div class="col-sm-6">
						<?php $this->fx->ponerInput('text','cadena','50','50','','estiloRadioButton','Cadena',null,null,null,null,null,null); ?>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-6">
                        <h6 class="card-subtitle mb-2 text-muted derecha"> Usuario</h6>
                    </div>
                    <div class="col-sm-6">
						<?php $this->fx->ponerInput('text','usuarioReg','20','20','','estiloRadioButton','Usuario',null,null,null,null,null,null); ?>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-6">
                        <h6 class="card-subtitle mb-2 text-muted derecha"> Clave</h6>
                    </div>
                    <div class="col-sm-6">
						<?php $this->fx->ponerInput('text','claveReg','20','20','','estiloRadioButton','Clave',null,null,null,null,null,null); ?>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12 centrado">
						<?php $this->fx->ponerBoton('completarRegistro',null,null,'Grabar',null,null,null,'btn estiloBoton centrado','0',null,null,null); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-1 " >
    </div>




