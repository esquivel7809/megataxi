<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends CI_Controller {

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

		$data['vista_contenido']="inicio_view";
        // se consultan las empresas
		$arrayEmpresas=$this->funciones->consEmpresa();
		
		$empresas['0']='Selecione Empresa';

		foreach ($arrayEmpresas as $fila)
		{
			$empresas[$fila['idempresa']]=$fila['nombreempresa'];
		}
		$data['empresas']=$empresas;
		$data['inicio']=site_url("inicio/index");
		$this->load->view('include/plantilla1',$data);
	}
}

/* End of file inicio.php */
/* Location: ./application/controllers/inicio.php */