<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf2 extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }
	//Page header
	public function Header() {
		// Logo
		//$image_file = K_PATH_IMAGES.'logo_example.jpg';
		//$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		$this->SetFont('', '', 10);
		// Title
		$headerdata = $this->getHeaderData();
		$this->MultiCell(0, 10, $headerdata['string'], 0, 'C', 0, 1, '', '', true, 0, false, true, 0, 'T', false);
		//$this->Cell(0, 15, $headerdata['string'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-30);
		// Set font
		//$this->SetFont('helvetica', 'I', 8);
		$this->SetFont('', '', 10);
		$footer_string="CARRERA 4B No. 29-02 HIPODROMO
						TELEFAX 2658054  PBX 2654444 666 TRANSPORTE 2700268
						Correo electrónico: megataxi21@hotmail.com
						IBAGUE (Tolima)
						AFILIADO CONFECOOP-TOLIMA
						";
		// Page number
		//$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		$this->MultiCell(0, 10, $footer_string, 0, 'C', 0, 1, '', '', true, 0, false, true, 0, 'T', false);
		//$this->Cell(0, 10, $footer_string, 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}

}
/* application/libraries/Pdf.php */