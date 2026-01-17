<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Informes_model extends CI_Model {
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
            // Llamando al contructor del Modelo
            parent::__construct();
            $this->load->database();
			$this->idempresa=$this->session->userdata('idempresaactual');
        }
		/**
		 * Devuelve los datos de los vencimientos SOAT de los vehiculos
		 *
		 * Acepta el tipo de vencimiento
		 *
		 * @return	query
		 */
		public function cons_venc_soat($cond=1)
		{
			$date=date("Y-m-d");
			switch($cond){
				case(1): //vencidos
				default:
					$where="WHERE (s.fechafinal < '".$date."')";
				break;
				case(2): //vencen hoy
					$where="WHERE (s.fechafinal = '".$date."')";
				break;
				case(3): //vencen mañana
					$nuevafecha = strtotime ( '+1 day' , strtotime ( $date ) ) ;
					$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
					$where="WHERE (s.fechafinal > '".$date."' AND s.fechafinal <= '".$nuevafecha."')";
				break;
			}
			
			$sql="SELECT v.placa, s.numerosoat
				  FROM	 soat AS s
				  INNER JOIN vehiculo as v ON v.idvehiculo = s.idvehiculo
				  ".$where." AND s.idempresa='".$this->idempresa."' AND v.activo='1' AND s.activo='1'
				  LIMIT 0 , 20";
			
			$cons = $this->db->query($sql);
			return $cons;
		}
		
		/**
		 * Devuelve los datos de los vencimientos de Revision de los vehiculos
		 *
		 * Acepta el tipo de vencimiento
		 *
		 * @return	query
		 */
		public function cons_venc_revision($cond=1)
		{
			$date=date("Y-m-d");
			switch($cond){
				case(1): //vencidos
				default:
					$where="WHERE (r.fechafinal < '".$date."')";
				break;
				case(2): //vencen hoy
					$where="WHERE (r.fechafinal = '".$date."')";
				break;
				case(3): //vencen mañana
					$nuevafecha = strtotime ( '+1 day' , strtotime ( $date ) ) ;
					$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
					$where="WHERE (r.fechafinal > '".$date."' AND r.fechafinal <= '".$nuevafecha."')";
				break;
			}
			
			$sql="SELECT v.placa, r.numerorevision
				  FROM	 revision AS r
				  INNER JOIN vehiculo as v ON v.idvehiculo = r.idvehiculo
				  ".$where." AND r.idempresa='".$this->idempresa."' AND v.activo='1' AND r.activo='1'
				  LIMIT 0 , 20";
			
			$cons = $this->db->query($sql);
			return $cons;
		}
		
		/**
		 * Devuelve los datos de los vencimientos de las licnecias de conduccion de los conductores
		 *
		 * Acepta el tipo de vencimiento
		 *
		 * @return	query
		 */
		public function cons_venc_licencia($cond=1)
		{
			$date=date("Y-m-d");
			switch($cond){
				case(1): //vencidos
				default:
					$where="WHERE (lc.fechavencimiento < '".$date."')";
				break;
				case(2): //vencen hoy
					$where="WHERE (lc.fechavencimiento = '".$date."')";
				break;
				case(3): //vencen mañana
					$nuevafecha = strtotime ( '+1 day' , strtotime ( $date ) ) ;
					$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
					$where="WHERE (lc.fechavencimiento > '".$date."' AND lc.fechavencimiento <= '".$nuevafecha."')";
				break;
			}
			
			$sql="SELECT c.numerodocumento, lc.numerolicenciaconductor, td.abreviatura, c.nombrecompleto
				  FROM	 licenciaconductor AS lc
				  INNER JOIN conductor as c ON c.idconductor = lc.idconductor
				  LEFT JOIN tipodocumento AS td ON td.idtipodocumento=c.idtipodocumento
				  ".$where." AND lc.idempresa='".$this->idempresa."' AND c.activo='1' AND lc.activo='1'
				  LIMIT 0 , 20";
			
			$cons = $this->db->query($sql);
			return $cons;
		}
}
/* End of file usuario.php */
/* Location: ./application/models/informes_model.php */
