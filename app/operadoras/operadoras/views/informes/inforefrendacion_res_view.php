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
            <td nowrap="nowrap">TD</td>
            <td nowrap="nowrap">Nº Doc</td>
            <td nowrap="nowrap">Lugar Exp.</td>
            <td nowrap="nowrap">Nombre</td>
            <td nowrap="nowrap">Genero</td>
            <td nowrap="nowrap">Factor RH</td>
            <td nowrap="nowrap">Placa</td>
            <td nowrap="nowrap">Marca</td>
            <td nowrap="nowrap">Modelo</td>
            <td nowrap="nowrap">Nº Interno</td>
            <td nowrap="nowrap">Nº Tarjeta</td>
            <td nowrap="nowrap">Fecha Refrendación</td>
            <td nowrap="nowrap">Hora Refrendación</td>
            <td nowrap="nowrap">Fecha Vencimiento</td>
        </tr>
    
    <?php
    $x=0;
    foreach ($result->result_array() as $row)
    {
        $x++;
        echo"<tr>";
        echo"<td nowrap='nowrap'>".$x."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['abreviatura'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['numerodocumento'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['lugarexpedicion'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['nombrecompleto'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['nombregenero'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['nombregruposanguineo'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['placa'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['nombremarcavehiculo'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['nombremodelo'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['numerointerno'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['numerotarjeta'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($this->funciones->convertirFormatoFecha($row['fecharefrendacion'],'aaaa-mm-dd','dd/mm/aaaa'))."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['horarefrendacion'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($this->funciones->convertirFormatoFecha($row['fechavencimiento'],'aaaa-mm-dd','dd/mm/aaaa'))."</td>";
        echo"</tr>";
    }
    ?>
    </table>
