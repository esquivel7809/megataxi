<style>
	ul li.numero{
		width:2%;
	}
	ul li.telefono{
		width:7%;
	}
	ul li.direccion{
		width:42%;
	}
	ul li.descripcion{
		width:16%;
	}
	ul li.hora{
		width:5%;
	}
	ul li.mega{
		width:18%;
	}
	ul li.reporta{
		width:5%;
	}
	ul li.accion{
		width:5%;
	}
	.input-mega, .input-reporta{
		width:40px
	}
</style>
<div class="container show-top-margin separate-rows tall-rows">
  <div class="row show-grid">
    <div class="col-xs-12 col-md-8">.col-xs-12 col-md-8</div>
    <div class="col-xs-6 col-md-4">.col-xs-6 .col-md-4</div>
  </div>
  <div class="row show-grid">
    <div class="col-xs-6 col-md-4">.col-xs-6 .col-md-4</div>
    <div class="col-xs-6 col-md-4">.col-xs-6 .col-md-4</div>
    <div class="col-xs-6 col-md-4">.col-xs-6 .col-md-4</div>
  </div>
  <div class="row show-grid">
    <div class="col-xs-6">.col-xs-6</div>
    <div class="col-xs-6">.col-xs-6</div>
  </div>
</div>

<div class="container-fluid show-top-margin separate-rows tall-rows">
  <div class="row show-grid">
    <div class="col-xs-12 col-md-10">
		<table class="table table-condensed">
			<tr class="active">
				<td class="active">...</td>
				<td class="success">...</td>
				<td class="warning">...</td>
				<td class="danger">...</td>
				<td class="info">...</td>
				<td class="info">...</td>
			</tr>
		</table>
		<div class="col-md-2">Telefono</div>
		<div class="col-md-4">Direcci&oacute;n</div>
		<div class="col-md-1">Descripci&oacute;n</div>
		<div class="col-md-1">Hora</div>
		<div class="col-md-1">Mega</div>
		<div class="col-md-1">Reporta</div>
		<div class="col-md-1">Acci&oacute;n</div>
	</div>
    <div class="col-xs-6 col-md-2">.col-xs-6 .col-md-2</div>
  </div>

  <div class="row show-grid">
    <div class="col-xs-12 col-md-10">
		<div class="col-md-1">Telefono</div>
		<div class="col-md-4">Direcci&oacute;n</div>
		<div class="col-md-1">Hora</div>
		<div class="col-md-4">Mega</div>
		<div class="col-md-1">Reporta</div>
		<div class="col-md-1">Acci&oacute;n</div>
	</div>
			<?php
			$x=1;
			//for($x=1; $x<=5; $x++){
			foreach ($datosServicios as $row){ //print_r($row);
			$arrayHora = split(" ", $row["dt_llamada"]);
			$hora = $arrayHora[1];
			$arraReportados = $row["reportados"];
			$cantInput=1;
			//data-posx : posicion horizontal
			//data-posy : posicion vertical
			?>

				<div class="col-xs-12 col-md-10">
					<div class="col-md-1"><?php echo $row["telefono"];?></div>
					<div class="col-md-4"><?php echo $row["direccion"]; if(empty($row["descripcion"])) echo "<br />- descripcion".$row["descripcion"];?></div>
					<div class="col-md-1"><?php echo $hora;?></div>
					<div class="col-md-4">
							<?php  
								foreach ($arraReportados as $clave => $valor){ ?>

										<input type="text" class="form-control input-mega pos-<?php echo $x."-".$cantInput;?>" value="<?php echo $valor;?>" data-posx="<?php echo $cantInput;?>" data-posy="<?php echo $x;?>" mega="<?php echo $valor;?>" data-idServicio="<?php echo $row["servicio_id"]?>" data-idmegareporte="<?php echo $clave;?>">

								<?php $cantInput++; }
								for($y=$cantInput;$y<=5;$y++){ ?>

										<input type="text" class="form-control input-mega pos-<?php echo $x."-".$y;?>" value="" data-posx="<?php echo $y;?>" data-posy="<?php echo $x;?>" mega="" data-idServicio="<?php echo $row["servicio_id"]?>" data-idmegareporte="">

								<?php } ?>

					</div>
					<div class="col-md-1"><input type="text" class="input-reporta pos-reporta-<?php echo $x;?>" data-posy="<?php echo $x;?>"></div>
					<div class="col-md-1">Acci&oacute;n</div>
				</div>
		<?php 
			$x++;
			} ?>

    <div class="col-xs-6 col-md-2">.col-xs-6 .col-md-2</div>
  </div>
  <div class="row show-grid">
    <div class="col-xs-6 col-md-4">.col-xs-6 .col-md-4</div>
    <div class="col-xs-6 col-md-4">.col-xs-6 .col-md-4</div>
    <div class="col-xs-6 col-md-4">.col-xs-6 .col-md-4</div>
  </div>
  <div class="row show-grid">
    <div class="col-xs-6">.col-xs-6</div>
    <div class="col-xs-6">.col-xs-6</div>
  </div>
</div>
<div id="page-wrapper" >
	<div class="col-lg-12" id="content">
		<h1 class="page-header">Servicios</h1>
		<ul class="nav nav-tabs">
			<li class="numero">Nro.</li>
			<li class="telefono">Telefono</li>
			<li class="direccion">Direcci&oacute;n</li>
			<li class="descripcion">Descripci&oacute;n</li>
			<li class="hora">Hora</li>
			<li class="mega">Mega</li>
			<li class="reporta">Reporta</li>
			<li class="accion">Acci&oacute;n</li>
		</ul>
		<?php
			$x=1;
			//for($x=1; $x<=5; $x++){
			foreach ($datosServicios as $row){ //print_r($row);
			$arrayHora = split(" ", $row["dt_llamada"]);
			$hora = $arrayHora[1];
			$arraReportados = $row["reportados"];
			$cantInput=1;
			//data-posx : posicion horizontal
			//data-posy : posicion vertical
			?>
		<ul class="nav nav-tabs">
			<li class="numero"><?php echo $x;?></li>
			<li class="telefono"><?php echo $row["telefono"];?></li>
			<li class="direccion"><?php echo $row["direccion"];?></li>
			<li class="descripcion"><?php echo $row["descripcion"]."&nbsp";?></li>
			<li class="hora"><?php echo $hora;?></li>
			<li class="mega">
				<?php  
					foreach ($arraReportados as $clave => $valor){ ?>
						<input type="text" class="input-mega pos-<?php echo $x."-".$cantInput;?>" value="<?php echo $valor;?>" data-posx="<?php echo $cantInput;?>" data-posy="<?php echo $x;?>" mega="<?php echo $valor;?>" data-idServicio="<?php echo $row["servicio_id"]?>" data-idmegareporte="<?php echo $clave;?>">
					<?php $cantInput++; }
				
				
				for($y=$cantInput;$y<=5;$y++){ ?>
				<input type="text" class="input-mega pos-<?php echo $x."-".$y;?>" value="" data-posx="<?php echo $y;?>" data-posy="<?php echo $x;?>" mega="" data-idServicio="<?php echo $row["servicio_id"]?>" data-idmegareporte="">
				<?php } ?>
				<!-- 
				<input type="text" class="input-mega pos-<?php echo $x;?>-2" value="<?php echo $x;?>" data-posx="2" data-posy="<?php echo $x;?>" mega="<?php echo $x;?>" data-idServicio="<?php echo $row["servicio_id"]?>">
				<input type="text" class="input-mega pos-<?php echo $x;?>-3" value="<?php echo $x;?>" data-posx="3" data-posy="<?php echo $x;?>" mega="<?php echo $x;?>" data-idServicio="<?php echo $row["servicio_id"]?>">
				<input type="text" class="input-mega pos-<?php echo $x;?>-4" value="<?php echo $x;?>" data-posx="4" data-posy="<?php echo $x;?>" mega="<?php echo $x;?>" data-idServicio="<?php echo $row["servicio_id"]?>">
				<input type="text" class="input-mega pos-<?php echo $x;?>-5" value="<?php echo $x;?>" data-posx="5" data-posy="<?php echo $x;?>" mega="<?php echo $x;?>" data-idServicio="<?php echo $row["servicio_id"]?>">
				
				-->
			</li>
			<li class="reporta"><input type="text" class="input-reporta pos-reporta-<?php echo $x;?>" data-posy="<?php echo $x;?>"></li>
			<li class="accion"></li>
		</ul>
		<?php 
			$x++;
			} ?>
	</div>
    <div class="col-lg-2" style="display: none;" >
        <h1 class="page-header">Automaticos</h1>
    </div>
</div>
<!-- /#page-wrapper -->
