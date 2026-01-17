<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_model extends CI_Model {
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

        public $idperfil=0;
        public $idmodulo=0;

        public function __construct()
        {
            // Llamando al contructor del Modelo
            parent::__construct();
            $this->idperfilusuario=getIdperfilactual();
			$this->idempresa=getIdempresaactual();
            $this->load->database("default", TRUE);
        }

        function listarModulos()
        { /*
            $modulos=array();
            $sqlModulos="SELECT m.nombremodulo,m.carpetamodulo,m.idmodulo, m.orden
						 FROM   modulo m
						 INNER JOIN submodulo sm ON m.idmodulo=sm.idmodulo
						 INNER JOIN perfilsubmodulo ps ON sm.idsubmodulo=ps.idsubmodulo
						 WHERE ps.idperfilusuario='".mysql_real_escape_string($this->idperfilusuario)."'
								AND (ps.modificar=1 OR ps.consultar=1 OR ps.eliminar=1 OR ps.imprimir=1)
								AND ps.idempresa='".$this->idempresa."'
						 GROUP BY m.nombremodulo
						 ORDER BY m.orden ASC";
            $queryresult = $this->db->query($sqlModulos);
            $modulos=$queryresult->result_array();
            $queryresult->free_result();
            return $modulos; */
        }

        function listarSubmodulos($idmodulo=0)
        {
            $submodulos='';
            if($idmodulo!=0)
            {
                $sqlSubModulo="SELECT s.nombresubmodulo,s.urlsubmodulo,s.idsubmodulo
								 FROM   submodulo s, perfilsubmodulo ps
								 WHERE  s.idsubmodulo=ps.idsubmodulo
										AND s.idmodulo='$idmodulo'
										AND ps.idperfilusuario='".mysql_real_escape_string($this->idperfilusuario)."'
										AND (ps.modificar=1 OR ps.consultar=1 OR ps.eliminar=1 OR ps.imprimir=1)
										AND ps.idempresa='".$this->idempresa."'
								 GROUP BY s.nombresubmodulo";

                $queryresult = $this->db->query($sqlSubModulo);
                $submodulos=$queryresult->result_array();
            }
            $queryresult->free_result();
            return $submodulos;
        }
}

/* End of file menu.php */
/* Location: ./application/models/menu.php */
