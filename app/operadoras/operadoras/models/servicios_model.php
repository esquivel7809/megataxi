<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Servicios_model extends CI_Model {
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
            $this->db_megataxi = $this->load->database("megataxi", TRUE);
        }
		
		public function index()
		{
			salida();
		}
		
		public function getServicios(){
			$sqlServicios = "SELECT servicio.*, directorio.direccion 
								FROM servicio, directorio 
								WHERE servicio.telefono=directorio.telefono AND servicio.estado=1 
									AND servicio.id_usuario='".$this->session->userdata('operadoraidusuarioactual')."' 
								ORDER BY servicio.servicio_id DESC, estado ASC";
			$queryresult = $this->db_megataxi->query($sqlServicios);
            if($queryresult->num_rows() > 0 )
            {
            	$row=$queryresult->result_array();
                return $row;
            }
            else
            {
                return array();
            }
		}
		
		public function getReportados($idServicio=0){
			if(!empty($idServicio) && ($idServicio > 0) ){
				$sqlReportados="SELECT mega, reporte_id
							    FROM reporte_mega_a_servicio 
							    WHERE servicio_id='".$idServicio."' AND estado=1";
				$queryresult = $this->db_megataxi->query($sqlReportados);
	            if($queryresult->num_rows() > 0 )
	            {
	            	foreach ($queryresult->result_array() as $row){
	            		$row_[$row["reporte_id"]]=$row["mega"];
	            	}
	            	//$row = $queryresult->result_array();
	                return $row_;
	            }
	            else
	            {
	                return array();
	            }
			}else{
				return array();
			}
		}
		public function getServiciosConReportados(){
			$x=0;
			$servicios = $this->getServicios();
			foreach ($servicios as $row){
				$reportados= $this->getReportados($row["servicio_id"]);
				$servicios[$x]["reportados"] = $reportados;
				$x++;
				//print_r($row);
			}
			return $servicios;
		}
}

/* End of file usuario.php */
/* Location: ./application/models/usuario.php */
