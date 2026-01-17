<?
$numero = $_GET['numero'];

$contexto            = "mega";
$extension_operadora = 110;


$comando_cli  = "originate SIP/$extension_operadora extension $numero@$contexto";

$comando      = "sudo /usr/sbin/asterisk -rx \"$comando_cli\"";

print("El comando fue: $comando \n");

//system($comando);



?>
