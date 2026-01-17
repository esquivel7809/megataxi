<html> 

<head> 
<title>imprime tarjeta de control</title> 
<META name='robot' content='noindex, nofollow'> 
<style type="text/css">
.j {
	color: #FFF666;
}
</style>
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

 $query = "select vehiculo.placa,vehiculo.numerointerno, tarjetaoperacion.numerotarjetaoperacion, tarjetaoperacion.idtarjetaoperacion, revision.numerorevision,revision.fechafinal,soat.fechafinal as vtosoat from vehiculo,tarjetaoperacion,revision,soat where placa = '$placa' and (vehiculo.idvehiculo = revision.idvehiculo) and (vehiculo.idvehiculo = soat.idvehiculo)and (vehiculo.idvehiculo = tarjetaoperacion.idvehiculo)  order by tarjetaoperacion.idtarjetaoperacion desc, revision.fechafinal desc,soat.fechafinal desc limit 1"; 
    $result = mysql_query($query); 

while ($registro1 = mysql_fetch_array($result)){  

$placa=$registro1["placa"];
$interno=$registro1["numerointerno"];
$operacion=$registro1["numerotarjetaoperacion"];
$revision=$registro1["numerorevision"];

$licencia=$registro["fechavencimiento"];
$vtorevision=$registro1["fechafinal"];
$vtosoat=$registro1["vtosoat"];
$eps=$registro["idsalud"];
$sangre=$registro["nombregruposanguineo"];
$arl=$registro["idarl"];
$pension=$registro["idpension"];
$empresa="COOPERATIVA MEGATAXI LTDA";
$nit="800204096-5";
}

 
    $query = "select * from conductor,licenciaconductor,gruposanguineo where numerodocumento = '$id' and (conductor.idgruposanguineo=gruposanguineo.idgruposanguineo) and conductor.idconductor=licenciaconductor.idconductor order by fechavencimiento desc limit 1"; 
    $result = mysql_query($query); 

while ($registro = mysql_fetch_array($result)){  


$cedula=$registro["numerodocumento"];
$imagen=$registro["rutafoto"];
$nombre=$registro["nombrecompleto"];
$placa1=$registro1["placa"];


//$revision=$registro1["numerorevision"];

$licencia=$registro["fechavencimiento"];


$eps=$registro["idsalud"];
$sangre=$registro["nombregruposanguineo"];
$arl=$registro["idarl"];
$pension=$registro["idpension"];
$empresa="COOPERATIVA MEGATAXI LTDA";
$nit="800204096-5";
?>

<table width="100%" height="670" border="0" align="center">
  <tr>
    <td width="13%" height="10"></td>
    <td  align="center" olspan="2"><h1 class="k"><strong><? echo $cedula; ?></strong></h1></td>
    <td width="20%">&nbsp;</td>
  </tr>
  
  <tr>
    <td rowspan="3" align="left" valign="middle"><? echo '<img height="180" border="0" width="120" src="'.$registro['rutafoto'].'"></img>'; ?></td>
    <td height="57" colspan="3" align="center"><h3><strong> <? echo $nombre; ?>
</strong></h3></td>
  </tr>

  <tr>
    <td align="left" width="47%" height="45"><h3><strong><? echo $placa; ?></strong></h3></td>
    <td width="28%"><strong><? echo $interno; ?></strong></td>
    <td align="center" valign="top"><strong><? echo $operacion; ?></strong></td>
  </tr>
  <tr>
    <td align="left" valign="top"><h3><strong><? echo $licencia; ?></strong></h3></td>
  
    <td align="left" valign="top"><strong><? echo $vtorevision; ?></strong></td>
    <td align="center" valign="top"><strong><? echo $vtosoat; ?></strong></td>
  </tr>
  <tr>
    <td height="94">&nbsp;</td>
    <td><strong><? echo $eps; ?></strong></td>
    <td>&nbsp;</td>
    <td align="center"><strong><? echo $sangre; ?></strong></td>
  </tr>
  <tr>
    <td height="54">&nbsp;</td>
    <td><strong><? echo $arl; ?></strong></td>
    <td>&nbsp;</td>
    <td><strong><? echo $pension; ?></strong></td>
  </tr>
  <tr>
    <td height="78">&nbsp;</td>
    <td colspan="2" align="center"><strong><? echo $empresa; ?></strong></td>
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