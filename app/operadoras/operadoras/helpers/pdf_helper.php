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
 * Terminar Session
 *
 * Accepts six parameter, or you can submit an associative
 * array in the first parameter containing all the values.
 *
 * @access	public
 * @param	mixed
 * @param	string	the value of the cookie
 * @param	string	the number of seconds until expiration
 * @param	string	the cookie domain.  Usually:  .yourdomain.com
 * @param	string	the cookie path
 * @param	string	the cookie prefix
 * @return	void
 */
if ( ! function_exists('generar_pdf'))
{
	function generar_pdf($html, $nombrearchivo, $margin=array())
	{
        $CI =& get_instance();
		$CI->load->library('Pdf');
		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Jorge Serrano');
		$pdf->SetTitle('Tarjeta de Control - Imprimir');
		//$pdf->SetSubject('Tutorial TCPDF');
		//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
		
		// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/config
		//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
		//$pdf->setFooterData($tc = array(0, 64, 0), $lc = array(0, 64, 128));
		$pdf->SetPrintHeader(false);
		$pdf->SetPrintFooter(false);
		
		// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config.php de libraries/config
		//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
		//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
		//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		if(is_array($margin) && !empty($margin)){
			$pdf->SetMargins($margin['left'], $margin['top'], $margin['right'], $margin['bottom']);
		}
		//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
		//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		//relación utilizada para ajustar la conversión de los píxeles
		//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		
		
		// ---------------------------------------------------------
		// establecer el modo de fuente por defecto
		//$pdf->setFontSubsetting(true);
		
		// Establecer el tipo de letra
		
		//Si tienes que imprimir carácteres ASCII estándar, puede utilizar las fuentes básicas como
		// Helvetica para reducir el tamaño del archivo.
		//$pdf->SetFont('freemono', '', 14, '', true);
		
		// Añadir una página
		// Este método tiene varias opciones, consulta la documentación para más información.
		$pdf->AddPage();
		
		//fijar efecto de sombra en el texto
		//$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
/*		
		// Establecemos el contenido para imprimir
		$provincia = $this->input->post('provincia');
		$provincias = $this->pdfs_model->getProvinciasSeleccionadas($provincia);
		foreach($provincias as $fila)
		{
			$prov = $fila['p.provincia'];
		}
		//preparamos y maquetamos el contenido a crear
		$html = '';
		$html .= "<style type=text/css>";
		$html .= "th{color: #fff; font-weight: bold; background-color: #222}";
		$html .= "td{background-color: #AAC7E3; color: #fff}";
		$html .= "</style>";
		$html .= "<h2>Localidades de ".$prov."</h2><h4>Actualmente: ".count($provincias)." localidades</h4>";
		$html .= "<table width='100%'>";
		$html .= "<tr><th>Id localidad</th><th>Localidades</th></tr>";
		
		//provincias es la respuesta de la función getProvinciasSeleccionadas($provincia) del modelo
		foreach ($provincias as $fila) 
		{
			$id = $fila['l.id'];
			$localidad = $fila['l.localidad'];
		
			$html .= "<tr><td class='id'>" . $id . "</td><td class='localidad'>" . $localidad . "</td></tr>";
		}
		$html .= "</table>";
*/		
		// Imprimimos el texto con writeHTMLCell()
		//$pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
		$pdf->writeHTML($html, true, false, false, false, '');
		
		// ---------------------------------------------------------
		// Cerrar el documento PDF y preparamos la salida
		// Este método tiene varias opciones, consulte la documentación para más información.
		$nombre_archivo = utf8_decode($nombrearchivo);
		$pdf->Output($nombre_archivo, 'I');
		
	}
}
/* End of file sessiones_helper.php */
/* Location: ./application/megataxi/helpers/cookie_helper.php */