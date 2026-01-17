<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administrador extends CI_Controller {

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
		$this->load->library('funciones');
	}

	public function index($salida='')
	{
		if(!empty($salida))
		{
			$this->session->destroy();
		}
		//$this->load->database();

		$data['vista_contenido']="inicioadministrador_view";
		$this->load->view('include/plantilla1',$data);
	}
}

/* End of file inicio.php */
/* Location: ./application/controllers/administrador.php */