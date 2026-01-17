<?php
include('conexion.php');   

if (isset($_POST['fechaini'])) {
$fechaini = $_POST['fechaini'];
$fechafin = $_POST['fechafin'];

    $queryconsulta = "SELECT numerodocumento,nombrecompleto,telefonofijo,celular,numerolicenciaconductor,fechaexpedicion,fechavencimiento 
FROM conductor, licenciaconductor where conductor.idconductor=licenciaconductor.idconductor and licenciaconductor.fechavencimiento>='$fechaini' and licenciaconductor.fechavencimiento<='$fechafin' order by licenciaconductor.fechavencimiento"; 
    $result = mysql_query($queryconsulta); 


$mostrar='
<center>
<table border="2" width="700">
	<tbody>
		<tr>
			<td>Cedula</td>
			<td>Nombre completo</td>
			<td>Celular</td>
			<td>Fecha_vencimiento</td>
		</tr>
		<tr>
<center>';

	while ($array = mysql_fetch_array($result)){  
	$cedula = "$array[numerodocumento]";
	$nombre = "$array[nombrecompleto]";
	$celular = "$array[celular]";
	$fecha = "$array[fechavencimiento]";
		echo $mostrararray='
		<center>
		<table>
		<tr>
			<td><input type="text"  disabled size="" value="'.$cedula.'"></td>
			<td><input type="text"  disabled size="" value="'.$nombre.'"></td>
			<td><input type="text"  disabled size="" value="'.$celular.'"></td>
			
			<td><input type="text"  disabled size="" value="'.$fecha.'"></td>
		</tr>
		</tbody>
		</table>
		</center>';
	} // while

}
else
	echo "<center>Debe introducir fecha inicial y final</center>";

?>