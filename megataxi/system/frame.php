<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<script language="javascript">
			//Variables Globales para refresco autom�tico de algunas partes de la patalla.
			var LastClients, LastServices; 
        </script>
        <script language="javascript" src="../js/scriptaculous-js-1.8.2/lib/prototype.js" type="text/javascript"></script>
        <script language="javascript" src="../js/scriptaculous-js-1.8.2/src/scriptaculous.js" type="text/javascript"></script>
        <script language="javascript" src="../js/shortcut.js" type="text/javascript"></script>
        <script language="javascript" src="../js/config_shortcuts.js" type="text/javascript"></script>
        <script language="javascript" src="../js/libreria.js" type="text/javascript"></script>
        <script language="javascript" src="../js/ajax.js" type="text/javascript"></script>
		<script language="javascript" src="../js/move.js" type="text/javascript"></script>
        <script src="../js/jscalendar-1.0/calendar.js" type="text/javascript"></script>
        <script src="../js/jscalendar-1.0/calendar-setup.js" type="text/javascript"></script>
        <script src="../js/jscalendar-1.0/lang/calendar-es.js" type="text/javascript"></script>
        <script src="../js/reloj.js" type="text/javascript"></script>
		<script type="text/javascript">
		window.onload=carga;
		</script>
        <?php
	//error_reporting(E_ALL);
	

	// SUSPENDIDOS
        //se consultan los megas suspendidos
        //$sql_suspendidos="SELECT placa, suspencion, frecuencia FROM vehiculo WHERE frecuencia='0' OR suspencion='0'";
	$sql_suspendidos="SELECT v.placa, v.frecuencia, v.suspencion, ts.nombre FROM vehiculo AS v INNER JOIN suspension_mega AS sm ON sm.vehiculo = v.placa INNER JOIN tipo_suspension AS ts ON ts.id_tipo = sm.id_tipo WHERE ( v.frecuencia='1' AND v.suspencion =  '0' AND sm.activo = '1' ) GROUP BY sm.vehiculo, sm.id_suspension ORDER BY sm.vehiculo DESC , sm.id_suspension DESC ";
        
	//se ejecuta la consulta
        $suspendidos=mysql_query($sql_suspendidos,$conexion)or die("Error en: $sql_suspendidos: " . mysql_error());
	
	// se prepara la salida de html para los suspendidos
        $javascript="<script language='javascript'>";
        $javascript.="var suspendidos=new Array();\n
                var causaSuspension=new Array();\n";
        $i=0;
        while($row_suspendidos=mysql_fetch_array($suspendidos)){
            $javascript.="suspendidos[$i]='$row_suspendidos[placa]';\n";
	    if($row_suspendidos["suspencion"]==0){
		$javascript.="causaSuspension[$i]='$row_suspendidos[nombre]';\n";
	    }else if($row_suspendidos["frecuencia"]==0){
		$javascript.="causaSuspension[$i]='Suspendido por pago';\n";
	    }
        
            //$javascript.="causaSuspension[$i]='$row_suspendidos[nombre]';\n";
            //$mensaje="";
        
            $i++;
	}
	//FIN SUSPENDIDOS

        //se consultan los megas que esten al dia con la frecuencia y que no tengan ninguna suspencion
        $sql_nosuspendidos="SELECT placa FROM vehiculo WHERE frecuencia='1' AND suspencion='1'";
        $NoSuspendidos=mysql_query($sql_nosuspendidos,$conexion);
        
       

/*      
  
        $javascript="<script language='javascript'>";
        $javascript.="var suspendidos=new Array();\n
                var causaSuspension=new Array();\n";
        $i=0;
        while($row_suspendidos=mysql_fetch_assoc($suspendidos)){
            $javascript.="suspendidos[$i]='$row_suspendidos[placa]';\n";
        
            //if($row_suspendidos[pago]!=0){
            if($row_suspendidos["suspencion"]==0){
                $sqlCausa="select suspension_mega.*, tipo_suspension.duracion, tipo_suspension.nombre from suspension_mega, tipo_suspension where tipo_suspension.id_tipo=suspension_mega.id_tipo and suspension_mega.vehiculo='$row_suspendidos[placa]' order by suspension_mega.id_suspension desc limit 0,1";
                $resultCausa=mysql_query($sqlCausa,$conexion);
                $row_causa=mysql_fetch_assoc($resultCausa);
                
                $mensaje="'El mega se encuentra suspendido por $row_causa[nombre], desde $row_causa[fecha] durante $row_causa[duracion] horas';\n";
        
                //$javascript.="causaSuspension[$i]='El mega se encuentra suspendido por $row_causa[nombre], desde $row_causa[fecha] durante $row_causa[duracion] horas';\n";
            //}else{
            }else if($row_suspendidos["frecuencia"]==0){
                $mensaje.="' Mega suspendido por pago';\n";
                //$javascript.="causaSuspension[$i]='El mega se encuentra suspendido por pago';\n";
        
            }
            $javascript.="causaSuspension[$i]=$mensaje";
            $mensaje="";
        
            $i++;
        }
  */    
        $javascript1=""; 
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
		<!-- Bootstrap css -->
		<link href="../css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body  onload="muestraReloj();<?php if($page=='registro.php'){ echo "seleccionar_fila('servicios','1');"; }?>">
        <div id="banner">
            <div id="menu_top_left">
                <?php if($_SESSION['datos']->perfil==1){include('menu_admin.php'); }else if($_SESSION['datos']->perfil==2){include('menu_operadora.php'); }?>
            </div>
            <div id="img_banner" style="display:none;">
                <img src="../images/logo.png" alt="Banner" />
                <!-- <div align="left">		
                <span id="spanreloj" style="position:absolute;left:10;top:10;"></span> 
                </div>-->
            </div>
        </div>
        <div class="clear"></div>
        <div id="wrap" class="container-fluid">
			
				<!--<div id="content_">-->
						<?php include($page); ?>
				<!--</div>-->
			
        </div>
        
        <div id="footer">
            Soporte T&eacute;cnico: <a href="http://www.jossof.com" target="_blank">www.jossof.com</a>
        </div>
        <iframe name="IFrameProcess" id="IFrameProcess" style="display:none;"></iframe>
        <div id="DivProcess" style="display:none;"></div>
        <div id="EditBackground" style="display:none;"></div>
        
		<div id="DivEdicion" style="display:none;">
            <div align="right"><img src="../images/closelabel.gif" onclick="cerrar_edicion();" style="cursor:pointer;" /></div>
            <div id="acciones"></div>
            <div id="Edicion"></div>
        </div>
		<div id="DivEdicion_1" style="display:none; top:100px; left:100px; position:absolute; background-color:#FF0000; color:#000000;" onmousedown="comienzoMovimiento(event, this.id);" >
            <div align="right"><img src="../images/closelabel.gif" onclick="cerrar_edicion();" style="cursor:pointer;" /></div>
            <div id="acciones"></div>
            <div id="Edicion_1"></div>
        </div>

        <script language="javascript">
        /*
            if(buscar_en_array(suspendidos,'fcd19a'))
                alert('lo encontr�');
            else
                alert('no lo encontro');
        */
        // revert
        // constrain direction and give a handle
        //new Draggable('DivEdicion',{ revert: true, snap: [40, 40] });
        </script>
		<!-- Bootstrap js -->
		<!--<script src="../css/bootstrap/js/bootstrap.min.js"></script>-->
		
        <input name="nombre_p_actual" id="nombre_p_actual" type="hidden" value="" />
        <input name="num_p_actual" id="num_p_actual" type="hidden" value="" />
        <input name="total_servicios" id="total_servicios" type="hidden" value="" />
        <input name="id_meg_repo" id="id_meg_repo" type="hidden" value="" size="50" />
    </body>
</html>
