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
            $this->loginusuario=trim(addslashes($this->input->post('username')));
            $this->contrasena=sha1(md5(trim(addslashes($this->input->post('password')))));
            //$this->idempresa=trim(addslashes($this->input->post('idempresa')));
			//$this->nitempresa=trim(addslashes($this->input->post('nitempresa')));
            $this->load->model('Usuario');
	}
	public function index()
	{
		salida();
	}

	public function validarusuario()
	{
		//$empresa = (!empty($this->idempresa)) ? $this->idempresa : (!empty($this->nitempresa)) ? $this->nitempresa : "" ;
            
			if($this->Usuario->existeUsuario($this->loginusuario, $this->contrasena))
            {
                if($this->Usuario->existeEmpresa())
                {
					if($this->Usuario->existeUsuarioempresa())
					{
						$data["resultado"] ="entrar";
						$datosusuario=$this->Usuario->datosUsuario();
						//$this->load->library('session');
						$this->session->set_userdata('sigitransloginusuarioactual', $datosusuario['loginusuario']);
						$this->session->set_userdata('sigitransidtipodocumentoactual', $datosusuario['idtipodocumento']);
						$this->session->set_userdata('sigitransnumeroidusuarioactual', $datosusuario['numeroidusuario']);
						$this->session->set_userdata('sigitransnombreusuarioactual', $datosusuario['nombreusuario']);
						$this->session->set_userdata('sigitransidperfilactual', $datosusuario['idperfilusuario']);
						$this->session->set_userdata('sigitransultimologin', $datosusuario['ultimologin']);
						$this->session->set_userdata('sigitransidusuario', $datosusuario['idusuario']);
						$this->session->set_userdata('sigitransidempresaactual', $this->Usuario->getIdempresa());
						$this->Usuario->actualizaUltimoLogin();
						//$this->Usuario->insertaRegistroLogin();  //revisar 
						
						
						//define('URL_COMUN_PATH', $urlraiz.'comun/');
					}
					else
					{
						$data["resultado"] = "nousuarioempresa";
					}
                }
                else
                {
                    $data["resultado"] = "noempresa";
                }
            }
            else
            {
				$data["resultado"] = "nousuario";
            }
		$this->load->view('validacionusuario',$data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/validacion.php */