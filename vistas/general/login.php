<!-- LOGIN-->
<?php //include_once ('vistas/general/cabeza.php')?>
<div class="row">
    <div class="col-sm-1 ">
    </div>
    <div class="col-sm-10">
        <br>
        <div class="card mx-auto redondeada">
        
            <div class="row">
                <div class="col-sm-12 titulo centrado">
                    Si ya esta registrado ingrese por favor
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-6">
                    <h6 class="card-subtitle mb-2 text-muted derecha"> Usuario</h6>
                </div>
                <div class="col-sm-6">
                    <?php $this->fx->ponerInput('text','usuario','20','20','','estiloRadioButton','Usuario',null,null,null,null,null,null); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-6">
                    <h6 class="card-subtitle mb-2 text-muted derecha"> Clave</h6>
                </div>
                <div class="col-sm-6">
                    <?php $this->fx->ponerInput('text','clave','20','20','','estiloRadioButton','Clave',null,null,null,null,null,null); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-12 centrado">
                    <?php $this->fx->ponerBoton('login',null,null,'Login',null,null,null,'btn estiloBoton','0',null,null,null); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 titulo centrado">
                    Si no esta registrado registrese por favor
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-12 centrado">
                    <?php $this->fx->ponerBoton('registro',null,null,'Registrarse',null,null,null,'btn estiloBoton','0',null,null,null); ?>
                
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-1 " >
    </div>
</div>






