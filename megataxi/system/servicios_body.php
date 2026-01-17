<?php require_once('../Connections/conexion.php'); ?>
<?php
mysql_select_db($database_conexion, $conexion);

$datetime1=($_GET[fecha1]?$_GET[fecha1]:date("Y-m-d"))." ".($_GET[hora1]?$_GET[hora1]:"00").":".($_GET[min1]?$_GET[min1]:"00").":".($_GET[sec1]?$_GET[sec1]:"00");
$datetime2=($_GET[fecha2]?$_GET[fecha2]:date("Y-m-d"))." ".($_GET[hora2]?$_GET[hora2]:"23").":".($_GET[min2]?$_GET[min2]:"59").":".($_GET[sec2]?$_GET[sec2]:"59");



$sqlServicios="select servicio.*, estado_servicio.nombre as estadoServicio, directorio.direccion, usuario.nombre as usuario from servicio, estado_servicio, usuario, directorio where servicio.estado=estado_servicio.estado_id and servicio.telefono=directorio.telefono and servicio.id_usuario=usuario.id_usuario and 	(dt_llamada between '$datetime1' and '$datetime2')";

if($_GET[telefono]!=""){
	if($_GET[comparador1]=="like")
		$sqlServicios.=" and servicio.telefono $_GET[comparador1] '%$_GET[telefono]%'";
	else
		$sqlServicios.=" and servicio.telefono $_GET[comparador1] '$_GET[telefono]'";	
		
}

if($_GET[vehiculo]!=""){
	if($_GET[comparador1]=="like")
		$sqlServicios.=" and servicio.mega $_GET[comparador2] '%$_GET[vehiculo]%'";	
	else
		$sqlServicios.=" and servicio.mega $_GET[comparador2] '$_GET[vehiculo]'";
}

if($_GET[estado]!=""){
	$sqlServicios.=" and servicio.estado $_GET[comparador3] '$_GET[estado]'";
}

if($_GET[usuario]!=""){
	$sqlServicios.=" and servicio.id_usuario $_GET[comparador4] '$_GET[usuario]'";
}

//echo $sqlServicios;


$servicios=mysql_query($sqlServicios,$conexion)or die(mysql_error());
$row_servicios=mysql_fetch_assoc($servicios);

?>


<form method="get" action="servicios.php" id="BusquedaServiciosForm" target="_self">
<h2>Panel De Busqueda Servicios</h2>
<table border="0" align="center">
	<tr class="tr_title">
		<td width="85">Telefono		</td>
		<td width="222">
			<select name="comparador1">
				<option value="=" <?php if($_GET[comparador1]=="=")echo "selected=\"selected\""; ?>>=</option>
				<option value="like" <?php if($_GET[comparador1]=="like")echo "selected=\"selected\""; ?>>Contiene</option>
	  </select>		</td>
		<td width="177"><input type="text" name="telefono" value="<?php echo $_GET[telefono]; ?>"></td>
	</tr>
	<tr class="tr_title">
		<td>Vehiculo</td>
		<td>
			<select name="comparador2">
				<option value="=" <?php if($_GET[comparador2]=="=")echo "selected=\"selected\""; ?>>=</option>
				<option value="like" <?php if($_GET[comparador2]=="like")echo "selected=\"selected\""; ?>>Contiene</option>
			</select>		</td>
		<td>
			<input type="text" name="vehiculo" value="<?php echo $_GET[vehiculo]; ?>">		</td>
	</tr>	
	<tr class="tr_title">
		<td>Estado</td>
		<td>
			<select name="comparador3">
				<option value="=" <?php if($_GET[comparador3]=="=")echo "selected=\"selected\""; ?>>=</option>
			</select>		</td>
		<td>
			<?php 
				$estados=mysql_query("select * from estado_servicio",$conexion)or die(mysql_error());
			?>		
			<select name="estado">
				<option value="">Seleccione Valor</option>
			<?php
				while($row_estados=mysql_fetch_assoc($estados)){
			?>
				<option value="<?php echo $row_estados[estado_id]; ?>" <?php if($_GET[estado]==$row_estados[estado_id])echo "selected=\"selected\""; ?>><?php echo $row_estados[nombre]; ?></option>
			<?php
				}
			?>
			</select>		
		</td>
	</tr>	
	<tr class="tr_title">
		<td>Hora entre </td>
		<td colspan="2"> <?php 
		

		
		$fecha_partida1=split(" ",$datetime1); ?>
  <input name="fecha1" type="text" id="fecha1" value="<?php echo $fecha_partida1[0]; ?>" />
  <img src="../js/jscalendar-1.0/img.gif" alt="calendario" name="fecha_button1" id="fecha_button1" style="cursor:pointer;" onload="activar_calendario('fecha1','fecha_button1');"; /> H
  <?php $hora_partida1=split(":",$fecha_partida1[1]); ?>
  <select name="hora1" id="hora1">
    <?php for($i=0;$i<24;$i++){ ?>
    <option value="<?php echo $i ?>" <?php echo ($hora_partida1[0]==$i)?"selected='selected'":""; ?>><?php echo $i ?></option>
    <?php }?>
  </select>
    :m
  <select name="min1" id="min1">
    <?php for($i=0;$i<60;$i++){ ?>
    <option value="<?php echo $i ?>" <?php echo ($i==$hora_partida1[1])?"selected='selected'":""; ?>><?php echo $i ?></option>
    <?php }?>
  </select>
    :s
  <select name="sec1" id="sec1">
    <?php for($i=0;$i<60;$i++){ ?>
    <option value="<?php echo $i ?>" <?php echo ($i==$hora_partida1[2])?"selected='selected'":""; ?>><?php echo $i ?></option>
    <?php }?>
  </select></td>
		<td width="16">Y</td>
		<td width="398">
		 <?php 
		

		
		$fecha_partida2=split(" ",$datetime2); ?>
  <input name="fecha2" type="text" id="fecha2" value="<?php echo $fecha_partida2[0]; ?>" />
  <img src="../js/jscalendar-1.0/img.gif" alt="calendario" name="fecha_button2" id="fecha_button2" style="cursor:pointer;" onload="activar_calendario('fecha2','fecha_button2');"; /> H
  <?php $hora_partida2=split(":",$fecha_partida2[1]); ?>
  <select name="hora2" id="hora2">
    <?php for($i=0;$i<24;$i++){ ?>
    <option value="<?php echo $i ?>" <?php echo ($hora_partida2[0]==$i)?"selected='selected'":""; ?>><?php echo $i ?></option>
    <?php }?>
  </select>
    :m
  <select name="min2" id="min2">
    <?php for($i=0;$i<60;$i++){ ?>
    <option value="<?php echo $i ?>" <?php echo ($i==$hora_partida2[1])?"selected='selected'":""; ?>><?php echo $i ?></option>
    <?php }?>
  </select>
    :s
  <select name="sec2" id="sec2">
    <?php for($i=0;$i<60;$i++){ ?>
    <option value="<?php echo $i ?>" <?php echo ($i==$hora_partida2[2])?"selected='selected'":""; ?>><?php echo $i ?></option>
    <?php }?>
  </select>
	  </td>
	</tr>	
	<tr class="tr_title">
		<td>Usuario		</td>
		<td>
			<select name="comparador4">
				<option value="=">=</option>
			</select>		</td>
		<td>
			<?php 
				$usuarios=mysql_query("select * from usuario where perfil > 1",$conexion)or die(mysql_error());
			?>		
			<select name="usuario">
				<option value="">Seleccione Valor</option>
			<?php
				while($row_usuarios=mysql_fetch_assoc($usuarios)){
			?>
				<option value="<?php echo $row_usuarios[id_usuario]; ?>" <?php if($_GET[usuario]==$row_usuarios[id_usuario])echo "selected=\"selected\""; ?>><?php echo $row_usuarios[nombre]; ?></option>
			<?php
				}
			?>
			</select>		</td>
	</tr>
	<tr class="tr_title">
	  <td>&nbsp;</td>
	  <td><label>
	    <input type="button" name="Reporte" value="Reporte" onClick="document.getElementById('BusquedaServiciosForm').action='../reports/servicios.report.php';document.getElementById('BusquedaServiciosForm').target='IFrameProcess';enviar('BusquedaServiciosForm');">
	  </label></td>
	  <td><label>
	    <input type="button" name="Buscar" value="Buscar" onClick="document.getElementById('BusquedaServiciosForm').action='servicios.php';document.getElementById('BusquedaServiciosForm').target='_self';enviar('BusquedaServiciosForm');">
	  </label></td>
    </tr>						
</table>
</form>


<h2>Servicios</h2>

<?php echo "Servicios Mostrados: ".mysql_num_rows($servicios); ?>

<table border="1" align="center">
  <tr class="tr_title">
    <td>Telefono</td>
    <td>Direccion</td>
    <td>Descripcion</td>
	<td>Tipo Servicio</td>	
    <td>Vehiculo</td>
	<td>Reportados</td>
    <td>Estado</td>
    <td>Hora de Llamada</td>
    <td>Hora de Servicio</td>
    <td>Usuario</td>
  </tr>
  <?php do { 
  	$reportadosSql="select * from reporte_mega_a_servicio where servicio_id='".$row_servicios["servicio_id"]."'";
	$reportados=mysql_query($reportadosSql,$conexion)or die(mysql_error());
	$row_reportados=mysql_fetch_assoc($reportados);
		$cadena_reportados="";
		$cadena_reportados.="$row_reportados[mega]";
	while($row_reportados=mysql_fetch_assoc($reportados)){
		$cadena_reportados.=", $row_reportados[mega]";
	}
  
  ?>
    <tr>
      <td><?php echo $row_servicios['telefono']; ?></td>
      <td><?php echo $row_servicios['direccion']; ?></td>
      <td><?php echo $row_servicios['descripcion']; ?></td>	  
      <td><?php if($row_servicios['tipo_servicio']==1){echo "Taxi"; }else if($row_servicios['tipo_servicio']==2){ echo "domicilio"; }else if($row_servicios['tipo_servicio']==3){ echo "Camioneta"; }  ?></td>	  	  
      <td><?php echo $row_servicios['mega']; ?></td>
      <td><?php echo $cadena_reportados; ?></td>	  
      <td><?php echo $row_servicios['estadoServicio']; ?></td>
      <td><?php echo $row_servicios['dt_llamada']; ?></td>
      <td><?php echo $row_servicios['dt_recogida']; ?></td>
      <td><?php echo $row_servicios['usuario']; ?></td>
       
    </tr>
    <?php } while ($row_servicios = mysql_fetch_assoc($servicios)); ?>
</table>
<?php
mysql_free_result($servicios);
?>
