<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Model {
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
            $this->idempresa=trim(addslashes($this->input->post('idempresa')));
            $this->load->database();
        }
        
        /**
         * Se valida el login, contraseña y estado del usuario 0(cero)=inactivo, 1(uno)=activo
         */
        public function existeUsuario()
        { 
            
            $sqlUsuario="SELECT loginusuario,contrasena,activo
                        FROM   usuario
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
         * Se valida si la empresa esta registrada en el sistema
         */
        public function existeEmpresa()
        { 
            $sqlEmpresa="SELECT idempresa
                        FROM   empresa
                        WHERE  idempresa='$this->idempresa'";
            $queryresult = $this->db->query($sqlEmpresa);
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
         * Se valida si el usuario esta activo para la empresa
         */
        public function existeUsuarioempresa()
        { 
            
            $sqlUsuario="SELECT loginusuario,contrasena,activo
                        FROM   usuario
                        WHERE  loginusuario='$this->loginusuario' AND contrasena='$this->contrasena' AND idempresa='$this->idempresa' AND activo='1' ";
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
                                         FROM   usuario
                                         WHERE  loginusuario='$this->loginusuario'";
                $queryresult = $this->db->query($sqlUsuario);
                return $queryresult->row_array();
        }
        
        /**
         * Retorna los datos de la empresa actual
         */
        function datosEmpresa($idempresa="")
        {
			$condicion = "";
			if(!empty($idempresa) && $idempresa!=0)
			{
				$condicion= $idempresa;
			}
			else
			{
				$condicion= $this->idempresa;
			}
			$sqlEmpresa="SELECT *
						 FROM empresa
						 WHERE idempresa ='".$condicion."'";
			$queryresult = $this->db->query($sqlEmpresa);
			return $queryresult->row_array();
        }
        /**
         * Retorna el id de la empresa actual
         */
        function getIdempresa()
        {
			return $this->idempresa;
        }


        function actualizaUltimoLogin()
        {
                $sqlUsuario="UPDATE usuario
                                         SET 	ultimologin=NOW()
                                         WHERE  loginusuario='".mysql_real_escape_string($this->loginusuario)."'";
                $this->db->query($sqlUsuario);
        }

        function insertaRegistroLogin()
        {
                $sqlUsuario="INSERT INTO sesion (loginusuario,ipcliente,fechalogin,horalogin)
                                         VALUES ('".$_SESSION['loginusuarioactual']."','".$_SERVER['REMOTE_ADDR']."',CURDATE(),CURTIME())";
                $this->db->query($sqlUsuario);
                $_SESSION['idsesion']=mysql_insert_id();
        }
        function insertaRegistroConectado()
        {
			if($_SESSION['loginusuarioactual']!="")
			{
				$sql="SELECT loginusuario
						  FROM   usuarioconectado
						  WHERE  loginusuario= '".$_SESSION['loginusuarioactual']."'";
				$result=$this->db->query($sql);
				$cantUsuario=$this->db->numRows($result);
				if($cantUsuario>0)
				{
						$sqlUsuario="UPDATE usuarioconectado SET fechaconexion=CURDATE(),horaconexion=CURTIME()
												 WHERE  loginusuario= '".$_SESSION['loginusuarioactual']."'";
						$this->db->query($sqlUsuario);
				}
				else
				{
						$sqlUsuario="INSERT INTO usuarioconectado (loginusuario,fechaconexion,horaconexion)
												 VALUES ('".$_SESSION['loginusuarioactual']."',CURDATE(),CURTIME())";
						$this->db->query($sqlUsuario);
				}
			}
        }
		
		function getPermisos()
		{
			$param=array();
			//  Se consultan los permisos para la botoneria 
			$sqlPermisos="SELECT modificar,consultar,eliminar, imprimir
						  FROM   perfilsubmodulo 
						  WHERE	 idperfilusuario='".$this->session->userdata('idperfilactual')."' AND 
								 idsubmodulo='".$this->session->userdata('idsubmoduloactual')."'";
			$consultaPersmisos = $this->db->query($sqlPermisos);
			
			$rowPermisos=$consultaPersmisos->row();
			$consultaPersmisos->free_result();
			$param = array('modificar' => $rowPermisos->modificar,'consultar' => $rowPermisos->consultar, 'eliminar' => $rowPermisos->eliminar, 'imprimir' => $rowPermisos->imprimir);
			
			return $param;

		}

}

/* End of file usuario.php */
/* Location: ./application/models/usuario.php */
