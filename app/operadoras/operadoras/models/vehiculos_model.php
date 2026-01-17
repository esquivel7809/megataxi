<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehiculos_model extends CI_Model {
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
		
		public function getSuspendidos(){
			$lista = array();
			//suspendidos
			$sql_suspendidos="SELECT v.placa, v.frecuencia, v.suspencion, ts.nombre 
							  FROM vehiculo AS v 
							  INNER JOIN suspension_mega AS sm ON sm.vehiculo = v.placa 
							  INNER JOIN tipo_suspension AS ts ON ts.id_tipo = sm.id_tipo 
							  WHERE ( v.frecuencia='1' AND v.suspencion =  '0' AND sm.activo = '1' ) 
							  GROUP BY sm.vehiculo, sm.id_suspension 
							  ORDER BY sm.vehiculo DESC , sm.id_suspension DESC ";
			$queryresult = $this->db_megataxi->query($sql_suspendidos);
	        foreach ($queryresult->result_array() as $row)
	        {
	            $row_['placa']=html_entity_decode($row['placa']);
			    if($row_suspendidos["suspencion"]==0){
			    	$row_['suspension']=html_entity_decode($row['nombre']);
			    }else if($row_suspendidos["frecuencia"]==0){
			    	$row_['suspension']="Suspendido por pago";
				}
	        	$lista[]=$row_;
	        }
	        if(!empty($lista))
	        {
	        	echo json_encode($lista);
	        }
	        
	        return $lista;
		}
		public function getNoSuspendidos(){
			$sql_nosuspendidos="SELECT placa FROM vehiculo WHERE frecuencia='1' AND suspencion='1'";
			$queryresult = $this->db_megataxi->query($sql_nosuspendidos);
	        foreach ($queryresult->result_array() as $row)
	        {
	            $row_['placa']=html_entity_decode($row['placa']);
	        	$lista[]=$row_;
	        }
	        if(!empty($lista))
	        {
	        	echo json_encode($lista);
	        }
	        
	        return $lista;
		}
}

/* End of file Vehiculos_model.php */
/* Location: ./application/models/Vehiculos_model.php */
