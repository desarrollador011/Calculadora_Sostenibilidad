<div class="fondoCajaSubirEvidencia">
	<div class="row">
		
		<div class="col-sm-3">
		</div>
		<div class="col-sm-6">
			<br><br><br><br>
			<div class="card mx-auto izq10 superior10">
				<div class="card-header tituloCarta ">
					Subir evidencia
				</div>
				<div class="card-body textoCarta">
					<div class="table-sm">
						<table class="table">
							<tbody>
							<tr>
								<td class="textoCarta negritas" colspan="2">
									&nbsp;<?php $this->fx->ponerInput('text','nombreArchivo','60','60','',null,'Nombre del archivo',null,null,null,null,null,null) ?>
								</td>
							</tr>
							<tr>
								<td class="inputGeneralSinBorde"  colspan="2">
									<?php $this->fx->ponerInput("file","archivoSoporte",null,null,"","inputGeneral",null,null,null,null,null,null,null); ?>
								</td>
							</tr>
							<tr>
								<td class="inputGeneralSinBorde"  colspan="1">
									<?php $this->fx->ponerBoton('agregarArchivoSoporte', null, null, 'Subir', null,null,null, 'btn btn-info btn-xs textoXs', 0, null, null, null);
									?>
								</td>
								<td class="inputGeneralSinBorde derecha">
									<?php $this->fx->ponerBoton('cancelarSubirEvidencia', null, null, 'Cancelar', null,null,null, 'btn btn-danger btn-xs textoXs', 0, null, null, null); ?>
								</td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-3">
		</div>
	</div>
</div>
