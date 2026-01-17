<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tabla_model extends CI_Model {
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
		var $nitempresa = '';

        public function __construct()
        {
            // Llamando al contructor del Modelo
            parent::__construct();
            $this->load->database();
			$this->load->library('tabla');
        }
		
		public function index()
		{
			salida();
		}
	    /**
	    * Consulta los modelos, si se envia el idmodelo se consulta solo ese id
	    *
	    * @access public
	    * @param int
	    * @return array
	    */
		function getProveedores($idproveedor="")
		{
			$condicion = array();
			if(!empty($idproveedor) && $idproveedor!=0)
			{
				$condicion['idproveedor']=$idproveedor;
			}
			$this->tabla->settabla('proveedor');
			$array= $this->tabla->consultarDatos('idproveedor,nombreproveedor',$condicion,"nombreproveedor DESC");
			return $array;
		}
	    /**
	    * Consulta los modelos, si se envia el idmodelo se consulta solo ese id
	    *
	    * @access public
	    * @param int
	    * @return array
	    */
		function getProductos($idproducto="")
		{
			$condicion = array();
			if(!empty($idproducto) && $idproducto!=0)
			{
				$condicion['idproducto']=$idproducto;
			}
			$this->tabla->settabla('producto');
			$array= $this->tabla->consultarDatos('idproducto,nombreproducto',$condicion,"nombreproducto DESC");
			return $array;
		}
	
}

/* End of file usuario.php */
/* Location: ./application/models/usuario.php */
