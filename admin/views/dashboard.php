<?php
?>
<div class="row">
	<!-- totales-->
	<div class="col-md-5">
		<p class="text-center ">
			<strong>Totales</strong>
		</p>
		
		<div class="progress-group">
			Hoteles
			<span class="float-right"><b>160</b>/200</span>
			<div class="progress progress-sm">
				<div class="progress-bar bg-primary" style="width: 80%"></div>
			</div>
		</div>
		<!-- /.progress-group -->
		
		<div class="progress-group">
			Usuarios
			<span class="float-right"><b>310</b>/400</span>
			<div class="progress progress-sm">
				<div class="progress-bar bg-danger" style="width: 75%"></div>
			</div>
		</div>
		
		<!-- /.progress-group -->
		<div class="progress-group">
			<span class="progress-text">Evaluaciones</span>
			<span class="float-right"><b>480</b>/800</span>
			<div class="progress progress-sm">
				<div class="progress-bar bg-success" style="width: 60%"></div>
			</div>
		</div>
		
		<!-- /.progress-group -->
		<div class="progress-group">
			Planes
			<span class="float-right"><b>250</b>/500</span>
			<div class="progress progress-sm">
				<div class="progress-bar bg-warning" style="width: 50%"></div>
			</div>
		</div>
		<!-- /.progress-group -->
	</div>
	<!-- /.col -->
	
	<div class="col-md-2">
		&nbsp;
	</div>
	<!-- por estado-->
	<div class="col-md-5">
		<p class="text-center">
			<strong>Total de Hoteles por Estado</strong>
		</p>
		
		<div class="progress-group">
			Add Products to Cart
			<span class="float-right"><b>160</b>/200</span>
			<div class="progress progress-sm">
				<div class="progress-bar bg-primary" style="width: 80%"></div>
			</div>
		</div>
		<!-- /.progress-group -->
		
		<div class="progress-group">
			Complete Purchase
			<span class="float-right"><b>310</b>/400</span>
			<div class="progress progress-sm">
				<div class="progress-bar bg-danger" style="width: 75%"></div>
			</div>
		</div>
		
		<!-- /.progress-group -->
		<div class="progress-group">
			<span class="progress-text">Visit Premium Page</span>
			<span class="float-right"><b>480</b>/800</span>
			<div class="progress progress-sm">
				<div class="progress-bar bg-success" style="width: 60%"></div>
			</div>
		</div>
		
		<!-- /.progress-group -->
		<div class="progress-group">
			Send Inquiries
			<span class="float-right"><b>250</b>/500</span>
			<div class="progress progress-sm">
				<div class="progress-bar bg-warning" style="width: 50%"></div>
			</div>
		</div>
		<!-- /.progress-group -->
	</div>
	<!-- /.col -->
</div>


<div class="row">
	<!-- totales por desitno-->
	<div class="col-md-5">
		<p class="text-center ">
			<strong>Totales por destino</strong>
		</p>
		
		<?php
		for($x=0;$x<count($this->arrDestinoHotel);$x++){
			echo "<div class=\"progress-group\">";
			echo "Hoteles";
			echo "<span class=\"float-right\"><b>160</b>/200</span>";
			echo "<div class=\"progress progress-sm\">";
				echo "<div class=\"progress-bar bg-primary\" style=\"width: 80%\"></div>";
			echo "</div>";
		echo "</div>";
		}
		
		
		?>
		
		
		
		
		<div class="progress-group">
			Hoteles
			<span class="float-right"><b>160</b>/200</span>
			<div class="progress progress-sm">
				<div class="progress-bar bg-primary" style="width: 80%"></div>
			</div>
		</div>
		<!-- /.progress-group -->
		
		<div class="progress-group">
			Usuarios
			<span class="float-right"><b>310</b>/400</span>
			<div class="progress progress-sm">
				<div class="progress-bar bg-danger" style="width: 75%"></div>
			</div>
		</div>
		
		<!-- /.progress-group -->
		<div class="progress-group">
			<span class="progress-text">Evaluaciones</span>
			<span class="float-right"><b>480</b>/800</span>
			<div class="progress progress-sm">
				<div class="progress-bar bg-success" style="width: 60%"></div>
			</div>
		</div>
		
		<!-- /.progress-group -->
		<div class="progress-group">
			Planes
			<span class="float-right"><b>250</b>/500</span>
			<div class="progress progress-sm">
				<div class="progress-bar bg-warning" style="width: 50%"></div>
			</div>
		</div>
		<!-- /.progress-group -->
	</div>
	<!-- /.col -->
	
	<div class="col-md-2">
		&nbsp;
	</div>
	
	<!-- totales por tamano-->
	<div class="col-md-5">
		
		<p class="text-center">
			<strong>Total de Hoteles por tamaño</strong>
		</p>
		
		<div class="progress-group">
			Add Products to Cart
			<span class="float-right"><b>160</b>/200</span>
			<div class="progress progress-sm">
				<div class="progress-bar bg-primary" style="width: 80%"></div>
			</div>
		</div>
		<!-- /.progress-group -->
		
		<div class="progress-group">
			Complete Purchase
			<span class="float-right"><b>310</b>/400</span>
			<div class="progress progress-sm">
				<div class="progress-bar bg-danger" style="width: 75%"></div>
			</div>
		</div>
		
		<!-- /.progress-group -->
		<div class="progress-group">
			<span class="progress-text">Visit Premium Page</span>
			<span class="float-right"><b>480</b>/800</span>
			<div class="progress progress-sm">
				<div class="progress-bar bg-success" style="width: 60%"></div>
			</div>
		</div>
		
		<!-- /.progress-group -->
		<div class="progress-group">
			Send Inquiries
			<span class="float-right"><b>250</b>/500</span>
			<div class="progress progress-sm">
				<div class="progress-bar bg-warning" style="width: 50%"></div>
			</div>
		</div>
		<!-- /.progress-group -->
	</div>
	<!-- /.col -->
</div>
