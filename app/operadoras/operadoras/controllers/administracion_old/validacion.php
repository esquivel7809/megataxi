<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Validacion extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/validacion
	 *	- or -
	 * 		http://example.com/index.php/validacion/index
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
            //parent::Controller();
            parent::__construct();
            $this->load->model('Administrador_model');
	}

	public function validarusuario()
	{
		if($this->Administrador_model->existeUsuario())
		{
				$data["resultado"] ="entrar";
				$datosusuario=$this->Administrador_model->datosUsuario();
				$this->session->set_userdata('loginadminactual', $datosusuario['loginusuario']);
				$this->session->set_userdata('idtipodocumentoadminactual', $datosusuario['idtipodocumento']);
				$this->session->set_userdata('numeroidusuarioadminactual', $datosusuario['numeroidusuario']);
				$this->session->set_userdata('nombreadminactual', $datosusuario['nombreusuario']);
				//$this->session->set_userdata('idperfilactual', $datosusuario['idperfilusuario']);
				$this->session->set_userdata('ultimologin', $datosusuario['ultimologin']);
				//$this->session->set_userdata('idempresaactual', $this->Usuario->getIdempresa());
				//$this->Usuario->actualizaUltimoLogin();
				//$this->Usuario->insertaRegistroLogin();  //revisar 
		}
		else
		{
			$data["resultado"] = "nousuario";
		}
            $this->load->view('validacionusuario',$data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/administracion/validacion.php */