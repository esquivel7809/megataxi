<?php require_once('../Connections/conexion.php'); ?>
<?php
$currentPage = "recordatorios.php";

$maxRows_recordatorios = $num_registros?$num_registros:20;

//echo $maxRows_recordatorios;


$pageNum_recordatorios = 0;
if (isset($_GET['pageNum_recordatorios'])) {
  $pageNum_recordatorios = $_GET['pageNum_recordatorios'];
}
$startRow_recordatorios = $pageNum_recordatorios * $maxRows_recordatorios;

$colname_recordatorios = "1";
if (isset($_GET['estado'])) {
  $colname_recordatorios = (get_magic_quotes_gpc()) ? $_GET['estado'] : addslashes($_GET['estado']);
}
mysql_select_db($database_conexion, $conexion);
$query_recordatorios = sprintf("SELECT * FROM recordatorio WHERE estado = %s", $colname_recordatorios);
$query_limit_recordatorios = sprintf("%s LIMIT %d, %d", $query_recordatorios, $startRow_recordatorios, $maxRows_recordatorios);
$recordatorios = mysql_query($query_limit_recordatorios, $conexion) or die(mysql_error());
$row_recordatorios = mysql_fetch_assoc($recordatorios);

if (isset($_GET['totalRows_recordatorios'])) {
  $totalRows_recordatorios = $_GET['totalRows_recordatorios'];
} else {
  $all_recordatorios = mysql_query($query_recordatorios);
  $totalRows_recordatorios = mysql_num_rows($all_recordatorios);
}
$totalPages_recordatorios = ceil($totalRows_recordatorios/$maxRows_recordatorios)-1;

$queryString_recordatorios = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_recordatorios") == false && 
        stristr($param, "totalRows_recordatorios") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_recordatorios = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_recordatorios = sprintf("&totalRows_recordatorios=%d%s", $totalRows_recordatorios, $queryString_recordatorios);
?>

<table align="center"><tr><td><h2>Recordatorios</h2></td></tr></table>
<table border="1" align="center">
  <tr class="tr_title">
    <td width="146">Telefono</td>
    <td width="169">Descripcion</td>
    <td width="140">Hora Llamada</td>
    <td width="140">Hora Recordatorio</td>	
	<td colspan="2">Accion</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_recordatorios['telefono']; ?></td>
      <td><?php echo $row_recordatorios['descripcion']; ?></td>
      <td><?php echo $row_recordatorios['timestamp']; ?></td>
      <td><?php echo $row_recordatorios['hora']; ?></td>	  	  
	  <td width="24"><form id="DropRecordatorio<?php echo $row_recordatorios['id_recordatorio']; ?>" action="../process/recordatorio.process.php" method="post" target="IFrameProcess"><div align="center"><input type="hidden" name="id_recordatorio" value="<?php echo $row_recordatorios[id_recordatorio]; ?>">
	    <input name="modo" type="hidden" value="delete">
	    <img src="../images/b_drop.png" style="cursor:pointer;" alt="Borrar" onClick="enviar('DropRecordatorio<?php echo $row_recordatorios['id_recordatorio']; ?>');"></div></form></td>
	  <td width="19"><img src="../images/b_edit.png" style="cursor:pointer;" onclick="abrir('/megataxi/forms/recordatorio.form.php','','&modo=edit&id_recordatorio=<?php echo $row_recordatorios['id_recordatorio']; ?>','Edicion');ver_div_edit();" alt="Editar"></td>
    </tr>
    <?php } while ($row_recordatorios = mysql_fetch_assoc($recordatorios)); ?>
	<tr>
		<td colspan="4"></td>
		<td colspan="2"><input type="button" value="Nuevo" onClick="nuevo_recordatorio();"></td>
	</tr>
</table>

<div align="center">Registros <?php echo ($startRow_recordatorios + 1) ?> a <?php echo min($startRow_recordatorios + $maxRows_recordatorios, $totalRows_recordatorios) ?> de <?php echo $totalRows_recordatorios ?></div>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_recordatorios > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_recordatorios=%d%s", $currentPage, 0, $queryString_recordatorios); ?>"><img src="First.gif" border=0></a>
          <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_recordatorios > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_recordatorios=%d%s", $currentPage, max(0, $pageNum_recordatorios - 1), $queryString_recordatorios); ?>"><img src="Previous.gif" border=0></a>
          <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_recordatorios < $totalPages_recordatorios) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_recordatorios=%d%s", $currentPage, min($totalPages_recordatorios, $pageNum_recordatorios + 1), $queryString_recordatorios); ?>"><img src="Next.gif" border=0></a>
          <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_recordatorios < $totalPages_recordatorios) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_recordatorios=%d%s", $currentPage, $totalPages_recordatorios, $queryString_recordatorios); ?>"><img src="Last.gif" border=0></a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<?php
mysql_free_result($recordatorios);
?>