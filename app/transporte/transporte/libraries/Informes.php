<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Menu Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Menu
 * @author		Jorge serrano
 * @link		
 */

class Informes{
    
        public $idmodulo=0;
        public $idsubmodulo=0;
        public $nombremodulo='';
        public $nombresubmodulo='';
        public $idperfilusuario=0;
        public $CI='';

	public function __construct()
	{
            $this->CI =& get_instance();
            $this->CI->load->library('funciones');
            $this->CI->load->library('tabla');
            
            if (count($config) > 0)
            {
                    $this->initialize($config);
            }
	}
    
    
    function tituloFiltro($valorid,$tabla,$campoid,$camponombre,$tituloCriterio)
    {
    	if(count(explode(",",$valorid))==1)
        {
    		$tituloFuncion="Filtrado por ".$tituloCriterio.": ".substr(html_entity_decode($this->CI->funciones->nombredato($tabla,$campoid,$camponombre,array(str_replace("'","",stripslashes($valorid))))),0,20)."<br>";
        }
    	else
        {
    		$tituloFuncion="Filtrado por ".$tituloCriterio."<br>";
        }
    	return $tituloFuncion;
    }

	// esta funcion se utiliza en la construcion de los informes para pintar el encabezado
	//recibe como parametros el
	//$nombreinforme ="nombre del informe"
	//$titulo_       ="si el informe es filtrado recibe el nombre de dicho filtro (uno o varios filtros)"
	//$fechainicial_ ="fecha inicial del informe"
	//$fechafinal_	 ="fecha final del informe"
	function encabezadoInforme($nombreinforme="",$titulo_="",$fechainicial_,$fechafinal_,$mostrarFecha=true)
	{
	   $html="";
		$colspan=2;
		//$empresa=new tabla('empresa');
        $this->CI->tabla->settabla('empresa');
		$condicionempresa = array(
		'idempresa' => $this->CI->session->userdata('idempresaactual'),
			);
		$datoempresa=$this->CI->tabla->consultarDatos('*',$condicionempresa);
        
        $html.="<table class='encabezainfo'>
                <tr>
                    <td colspan='".$colspan."'></td>
                </tr>
                <tr>
                    <td colspan='".$colspan."'><img height='50px' width='120px' src='".base_url($datoempresa[0]['rutalogo'])."' alt='".$datoempresa[0]['nombreempresa']."' /></td>
                </tr>
                <tr>
                    <td colspan='".$colspan."'></td>
                </tr>
                <tr>
                    <td colspan='".$colspan."' style='font-size:13px'>
                        ".utf8_decode(html_entity_decode($datoempresa[0]['nombreempresa']))."<br />
                        NIT ".$datoempresa[0]['nitempresa']."
                    </td>
                </tr>
                <tr>
                    <td colspan='".$colspan."' style='font-size:12px'><b>$nombreinforme</b></td>
                </tr>";
			if($mostrarFecha)
			{
                $html.="<tr>
				            <td colspan='".$colspan."' style='font-size:9px'>
        					<b>
        					Desde: ".$this->CI->funciones->convertirFormatoFecha($fechainicial_,'aaaa-mm-dd','dd/mm/aaaa')."
        					Hasta: ".$this->CI->funciones->convertirFormatoFecha($fechafinal_,'aaaa-mm-dd','dd/mm/aaaa')."
        					</b>
        					</td>
        				</tr>";
			}
            $html.="<tr>
                        <td colspan='".$colspan."' align='center' style='font-size:11px'><b>$titulo_</b></td>
                    </tr>
                    <tr>
                        <td colspan='".$colspan."' align='center' style='font-size:11px'>
                            <b>Impreso el: ".date('d/m/Y')." a las: ".date('H:i:s')." por: ".$this->CI->session->userdata('loginusuarioactual')."</b>
                        </td>
                    </tr>
                </table>";
        return $html;
	}
    
    
	function visualizaFiltros_($Titulo,$CamposBusqueda,$CamposLista,$CapaLista,$CapaBusqueda,$Tablas,$CamposId,$CamposNombre,$mostrargeneracion="",$otrasCondiciones="")
	{
		$CantidadCriterios=count($Titulo);
        $html="";
        $html.="<fieldset><legend>Criterios de Selecci&oacute;n</legend>";
        $html.="<table class='tablacontenido'>";
        $html.="<tr><th class='centro'>Seleccion de Filtros</th><th class='centro'>Filtros Seleccionados</th>";
        if($mostrargeneracion==1)
        {
            $html.="<th class=''>Informes a Generar</th>";
        }
        $html.="</tr><tr><td style='float:left;'>";
        $html.="<select size='".$CantidadCriterios."' style='height:'".($CantidadCriterios*20)."px; cursor:pointer;' name='seleccionfiltro' id='seleccionfiltro' class='cajatexto' multiple='multiple' ondblclick='visualizarFiltro(this.value);' >";
        for($i=0;$i<$CantidadCriterios;$i++)
        {
            $html.="<option value='".$CamposBusqueda[$i]."'> ".$Titulo[$i]."</option>";
		}
        $html.="</select></td>";
        $html.="<td class='top'><table width='100%'><tr><th class='' style='width:200px;'>Valores selecccionados</th><th class='top' style='width:200px;'>Criterios selecccionados</th></tr>";
        for($i=0;$i<$CantidadCriterios;$i++)
        {
        	if(!is_array($otrasCondiciones)){ $otrasCondiciones[$i]="";}
            $html.="<tr id='".$CamposBusqueda[$i]."_tr' style='display:none;'>"; 
            $onkeyup="buscarDatos('{$CapaBusqueda[$i]}',this.form,'',this,'".site_url('informes/data/buscarregistroreporte')."','valordato='+this.form.{$CamposBusqueda[$i]}.value+'&nombrelistadato={$CamposLista[$i]}&listadato='+this.form.{$CamposLista[$i]}.value+'&tabla={$Tablas[$i]}&nombrecampoid={$CamposId[$i]}&nombretextoid={$CamposBusqueda[$i]}&nombrecamponombre={$CamposNombre[$i]}&capadato={$CapaBusqueda[$i]}&capalista={$CapaLista[$i]}&otrasCondiciones={$otrasCondiciones[$i]}',event,'buscareporte{$CamposNombre[$i]}')";
            
            $html.="<td class=''>".$Titulo[$i].":<br />";
            $html.="<input name='".$CamposBusqueda[$i]."' id='".$CamposBusqueda[$i]."' class='cajatexto' style='width:200px' onKeyUp=".$onkeyup." onkeypress='return desactivaEnter(event)' />";
            $html.="<br /><div style='position:relative'>";
            $html.="<div style='width:350px; display:none;' id='".$CapaBusqueda[$i]."' class='capabusqueda'></div>";
            $html.="</div></td><td class='' style='float:left;'>";
            $html.="<input type='hidden' name='".$CamposLista[$i]."' id='".$CamposLista[$i]."' />";
            $html.="<div style='width:180px; overflow:auto; background: white; float: left;' id='".$CapaLista[$i]."'></div></td></tr>";
        }
        $html.="</table></td></tr></table></fieldset></td></tr>";
        
        return $html;
	}

	function visualizaFiltros($Titulo,$CamposId,$rutaBusqueda,$otrasCondiciones="")
	{
		$CantidadCriterios=count($Titulo);
        $html=""; $script="";
		$html.="<div class='sel_filtros'>";
        for($i=0;$i<$CantidadCriterios;$i++)
        {
        	if(!is_array($otrasCondiciones)){ $otrasCondiciones[$i]="";}
			$script.="$('#".$CamposId[$i]."').fcbkcomplete({
						json_url: '".$rutaBusqueda[$i]."',
						addontab: true,                   
						maxitems: 10,
						input_min_size: 0,
						height: 10,
						cache: true,
						newel: false,
						select_all_text: 'seleccionar todos',
						filter_selected : true,
						width : '586px',
					});";
			$html.="<h4>".$Titulo[$i].":</h4>";
            $html.="<select name='".$CamposId[$i]."' id='".$CamposId[$i]."'  ></select>";
        }
		$html.="</div>";
		$html.="<script type='text/javascript'>
			$(document).ready(function(){
				".$script."
			});
		</script>";
        return $html;
	}
    
	public function initialize($config = array())
	{
            $defaults = array(
                'idperfilusuario'			=> 0
            );

            foreach ($defaults as $key => $val)
            {
                    if (isset($config[$key]))
                    {
                            $this->$key = $config[$key];
                    }
                    else
                    {
                            $this->$key = $val;
                    }
            }
        }
}
// END Menu Class

/* End of file Menu.php */
/* Location: ./application/libraries/Menu.php */
