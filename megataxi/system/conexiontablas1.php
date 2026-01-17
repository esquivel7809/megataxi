<?php
$nombre_bd = 'megataxi';

if (!mysql_pconnect('localhost', 'root', 'super45mega67')) {
    echo 'No se pudo conectar a mysql';
    exit;
}

$sql = "SHOW TABLES FROM $nombre_bd";
$resultado = mysql_query($sql);

if (!$resultado) {
    echo "Error de BD, no se pudieron listar las tablas\n";
    echo 'Error MySQL: ' . mysql_error();
    exit;
}

while ($fila = mysql_fetch_row($resultado)) {
    echo "Tabla: {$fila[0]}\n";
}

mysql_free_result($resultado);
?>

