<style>
table.panilla{
	font-size:10px;
}
.esp_sup_uno{
	height:60px;
}
.esp_empre{
	width:20px;
}
.nom_emp{
	width:420px;
	height:31px;
}
.num_doc_emp{
	width:110px;
	height:31px;
}
.alto_dos{
	height:35px;
}
.alto_empre{
	height:25px;
}
.alto_contr{
	height:26px;
}
.esp_o{
	width:35px;
}
.alto_tres{
	height:40px;
}
.origen{
	width:150px;
}
.finicio{
	width:150px;
}
.destino{
	width:140px;
}
.fregreso{
	width:70px;
}
.esp_con{
	width:50px;
}
.alto_cuatro{
	height:35px;
}
.contra{
	width:300px;
}
.tipod{
	width:45px;
}
.num_contra{
	width:90px;
}
.alto_dir{
	height:34px;
}
.esp_dir{
	width:20px;
}
.dire{
	width:330px;
}
.tele{
	width:150px;
}
.cantp{
	width:60px;
}
.alto_placa{
	height:26px;
}
.placa{
	width: 150px;
}
.esp_soat{
	width: 30px;
}
.soat{
	width:180px;
}
.aseg{
	width:260px;
}
.taro{
	width:70px;
}
.esp_nom_cond{
	width:10px;
}
.nom_cond{
	width:220px;
	font-size:10px;
}
.doc_cond{
	width:185px;
}
.lic_cond{
	width:125px;
}
.cat{
	width:25px;
}
</style>
<table border="0" class="planilla uno">
	<tr>
    	<td class="alto_empre esp_empre">&nbsp;</td>
    	<td class="nom_emp"><?php echo $datonombreempresa; ?></td>
        <td class="num_doc_emp"><?php echo $datonitempresa; ?></td>
    </tr>
</table>
<table border="0" class="planilla dos">
	<tr>
    	<td class="alto_tres esp_o">&nbsp;</td>
        <td class="alto_tres origen"><?php echo $datolugarorigen; ?></td>
        <td class="alto_tres finicio"><?php echo $datofechainicio; ?></td>
        <td class="alto_tres destino"><?php /*echo $datolugardestino; */ echo $datociudaddestino; ?></td>
        <td class="alto_tres fregreso"><?php echo $datofecharegreso; ?></td>
    </tr>
</table>
<table border="0" class="planilla tres">
	<tr>
    <td class="alto_contr esp_con">&nbsp;</td>
        <td class="alto_contr contra"><?php echo $datonombrecontratante; ?></td>
        <td class="alto_contr tipod"><?php echo ($datoidtipodocumento==1)? "X" : "" ; ?></td>
        <td class="alto_contr tipod"><?php echo ($datoidtipodocumento==2)? "X" : "" ; ?></td>
        <td class="alto_contr num_contra"><?php echo $datonumerocontratante; ?></td>
    </tr>
</table>
<table border="0" class="planilla cuatro">
	<tr>
    	<td class="alto_dir esp_dir">&nbsp;</td>
        <td class="alto_dir dire"><?php echo $datodireccion; ?></td>
        <td class="alto_dir tele"><?php echo $datotelefonofijo; ?></td>
        <td class="alto_dir cantp"><?php echo $datocantidadpasajeros; ?></td>
    </tr>
</table>
<table border="0" class="planilla cinco">
	<tr>
        <td class="alto_placa placa"><?php echo $datoplaca; ?></td>
        <td class="alto_placa placa"><?php echo $datonombretipovehiculo; ?></td>
        <td class="alto_placa placa"><?php echo $datonombremarcavehiculo; ?></td>
        <td class="alto_placa placa"><?php echo $datonombremodelo; ?></td>
    </tr>
</table>
<table border="0" class="planilla seis">
	<tr>
    	<td class="alto_dos esp_soat">&nbsp;</td>
        <td class="alto_dos soat"><?php echo $datonumerosoat; ?></td>
        <td class="alto_dos aseg"><?php echo $datonombreaseguradora; ?></td>
        <td class="alto_dos taro"><?php echo $datonumerotarjetaoperacion; ?></td>
    </tr>
</table>
<table border="0" class="planilla siete">
	<tr>
    	<td class="alto_dos esp_nom_cond">&nbsp;</td>
        <td class="alto_dos nom_cond"><?php echo $datonombrecompleto; ?></td>
        <td class="alto_dos doc_cond"><?php echo $datonumerodocumento; ?></td>
        <td class="alto_dos lic_cond"><?php echo $datonumerolicenciaconductor; ?></td>
        <td class="alto_dos cat"><?php echo $datonombrecategoria; ?></td>
    </tr>
</table>





