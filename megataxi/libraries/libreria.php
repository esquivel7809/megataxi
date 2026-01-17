<?php /*toma una fecha en el formato aaaa-mm-dd H:i:s y retorna un arreglo con los valores de cada uno de los datos*/
function get_array_fecha($cadena){
	$arreglo=split(" ",$cadena);
	$fecha=split("-",$arreglo[0]);
	$tiempo=split(":",$arreglo[1]);
	$marca_tiempo=mktime($tiempo[0],$tiempo[1],$tiempo[2],$fecha[1],$fecha[2],$fecha[0]);
	$array_tiempo=getdate($marca_tiempo);
	return $array_tiempo;
}

/*Recibe dos arreglos de fechas y horas devuelve la diferencia en minutos*/
function diferencia_minutos($datatime1,$datatime2){

	$arreglo1=split(" ",$datatime1);
	$fecha1=split("-",$arreglo1[0]);
	$tiempo1=split(":",$arreglo1[1]);
	$marca_tiempo1=mktime($tiempo1[0],$tiempo1[1],$tiempo1[2],$fecha1[1],$fecha1[2],$fecha1[0]);

	$arreglo2=split(" ",$datatime2);
	$fecha2=split("-",$arreglo2[0]);
	$tiempo2=split(":",$arreglo2[1]);
	$marca_tiempo2=mktime($tiempo2[0],$tiempo2[1],$tiempo2[2],$fecha2[1],$fecha2[2],$fecha2[0]);

	$segundos=$marca_tiempo1-$marca_tiempo2;
	$minutos=$segundos/60;
	return $minutos;
}

/*Recibe dos arreglos de fechas y horas devuelve la diferencia en minutos*/
function diferencia_segundos($datatime1,$datatime2){

	$arreglo1=split(" ",$datatime1);
	$fecha1=split("-",$arreglo1[0]);
	$tiempo1=split(":",$arreglo1[1]);
	$marca_tiempo1=mktime($tiempo1[0],$tiempo1[1],$tiempo1[2],$fecha1[1],$fecha1[2],$fecha1[0]);

	$arreglo2=split(" ",$datatime2);
	$fecha2=split("-",$arreglo2[0]);
	$tiempo2=split(":",$arreglo2[1]);
	$marca_tiempo2=mktime($tiempo2[0],$tiempo2[1],$tiempo2[2],$fecha2[1],$fecha2[2],$fecha2[0]);

	$segundos=$marca_tiempo1-$marca_tiempo2;
	return $segundos;
}

function segundos($datatime1){
        $arreglo1=split(" ",$datatime1);
        $fecha1=split("-",$arreglo1[0]);
        $tiempo1=split(":",$arreglo1[1]);
        $marca_tiempo1=mktime((int)$tiempo1[0],(int)$tiempo1[1],(int)$tiempo1[2],(int)$fecha1[1],(int)$fecha1[2],(int)$fecha1[0]);

        return $marca_tiempo1;

}
