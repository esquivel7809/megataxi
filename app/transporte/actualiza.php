<html> 

<head> 
<title>Actualizacion completada.</title> 
<META name='robot' content='noindex, nofollow'> 
</head> 

<body> 

<?php 
// Actualizamos en funcion del id que recibimos 
include('conexion.php'); 
$nombre = $_FILES['archivo']['name'];
$fecha = date('Y/m/d H:i');
$tipo = $_FILES['archivo']['type'];
$tamanio = $_FILES['archivo']['size'];
//$directorio = $_SERVER['DOCUMENT_ROOT'].'/html/app/transporte/archivos/';
//move_uploaded_file($_FILES['imagen']['tmp_name'],$directorio.$nombre);

$destino = "192.168.1.66/archivos" . $nombre;
$id = $_POST['id'];
$dir = "imagenes/";
$ext = ".png";  
$ruta = $dir . $id . $ext;
$nombre1 = $_POST['nombre1']; 
$nombre2 = $_POST['nombre2']; 
$apellido1 = $_POST['apellido1']; 
$apellido2 = $_POST['apellido2']; 
$direccion = $_POST['direccion']; 
$celular = $_POST['celular']; 
$arl = $_POST['arl']; 
$pension = $_POST['pension']; 
$salud = $_POST['salud']; 


 

$sSQL="Update conductor Set primernombre='$nombre1',segundonombre='$nombre2',primerapellido='$apellido1',segundoapellido='$apellido2',direccion='$direccion',celular='$celular',idsalud='$salud',idpension='$pension',idarl='$arl',rutafoto='$ruta' where numerodocumento='$id'"; 
mysql_query($sSQL); 

//include('cierra_conexion.php');   

echo " 
<p>Los datos han sido actualizados con exito.</p> 

<p><a href='foto.php'>SUBIR LA FOTO DEL CONDUCTOR</a></p> 
<p><a href='javascript:history.go(-1)'>VOLVER ATRAS</a></p> 
<p><a href='tarjeta.php'>IMPRIMIR TARJETA CONTROL</a></p> 
<p><a href='javascript:history.go(-2)'>OTRO CONDUCTOR</a></p> 
"; 
 
?> 

</body> 

</html>

