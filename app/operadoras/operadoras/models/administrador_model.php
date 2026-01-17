<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administrador_model extends CI_Model {
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

        var $loginusuario = '';
        var $contrasena = '';
        var $date = '';
		var $idempresa = '';

        public function __construct()
        {
            // Llamando al contructor del Modelo
            parent::__construct();
            $this->loginusuario=trim(addslashes($this->input->post('username')));
            $this->contrasena=sha1(md5(trim(addslashes($this->input->post('password')))));
            $this->load->database();
        }
        
        /**
         * Se valida el login, contraseña y estado del usuario 0(cero)=inactivo, 1(uno)=activo
         */
        public function existeUsuario()
        { 
            
            $sqlUsuario="SELECT loginusuario,contrasena,activo
                        FROM   administrador
                        WHERE  loginusuario='$this->loginusuario' AND contrasena='$this->contrasena' AND activo='1' ";
            $queryresult = $this->db->query($sqlUsuario);
            if($queryresult->num_rows() > 0 )
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        /**
         * Retorna los datos del usuario actual
         */
        function datosUsuario()
        {
                $sqlUsuario="SELECT loginusuario,idtipodocumento,numerodocumento,nombreusuario,idperfilusuario,ultimologin
                                         FROM   administrador
                                         WHERE  loginusuario='$this->loginusuario'";
                $queryresult = $this->db->query($sqlUsuario);
                return $queryresult->row_array();
        }
        
}

/* End of file usuario.php */
/* Location: ./application/models/administrador_model.php */
