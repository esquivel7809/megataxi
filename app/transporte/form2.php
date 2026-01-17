<html> 

<head> 
<title>InformaciÃ³n del conductor a actualizar.</title> 
<META name='robot' content='noindex, nofollow'> 
</head> 

<?php  
$id = $_POST['id']; 
$dir = "imagenes/";
$ext = ".png";  
$ruta = $dir . $id . $ext;
include('conexion.php');   
$sSQL="Update conductor Set rutafoto='$ruta' where numerodocumento='$id'"; 
mysql_query($sSQL); 
    $query = "select * from conductor where numerodocumento = '$id'"; 
    $result = mysql_query($query); 

while ($registro = mysql_fetch_array($result)){  
$imagen=$registro["rutafoto"];
?>
<table width="10%" border="0" align="center">
  <tr>
    <td><? echo '<img height="80" border="0" width="80" src="'.$registro['rutafoto'].'"></img>'; ?></td>
  </tr>
</table>


<?
echo " 
<body> 

<div align='center'> 
    <table border='0' width='600' style='font-family: Verdana; font-size: 8pt' id='table1'> 
        <tr> 
            <td colspan='2'><h3 align='center'>Actualice la informacion de seguridad social y la foto para la tarjeta de control</h3></td> 
        </tr> 
        <tr> 
            <td colspan='2'>En los campos del formulario puede ver los valores actuales,  
            si no se cambian los valores se mantienen iguales.</td> 
        </tr> 
        <form method='POST' enctype='multipart/form-data' action='actualiza.php'> 
        <tr> 
            <td width='50%'>&nbsp;</td> 
            <td width='50%'>&nbsp;</td> 
        </tr> 
        <tr> 
            <td width='50%'><p align='center'><b>Cedula: </b></td> 
            <td width='50%'><p align='center'><input type='text' disabled='disabled' name='cedula' size='20' value='".$registro['numerodocumento']."'></td> 
        </tr> 
        <tr> 
            <td width='50%'><p align='center'><b>Primer Nombre:</b></td> 
            <td width='50%'><p align='center'><input type='text' name='nombre1' size='20' value='".$registro['primernombre']."'></td> 
		</tr>
		<tr>	
			<td width='50%'><p align='center'><b>Segundo Nombre:</b></td> 
<td width='50%'><p align='center'><input type='text' name='nombre2' size='20' value='".$registro['segundonombre']."'></td> 
</tr>
		<tr>	
<td width='50%'><p align='center'><b>Primer Apellido:</b></td> 
<td width='50%'><p align='center'><input type='text' name='apellido1' size='20' value='".$registro['primerapellido']."'></td> 
</tr>
		<tr>	
<td width='50%'><p align='center'><b>Segundo Apellido:</b></td> 
<td width='50%'><p align='center'><input type='text' name='apellido2' size='20' value='".$registro['segundoapellido']."'></td> 
</tr>
		<tr>	
<td width='50%'><p align='center'><b>Direccion:</b></td> 
<td width='50%'><p align='center'><input type='text' name='direccion' size='20' value='".$registro['direccion']."'></td> 
</tr>
		<tr>	
<td width='50%'><p align='center'><b>Celular:</b></td> 
<td width='50%'><p align='center'><input type='text' name='celular' size='20' value='".$registro['celular']."'></td> 
        </tr> 
<tr>	
<td width='50%'><p align='center'><b>Arl:</b></td> 
<td width='50%'><p align='center'><input type='text' name='arl' size='20' value='".$registro['idarl']."'></td> 
        </tr> 		
<tr>	
<td width='50%'><p align='center'><b>Fondo de pensiones:</b></td> 
<td width='50%'><p align='center'><input type='text' name='pension' size='20' value='".$registro['idpension']."'></td> 
        </tr> 
<tr>	
<td width='50%'><p align='center'><b>EPS:</b></td> 
<td width='50%'><p align='center'><input type='text' name='salud' size='20' value='".$registro['idsalud']."'></td> 
        </tr> 
		
        <tr> 
            <td width='50%'>&nbsp;</td> 
            <td width='50%'>&nbsp;</td> 
        </tr> 
        <input type='hidden' name='id' value='$id'> 
        <tr> 
            <td width='100%' colspan='2'> 
            <p align='center'> 
            <input type='submit' value='Actualizar datos' name='B1'></td> 
        </tr> 
        </form> 
    </table> 
</div> 
"; 
} 


//include('cierra_conexion.php');   
?> 
</body> 

</html> 