<html> 

<head> 
<title>imprime tarjeta de control</title> 
<META name='robot' content='noindex, nofollow'> 
</head> 
<body>
<br>
<br>
<br>
<br><br>
<?php  
$id = $_POST['cedula']; 
$placa = $_POST['placa']; 

include('conexion.php');   
 
    $query = "select * from vehiculo,revision,soat where placa = '$placa' and (vehiculo.idvehiculo = revision.idvehiculo) and (vehiculo.idvehiculo = soat.idvehiculo) order by placa desc limit 1"; 
    $result = mysql_query($query); 

while ($registro = mysql_fetch_array($result)){  

$query1 = "select * from vehiculo,revision,soat where placa = '$placa' and (vehiculo.idvehiculo = revision.idvehiculo) and (vehiculo.idvehiculo = soat.idvehiculo) order by placa desc limit 1"; 
$result1 = mysql_fetch_row($query1); 
$cedula=$registro["numerodocumento"];
$imagen=$registro["rutafoto"];
$nombre=$registro["nombrecompleto"];
$placa1=$registro1["placa"];
$interno=$registro["numerointerno"];
echo $interno;
$revision=$registro1["numerorevision"];
$licencia=$registro["fechavencimiento"];
$vtorevision=$registro1["fechafinal"];
$vtosoat=$registro1["fechafinal"];
$eps=$registro["idsalud"];
$sangre=$registro["nombregruposanguineo"];
$arl=$registro["idarl"];
$pension=$registro["idpension"];
$empresa="COOPERATIVA MEGATAXI LTDA";
$nit="800204096-5";
?>
<table width="100%" height="670" border="0" align="center">
  <tr>
    <td width="13%" height="33"></td>
    <td  align="center"colspan="2"><h1><strong><? echo $cedula; ?></strong></h1></td>
    <td width="20%">&nbsp;</td>
  </tr>
  
  <tr>
    <td rowspan="3" align="left" valign="middle"><? echo '<img height="120" border="0" width="100" src="'.$registro['rutafoto'].'"></img>'; ?></td>
    <td height="57" colspan="3" align="center"><h3><strong> <? echo $nombre; ?></strong></h3></td>
  </tr>
  <tr>
    <td align="left" width="47%" height="40"><h3><strong><? echo $interno; ?></strong></h3></td>
    <td width="20%"><strong><? echo $interno; ?></strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top"><h3><strong><? echo $licencia; ?></strong></h3></td>
  
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="94">&nbsp;</td>
    <td><strong><? echo $eps; ?></strong></td>
    <td>&nbsp;</td>
    <td align="right"><strong><? echo $sangre; ?></strong></td>
  </tr>
  <tr>
    <td height="64">&nbsp;</td>
    <td><strong><? echo $arl; ?></strong></td>
    <td>&nbsp;</td>
    <td><strong><? echo $pension; ?></strong></td>
  </tr>
  <tr>
    <td height="78">&nbsp;</td>
    <td colspan="2"><strong><? echo $empresa; ?></strong></td>
    <td><strong><? echo $nit; ?></strong></td>
  </tr>
  <tr>
    <td height="208" align="left" valign="bottom"><? echo '<img height="100" border="0" width="200" src="imagenes/logo.jpg"></img>'; ?></td>
    
  
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>


<?


}


//include('cierra_conexion.php');   
?> 
</body>

</html> 