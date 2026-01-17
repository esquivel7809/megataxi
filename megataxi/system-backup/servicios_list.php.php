<?php require_once('../../Connections/conexion.php'); ?>
<?php
include('../../process/validar.php');
include('../../class/destino.class.php');

?>


  <div class="panel">
	<br />
	  <fieldset>
		  <legend>Filtros de busqueda</legend>
		  <fieldset>
			  <legend>Por Fecha y hora</legend>
			    Desde:
				  <?php $fecha_partida=split(" ",$_GET[fecha_inicial]); ?>
					  <input name="fecha_ini_txt" type="text" id="fecha_ini_txt" value="<?php echo $_GET[fecha_inicial]?$fecha_partida[0]:date("Y-m-d"); ?>" />
					  <img src="../../js/jscalendar-1.0/img.gif" alt="calendario" name="fecha_ini_button" id="fecha_ini_button" style="cursor:pointer;" onload="activar_calendario('fecha_ini_txt','fecha_ini_button');"; /> H
					  <?php $hora_partida=split(":",$fecha_partida[1]); ?>
					  <select name="h_ini" id="h_ini">
						<?php for($i=0;$i<24;$i++){ ?>
						    <option value="<?php echo $i ?>" <?php echo ($hora_partida[0]==$i)?"selected='selected'":""; ?>><?php echo $i ?></option>
    					<?php }?>
					  </select>
					    :m
					  <select name="m_ini" id="m_ini">
					    <?php for($i=0;$i<60;$i++){ ?>
					    <option value="<?php echo $i ?>" <?php echo ($i==$hora_partida[1])?"selected='selected'":""; ?>><?php echo $i ?></option>
					    <?php }?>
					  </select>
					    :s
						<select name="s_ini" id="s_ini">
						    <?php for($i=0;$i<60;$i++){ ?>
						    <option value="<?php echo $i ?>" <?php echo ($i==$hora_partida[2])?"selected='selected'":""; ?>><?php echo $i ?></option>
						    <?php }?>
						  </select>
					    ---- Hasta:
						  <?php $fecha_partida=split(" ",$_GET[fecha_final]); ?>
						  <input name="fecha_fin_txt" type="text" id="fecha_fin_txt" value="<?php echo $_GET[fecha_final]?$fecha_partida[0]:date("Y-m-d"); ?>" />
							  <img src="../../js/jscalendar-1.0/img.gif" alt="calendario" name="fecha_fin_button" id="fecha_fin_button" style="cursor:pointer;" onload="activar_calendario('fecha_fin_txt','fecha_fin_button');"; /> H
							  <?php $hora_partida=split(":",$fecha_partida[1]); ?>
					  <select name="h_fin" id="h_fin">
					    <?php for($i=0;$i<24;$i++){ ?>
					    <option value="<?php echo $i ?>" <?php if($_GET[f_fecha]){ echo ($i==$hora_partida[0])?"selected='selected'":"";}else{echo ( $i==23)?"selected='selected'":""; } ?>><?php echo $i ?>
						</option>
					    <?php }?>
					  </select>
					    :m
					  <select name="m_fin" id="m_fin">	
					    <?php for($i=0;$i<60;$i++){ ?>
					    <option value="<?php echo $i ?>" <?php if($_GET[f_fecha]){ echo ($i==$hora_partida[1])?"selected='selected'":"";}else{echo ( $i==59)?"selected='selected'":""; } ?>><?php echo $i ?>
						</option>
					    <?php }?>
					  </select>
					    :s
					  <select name="s_fin" id="s_fin">
					    <?php for($i=0;$i<60;$i++){ ?>
					    <option value="<?php echo $i ?>" <?php if($_GET[f_fecha]){ echo ($i==$hora_partida[2])?"selected='selected'":"";}else{echo ( $i==59)?"selected='selected'":""; } ?>><?php echo $i ?>
						</option>
					    <?php }?>
					  </select>
					  <!--<input name="f_fecha" type="checkbox" id="f_fecha" value="1" <?php echo $_GET[f_fecha]?"checked=\"checked\"":""; ?> />-->
		  </fieldset>
  <br />
		  <fieldset>
			  <legend style="cursor:pointer;" id="leyenda_mas" onclick="Effect.toggle('otrosCampos','Blind'); if(document.getElementById('otrosCampos').style.display!=''){document.getElementById('leyenda_mas').innerHTML='Ocultar -';}else{document.getElementById('leyenda_mas').innerHTML='Mas +';}"><?php echo $_GET[otrosCampos]?"Ocultar -":"Mas +"; ?></legend>
				  <div id="otrosCampos" style="display:<?php echo ($_GET[otrosCampos])?"":"none"; ?>;">
				    <table border="0" align="center">
				      <tr>
				        <td> Indicativo o Telefono </td>
				        <td><input name="indicativo" id="indicativo" type="text" value="<?php echo $_GET[indicativo] ?>" />        </td>
				        <td>Plan D </td>
				        <td><?php require_once('../../Connections/conexion.php'); ?>
						<?php
							mysql_select_db($database_conexion, $conexion);
							$query_planes_distribuidor = sprintf("SELECT * FROM plan_distribuidor");
							$planes_distribuidor = mysql_query($query_planes_distribuidor, $conexion) or die(mysql_error());
							$row_planes_distribuidor = mysql_fetch_assoc($planes_distribuidor);
							$totalRows_planes_distribuidor = mysql_num_rows($planes_distribuidor);
?><select name="no_plan_d" id="no_plan_d" onChange="abrir('select_distribuidores.php','','&no_plan_d='+document.getElementById('no_plan_d').options[document.getElementById('no_plan_d').selectedIndex].value,'DivDistribuidor');">
  <option value="" <?php if (!(strcmp("", "$_GET[no_plan_d]"))) {echo "selected=\"selected\"";} ?>>[todos]</option>
  <?php
do {  
?>
  <option value="<?php echo $row_planes_distribuidor['no_plan']?>"<?php if (!(strcmp($row_planes_distribuidor['no_plan'], "$_GET[no_plan_d]"))) {echo "selected=\"selected\"";} ?>><?php echo $row_planes_distribuidor['nombre']?></option>
  <?php
} while ($row_planes_distribuidor = mysql_fetch_assoc($planes_distribuidor));
  $rows = mysql_num_rows($planes_distribuidor);
  if($rows > 0) {
      mysql_data_seek($planes_distribuidor, 0);
	  $row_planes_distribuidor = mysql_fetch_assoc($planes_distribuidor);
  }
?>
</select>
<?php
mysql_free_result($planes_distribuidor);
?>
</td>
        <td>Distribuidor</td>
        <td>
<?php
$colname_distribuidores = "-1";
if (isset($_GET['no_plan_d'])) {
  $colname_distribuidores = (get_magic_quotes_gpc()) ? $_GET['no_plan_d'] : addslashes($_GET['no_plan_d']);
}
mysql_select_db($database_conexion, $conexion);
$query_distribuidores = sprintf("SELECT id_distribuidor, nombre FROM distribuidor WHERE no_plan='%s'", $colname_distribuidores);
$distribuidores = mysql_query($query_distribuidores, $conexion) or die(mysql_error());
$row_distribuidores = mysql_fetch_assoc($distribuidores);
$totalRows_distribuidores = mysql_num_rows($distribuidores);
?>

<div id="DivDistribuidor">
<?php require_once('../../Connections/conexion.php'); ?>
<?php
$colname_distribuidores = "-1";
if (isset($_GET['no_plan_d'])) {
  $colname_distribuidores = (get_magic_quotes_gpc()) ? $_GET['no_plan_d'] : addslashes($_GET['no_plan_d']);
}
mysql_select_db($database_conexion, $conexion);
$query_distribuidores = sprintf("SELECT id_distribuidor, nombre FROM distribuidor WHERE no_plan = '%s'", $colname_distribuidores);
$distribuidores = mysql_query($query_distribuidores, $conexion) or die(mysql_error());
$row_distribuidores = mysql_fetch_assoc($distribuidores);
$totalRows_distribuidores = mysql_num_rows($distribuidores);
?>


<select name="id_distribuidor" id="id_distribuidor" onChange="abrir('select_plan_c.php','','&id_distribuidor='+document.getElementById('id_distribuidor').options[document.getElementById('id_distribuidor').selectedIndex].value,'DivPlanClienteList');">
  <option value="all">[todos]</option>
  <?php
do {  
?>
  <option value="<?php echo $row_distribuidores['id_distribuidor']?>"<?php if (!(strcmp($row_distribuidores['id_distribuidor'], "$_GET[id_distribuidor]"))) {echo "selected=\"selected\"";} ?>><?php echo $row_distribuidores['nombre']?></option>
  <?php
} while ($row_distribuidores = mysql_fetch_assoc($distribuidores));
  $rows = mysql_num_rows($distribuidores);
  if($rows > 0) {
      mysql_data_seek($distribuidores, 0);
	  $row_distribuidores = mysql_fetch_assoc($distribuidores);
  }
?>
</select>


<?php
mysql_free_result($distribuidores);
?>
</div>

<?php
mysql_free_result($distribuidores);
?></td>
      </tr>
      <tr>
        <td>Plan Cliente </td>
        <td><div id="DivPlanClienteList">
				<select name="no_plan" id="no_plan" onchange="abrir('select_clientes.php','','&no_plan='+document.getElementById('no_plan').options[document.getElementById('no_plan').selectedIndex].value,'DivClienteList');">
				  <option value="all" <?php if (!(strcmp("all", "$_GET[no_plan]"))) {echo "selected=\"selected\"";} ?>>todos</option>
				  <?php
do {  
?>
				  <option value="<?php echo $row_planes_cliente['no_plan']?>"<?php if (!(strcmp($row_planes_cliente['no_plan'], $_GET[no_plan]))) {echo "selected=\"selected\"";} ?>><?php echo $row_planes_cliente['nombre']?></option>
				  <?php
} while ($row_planes_cliente = mysql_fetch_assoc($planes_cliente));
  $rows = mysql_num_rows($planes_cliente);
  if($rows > 0) {
      mysql_data_seek($planes_cliente, 0);
	  $row_planes_cliente = mysql_fetch_assoc($planes_cliente);
  }
?>
				</select></div>        </td>
        <td> Cliente </td>
        <td><div id="DivClienteList">
<?php $colname_clientes = "-1";
if (isset($_GET['no_plan'])) {
  $colname_clientes = (get_magic_quotes_gpc()) ? $_GET['no_plan'] : addslashes($_GET['no_plan']);
}
mysql_select_db($database_conexion, $conexion);
$query_clientes = sprintf("SELECT * FROM cliente WHERE no_plan = %s ORDER BY nombre ASC", $colname_clientes);
$clientes = mysql_query($query_clientes, $conexion) or die(mysql_error());
$row_clientes = mysql_fetch_assoc($clientes);
$totalRows_clientes = mysql_num_rows($clientes);
?><select name="id_cliente" id="id_cliente" onChange="abrir('select_cuentas_sip.php','','&id_cliente='+document.getElementById('id_cliente').options[document.getElementById('id_cliente').selectedIndex].value,'DivCuentaList');">
  <option value="all" <?php if (!(strcmp("all", "$_GET[id_cliente]"))) {echo "selected=\"selected\"";} ?>>[todos]</option>
  <?php
do {  
?>
  <option value="<?php echo $row_clientes['id_cliente']?>"<?php if (!(strcmp($row_clientes['id_cliente'], $_GET[id_cliente]))) {echo "selected=\"selected\"";} ?>><?php echo $row_clientes['nombre']?></option>
  <?php
} while ($row_clientes = mysql_fetch_assoc($clientes));
  $rows = mysql_num_rows($clientes);
  if($rows > 0) {
      mysql_data_seek($clientes, 0);
	  $row_clientes = mysql_fetch_assoc($clientes);
  }
?>
</select>
<?php
mysql_free_result($clientes);
?>
		  </div>        </td>
        <td>Cuenta</td>
        <td><div id="DivCuentaList"><?php
$colname_cuentas_sip = "-1";
if (isset($_GET['id_cliente'])) {
  $colname_cuentas_sip = (get_magic_quotes_gpc()) ? $_GET['id_cliente'] : addslashes($_GET['id_cliente']);
}
mysql_select_db($database_conexion, $conexion);
$query_cuentas_sip = sprintf("SELECT * FROM cuenta_sip WHERE id_cliente = %s ORDER BY id_cuenta ASC", $colname_cuentas_sip);
$cuentas_sip = mysql_query($query_cuentas_sip, $conexion) or die(mysql_error());
$row_cuentas_sip = mysql_fetch_assoc($cuentas_sip);
$totalRows_cuentas_sip = mysql_num_rows($cuentas_sip);
?>
<select name="id_cuenta" id="id_cuenta">
  <option value="todos" <?php if (!(strcmp("todos", "$_GET[id_cuenta]"))) {echo "selected=\"selected\"";} ?>>todos</option>
  <?php
do {  
?>
  <option value="<?php echo $row_cuentas_sip['id_cuenta']?>"<?php if (!(strcmp($row_cuentas_sip['id_cuenta'], "$_GET[id_cuenta]"))) {echo "selected=\"selected\"";} ?>><?php echo $row_cuentas_sip['id_cuenta']?></option>
  <?php
} while ($row_cuentas_sip = mysql_fetch_assoc($cuentas_sip));
  $rows = mysql_num_rows($cuentas_sip);
  if($rows > 0) {
      mysql_data_seek($cuentas_sip, 0);
	  $row_cuentas_sip = mysql_fetch_assoc($cuentas_sip);
  }
?>
</select>
<?php
mysql_free_result($cuentas_sip);
?></div></td>
        <td><!--<input name="f_cuenta" type="checkbox" id="f_cuenta" value="1" <?php echo $_GET[cuenta]?"checked=\"checked\"":""; ?> />--></td>
      </tr>
  			<tr>
				<td>Cantidad Llamadas</td>
				<td><input type="text" id="cantidad_llamadas" value="<?php echo $_GET[cantidad_llamadas]?$_GET[cantidad_llamadas]:100; ?>" /></td>
			</tr>	  
    </table>
  </fieldset>
  </fieldset>
  <input type="hidden" name="url_busqueda" id="url_busqueda" value="" />
  <input name="button" type="button" onclick="armar_url_busqueda_a();abrir('llamadas_a.php',' - Llamadas <?php echo $_SESSION[nombre] ?>',document.getElementById('url_busqueda').value,'content');" value="buscar" />
  
    </div>
  <table align="center" class="t_listas" width="750">
    <tr class="tr_title">
      <td width="124">Fecha</td>
      <td width="158">Telefono</td>
      <td width="159">Destino</td>
      <td width="55">Duracion</td>
      <td width="34">Valor</td>
	  <td width="41" style="color:red;">Costo D </td>
	  <td width="51" style="color:red;">Utilidad D </td>	  
	  <td width="41" style="color:#660000">Costo </td>
	  <td width="47" style="color:#660000">Utilidad</td>	  
    </tr>
    <?php 
  
	$n_llamada=0;
	$total_utilidad=0;
	$total_consumido_saldo=0;
  
  do {
  
  
  $r_trunk=mysql_query("select nombre from trunk where id_trunk='$row_llamadas[id_trunk]'",$conexion);
  $row_trunk_r=mysql_fetch_assoc($r_trunk);
  
  $r_cliente=mysql_query("select nombre from cliente where id_cliente='$row_llamadas[id_cliente]'",$conexion);
  $row_cliente_r=mysql_fetch_assoc($r_cliente);
  
  $r_distribuidor=mysql_query("select nombre from distribuidor where id_distribuidor='$row_llamadas[id_distribuidor]'",$conexion);
  $row_distribuidor_r=mysql_fetch_assoc($r_distribuidor);
  
  
  
  
   ?>
    <tr title="<?php echo "Distribuidor: $row_distribuidor_r[nombre] . Cliente: $row_cliente_r[nombre] . Cuenta: $row_llamadas[id_cuenta] . Trunk: $row_trunk_r[nombre]";?>">
      <td class="td_lista"><?php echo $row_llamadas['h_inicio']; ?></td>
      <td class="td_lista" align="center"><?php echo $row_llamadas['no_destino']; ?></td>
      <td class="td_lista"><div align="justify">
          <?php 
		  	$destino=new Destino();
			$destino->select_by_id($row_llamadas['id_indicativo'],$conexion);
	        echo utf8_decode($destino->get_destino()); ?>
      </div></td>
      <td class="td_lista" align="center"><?php echo (int)($row_llamadas['duracion']/60).":".((($row_llamadas['duracion']/60)-(int)($row_llamadas['duracion']/60))*60); 
?> </td>
      <td class="td_lista"><div align="right">
          <?php $row_llamadas['valor'];
	  echo "\$".number_format($row_llamadas[valor],$n_decimales_a,",",".");
	  $total_llamadas+=$row_llamadas[valor];
	   ?>
      </div></td>
      <td class="td_lista"><div align="right" style="color:red;">
          <?php $row_llamadas['p_costo_d'];
	  echo "\$".number_format($row_llamadas[valor_llamada_distribuidor],$n_decimales_a,",",".");
	  $total_consumido_saldo+=$row_llamadas[valor_llamada_distribuidor];
	   ?>
      </div></td>
      <td class="td_lista"><div align="right" style="color:red;">
          <?php $row_llamadas['utilidad_distribuidor'];
	  echo "\$".number_format($row_llamadas[utilidad_distribuidor],$n_decimales_a,",",".");
	  $total_utilidad+=$row_llamadas[utilidad_distribuidor];
	   ?>
      </div></td>	  	  
	  
	  <td style="color:#660000; text-align:right;">          <?php $precio_de_costo_admin=ceil($row_llamadas[duracion]/60)*$row_llamadas['p_costo'];
	  echo "\$".number_format($precio_de_costo_admin,$n_decimales_a,",",".");
	  $total_consumido_a+=$row_llamadas[p_costo];
	   ?>
	   </td>	  
	  	  <td style="color:#660000;text-align:right;">
		            <?php $row_llamadas['utilidad_administrador'];
	  echo "\$".number_format($row_llamadas[utilidad_administrador],$n_decimales_a,",",".");
	  $total_utilidad_a+=$row_llamadas[utilidad_administrador];
	   ?>
		  </td>	  
	  
    </tr>
    <?php 
			  $n_llamada++;
	} while ($row_llamadas = mysql_fetch_assoc($result_llamadas)); ?>
    <tr>
      <td colspan="4" align="right">Total</td>
      <td align="right"><?php
			echo "\$".number_format($total_llamadas,$n_decimales_a,",",".");
		?>
      </td>
      <td style="color:red;" align="right"><?php
			echo "\$".number_format($total_consumido_saldo,$n_decimales_a,",",".");
		?>
      </td>
      <td style="color:red;" align="right"><?php
			echo "\$".number_format($total_utilidad,$n_decimales_a,",",".");
		?>
      </td>	  	  
	        <td style="color:#660000;" align="right"><?php
			echo "\$".number_format($total_consumido_a,$n_decimales_a,",",".");
		?>
      </td>
      <td style="color:#660000;" align="right"><?php
			echo "\$".number_format($total_utilidad_a,$n_decimales_a,",",".");
		?>
      </td>	  	  
	      </tr>
  </table>
  <table border="0" width="50%" align="center">
    <tr>
      <td width="23%" align="center"><?php if ($pageNum > 0) { // Show if not first page ?>
          <a onclick="abrir('llamadas_a.php','Llamadas <?php echo $_SESSION[nombre] ?>','&<?php printf("pageNum=%d%s", 0, $queryString); ?>','content');"><img src="First.gif" alt="primera pagina" border="0" /></a>
          <?php } // Show if not first page ?>
      </td>
      <td width="31%" align="center"><?php if ($pageNum > 0) { // Show if not first page ?>
          <a onclick="abrir('llamadas_a.php','Llamadas <?php echo $_SESSION[nombre] ?>','&<?php printf("pageNum=%d%s", max(0, $pageNum - 1), $queryString); ?>','content');"><img src="Previous.gif" alt="pagina anterior" border="0" /></a>
          <?php } // Show if not first page ?>
      </td>
      <td width="23%" align="center"><?php if ($pageNum < $totalPages) { // Show if not last page ?>
          <a onclick="abrir('llamadas_a.php','Llamadas <?php echo $_SESSION[nombre] ?>','&<?php printf("pageNum=%d%s", min($totalPages, $pageNum + 1), $queryString); ?>','content');"><img src="Next.gif" alt="pagina siguiente" border="0" /></a>
          <?php } // Show if not last page ?>
      </td>
      <td width="23%" align="center"><?php if ($pageNum < $totalPages) { // Show if not last page ?>
			  <a onclick="abrir('llamadas_a.php','Llamadas <?php echo $_SESSION[nombre] ?>','&<?php printf("pageNum=%d%s", $totalPages, $queryString); ?>','content');"><img src="Last.gif" alt="ultima pagina" border="0" /></a>
          <?php 

		  } // Show if not last page ?>
      </td>
    </tr>
    <tr>
      <td colspan="5" align="center"> Registros <?php echo ($startRows + 1) ?> a <?php echo min($startRows + $maxRows, $totalRows) ?> de <?php echo $totalRows ?> </td>
    </tr>
    <tr>
      <td>    
    </td>
      </tr>
  </table>
  
  <table border="0" align="center">
  	<tr>
		<td align="right">
		</td>
		<td></td>
	</tr>
  	<tr>
		<td align="right">
		</td>
		<td></td>
	</tr>	
  </table>
  
<div align="center">
  <div style="width:300px;">
  	<fieldset>
		<legend id="VerMas" onclick="Effect.toggle('MasDetalles');" style="cursor:pointer;">Ver Mas</legend>
			 <div id="MasDetalles" style="display:none;">
				  <table border="0" align="center">
				  	<tr class="tr_title"><td colspan="2">
						Informacion entre <?php echo $_GET[fecha_inicial]; ?> y <?php echo $_GET[fecha_final]; ?>
						</td>
					</tr>
				  	<tr>
						<td align="right" style="color:#0000CC;">Inversion
						</td>
						<td style="color:red; font-size:14px; text-align:right">$<?php echo number_format($inversion_all,$n_decimales_a,",","."); ?></td>
					</tr>
				  	<tr >
						<td align="right" style="color:#0000CC;">
							Ganancias
						</td>
						<td style="color:red; font-size:14px; text-align:right">$
							<?php echo number_format($utilidad_all,$n_decimales_a,",","."); ?>
						</td>
					</tr>	
			  </table>
		  </div>
  </fieldset>
  </div>
 </div>
   
  <?php
mysql_free_result($result_llamadas);

mysql_free_result($planes_cliente);
?>
