<?php require_once('../Connections/conexion.php'); ?>
<?php
if(!isset($_SESSION[datos])) session_start();


mysql_select_db($database_conexion, $conexion);
$query_mensajes = "SELECT * FROM mensaje where date(timestamp)=date('".($_POST[fecha]?$_POST[fecha]:date("Y-m-d"))."')";

if($_POST[txt]!=""){
	$query_mensajes.=" and texto like '%$_POST[txt]%'";
}

if(isset($_POST[estado])){
	if($_POST[estado]!="all"){
		$query_mensajes.=" and estado = '$_POST[estado]'";
	}
}else{
	$query_mensajes.=" and estado = '0'";
}

if($_POST[vehiculo]!=""){
	$query_mensajes.=" and placa = '$_POST[vehiculo]'";
}

$query_mensajes.=" order by id_mensaje desc";

//echo $query_mensajes;

$mensajes = mysql_query($query_mensajes, $conexion) or die(mysql_error());
$row_mensajes = mysql_fetch_assoc($mensajes);
$totalRows_mensajes = mysql_num_rows($mensajes);
?>
<div align="center">
<table align="center"><tr><td><h2>Mensajes</h2></td></tr></table>
<form id="form1" name="form1" method="post" action="">
  <table width="252" border="0">
    <tr>
      <td width="63">Texto : </td>
      <td width="173"><input name="txt" type="text" id="txt" value="<?php echo $_POST[txt] ?>" /></td>
    </tr>
    <tr>
      <td>Estado : </td>
      <td><label>
        <select name="estado" id="estado">
          <option value="all"<?php if($_POST[estado]=="all") echo " selected=\"selected\""; ?>>Todos</option>
          <option value="1"<?php if($_POST[estado]=="1") echo " selected=\"selected\""; ?>>Entregados</option>
          <option value="0"<?php if($_POST[estado]=="0"||($_POST[estado]!="all"&&$_POST[estado]!="1")) echo " selected=\"selected\""; ?>>Sin Entregar</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <td>Vehiculo : </td>
      <td><label>
        <input name="vehiculo" type="text" id="vehiculo" value="<?php echo $_POST[vehiculo] ?>" />
      </label></td>
    </tr>
    <tr>
      <td>Fecha : </td>
      <td>  <input name="fecha" type="text" id="fecha" value="<?php echo $_POST[fecha]?$_POST[fecha]:date("Y-m-d"); ?>" />
  <img src="../js/jscalendar-1.0/img.gif" alt="calendario" name="fecha_button1" id="fecha_button1" style="cursor:pointer;" onload="activar_calendario('fecha','fecha_button1');"; /> </td>
    </tr>
    <tr>
      <td><label>
        <input name="Reporte" type="button" id="Reporte" value="Reporte" />
      </label></td>
      <td align="right"><input name="Buscar" type="submit" id="Buscar" value="Buscar" /></td>
    </tr>
  </table>
</form>
<p><a onclick="	abrir('/megataxi/forms/mensaje.form.php','','','Edicion');
	ver_div_edit();">Nuevo Mensaje</a></p>
<table border="1">
  <tr>
    <td>Mensaje # </td>
    <td>Mensaje</td>
    <td>Estado</td>
    <td>Vehiculo</td>
	<td>Accion</td>
  </tr>
  <?php 
  
  if($totalRows_mensajes){
  
  do { ?>
    <tr>
      <td><?php echo $row_mensajes['id_mensaje']; ?></td>
      <td><?php echo $row_mensajes['texto']; ?></td>
      <td><?php if($row_mensajes['estado']==0) echo "Sin Entregar"; else echo "Entregado"; ?></td>
      <td><?php
	  	$vehiculo="select * from vehiculo where placa='$row_mensajes[placa]'";
		$result_vehiculo=mysql_query($vehiculo,$conexion);
		$row_vehiculo=mysql_fetch_assoc($result_vehiculo);
	  	echo $row_vehiculo['placa']; ?></td>
	<td>
	<?php if($row_mensajes[estado]==0){ ?>
	<form method="post" id="Mensaje<?php echo $row_mensajes[id_mensaje]; ?>" name="Mensaje<?php echo $row_mensajes[id_mensaje]; ?>" action="/megataxi/process/mensaje.process.php" target="IFrameProcess">
		<input type="hidden" name="modo" id="modo" value="entregado" />
		<input type="hidden" name="id_mensaje" id="id_mensaje<?php echo $row_mensajes[id_mensaje]; ?>" value="<?php echo $row_mensajes[id_mensaje]; ?>" />
		<input type="submit" name="enviar<?php echo $row_mensajes[id_mensaje]; ?>" value="Entregado" />
	</form><?php } ?></td>
    </tr>
	
    <?php } while ($row_mensajes = mysql_fetch_assoc($mensajes)); 
	}
	?>
</table>
</div>
<?php
mysql_free_result($mensajes);
?>
