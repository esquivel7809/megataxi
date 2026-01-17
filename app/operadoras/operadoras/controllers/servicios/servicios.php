<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Servicios extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
        parent::__construct();
        //$this->load->library('funciones');

        //$this->arrayRequest=$this->funciones->convRequest($_REQUEST);
        //$usuario=$this->session->userdata('operadorausuarioactual');
		//$this->idempresa=$this->session->userdata('idempresaactual');
        if(!empty($usuario))
        { /*
            if(empty($this->arrayRequest['idsubmoduloactual']) && !isset($this->arrayRequest['idvehiculo']))
            {
                //terminar_session();
            }
            else
            {
                //$this->load->library('tabla');
            } */
			//$this->load->library('tabla');
        }
        else
        {
            //terminar_session();
        }
		
    }
    /**
    * Muestra el formulario para el registro de los vehiculos
    *
    * @access public
    * @param string
    * @return string
    */
	public function index()
	{
		//echo "entro";
		$data['vista_contenido_mod']=array("servicios/servicios_view");
		$this->load->view('include/plantillaservicios',$data);
    
        //$this->load->view('include/plantilla3',$data);
		
    }
   
}
/* End of file vehiculos.php */
/* Location: ./application/controllers/paraqueautomotor/vehiculos.php */