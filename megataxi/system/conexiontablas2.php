<?php
$nombre_bd = 'megataxi';

if (!mysql_pconnect('localhost', 'soporte', 'mega89soporte12')) {
    echo 'No se pudo conectar a mysql';
    exit;
}

$sql = "SHOW COLUMNS FROM llamada_actual";
$resultado = mysql_query($sql);

if (!$resultado) {
    echo "Error de BD, no se pudieron listar los campos\n";
    echo 'Error MySQL: ' . mysql_error();
    exit;
}

while ($fila = mysql_fetch_row($resultado)) {
    echo "campo: {$fila[0]}\n";
}

mysql_free_result($resultado);
?>