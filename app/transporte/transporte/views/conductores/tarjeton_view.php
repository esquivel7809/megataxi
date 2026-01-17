<?php

//print_r($datosMeses);
foreach ($datosRefrendacion as $filaDatosRefrendacion){
	$arrayPuestos[]=$filaDatosRefrendacion['puesto'];
	$arrayFechaini[$filaDatosRefrendacion['puesto']]=$filaDatosRefrendacion['fecharefrendacion'];
}
?>
<style>
.titulo-tarjeta-control, .refrendacion{
	font-size:20px;
	text-align:center;
	margin-bottom: 10px;
}
.nombre-conductor, .placa-vehiculo{
	font-size:25px;
	text-align:center;
	margin-bottom: 10px;
}
.firmas-tarjeta-control{
	width:620px;
	
}
.firmas-tarjeta-control > li{
	width:140px;
	height: 140px;
	float:left;
	border: 1px solid #52865D;
	margin-bottom: 10px;
	margin-right: 10px;
}
.firmas-tarjeta-control > li.no-refrendado:hover{
	border: 1px solid #FFF;
}
.firmas-tarjeta-control > li > p{
	width: 100%;
}
.firmas-tarjeta-control > li > p.num{
	height: 10px;
}
.firmas-tarjeta-control > li > p.fecha-fin,
.firmas-tarjeta-control > li > p.fecha-ini{
	height: 10px;
	text-align: center;
	font-size: 14px;
}
.firmas-tarjeta-control > li > p.fecha-ini{
	margin-top: 30px;
}
.firmas-tarjeta-control > li > p.fecha-fin{
	margin-top: 10px;
}

</style>

<div class="titulo-tarjeta-control">TARJETA DE CONTROL</div>
<div class="nombre-conductor"><?php echo $datosNombre." - ".$datosPlaca;?></div>
<div class="placa-vehiculo"></div>
<div class="refrendacion">REFRENDACI&Oacute;N</div>
<div>
<ul class="firmas-tarjeta-control">
<?php
$mes = date('n');
for($x=1; $x<=12; $x++){
	$fecha_final="";
	$onclick="";
	$id= $idvehiculoconductor."_".$x;
	if(in_array($x, $arrayPuestos) ){
		$class =  'class="refrendado"';
		$fecha_final = "10 ".substr($datosMeses[$x], 0, 3)." ".date('Y');
	}
	else{
		$class =  'class="no-refrendado"';
		$onclick = 'onclick="guardar_refrendacion("'.$id.'")"';
	}
	if($x < $mes || $x > $mes )
	{
		$class =  'class="refrendado"';
		$onclick="";
	}

	
	?>
	<li id="<?php echo $id;?>" <?php echo $onclick; ?> <?php echo $class; ?> >
    	<p class="num"><?php echo $x; ?></p>
        <p class="fecha-ini"><?php echo $arrayFechaini[$x]; ?></p>
        <p class="fecha-fin"><?php echo $fecha_final; ?></p>
    </li>
	<?php
}
?>
</ul>
<?php


						//inicializamos la bandera para refrendar
						$refrendar= true;
						$mensaje_final = "";
						$mensaje="";
						$mensaje_activo="";
/*
						//validamos el SOAT
						if(empty($filaDatosVehConductor['numerosoat']))
						{
							//no tiene SOAT registrado
							$mensaje.="no tiene registrado SOAT ";
							$refrendar= false;
						}
						else
						{
							if(strtotime($filaDatosVehConductor['soat_fechafinal']) <= strtotime(date('Y-m-d')))
							{
								//el SOAT esta vencido
								$mensaje.="el SOAT esta vencido ";
								$refrendar= false;
							}
						}
						//validamos el contractual
						if(empty($filaDatosVehConductor['numerocontractual'])) 
						{
							//no tiene contractual registrado
							$mensaje.="no tiene registrado seguro contractual ";
							$refrendar= false;
						}
						else
						{
							if($filaDatosVehConductor['cont_fechafinal'] <= date('Y-m-d'))
							{
								//el contractual esta vencido
								$mensaje.="el seguro contractual esta vencido ";
								$refrendar= false;
							}
						}
						//validamos el extracontractual
						if(empty($filaDatosVehConductor['numeroextracontractual']))  
						{
							//no tiene extracontractual registrado
							$mensaje.="no tiene registrado seguro extracontractual ";
							$refrendar= false;
						}
						else
						{
							if($filaDatosVehConductor['extra_fechafinal'] <= date('Y-m-d'))
							{
								//el extracontractual esta vencido
								$mensaje.="el seguro extracontractual esta vencido ";
								$refrendar= false;
							}
						}
						//validamos el revision
						if(empty($filaDatosVehConductor['numerorevision']))   
						{
							//no tiene revision registrado
							$mensaje.="no tiene registrado revision tecnicomecanica ";
							$refrendar= false;
						}
						else
						{
							if($filaDatosVehConductor['revi_fechafinal'] <= date('Y-m-d'))
							{
								//el revision esta vencido
								$mensaje.="la revision tecnico-mecanica esta vencida ";
								$refrendar= false;
							}
						}
*/

?>