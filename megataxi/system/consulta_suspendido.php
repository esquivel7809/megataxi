<?php
$nombre_bd = 'megataxi';

if (!mysql_pconnect('localhost', 'soporte', 'mega89soporte12')) {
    echo 'No se pudo conectar a mysql';
    exit;
}

$sql = "select * FROM suspension_mega where vehiculo = 273";
$resultado = mysql_query($sql);

if (!$resultado) {
    echo "Error de BD, no se pudieron listar los campos\n";
    echo 'Error MySQL: ' . mysql_error();
    exit;
}
print "LISTADO DE SUSPENSIONES DEL MEGA <br/> \n";
while ($fila = mysql_fetch_row($resultado)) {
print " <br/> \n";      
echo "Consecutivo: {$fila[0]}\n";
echo "Mega: {$fila[1]}\n";
echo "Suspendido el: {$fila[2]}\n";
}

mysql_free_result($resultado);
?>