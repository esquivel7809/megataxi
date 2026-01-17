<?php /*
| reporte_id  | int(11)     | NO   | PRI | NULL    | auto_increment |
| mega        | varchar(10) | NO   | MUL | NULL    |                |
| servicio_id */

	include('../Connections/conexion.php');
	include('../process/validar.php');
	include('../libraries/javascript.php');
	//print_r($_POST);
	if(!empty($_POST['RMegaTxt'])){
		//$sql_verifica="select * from vehiculo where placa='$_POST[RMegaTxt]'";
		$sql_verifica="select suspencion, frecuencia from vehiculo where placa='$_POST[RMegaTxt]'";
		 
		$result_verifica=mysql_query($sql_verifica,$conexion);
		$row_vehiculo=mysql_fetch_assoc($result_verifica);
		
		if(mysql_num_rows($result_verifica)>0){
			//if($row_vehiculo['estado']==1 && ($row_vehiculo['pago']==1 || $row_vehiculo['pago']==2) && $row_vehiculo['frecuencia']==1){
			if($row_vehiculo['suspencion']==1 && $row_vehiculo['frecuencia']==1){
				$sql_verifica_ser="select reporte_id from reporte_mega_a_servicio where mega='$_POST[RMegaTxt]' AND servicio_id='$_POST[RServicio_idTxt]'";
				$result_verifica_ser=mysql_query($sql_verifica_ser,$conexion);
				if(mysql_num_rows($result_verifica_ser)==0){
					$sql="insert into reporte_mega_a_servicio(mega,servicio_id) values('$_POST[RMegaTxt]','$_POST[RServicio_idTxt]');";
					$result=mysql_query($sql,$conexion) or die(mysql_error());	
					if(!$result){
						alert('No Se inserto el reporte correctamente');
					}
					//else{
					//echo "alert('No se pudo insertar el cosito');";
					//}
				}
			}else{
				if($row_vehiculo['suspencion']==0){
					$sqlSuspension="select suspension_mega.fecha, tipo_suspension.nombre, tipo_suspension.duracion from tipo_suspension, suspension_mega where tipo_suspension.id_tipo=suspension_mega.id_tipo and suspension_mega.vehiculo='$_POST[RMegaTxt]' order by suspension_mega.id_suspension desc limit 1";
					$resultSuspension=mysql_query($sqlSuspension,$conexion)or die(mysql_error().$sqlSuspension);
					$row_suspension=mysql_fetch_assoc($resultSuspension);	
				
					$fecha_inicio_segundos=segundos($row_suspension[fecha]);
					$vence_segundos=$fecha_inicio_segundos+($row_suspension[duracion]*3600);
					$vence=date("Y-m-d H:i:s",$vence_segundos);
					alert("El vehiculo que intenta reportar se encuentra suspendido por $row_suspension[nombre] durante $row_suspension[duracion] horas, desde $row_suspension[fecha] hasta $vence.");
				}elseif($row_vehiculo['frecuencia']==0){
					alert("El vehiculo que intenta reportar se encuentra suspendido por NO PAGO");
				}
			}
		}
		mysql_free_result($result_verifica);
	}

?>
