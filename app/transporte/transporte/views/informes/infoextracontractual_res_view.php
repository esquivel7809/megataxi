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
            <td nowrap="nowrap">Modelo</td>
            <td nowrap="nowrap">Tipo de Vehiculo</td>
            <td nowrap="nowrap">Marca</td>
            <td nowrap="nowrap">Nº Seguro</td>
            <td nowrap="nowrap">Fecha de Vencim.</td>
            <td nowrap="nowrap">Aseguradora</td>
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
             <td nowrap='nowrap'>".html_entity_decode($row['nombremodelo'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['nombretipovehiculo'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['nombremarcavehiculo'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['numeroextracontractual'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($this->funciones->convertirFormatoFecha($row['fechafinal'],'aaaa-mm-dd','dd/mm/aaaa'))."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['nombreaseguradora'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($arraysino[$row['asociado']])."</td>
             <td nowrap='nowrap'>".html_entity_decode($arraysino[$row['empresa']])."</td>
             <td nowrap='nowrap'>".html_entity_decode($arraysino[$row['comunicacion']])."</td>
             <td nowrap='nowrap'>".html_entity_decode($arraysino[$row['activo']])."</td>";
        echo"</tr>";
    }
    ?>
    </table>
     
