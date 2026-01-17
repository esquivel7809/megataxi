<?php

if($tiporeporte=="excel")
{
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=".$nombrearchivo);
	header("Pragma: no-cache");
	header("Expires: 0");
}

    $html="<div class='container_12'>
        <div class='grid_12'>
            ".$tituloInfo."
        </div>
        <div class='clear'></div>
    </div>";

    $html.="<table>
        <tr>
            <td nowrap='nowrap'>N</td>
            <td nowrap='nowrap'>TD</td>
            <td nowrap='nowrap'>N Doc</td>
            <td nowrap='nowrap'>Lugar Exp.</td>
            <td nowrap='nowrap'>Primer Nombre</td>
            <td nowrap='nowrap'>Segundo Nombre</td>
            <td nowrap='nowrap'>Primer Apellido</td>
            <td nowrap='nowrap'>Segundo Apellido</td>
            <td nowrap='nowrap'>Direccion</td>
            <td nowrap='nowrap'>Telefono fijo</td>
            <td nowrap='nowrap'>Celular</td>
            <td nowrap='nowrap'>E-Mail</td>
            <td nowrap='nowrap'>Factor RH</td>
            <td nowrap='nowrap'>Fecha de Nac.</td>
            <td nowrap='nowrap'>Lugar Nac.</td>
            <td nowrap='nowrap'>Genero</td>
            <td nowrap='nowrap'>Conductor</td>
            <td nowrap='nowrap'>Propietario</td>
            <td nowrap='nowrap'>Activo</td>
        </tr>";
    
    $x=0;
    foreach ($result->result_array() as $row)
    {
        $x++;
        $html.="<tr>";
        $html.="<td nowrap='nowrap'>".$x."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['abreviatura'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['numerodocumento'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['lugarexpedicion'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['primernombre'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['segundonombre'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['primerapellido'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['segundoapellido'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['direccion'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['telefonofijo'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['celular'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['email'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['nombregruposanguineo'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['fechanacimiento'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['lugarnacimiento'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($row['nombregenero'])."</td>
             <td nowrap='nowrap'>".html_entity_decode($arraysino[$row['conductor']])."</td>
             <td nowrap='nowrap'>".html_entity_decode($arraysino[$row['propietario']])."</td>
             <td nowrap='nowrap'>".html_entity_decode($arraysino[$row['activo']])."</td>";
        $html.="</tr>";
    }
    $html.="</table>";
	echo $html;
?>