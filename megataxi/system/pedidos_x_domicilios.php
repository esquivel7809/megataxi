<?php require_once('../Connections/conexion.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_conexion, $conexion);
$query_contactar = "SELECT id_domicilios_com_contacto, nombre, telefono, fecha FROM domicilios_com_contacto WHERE estado = 0 ORDER BY fecha ASC";
$contactar = mysql_query($query_contactar, $conexion) or die(mysql_error());
$row_contactar = mysql_fetch_assoc($contactar);
$totalRows_contactar = mysql_num_rows($contactar);
?>
<?php if($totalRows_contactar){ ?>
<fieldset>
<legend>Contactos Domicilios.com</legend>
<table border="0" cellspacing="0" class="tablita">
  <tr class="tr_title">
    <td>Nombre</td>
    <td>Telefono</td>
    <td>Fecha</td>
    <td colspan="2">Acci&oacute;n</td>
  </tr>
  <?php do { ?>
    <tr class="servicio_domicilios_com">
      <td><img src="../images/favicondomicilios.png" height="16" width="16"> <?php echo $row_contactar['nombre']; ?></td>
      <td>
	  	  <a href="../llamar.php?numero=<?php echo $row_contactar['telefono']; ?>" target="IFrameProcess" title="Click para Llamar"><?php echo $row_contactar['telefono']; ?>
          </a>
      </td>
      <td><?php
	  			$array_fecha=split(" ",$row_contactar['fecha']); 
				echo $array_fecha[1];
				?></td>
      <td>
      	<div class="div_td_image">
	       	<form id="FormUsuarioContactado<?php echo $row_contactar[id_domicilios_com_contacto]; ?>" method="post" action="../process/cliente_contactado.php" target="IFrameProcess">
    	    	<input type="hidden" name="id_domicilios_com_contacto" value="<?php echo $row_contactar[id_domicilios_com_contacto]; ?>">
        	    <input type="image" name="llamar" src="../images/tick.png">
	        </form>
        </div>
      </td>
      <td>
      	<form id="FormLlamarContacto<?php echo $row_contactar[id_domicilios_com_contacto]; ?>" method="get" action="../llamar.php" target="IFrameProcess">
        	<input type="hidden" name="numero" value="<?php echo $row_contactar[telefono]; ?>">
			<input type="image" src="../images/telefono.png" border="0" />
        </form></td>
    </tr>
    <?php } while ($row_contactar = mysql_fetch_assoc($contactar)); ?>
</table>
</fieldset>
<?php }else{ ?>

<!--//si no se encontró nada-->
<?php } ?>
<?php
mysql_free_result($contactar);
?>
<br />
