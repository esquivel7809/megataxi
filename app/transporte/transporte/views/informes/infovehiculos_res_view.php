<?php
if($tiporeporte=="excel")
{
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=".$nombrearchivo);
	header("Pragma: no-cache");
	header("Expires: 0");
}
?>
    <div class="container_12">
        <div class="grid_12">
            <?php echo $tituloInfo;?>
        </div>
        <div class="clear"></div>
    </div>

    <table>
        <tr>
            <td nowrap="nowrap">Nº</td>
            <td nowrap="nowrap">Placa</td>
            <td nowrap="nowrap">Nº de Chasis</td>
            <td nowrap="nowrap">Nº de Motor</td>
            <td nowrap="nowrap">Cilindraje</td>
            <td nowrap="nowrap">Modelo</td>
            <td nowrap="nowrap">Marca</td>
            <?php if($tarjetaOperacion){ ?>
            <td nowrap="nowrap">Nro. Tarj. Operaci&oacute;n</td>
            <?php } ?>
            <?php if($propietarios){ ?>
            <td nowrap="nowrap">Doc.</td>
            <td nowrap="nowrap">Propietario</td>
            <td nowrap="nowrap">Tel fijo</td>
            <td nowrap="nowrap">Celular</td>
            <?php } ?>
            <td nowrap="nowrap">Tipo de Vehiculo</td>
            <td nowrap="nowrap">Nº de Licencia</td>
            <td nowrap="nowrap">Nº Interno</td>
            <td nowrap="nowrap">Fecha de Matricula</td>
            <td nowrap="nowrap">Revisado</td>
            <td nowrap="nowrap">Asociado</td>
            <td nowrap="nowrap">Afil. Rodamiento</td>
            <td nowrap="nowrap">Afil. Comunicación</td>
            <td nowrap="nowrap">Activo</td>
        </tr>
    
    <?php
    $x=0;
    foreach ($result->result_array() as $row)
    {
        $x++;
        echo"<tr>";
        echo"<td nowrap='nowrap'>".$x."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['placa'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['numerochasis'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['numeromotor'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['cilindraje'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['nombremodelo'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['nombremarcavehiculo'])."</td>
			 ";
        if($tarjetaOperacion){
		echo"<td nowrap='nowrap'>".html_entity_decode($row['numerotarjetaoperacion'])."</td>
			 ";
        }
		if($propietarios){
		echo"<td nowrap='nowrap'>".html_entity_decode($row['numerodocumento'])."</td>
			 <td nowrap='nowrap'>".html_entity_decode($row['nombrecompleto'])."</td>
			 <td nowrap='nowrap'>".html_entity_decode($row['telefonofijo'])."</td>
			 <td nowrap='nowrap'>".html_entity_decode($row['celular'])."</td>
			 ";
		}
        echo"<td nowrap='nowrap'>".html_entity_decode($row['nombretipovehiculo'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['numerolicencia'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['numerointerno'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['fechamatricula'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['revisado'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($arraysino[$row['asociado']])."</td>
             <td nowrap='nowrap'>".html_entity_decode($arraysino[$row['empresa']])."</td>
             <td nowrap='nowrap'>".html_entity_decode($arraysino[$row['comunicacion']])."</td>
             <td nowrap='nowrap'>".html_entity_decode($arraysino[$row['activo']])."</td>";
        echo"</tr>";
    }
    ?>
    </table>
     
