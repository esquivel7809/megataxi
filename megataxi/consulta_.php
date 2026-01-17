#!/usr/bin/php -f
<?php
   # Conectar a mysql
   $link = conectar();
   //incluimos la libreria para el envio de email
   include("libraries/phpmailer/class.phpmailer.php");

   //obtenemos la fecha actual
   $fecha_actual = date("F j, Y, g:i a");
   //$fecha_actual = date('Y-m-d H:i:s');
   //$fecha_actual = "2013-05-13";

   $msg="<H2> Megataxi - Reporte total de servicios </H2>";
   $msg.="<table border='0'>";
   $msg.="<tr><td>Fecha</td><td>".$fecha_actual ."</td></tr>";

   #Totalizar los servicios automaticos del dia
   //$sql_automatico="SELECT count(*) AS total FROM servicio
   //                          WHERE estado = 2 AND DATE(dt_llamada) = CURDATE()
   //                            AND automatico = 1";

   $sql_automatico="SELECT count(*) as total, u.nombre, s.id_usuario
                FROM servicio AS s
                INNER JOIN usuario AS u ON u.id_usuario= s.id_usuario
                WHERE s.estado = 2 AND DATE(s.dt_llamada) = CURDATE() AND s.automatico =1
                GROUP BY s.id_usuario";

   $consulta_auto = mysql_query($sql_automatico,$link);

   //$fila = mysql_fetch_row($consulta_auto);
   //$total_automaticos = $fila[0];

   $msg.="<tr><td colspan='2'>AUTOMATICOS</td></tr>";
   while($row_consulta_auto=mysql_fetch_assoc($consulta_auto))
   {
      $msg.="<tr><td>".$row_consulta_auto["nombre"]."</td><td>".$row_consulta_auto["total"]."</td></tr>";
      //$array_ser[$row_consulta_auto["id_usuario"]]["auto"]=$row_consulta_auto["total"];
      $total_automaticos +=$row_consulta_auto["total"];

   }

   # Totalizar los servicios normales del dia
   //$sql_normal="SELECT count(*) AS total FROM servicio
   //                          WHERE estado = 2 AND DATE(dt_llamada) = CURDATE()
   //                            AND automatico = 0";

   $sql_normal="SELECT count(*) as total, u.nombre
                FROM servicio AS s
                INNER JOIN usuario AS u ON u.id_usuario= s.id_usuario
                WHERE s.estado = 2 AND DATE(s.dt_llamada) = CURDATE() AND s.automatico =0
                GROUP BY s.id_usuario";

   $consulta_normal = mysql_query($sql_normal,$link);

   $msg.="<tr><td colspan='2'>&nbsp</td></tr>";
   $msg.="<tr><td colspan='2'>NORMALES</td></tr>";
   while($row_consulta_normal=mysql_fetch_assoc($consulta_normal))
   {
      $msg.="<tr><td>".$row_consulta_normal["nombre"]."</td><td>".$row_consulta_normal["total"]."</td></tr>";
      //$array_ser[$row_consulta_normal["id_usuario"]]["normal"]=$row_consulta_normal["total"];
      $total_normales +=$row_consulta_normal["total"]; 

   }
   
   //$fila2 = mysql_fetch_row($consulta_normal);
   //$total_normales = $fila2[0];

   $gran_total = $total_automaticos + $total_normales;
   $porcentaje_automaticos=0;
   $porcentaje_normales=0;

   if($gran_total!=0)
   {
      $porcentaje_automaticos = round(( $total_automaticos / $gran_total ) * 100 );
      $porcentaje_normales    = round(( $total_normales /  $gran_total ) * 100 );
   }
  
   $msg.="<tr><td colspan='2'>&nbsp</td></tr>";
   $msg.="<tr><td>Total Servicios Automaticos</td><td>".$total_automaticos ." - ". $porcentaje_automaticos ."%</td></tr>";
   $msg.="<tr><td>Total Servicios Normales</td><td>".$total_normales ." - ". $porcentaje_normales ."%</td></tr>"; 
   $msg.="<tr><td>Gran Total</td><td>".$gran_total ."</td></tr>";
   $msg.="</table><br />";
   $msg.="<table border='1'>";

   $msg.="<tr><td colspan='8'>RECORDATORIOS</td></tr>";
   $msg.="<tr><td>Telefono</td>";
   $msg.="<td>Descripcion</td>";
   $msg.="<td>Solicitado</td>";
   $msg.="<td>Hora</td>";
   $msg.="<td>Estado</td>";
   $msg.="<td>Operadora Lanzo</td>";
   $msg.="<td>Mega Recogio</td>";
   $msg.="<td>Hora</td></tr>";



   $sql_recordatorio="SELECT *  FROM recordatorio WHERE DATE(timestamp) = CURDATE() ";
   $consulta_recordatorio = mysql_query($sql_recordatorio,$link);

   $array_est[1]="Pendiente";
   $array_est[2]="Ejecutado";
   $array_est[3]="Cancelado";
   $array_est[0]="Borrado";


   while($row_consulta_recordatorio=mysql_fetch_assoc($consulta_recordatorio))
   {
      $sql_ser_rec="SELECT s.mega, s.dt_recogida, u.nombre
                    FROM servicio AS s 
                    INNER JOIN usuario AS u ON u.id_usuario=s.id_usuario
                    WHERE s.telefono ='".$row_consulta_recordatorio["telefono"]."' AND DATE(s.dt_llamada) = CURDATE() ";
      $consulta_ser_rec = mysql_query($sql_ser_rec,$link);
      $row_ser_rec = mysql_fetch_row($consulta_ser_rec);

      $msg.="<tr><td>".$row_consulta_recordatorio["telefono"]."</td>
                 <td>".$row_consulta_recordatorio["descripcion"]."</td>
                 <td>".$row_consulta_recordatorio["timestamp"]."</td>
                 <td>".$row_consulta_recordatorio["hora"]."</td>
                 <td>".$array_est[$row_consulta_recordatorio["estado"]]."</td>
                 <td>".$row_ser_rec[2]."</td>
                 <td>".$row_ser_rec[0]."</td>
                 <td>".$row_ser_rec[1]."</td></tr>";

   }

   $msg.="</table>";

//Cerrar conexion mysql
 mysql_close ($link);


            $mail = new PHPMailer();
            $mail->SMTPDebug = 1;
            $mail->IsSMTP();  // telling the class to use SMTP
            $mail->IsHTML(true);
            $mail->SMTPAuth   = true;                // enable SMTP authentication
            $mail->SMTPSecure ="ssl";
            $mail->Port       = 465;                  // set the SMTP port
            $mail->Host       = "smtp.gmail.com"; // SMTP server
            $mail->Username   = "jorgesoftware2005@gmail.com"; // SMTP account username
            $mail->Password   = "juan26saian";     // SMTP account password
            $mail->From = "jorgesoftware2005@gmail.com";
            $mail->FromName = "Megataxi - Central Telefonica";
            $mail->Subject = "Reporte Total de Servicios ".$fecha_actual;
	    	$mail->AddAddress("jorge_software2005@hotmail.com", "Jorge Serrano");
            //$mail->AddAddress("megataxi21@hotmail.com", "Iraide Guzman");
            $mail->Body = wordwrap($msg , 200);

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
		
###########################################################


function conectar()
{
 # Conectar con la base de datos
 $link = mysql_connect("localhost", "usermegataxi","user21megataxi")
            or die("Error Conectando la base de datos\n");
 mysql_select_db("megataxi", $link)
            or die("Error Seleccionando la base de datos..\n");
 return $link;
}

?>
