<style>
/*
div.marco div{
	float: left;
	font-family:"Comic Sans MS", cursive;
	font-size:15px;
	font-weight:bold;
}
.marco{
	width: 800px;
	height: 600px;
}
.item{
	width: 100%;
}
.sup{
	margin-top:50px;
}
.item1{
	width: 430px;
	height: 100px;
}
.item2{
	width: 292px;
	height: 100px;
}
.item1_small{
	width: 440px;
	height: 80px;
}
.item2_small{
	width: 292px;
	height: 80px;
}
.nombre{
	width: 380px;
	margin-top:30px;
	margin-left: 40px;
	font-size:20px !important;
}
.telefono, .direccion{
	width: 380px;
	margin-top:-6px;
	margin-left: 40px;
	font-size: 16px !important;
}
.tipodoc{
	width: 280px;
	margin-top:30px;
}
.fechanac{
	width: 280px;
	margin-top:5px;
}
.rh{
	width: 260px;
	margin-top:25px;
	margin-left: 25px;
}
.nrointerno{
	width: 130px;
	margin-top:20px;
	margin-left: 153px;
	text-align:center;
}
.placa{
	width: 130px;
	margin-top:10px;
	text-align:center;
	font-size: 23px !important;
}
.tarjetaope{
	width: 130px;
	margin-top:4px;
	margin-left: 153px;
	text-align:center;
}
.licencia{
	width: 280px;
	margin-top:1px;
	margin-left: 10px;
}
.tar_fechafinal{
	width: 130px;
	margin-top:4px;
	text-align:center;
}
.soat{
	width: 130px;
	margin-top:11px;
	margin-left: 153px;
	text-align:center;
}
.fecha_soat{
	width: 130px;
	margin-top:11px;
	text-align:center;
}
.licencia_venc{
	width: 208px;
	margin-left: 63px;
	margin-top: 7px;
}
*/
.tbl{
	font-size:12px;
}
.n1{
	width:270px;
	font-size:9px;
	height:47px;	
}
.n1_1{
	width: 90px;
	height:50px;
	vertical-align:middle;
	text-align:center;
}
.n1_2{
	height:32px;
	vertical-align:middle;
	text-align:center;
        margin-top: 5px;
}
.n2{
	width:130px;	
}
.esp{
	height:50px;	
}
.nom{
	font-size:!important 12px;
}
.lateral_izq{
	width: 15px;	
}
.nom_fech{
	font-size:10px;
	width:130px;
}
.grupo_sang{
	width: 20px;
}
.foto{
	width:90px;
	
}
.n_interno{
	font-size:16px;	
}
.n_interno_tam{
	width: 10px;
}
.licencia_tam{
	height: 5px !important;
}
.n1_1_1{
	width: 130px;
	height:60px;
}
</style>
<?php
$array_tar_fechafinal=explode("-",$datorevision_fechafinal);
$mes = $array_tar_fechafinal[1];
$mes = intval($mes);
$mes = substr($meses[$mes],0,10);
$array_datofechavencimiento=explode("/",$datofechavencimiento);
$datofechavencimiento= $array_datofechavencimiento[0]." . ".$array_datofechavencimiento[1]." . ".$array_datofechavencimiento[2];
?>
<table border="0" class="tbl">
	<tr>
    	<td colspan="5" class="esp">&nbsp;</td>
    </tr>
	<tr>
    	<td rowspan="5" class="lateral_izq">&nbsp;</td>
    	<td colspan="3" class="n1">
			<span class="nom"><?php echo $datonombrecompleto; ?></span><br />
			<?php echo $datodireccion; ?><br />
            <?php echo (!empty($datocelular))? $datocelular : "" ; echo (!empty($datotelefonofijo))? (!empty($datocelular))? " - ".$datotelefonofijo : $datotelefonofijo : "" ; ?><br />
        </td>
        <td colspan="2" class="nom_fech" >
			<?php echo $datonumerodocumento." DE ".$datonombremunicipio; ?><br />
            Nacimiento <?php echo $datofechanacimiento; ?><br />
        </td>
    </tr>
	<tr>
    	<td colspan="3" class="n1"></td>
        <td colspan="2" class="n2_">
        	<table border="0">
            	<tr>
                	<td colspan="2">&nbsp;</td>
                </tr>            
            	<tr>
                	<td class="grupo_sang">&nbsp;</td>
                	<td>&nbsp; &nbsp; <?php echo $datonombregruposanguineo; ?></td>
                </tr>            
            </table>
        </td>
    </tr>
	<tr>
    	<td rowspan="3" class="foto"></td>
        <td class="n1_1">
        	<table border="0" width="100%">
            	<tr>
                	<td>&nbsp;</td>
                </tr>
            	<tr>
                	<td class="n_interno" nowrap="nowrap"><?php echo $datonumerointerno; ?></td>
                </tr>
        	
            </table>
        </td>
        <td class="n1_1">
        	<table border="0">
            	<tr>
                	<td>&nbsp;</td>
                </tr>
            	<tr>
                	<td class="n_interno"><?php echo $datoplaca; ?></td>
                </tr>
        	
            </table>
        </td>
        <td colspan="2" class="n1_1_1">
<!--
        	<div style="height:10px; float:left; border: solid 1px; margin: 0px;">
				<?php 
                $array_organismo=explode(" ",$datonombreorganismo);
                echo end($array_organismo)."  ".$datonombrecategoria;
                ?>
            </div>
            <div style="height:10px; float:left;">
            	<?php echo $datofechavencimiento; ?>
            </div>
-->
        	<table border="0" cellpadding="0" cellspacing="11" >
            	<tr>
                	<td style="padding-right: 1px; margin-top: 5px;">
						<?php 
                        $array_organismo=explode(" ",$datonombreorganismo);
                        echo end($array_organismo)."  ".$datonombrecategoria;
						?>
                    </td>
                </tr>
            </table>
        	<table border="0" cellpadding="0" cellspacing="4" >
            	<tr>
                	<td style="text-align:right; padding: 1px;">
                    	<?php echo $datofechavencimiento; ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<!-- <tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td rowspan="3"></td>
<td>&nbsp;</td>
</tr>-->
	<tr>
        <td class="n1_2">&nbsp;<br /><?php echo $datonumerorevision; ?></td>
        <td class="n1_2">&nbsp;<br /><?php echo $datorevision_fechafinal; ?></td>
        <td rowspan="2"></td>
        <td>&nbsp;</td>
    </tr>
	<tr>
    	<td class="n1_2">&nbsp;<br /><br /><?php echo $datonumerosoat; ?></td>
        <td class="n1_2">&nbsp;<br /><br /><?php echo $datosoat_fechafinal; ?></td>
        <td>&nbsp;</td>
    </tr>
</table>
<!-- 
<div class="marco">
	<div class="item sup">
		<div class="item1">
			<div class="nombre"><?php echo $datonombrecompleto; ?></div>
			<div class="direccion"><?php echo $datodireccion; ?></div>
            <div class="telefono"><?php echo (!empty($datocelular))? $datocelular : "" ; echo (!empty($datotelefonofijo))? (!empty($datocelular))? " - ".$datotelefonofijo : $datotelefonofijo : "" ; ?></div>
		</div>
		<div  class="item2">
			<div class="tipodoc"><?php echo $datonumerodocumento." DE ".$datonombremunicipio; ?></div>
            <div class="fechanac">Nacimiento <?php echo $datofechanacimiento; ?></div>
        </div>
	</div>
	<div class="item">
		<div class="item1_small">
        	&nbsp;
		</div>
		<div  class="item2_small">
			<div class="rh"><?php echo $datonombregruposanguineo; ?></div>
        </div>
	</div>
	<div class="item">
		<div class="item1_small">
			<div class="nrointerno"><?php echo $datonumerointerno; ?></div>
			<div class="placa"><?php echo $datoplaca; ?></div>
		</div>
		<div  class="item2_small">
			<div class="licencia">
			<?php 
			$array_organismo=explode(" ",$datonombreorganismo);
			echo end($array_organismo)."  ".$datonombrecategoria; ?>
            </div>
            <div class="licencia_venc"><?php echo $datofechavencimiento; ?></div>
        </div>
	</div>
	<div class="item">
		<div class="item1">
			<div class="tarjetaope">&nbsp;<?php echo $datonumerorevision; ?></div>
			<div class="tar_fechafinal">&nbsp;<?php echo $mes ?></div>
			<div class="soat">&nbsp;<?php echo $datonumerosoat; ?></div>
			<div class="fecha_soat">&nbsp;<?php echo $datosoat_fechafinal; ?></div>
		</div>
		<div  class="item2">
			&nbsp;
        </div>
	</div>
</div>
-->
