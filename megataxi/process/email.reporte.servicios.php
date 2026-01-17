<?php
	include('../Connections/conexion.php');
	include('../process/validar.php');
   //incluimos la libreria para el envio de email
   include("../libraries/phpmailer/class.phpmailer.php");

	//$_SESSION[datos]->id_usuario=21;
	//$_SESSION[datos]->perfil=2;
	if($_SESSION[datos]->perfil==2){

		$depuracion="";

		## SQL QUE SELECCIONA EL ULTIMO TURNO ABIERTO POR EL USUARIO
		$sql_turno="select * from turno where id_usuario='".$_SESSION[datos]->id_usuario."' order by id_turno desc";

		$depuracion.="<br><br> El sql del turno $sql_turno<br>";

		$result_turno=mysql_query($sql_turno,$conexion)or die(mysql_error());
		//$row_turno=mysql_fetch_assoc($result_turno);
		$row_turno=mysql_fetch_assoc($result_turno);
		$array_Row_turno = split(" ",$row_turno["inicio"]);
		$hora_Inicio_Turno =$array_Row_turno[1];  
		$fecha_Inicio_Turno =$array_Row_turno[0];
		
		$ahora=date("Y-m-d H:i:s");
		$ahora1=date("H:i:s");
		$titulo_Reporte = "De ".$_SESSION[datos]->nombre." del ".$fecha_Inicio_Turno." desde las ".$hora_Inicio_Turno." hasta ".$ahora1;
		## SQL QUE CIERRA EL TURNO DEL USUARIO BASADO EN REGISTRO DEL TURNO ABIERTO.
		$sql_cierre_turno="update turno set fin='".$ahora."' where id_turno='$row_turno[id_turno]'";

		$depuracion.="Sql del cierre del turno = $sql_cierre_turno<br>";		

		$result_cierre_turno=mysql_query($sql_cierre_turno,$conexion)or die(mysql_error());
		
		##SQL QUE CUENTA LOS SERVICIOS TOTALES DEL TURNO DEL USUARIO
		$sql_count_servicios="select count(*) as cantidad from servicio where dt_llamada between '$row_turno[inicio]' and '$ahora' and id_usuario='".$_SESSION[datos]->id_usuario."'";
		$result_count_servicios=mysql_query($sql_count_servicios,$conexion)or die(mysql_error());

		$depuracion.="cuenta servicios totales de usuario = $sql_count_servicios<br>";		

		$row_cantidad=mysql_fetch_assoc($result_count_servicios);
		
		##SQL QUE CUENTA LOS SERVICIOS QUE FUERON CANCELADOS
		
		$sql_count_servicios_c="select count(*) as cantidad from servicio where dt_llamada between '$row_turno[inicio]' and '$ahora' and id_usuario='".$_SESSION[datos]->id_usuario."' and estado=3";
		$result_servicios_c=mysql_query($sql_count_servicios_c,$conexion)or die(mysql_error());
		$row_cancelados=mysql_fetch_assoc($result_servicios_c);
	

		$depuracion.="Sql cuenta servicios cancelados = $sql_count_servicios_c<br>";


		##SQL QUE CUENTA LOS SERVICIOS QUE FUERON CANCELADOS
		
		$sql_count_servicios_pendientes="select count(*) as cantidad from servicio where dt_llamada between '$row_turno[inicio]' and '$ahora' and id_usuario='".$_SESSION[datos]->id_usuario."' and estado=1";

		$depuracion.="Sql que cuenta servicios pendientes = $sql_count_servicios_pendientes<br>";


		$result_servicios_pendientes=mysql_query($sql_count_servicios_pendientes,$conexion)or die(mysql_error());
		$row_pendientes=mysql_fetch_assoc($result_servicios_pendientes);


		##SQL QUE CUENTA LOS SERVICIOS QUE FUERON CANCELADOS
		
		$sql_count_servicios_prestados="select count(*) as cantidad from servicio where dt_llamada between '$row_turno[inicio]' and '$ahora' and id_usuario='".$_SESSION[datos]->id_usuario."' and estado=2";

		$depuracion.="sql servicios prestados = $sql_count_servicios_prestados<br>";

		$result_servicios_prestados=mysql_query($sql_count_servicios_prestados,$conexion)or die(mysql_error());
		$row_prestados=mysql_fetch_assoc($result_servicios_prestados);
		

		##SQL QUE CUENTA LOS SERVICIOS QUE FUERON PEDIDOS AUTOMï¿½TICAMENTE
		
		$sql_count_servicios_automaticos="select count(*) as cantidad from servicio where dt_llamada between '$row_turno[inicio]' and '$ahora' and id_usuario='".$_SESSION[datos]->id_usuario."' and automatico=1";

		$depuracion.="sql servicios automaticos = $sql_count_servicios_automaticos<br>";

		$result_servicios_automaticos=mysql_query($sql_count_servicios_automaticos,$conexion)or die(mysql_error());
		$row_automaticos=mysql_fetch_assoc($result_servicios_automaticos);		

		##SQL QUE CUENTA LOS SERVICIOS QUE FUERON PEDIDOS NORMALMENTE
		
		$sql_count_servicios_normales="select count(*) as cantidad from servicio where dt_llamada between '$row_turno[inicio]' and '$ahora' and id_usuario='".$_SESSION[datos]->id_usuario."' and automatico=0";
		
		$depuracion.="sql servicios normales = $sql_count_servicios_normales<br>";
		
		$result_servicios_normales=mysql_query($sql_count_servicios_normales,$conexion)or die(mysql_error());
		$row_normales=mysql_fetch_assoc($result_servicios_normales);
		
		
		##SQL QUE CONSULTA TODOS LOS SERVICIOS
		
		$sql_servicios="select * from servicio where dt_llamada between '$row_turno[inicio]' and '$ahora' and id_usuario='".$_SESSION[datos]->id_usuario."'";
		$result_servicios=mysql_query($sql_servicios,$conexion)or die(mysql_error());
		

		$depuracion.="sql que saca todos los servicios $sql_servicios<br>";

		#CODIGO PARA CREAR LA TABLA DE LOS SERVICIOS EN UNA VARIABLE
		
		
		$tabla_todos="
			<h1>".$titulo_Reporte."</h1>
			<table border='1' align='center'>";
		$tabla_todos.="<tr>
							<td>TELEFONO</td>
							<td>VEHICULO</td>
							<td>ESTADO SERVICIO</td>
							<td>HORA LLAMADA</td>
							<td>HORA SERVICIO</td>
							<td>USUARIO</td>
							<td>TIPO SERVICIO</td>
							<td>DESCRIPCION</td>
							<td>AUTOMATICO</td>
		</tr>";
		while($row_servicios=mysql_fetch_assoc($result_servicios)){

			$sql_estado_servicio="select * from estado_servicio where estado_id='$row_servicios[estado]'";
			$result_estado_servicio=mysql_query($sql_estado_servicio,$conexion)or die(mysql_error());
			$row_estado_servicio=mysql_fetch_assoc($result_estado_servicio);

			$tabla_todos.="<tr>
								<td>$row_servicios[telefono]</td>
								<td>$row_servicios[mega]</td>
								<td>$row_estado_servicio[nombre]</td>
								<td>$row_servicios[dt_llamada]</td>
								<td>$row_servicios[dt_recogida]</td>
								<td>".$_SESSION[datos]->nombre."</td>
								<td>".(($row_servicios[tipo_servicio]==1)?"TAXI":(($row_servicios[tipo_servicio]==2)?"DOMICILIO":"CAMIONETA"))."</td>
								<td>$row_servicios[descripcion]</td>
								<td>".($row_servicios[automatico]?"SI":"NO")."</td>								


							</tr>
			";
		}
		
		$tabla_todos.="</table>";
		
		$tabla_resumen="
			<h1>Resumen</h1>
			<table border='1' align='center'>";
		
		$tabla_resumen.="
			<tr>
				<td>Total Servicios</td>
				<td>$row_cantidad[cantidad]</td>
			</tr>
			<tr>
				<td>Total Prestados</td>
				<td>$row_prestados[cantidad]</td>
			</tr>			
			<tr>
				<td>Total Pendientes</td>
				<td>$row_pendientes[cantidad]</td>
			</tr>			
			<tr>
				<td>Total Cancelados</td>
				<td>$row_cancelados[cantidad]</td>
			</tr>			
			<tr>
				<td>Total Autom&aacute;ticos</td>
				<td>$row_automaticos[cantidad]</td>
			</tr>			
                        <tr>
                                <td>Total Normales</td>
                                <td>$row_normales[cantidad]</td>
                        </tr>
			
		</table>
			
			";
			
		//echo $texto=$tabla_todos.$tabla_resumen;
		//echo $tabla_resumen;

		//$to      = "Iraide Guzman <gerenciamegataxiibague@hotmail.com>, Rombetan <rombetan@hotmail.com>";
		//$to      = "Ròmulo Betancourt <rombetan@hotmail.com>, Rombetan <rombetan@hotmail.com>";
		$to      = "Jossof <info@jossof.com>";
		$subject = $titulo_Reporte;
		$message = $tabla_resumen;
		/*
		$headers = 'From: webmaster@example.com' . "\r\n" .
			'Reply-To: webmaster@example.com' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		*/
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: rombetan@hotmail.com' . "\r\n";
		//$headers .= 'Cc: rombetan@hotmail.com ' . "\r\n";
		//$headers .= 'Reply-To: info@jossof.com' . "\r\n";
		//$headers .= 'X-Mailer: PHP/' . phpversion();
/*
		if(mail($to, $subject, $message, $headers)){
			echo true;
			}else{
			echo false;
			}
*/			
			//echo  phpinfo();
/*		
		$mail = new PHPMailer();
		$mail->SMTPDebug = 1;
		$mail->IsSMTP();  // telling the class to use SMTP
		$mail->IsHTML(true);
		$mail->SMTPAuth   = true;                // enable SMTP authentication
		$mail->SMTPSecure ="ssl";
		$mail->Port       = 465;                  // set the SMTP port
		$mail->Host       = "smtp.gmail.com"; // SMTP server
		$mail->Username   = "rombetan@hotmail.com"; // SMTP account username
		$mail->Password   = "";     // SMTP account password
		$mail->From = "rombetan@hotmail.com";
		$mail->FromName = "Megataxi Reporte de Servicios";
		$mail->Subject = $titulo_Reporte;
		$mail->AddAddress("rombetan@hotmail.com", "Jorge Serrano");
		$mail->AddAddress("gerenciamegataxiibague@hotmail.com", "Gerencia Megataxi Ltda");
		//$mail->AddAddress("megataxi21@hotmail.com", "Iraide Guzman");
		#$mail->Body = wordwrap($msg , 200);
		$mail->Body = $texto;
		/*
		if(!$mail->Send())
		{
			echo "No se pudo enviar. <p>";
			echo "Mailer Error: " . $mail->ErrorInfo;
			$mail->ClearAllRecipients ();
			$mail->ClearReplyTos ();
			exit;
		}
		else
		{
			echo "Mensaje enviado con exito";
		}
*/
	
	}
