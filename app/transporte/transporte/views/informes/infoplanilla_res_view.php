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
            <td nowrap="nowrap">Numero Planilla</td>
            <td nowrap="nowrap">Fecha de Inicio</td>
            <td nowrap="nowrap">Destino</td>
            <td nowrap="nowrap">Fecha de Regreso</td>
            <td nowrap="nowrap">Cant. pasajeros</td>
            <td nowrap="nowrap">Conductor</td>
            <td nowrap="nowrap">Tel fijo</td>
            <td nowrap="nowrap">Celular</td>
            <td nowrap="nowrap">Placa</td>
        </tr>
    
    <?php
    $x=0;
    foreach ($result->result_array() as $row)
    {
        $x++;
        echo"<tr>";
        echo"<td nowrap='nowrap'>".$x."</td>
             <td nowrap='nowrap'>".$row['numeroplanilla']."</td>
             <td nowrap='nowrap'>".html_entity_decode($this->funciones->convertirFormatoFecha($row['fechainicio'],'aaaa-mm-dd','dd/mm/aaaa'))."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['ciudaddestino'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($this->funciones->convertirFormatoFecha($row['fecharegreso'],'aaaa-mm-dd','dd/mm/aaaa'))."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['cantidadpasajeros'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['nombrecompleto'])."</td>
			 <td nowrap='nowrap'>".html_entity_decode($row['telefonofijo'])."</td>
			 <td nowrap='nowrap'>".html_entity_decode($row['celular'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['placa'])."</td>";
        echo"</tr>";
    }
    ?>
    </table>
     
