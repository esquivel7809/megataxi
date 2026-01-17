<style>
</style>
<?php
/*
$array_tar_fechafinal=explode("-",$datorevision_fechafinal);
$mes = $array_tar_fechafinal[1];
$mes = intval($mes);
$mes = substr($meses[$mes],0,10);
$array_datofechavencimiento=explode("/",$datofechavencimiento);
$datofechavencimiento= $array_datofechavencimiento[0]." . ".$array_datofechavencimiento[1]." . ".$array_datofechavencimiento[2];
*/
$arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
$arrayDias = array('Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado');
$fecha_actual = " ".$arrayDias[date('w')]." ".date('d')." de ".$arrayMeses[date('m')-1]." del ".date('Y');
/*
Resultado, (fecha actual 21/09/2012):
Viernes, 21 de Septiembre de 2012
*/
?>
<table border="0" class="tbl">
	<tr>
    	<td>
        	<br />
            <br />
			Ibagué,<?php echo $fecha_actual;?>
            <br />
            <br />
            Señores.<br />
            <strong>Secretaria de Transito Transporte y de la Movilidad</strong><br />
            Ciudad<br /><br />
            Por medio del presente solicito renovación de la tarjeta de operación del vehículo de servicio publico tipo taxi, identificado con las siguientes características:<br />
        </td>
    </tr>
    <tr>
    	<td>
        	<table border="1" cellpadding="2">
            	<tr><td>PLACA</td><td><?php echo $arrayDatosGeneral["placa"];?></td></tr>
                <tr><td>MARCA</td><td><?php echo $arrayDatosGeneral["nombremarcavehiculo"];?></td></tr>
                <tr><td>MODELO</td><td><?php echo $arrayDatosGeneral["nombremodelo"];?></td></tr>
                <tr><td>CLASE</td><td><?php echo $arrayDatosGeneral["nombretipovehiculo"];?></td></tr>
                <tr><td>SERVICIO</td><td><?php echo $arrayDatosGeneral["servicio"];?></td></tr>
                <tr><td>MOTOR</td><td><?php echo $arrayDatosGeneral["numeromotor"];?></td></tr>
                <tr><td>CHASIS</td><td><?php echo $arrayDatosGeneral["numerochasis"];?></td></tr>
                <tr><td>COLOR</td><td><?php echo $arrayDatosGeneral["color"];?></td></tr>
                <tr><td>N° INTERNO</td><td><?php echo $arrayDatosGeneral["numerointerno"];?></td></tr>
                <tr><td>CAPACIDAD</td><td><?php echo $arrayDatosGeneral["cantidadpasajeros"];?></td></tr>
                <tr><td>PROPIETARIO (A)</td><td><?php echo $arrayDatosGeneral["nombrecompleto"];?></td></tr>
            </table>
        </td>
    </tr>
    <tr>
    	<td>
        	<br /><br />
            Cordialmente,
            <br />
            <br />
            <br />
        </td>
    </tr>
    <tr>
    	<td align="center">
            IRAIDE GUZMAN OSPINA<br />
            Gerente<br /><br />
        </td>
    </tr>
    <tr>
    	<td>
			<p align="justify" style="font-size:10px;">Anexos: Fotocopia de licencia de Transito, Seguro Obligatorio, Revisión Tecno Mecánica Unificada, Pólizas de Responsabilidad Civil Extra y Contractual, contrato de Vinculación y pago de Impuesto de Rodamiento año <?php echo date('Y');?>.
            <br />
            <br />
            <br />
            <br />
            Copia  Archivo<br />
            </p>

        </td>
    </tr>
</table>