<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script language="javascript">
//Variables Globales para refresco automático de algunas partes de la patalla.

var LastClients, LastServices;


</script>

<script language="javascript" src="../js/scriptaculous-js-1.8.2/lib/prototype.js" type="text/javascript"></script>
<script language="javascript" src="../js/scriptaculous-js-1.8.2/src/scriptaculous.js" type="text/javascript"></script>

<script language="javascript" src="../js/shortcut.js" type="text/javascript"></script>
<script language="javascript" src="../js/config_shortcuts.js" type="text/javascript"></script>
<script language="javascript" src="../js/libreria.js" type="text/javascript"></script>
<script language="javascript" src="../js/ajax.js" type="text/javascript"></script>
<script src="../js/jscalendar-1.0/calendar.js" type="text/javascript"></script>
<script src="../js/jscalendar-1.0/calendar-setup.js" type="text/javascript"></script>
<script src="../js/jscalendar-1.0/lang/calendar-es.js" type="text/javascript"></script>
<script src="../js/reloj.js" type="text/javascript"></script>
<?php

$SuspendidosSql="select placa, pago from vehiculo, estado_vehiculo where vehiculo.estado=estado_vehiculo.id_estado and (estado_vehiculo.nombre='SUSPENDIDO' or estado_vehiculo.nombre='NO PAGO' or vehiculo.pago='0')";
$suspendidos=mysql_query($SuspendidosSql,$conexion);

$NoSuspendidosSql="select placa from vehiculo, estado_vehiculo where vehiculo.estado=estado_vehiculo.id_estado and estado_vehiculo.nombre!='SUSPENDIDO' and estado_vehiculo.nombre!='NO PAGO' and vehiculo.pago!='0'";
$NoSuspendidos=mysql_query($NoSuspendidosSql,$conexion);

$javascript="<script language='javascript'>";
$javascript.="var suspendidos=new Array();\n
		var causaSuspension=new Array();\n";
$i=0;
while($row_suspendidos=mysql_fetch_assoc($suspendidos)){
	$javascript.="suspendidos[$i]='$row_suspendidos[placa]';\n";

	if($row_suspendidos[pago]!=0){
		$sqlCausa="select suspension_mega.*, tipo_suspension.duracion, tipo_suspension.nombre from suspension_mega, tipo_suspension where tipo_suspension.id_tipo=suspension_mega.id_tipo and suspension_mega.vehiculo='$row_suspendidos[placa]' order by suspension_mega.id_suspension desc limit 1";
		$resultCausa=mysql_query($sqlCausa,$conexion);
		$row_causa=mysql_fetch_assoc($resultCausa);

		$javascript.="causaSuspension[$i]='El mega se encuentra suspendido por $row_causa[nombre], desde $row_causa[fecha] durante $row_causa[duracion] horas';\n";
	}else{
		$javascript.="causaSuspension[$i]='El mega se encuentra suspendido por pago';\n";

	}

	$i++;
}


$javascript1.="\n\n\n var NoSuspendidos=new Array();\n";
$i=0;
while($row_NoSuspendidos=mysql_fetch_assoc($NoSuspendidos)){
	$javascript1.="NoSuspendidos[$i]='$row_NoSuspendidos[placa]';\n";
	$i++;
}



$javascript.=$javascript1;
$javascript.="</script>";

echo $javascript;
 ?>



<link href="../css/style.css" rel="stylesheet" media="screen" type="text/css" />
<!--[if IE 6]>
	<link href="../css/styleIE6.css" rel="stylesheet" media="screen" type="text/css" />
<![endif]-->
<link href="../css/menu.css" rel="stylesheet" media="screen" type="text/css" />

<style type="text/css">@import url("../js/jscalendar-1.0/calendar-win2k-cold-1.css");</style>



<script language="javascript">

shortcut.add("Ctrl+Shift+X",function() {
	alert("Hi there!");
});

</script>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $titulo ?></title>
</head>
<body  onload="muestraReloj();<?php if($page=='registro.php'){ echo "seleccionar_fila('servicios','10');"; }?>">

<div id="banner">
	<div id="menu_top_left">
		<?php if($_SESSION[datos]->perfil==1){include('menu_admin.php'); }else if($_SESSION[datos]->perfil==2){include('menu_operadora.php'); }?>
	</div>
	<div id="img_banner">
		<img src="../images/banner.jpg" alt="Banner" /><br />
<div align="left">		
<span id="spanreloj" style="position:absolute;left:10;top:10;"></span>
</div>
	</div>
</div>

<div id="wrap">
	<div id="content">
	    	<?php include($page); ?>
	</div>
</div>
	<div id="footer">
		Dise&ntilde;ado por: <a href="http://www.fcosystems.com">www.fcosystems.com</a>	<br />
		Tecnolog&iacute;a y Soluciones a su Alcance	</div>

<iframe name="IFrameProcess" id="IFrameProcess" style="display:none;">
</iframe>
<div id="DivProcess" style="display:none;">
</div>

<div id="EditBackground" style="display:none;">
</div>

<div id="DivEdicion" style="display:none;">
	<div align="right"><img src="../images/closelabel.gif" onclick="cerrar_edicion();" style="cursor:pointer;" /></div>
	<div id="acciones"></div>
	<div id="Edicion"></div>
</div>

<script language="javascript">
/*
	if(buscar_en_array(suspendidos,'fcd19a'))
		alert('lo encontró');
	else
		alert('no lo encontro');
	

*/



// revert
// constrain direction and give a handle
//new Draggable('DivEdicion',{ revert: true, snap: [40, 40] });
</script>
<input name="nombre_p_actual" id="nombre_p_actual" type="hidden" value="" />
<input name="num_p_actual" id="num_p_actual" type="hidden" value="" />


</body>
</html>
