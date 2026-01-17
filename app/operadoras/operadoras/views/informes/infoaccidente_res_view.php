<?php
if($tiporeporte=="excel")
{
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=Informe_Accidentes_vehiculos_".date('h_i_d_m_Y').".xls");
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
            <td nowrap="nowrap">Conductor</td>
            <td nowrap="nowrap">Fecha Accidente</td>
            <td nowrap="nowrap">Descripci&oacute;n</td>
            <td nowrap="nowrap">Personas leccionadas</td>
        </tr>
    
    <?php
    $x=0;
    foreach ($result->result_array() as $row)
    {
        $x++;
        echo"<tr>";
        echo"<td nowrap='nowrap'>".$x."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['placa'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['nombrecompleto'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($this->funciones->convertirFormatoFecha($row['fechaaccidente'],'aaaa-mm-dd','dd/mm/aaaa'))."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['descripcion'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($arraylecciones[$row['lecciones']])."</td>";
        echo"</tr>";
    }
    ?>
    </table>
     
