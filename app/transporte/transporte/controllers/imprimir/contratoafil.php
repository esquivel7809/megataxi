<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Contratoafil extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/conductores/conductores
	 *	- or -
	 * 		http://example.com/index.php/conductores/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/conductores/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
        parent::__construct();
		//cargamos el modelo de la refrendacion
        $this->load->model('Refrendacion_model');
		$this->load->library('funciones');
		$this->load->library('tabla');
		$this->load->library('Pdf2');
        $this->arrayRequest=$this->funciones->convRequest($_REQUEST);
        $login=$this->session->userdata('loginusuarioactual');
        if(!empty($login))
        {
            if(empty($this->arrayRequest['idsubmoduloactual']) && !isset($this->arrayRequest['idrefrendacion']) && !isset($this->arrayRequest['idconductor']))
            {
                //terminar_session();
            }
            else
            {
                $this->load->library('tabla');
            }
        }
        else
        {
            terminar_session();
        }
    }
    /**
    * Muestra el formulario de registro de las refrendaciones de las tarjetas de control
    *
    * @access public
    * @param string
    * @return string
    */
	public function index()
	{
		ob_start();
		//inicializamos variables
		$nombrearchivo="Formato_Contrato_de_Afiliacion_".date('YmdHis').".pdf";
        $arraypost=$this->input->post();
        $arrayidvehiculopropietario = $arraypost['idvehiculopropietario'];
		//print_r($arrayidvehiculo);
        if($arraypost['todos']=='on')
        {
			unset($arrayidvehiculopropietario);
			$queryidvehiculopropietarioAll=$this->funciones->consVehiculosFormatoAfil();
			foreach ($queryidvehiculopropietarioAll->result() as $row)
			{
				$arrayidvehiculopropietario[]=$row->idvehiculopropietario;
			}
        }
		//print_r($arrayidvehiculopropietario);

		if(is_array($arrayidvehiculopropietario) && !empty($arrayidvehiculopropietario))
		{
			$pdf = new Pdf2('P', 'cm', array(21.6, 27.9), true, 'UTF-8', false);
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Megataxi Ltda.');
			$pdf->SetTitle('Formato de Contrato de Afiliación - Imprimir');
			$titulo_header="COOPERATIVA DE TRANSPORTE Y DE USUARIOS MEGATAXI LTDA “MEGATAXI”
							PERSONERIA JURIDICA 2234 DEL 19 DE AGOSTO DE 1993 NIT.800.204.096-5
							";
			$pdf->SetHeaderData('', '', '', $titulo_header,'','');
			$pdf->SetPrintHeader(true);
			$pdf->SetPrintFooter(false);
			$pdf->SetHeaderMargin('10');
			//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetMargins(10, PDF_MARGIN_TOP, 10);
			//$pdf->SetFooterMargin(25);
			//permite el corte en cada pagina
			$pdf->SetAutoPageBreak(TRUE, 7);
			$pdf->setHeaderFont(Array('', '', '9'));
			//$pdf->AddPage();

			foreach($arrayidvehiculopropietario as $value)
			{
				//consultamos los datosd e cada uno de los vehiculos
				$arrayDatos=$this->funciones->consVehiculoPropietarioContratoAfil($value);
				//print_r($arrayDatos);
				//pasamos los datos que se necesitan a un array multidimensional
				$arrayDatosGeneral["nombrecompleto"]=$arrayDatos->nombrecompleto;
				$arrayDatosGeneral["numerodocumento"]=$arrayDatos->numerodocumento;
				$arrayDatosGeneral["lugarexpedicion"]=$arrayDatos->nombremunicipio." ".$arrayDatos->nombredepartamento;
				$arrayDatosGeneral["direccion"]=$arrayDatos->direccion;
				$arrayDatosGeneral["ciudad"]="Ibagué";
				$arrayDatosGeneral["telefono"]=$arrayDatos->telefonofijo." ".$arrayDatos->celular;
				$arrayDatosGeneral["nombremarcavehiculo"]=$arrayDatos->nombremarcavehiculo;
				$arrayDatosGeneral["numerointerno"]=$arrayDatos->numerointerno;
				$arrayDatosGeneral["placa"]=$arrayDatos->placa;
				$arrayDatosGeneral["nombremodelo"]=$arrayDatos->nombremodelo;
				$arrayDatosGeneral["color"]="Amarillo";
				$arrayDatosGeneral["nombretipovehiculo"]=$arrayDatos->nombretipovehiculo; 
				$arrayDatosGeneral["numeromotor"]=$arrayDatos->numeromotor;
				$arrayDatosGeneral["numerochasis"]=$arrayDatos->numerochasis;
				
				$data['arrayDatosGeneral']=$arrayDatosGeneral;
				
				$html = $this->load->view("imprimir/contratoafil_imp_view_",$data, true);
				
				$pdf->AddPage();
				$pdf->writeHTML($html, true, false, false, false, '');
				
			}
			$nombre_archivo = utf8_decode($nombrearchivo);
			ob_clean();
			$pdf->Output($nombre_archivo, 'I');
		}
		
    }

} ?>
/* End of file refrendacion.php */
/* Location: ./application/controllers/formatos/tarjetacontrol.php */