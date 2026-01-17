<style>
table.carnet1, table.carnet2{
	font-size:8px;
}
table.carnet1 tr td{
	height:15px;
}
table.carnet2 tr td{
	height:15px;
}
.logo{
	width:145px;
}
.num_car{
	width:70px;
}
.fecha{
	width:55px;
}
.foto{
	width:110px;
}
.datos1{
	width:80px;
}
.datos2{
	width:80px;
}
.datos3{
	width:90px;
}
.datos4{
	width:70px;
}
.nombre{
	width:160px;
}
</style>
<table border="0" class="carnet1">
	<tr>
    	<td rowspan="2" class="logo"></td>
        <td class="num_car"><?php echo $datonumerocarnet; ?></td>
        <td class="fecha"><?php echo $datofechacarnet; ?></td>
    </tr>
	<tr>
    	<?php if($datoidtipovehiculo==1){?>
        <td class="num_car"><?php echo $datonumeromega; ?></td>
        <td class="fecha">&nbsp;</td>
        <?php } else{?>
        <td class="num_car">&nbsp;</td>
        <td class="fecha"><?php echo $datonumeromega; ?></td>
        <?php } ?>
    </tr>
</table>
<table border="0" class="carnet2">
	<tr>
    	<td rowspan="6" class="foto">&nbsp;</td>
        <td colspan="2" class="nombre"><?php echo $datonombrecompleto; ?></td>
    </tr>
	<tr>
        <td class="datos1"><?php echo $datonumerodocumento; ?></td>
        <td class="datos2"><?php echo $datolugarexpedicion; ?></td>
    </tr>
	<tr>
        <td class="datos3"><?php echo $datonombretipovehiculo; ?></td>
        <td class="datos4"><?php echo $datonombremarcavehiculo; ?></td>
    </tr>
	<tr>
        <td class="datos3"><?php echo $datonombremodelo; ?></td>
        <td class="datos4"><?php echo $datoplaca; ?></td>
    </tr>
	<tr>
        <td colspan="2"><?php echo $datonombremarcaradio; ?></td>
    </tr>
	<tr>
        <td class="datos1"><?php echo $datonombremodeloradio; ?></td>
        <td class="datos2"><?php echo $datoserieradiotelefono; ?></td>
    </tr>
</table>