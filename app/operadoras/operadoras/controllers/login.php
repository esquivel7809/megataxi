<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

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
		$this->usuario=trim(addslashes($this->input->post('usuario')));
		$this->password=sha1(md5(trim(addslashes($this->input->post('password')))));
		//$this->load->library('funciones');
		//$this->load->library('mailer');
		//$this->load->helper('email');
		//$this->load->library('tabla');
		
		//cargamos los modelos necesarios
		$this->load->model('Usuario');
		//ini_set('display_errors', TRUE);
		
	}

	public function index($salida='')
	{
		if(!empty($salida))
		{
			$this->session->destroy();
		}
		$data['vista_contenido']="login_view";
		$this->load->view('include/plantilla1',$data);
	}
	public function validar(){
		//echo $this->usuario." - ".$this->password;
		
		//$empresa = (!empty($this->idempresa)) ? $this->idempresa : (!empty($this->nitempresa)) ? $this->nitempresa : "" ;
            
		if($this->Usuario->existeUsuario($this->usuario, $this->password)){
			//$data["resultado"] ="Entrada exitosa";
			//$data['vista_contenido']="login_view";
			redirect('/servicios');
			//header('Location: ../servicios/servicios');
		}else{
			$data["resultado"] = "Usuario o Contraseña incorrecta";
			$data['vista_contenido']="login_view";
			$this->load->view('include/plantilla1',$data);
		}
	}

	public function salida()
	{
		$this->session->destroy();
		redirect('', 'refresh');
	}

}

/* End of file inicio.php */
/* Location: ./application/controllers/inicio.php */