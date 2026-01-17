<?php
$cabeza='<script language="javascript">';
$pies='</script>';

function alert($txt){
	global $cabeza, $pies;
	echo $cabeza;
	echo "alert('$txt');";
	echo $pies;
}

function accion($txt="",$context=""){
	global $cabeza, $pies;
	echo $cabeza;
	echo ($context!='')?$context.".accion('$txt');":"accion('$txt');";
	echo $pies;
}

function ejecutar($funcion){
	global $cabeza, $pies;
	echo $cabeza;
	echo $funcion;
	echo $pies;
}

function segundos($datatime1){
        $arreglo1=split(" ",$datatime1);
        $fecha1=split("-",$arreglo1[0]);
        $tiempo1=split(":",$arreglo1[1]);
        $marca_tiempo1=mktime((int)$tiempo1[0],(int)$tiempo1[1],(int)$tiempo1[2],(int)$fecha1[1],(int)$fecha1[2],(int)$fecha1[0]);

        return $marca_tiempo1;

}
